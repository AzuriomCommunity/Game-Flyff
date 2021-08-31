<?php

namespace Azuriom\Plugin\Flyff\Controllers;

use Azuriom\Models\User;
use Azuriom\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Azuriom\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;

class InstallController extends Controller
{
    public function index()
    {
        return view('flyff::install.index');
    }

    public function adminAccount()
    {
        return view('flyff::install.admin');
    }

    public function storeAdminAccount(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:50'], // TODO ensure unique
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'game_id' => null,
        ]);

        $user->markEmailAsVerified();
        $user->forceFill(['role_id' => 2])->save();
        Setting::updateSettings([
            'flyff_installed' => 1
        ]);

        return redirect()->route('home');
    }

    public function setupDatabase(Request $request)
    {
        DB::purge();

        config([
            'database.connections.sqlsrv.host' => $request->input('sqlsrv_host'),
            'database.connections.sqlsrv.port' => $request->input('sqlsrv_port'),
            'database.connections.sqlsrv.username' => $request->input('sqlsrv_username'),
            'database.connections.sqlsrv.password' => $request->input('sqlsrv_password'),
            'database.connections.sqlsrv.database' => 'ACCOUNT_DBF'
        ]);

        try {
            DB::connection('sqlsrv')->getPdo();
        } catch (\Throwable $th) {
            if ($th->getMessage() === 'could not find driver') {
                $architecture = ((PHP_INT_SIZE === 4) ? 'x86' : 'x64');
                $ThreadSafe = ZEND_THREAD_SAFE ? 'TS version' : 'NTS version';
                $phpVersion = (float)phpversion();
                $inipath = php_ini_loaded_file();
                $tmp = Str::beforeLast($inipath, 'php.ini');
                $extfolder = Str::substr($tmp, 0, \strlen($tmp)-1).'/ext';
                $error = <<<EOT
                    <code>sqlsrv</code> and <code>pdo_sqlsrv</code> drivers are wrong version or not installed.<br>
                    Please verify that you choosed the <code>{$architecture} {$ThreadSafe}, for php {$phpVersion}</code><br>
                    Make sure you installed them at the extension folder : <br>
                    - <code>{$extfolder}</code><br>
                    Then verify you enabled the drivers at your php.ini: <br>
                    - <code>{$inipath}</code><br>
                    Then restart you webserver
                EOT;
                
                return redirect()->route('flyff.install.index')->with('error', $error);
            }
            return redirect()->route('flyff.install.index')->with('error', $th->getMessage());
        }

        Setting::updateSettings([
            'flyff.sqlsrv_host' => $request->input('sqlsrv_host'),
            'flyff.sqlsrv_port' => $request->input('sqlsrv_port') ?? '',
            'flyff.sqlsrv_username' => $request->input('sqlsrv_username'),
            'flyff.sqlsrv_password' => $request->input('sqlsrv_password'),
        ]);

        if (! Schema::connection('sqlsrv')->hasColumn('ACCOUNT_TBL', 'Azuriom_user_id')) {
            Schema::connection('sqlsrv')->table('ACCOUNT_TBL', function (Blueprint $table) {
                $table->integer('Azuriom_user_id')->nullable();
                $table->string('Azuriom_user_access_token')->nullable();
            });
        }

        return redirect()->route('flyff.install.adminAccount')->with('success', 'SQL Server configured!');
    }
}
