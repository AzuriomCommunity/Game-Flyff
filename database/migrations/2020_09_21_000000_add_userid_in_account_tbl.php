<?php

use Azuriom\Models\User;
use Illuminate\Support\Str;
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
        $azuriom_db = config("database.connections.sqlsrv.database");
        User::all()->each(function($user){
            $user->access_token = Str::random(128);
            $user->save();
        });
        
        config(["database.connections.sqlsrv.database" => 'ACCOUNT_DBF']);
        DB::purge();

        if(!Schema::hasTable('ACCOUNT_TBL')) {
            plugins()->disable('flyff');
            throw new RuntimeException('Flyff database has not been setup');
        }

        if(! Schema::hasColumn('ACCOUNT_TBL', 'Azuriom_user_id')) {
            Schema::table('ACCOUNT_TBL', function (Blueprint $table) {
                $table->integer('Azuriom_user_id')->nullable();
            });
        }

        

        config(["database.connections.sqlsrv.database" => $azuriom_db]);
        DB::purge();
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
