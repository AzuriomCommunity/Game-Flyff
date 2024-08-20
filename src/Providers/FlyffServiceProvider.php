<?php

namespace Azuriom\Plugin\Flyff\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Ban;
use Azuriom\Models\Role;
use Azuriom\Models\User;
use Azuriom\Plugin\Flyff\Games\FlyffGame;
use Azuriom\Plugin\Flyff\Models\FlyffAccount;
use Azuriom\Plugin\Flyff\Models\FlyffAccountDetail;
use Azuriom\Plugin\Flyff\Observers\BanObserver;
use Azuriom\Plugin\Flyff\View\Composers\FlyffAdminDashboardComposer;
use Azuriom\Providers\GameServiceProvider;
use Azuriom\Support\SettingsRepository;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class FlyffServiceProvider extends BasePluginServiceProvider
{
    protected array $middleware = [];

    protected array $middlewareGroups = [];

    protected array $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\Flyff\Middleware\ExampleRouteMiddleware::class,
    ];

    protected array $policies = [
        // User::class => UserPolicy::class,
    ];

    /**
     * Register any plugin services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__.'/../../vendor/autoload.php';
        GameServiceProvider::registerGames(['flyff' => FlyffGame::class]);
        //
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        if (is_installed()) {
            $this->setupSqlServer();
            $this->setupAuthEvents();
            Ban::observe(BanObserver::class);
            View::composer('admin.dashboard', FlyffAdminDashboardComposer::class);
            $this->app['router']->pushMiddlewareToGroup('web', \Azuriom\Plugin\Flyff\Middleware\InGameShop::class);
        }
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array
     */
    protected function routeDescriptions()
    {
        return [
            'flyff.guilds.index' => trans('flyff::messages.guilds'),
            'flyff.characters.index' => trans('flyff::messages.characters'),
            'flyff.guild-siege.index' => trans('flyff::messages.guild-siege'),
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array
     */
    protected function adminNavigation()
    {
        return [
            'flyff' => [
                'name' => 'Flyff',
                'type' => 'dropdown',
                'icon' => 'bi bi-controller',
                'route' => 'flyff.admin.*',
                'items' => [
                    'flyff.admin.settings' => 'Settings',
                    'flyff.admin.index' => 'Comptes',
                    'flyff.admin.mails' => 'Mails',
                    'flyff.admin.trades.index' => 'Trades',
                    'flyff.admin.lookup' => 'Item Lookup',
                    'flyff.admin.siege' => 'Guild Siege',
                ],
            ],
        ];
    }

    /**
     * Return the user navigations routes to register in the user menu.
     *
     * @return array
     */
    protected function userNavigation()
    {
        return [
            'flyff' => [
                'route' => 'flyff.accounts.index',
                'name' => trans('flyff::messages.game-accounts'),
            ],
        ];
    }

    private function setupAuthEvents()
    {
        Event::listen(function (Registered $event) {
            $validator = Validator::make(request()->all(), [
                'name' => ['string', 'min:4', 'max:16', 'regex:/^[A-Za-z0-9]+$/u'],
                'password' => ['required', 'string', 'min:8', 'max:16', 'regex:/^[A-Za-z0-9\.\!\?\*]+$/u'],
            ]);

            if ($validator->fails()) {
                Auth::logout();
                $event->user->delete();
                abort(redirect()->back()->withErrors($validator)->withInput());
            }

            $password = flyff_hash_mdp(request()->input('password'));
            $account = FlyffAccount::firstWhere('account', request()->input('name'));
            if ($account === null) {
                FlyffAccount::query()->create([
                    'account' => request()->input('name'),
                    'password' => $password,
                    'isuse' => 'T',
                    'member' => 'A',
                    'realname' => '',
                    'Azuriom_user_id' => $event->user->id,
                    'Azuriom_user_access_token' => Str::random(128),
                ]);

                FlyffAccountDetail::query()->create([
                    'account' => request()->input('name'),
                    'gamecode' => 'A000',
                    'tester' => '2',
                    'm_chLoginAuthority' => 'F',
                    'regdate' => Carbon::now(),
                    'BlockTime' => '0',
                    'EndTime' => '0',
                    'WebTime' => '0',
                    'isuse' => 'O',
                    'email' => '',
                ]);
            } else {
                request()->session()->flash('success', trans('flyff::messages.create-game-account'));
            }

            $event->user->access_token = Str::random(128);
            $event->user->save();
        });

        Auth::attempting(function (Attempting $event) {
            $credentials = $event->credentials;

            $user = User::firstWhere(Arr::except($credentials, 'password'));

            //No Azuriom user so we have to create it if it exists in flyff DB
            if ($user === null) {
                if (isset($credentials['name'])) {
                    $detail = FlyffAccountDetail::firstWhere('account', $credentials['name']);
                } else {
                    $detail = FlyffAccountDetail::firstWhere('email', $credentials['email']);
                }

                if ($detail === null) {
                    return;
                }

                $account = FlyffAccount::firstWhere('account', $detail->account);

                $hash = flyff_hash_mdp($credentials['password']);

                if ($account->password === $hash) {
                    //password match we can create an user
                    $user = User::forceCreate([
                        'name' => $credentials['name'] ?? $detail->account,
                        'email' => $credentials['email'] ?? empty($detail->email) ? (str()->random(16) . '@' . str()->random(4).'.tld') : $detail->email,
                        'password' => Hash::make($credentials['password']),
                        'role_id' => Role::defaultRoleId(),
                        'game_id' => null,
                        'last_login_ip' => request()->ip(),
                        'last_login_at' => now(),
                    ]);

                    $account->Azuriom_user_id = $user->id;
                    $account->Azuriom_user_access_token = Str::random(128);
                    $account->save();
                }
            }
        });
    }

    private function setupSqlServer()
    {
        if (config('database.default') !== 'sqlsrv') {
            //The SqlServer connection has to be setup for every requests if the default is not sqlsrv
            $settings = app(SettingsRepository::class);
            config([
                'database.connections.sqlsrv.host' => $settings->get('flyff.sqlsrv_host', ''),
                'database.connections.sqlsrv.port' => $settings->get('flyff.sqlsrv_port', ''),
                'database.connections.sqlsrv.username' => $settings->get('flyff.sqlsrv_username', ''),
                'database.connections.sqlsrv.password' => $settings->get('flyff.sqlsrv_password', ''),
                'database.connections.sqlsrv.database' => 'ACCOUNT_DBF',
            ]);
            DB::purge();
        }
    }
}
