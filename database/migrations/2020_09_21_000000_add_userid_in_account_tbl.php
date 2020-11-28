<?php

use Azuriom\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUseridInAccountTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(empty(env('SQLSRV_HOST'))) {
            plugins()->disable('flyff');
            throw new RuntimeException('To install the plugin properly please follow the wiki at: https://github.com/AzuriomCommunity/Game-Flyff/wiki/Installation');
        }
        
        if (!extension_loaded('sqlsrv') || !extension_loaded('pdo_sqlsrv')) {
            plugins()->disable('flyff');
            throw new RuntimeException('sqlsrv and pdo_sqlsrv extensions are missing or you are using the wrong version');
        }
        
        $users = User::all();
        $users->each(function($user){
            $user->access_token = Str::random(128);
            $user->save();
        });

        config([
            'database.connections.sqlsrv.host' => env('SQLSRV_HOST'),
            'database.connections.sqlsrv.port' => env('SQLSRV_PORT'),
            'database.connections.sqlsrv.username' => env('SQLSRV_USERNAME'),
            'database.connections.sqlsrv.password' => env('SQLSRV_PASSWORD'),
            'database.connections.sqlsrv.database' => 'ACCOUNT_DBF'
        ]);

        try {
            DB::connection('sqlsrv')->getPdo();
        } catch (\Throwable $th) {
            plugins()->disable('flyff');
            throw new RuntimeException($th->getMessage());
        }

        if(!Schema::connection('sqlsrv')->hasTable('ACCOUNT_TBL')) {
            plugins()->disable('flyff');
            throw new RuntimeException('Flyff database misses the table ACCOUNT_TBL?');
        }

        if(! Schema::connection('sqlsrv')->hasColumn('ACCOUNT_TBL', 'Azuriom_user_id')) {
            Schema::connection('sqlsrv')->table('ACCOUNT_TBL', function (Blueprint $table) {
                $table->integer('Azuriom_user_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
