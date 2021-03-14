<?php

namespace Azuriom\Plugin\Flyff\Providers;

use Azuriom\Models\Ban;
use Azuriom\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Schema;
use Azuriom\Support\SettingsRepository;
use Azuriom\Plugin\Flyff\Games\FlyffGame;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Validator;
use Azuriom\Providers\GameServiceProvider;
use Azuriom\Plugin\Flyff\Models\FlyffAccount;
use Azuriom\Plugin\Flyff\Observers\BanObserver;
use Azuriom\Plugin\Flyff\Middleware\CheckCharsShop;
use Azuriom\Plugin\Flyff\Models\FlyffAccountDetail;
use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Plugin\Flyff\View\Composers\FlyffAdminDashboardComposer;

class FlyffServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // \Azuriom\Plugin\Flyff\Middleware\ExampleMiddleware::class,
    ];

    /**
     * The plugin's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\Flyff\Middleware\ExampleRouteMiddleware::class,
    ];

    /**
     * The policy mappings for this plugin.
     *
     * @var array
     */
    protected $policies = [
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
        
        $this->registerMiddlewares();
        GameServiceProvider::registerGames(['flyff'=> FlyffGame::class]);
        //
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupSqlServer();
        // $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        View::composer('admin.dashboard', FlyffAdminDashboardComposer::class);

        Event::listen(function (Registered $event) {
            $event->user->access_token = Str::random(128);
            $settings = app(SettingsRepository::class);

            $validator = Validator::make(request()->all(), [
                'name' => ['string', 'max:25', 'regex:/^[A-Za-z0-9]+$/u'],
                'password' => ['required', 'string', 'min:8','max:16','regex:/^[A-Za-z0-9]+$/u'],
            ]);
       
            if ($validator->fails()) {
                Auth::logout();
                $event->user->delete();
                abort(redirect()->back()->withErrors($validator)->withInput());
            } else {
                if($settings->has('flyff.sqlsrv_host')) {
                    $password = flyff_hash_mdp(request()->input('password'));
                    FlyffAccount::query()->create([
                        'account' => request()->input('name'),
                        'password' => $password,
                        'isuse' => 'T',
                        'member' => 'A',
                        'realname' => '',
                        'Azuriom_user_id' => $event->user->id,
                        'Azuriom_user_access_token' => Str::random(128)
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
                }
                $event->user->save();
            }
        });

        Ban::observe(BanObserver::class);
        
        $this->app['router']->pushMiddlewareToGroup('web', \Azuriom\Plugin\Flyff\Middleware\InGameShop::class);
        //$this->app['router']->pushMiddlewareToGroup('web', \Azuriom\Plugin\Flyff\Middleware\CheckSqlSrv::class);
        //
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array
     */
    protected function routeDescriptions()
    {
        return [
            'flyff.guilds.index' => 'flyff::messages.guilds',
            'flyff.characters.index' => 'flyff::messages.characters'
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
                'icon' => 'fas fa-gamepad',
                'route' => 'flyff.admin.*',
                'items' => [
                    'flyff.admin.settings' => 'Settings',
                    'flyff.admin.index' => 'Comptes',
                    'flyff.admin.mails' => 'Mails',
                    'flyff.admin.trades.index' => 'Trades',
                    'flyff.admin.lookup' => 'Item Lookup',
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
                'name' => 'flyff::messages.game-accounts',
            ]
        ];
    }

    private function setupSqlServer()
    {
        $settings = app(SettingsRepository::class);
        if(config('database.default') !== 'sqlsrv') {
            //The SqlServer connection has to be setup for every requests if the default is not sqlsrv
            if($settings->has('flyff.sqlsrv_host')) {
                config([
                    'database.connections.sqlsrv.host' => $settings->get('flyff.sqlsrv_host', ''),
                    'database.connections.sqlsrv.port' => $settings->get('flyff.sqlsrv_port', ''),
                    'database.connections.sqlsrv.username' => $settings->get('flyff.sqlsrv_username', ''),
                    'database.connections.sqlsrv.password' => $settings->get('flyff.sqlsrv_password', ''),
                    'database.connections.sqlsrv.database' => 'ACCOUNT_DBF'
                ]);
                DB::purge();
            } else {
                //The middleware should redirect to settings to setup the connection
            }
        } else {
            //The default connection is sqlsrv, so do the migration and setup now since we have everything we need
            if(!$settings->has('flyff.sqlsrv_host')) {
                Setting::updateSettings([
                    'flyff.sqlsrv_host' => config('database.connections.sqlsrv.host'),
                    'flyff.sqlsrv_port' => config('database.connections.sqlsrv.port'),
                    'flyff.sqlsrv_username' => config('database.connections.sqlsrv.username'),
                    'flyff.sqlsrv_password' => config('database.connections.sqlsrv.password'),
                ]);

                $database = config('database.connections.sqlsrv.database');

                config(['database.connections.sqlsrv.database' => 'ACCOUNT_DBF']);
                DB::purge();

                if(! Schema::connection('sqlsrv')->hasColumn('ACCOUNT_TBL', 'Azuriom_user_id')) {
                    Schema::connection('sqlsrv')->table('ACCOUNT_TBL', function (Blueprint $table) {
                        $table->integer('Azuriom_user_id')->nullable();
                        $table->string('Azuriom_user_access_token')->nullable();
                    });
                }
                config(['database.connections.sqlsrv.database' => $database]);
                DB::purge();
            }
        }
    }
}
