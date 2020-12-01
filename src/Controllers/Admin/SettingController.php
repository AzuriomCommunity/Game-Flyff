<?php

namespace Azuriom\Plugin\Flyff\Controllers\Admin;

use Azuriom\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Azuriom\Plugin\Flyff\Models\User;
use Illuminate\Support\Facades\Schema;
use Azuriom\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;

class SettingController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        return view('flyff::admin.settings');
    }

    public function update(Request $request)
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
            return redirect()->route('flyff.admin.settings')->with('error', $th->getMessage());
        }

        Setting::updateSettings([
            'flyff.sqlsrv_host' => $request->input('sqlsrv_host'),
            'flyff.sqlsrv_port' => $request->input('sqlsrv_port') ?? '',
            'flyff.sqlsrv_username' => $request->input('sqlsrv_username'),
            'flyff.sqlsrv_password' => $request->input('sqlsrv_password'),
        ]);

        if(! Schema::connection('sqlsrv')->hasColumn('ACCOUNT_TBL', 'Azuriom_user_id')) {
            Schema::connection('sqlsrv')->table('ACCOUNT_TBL', function (Blueprint $table) {
                $table->integer('Azuriom_user_id')->nullable();
            });
        }

        return redirect()->route('flyff.admin.settings')->with('success', 'SQL Server configured!');
    }
}
