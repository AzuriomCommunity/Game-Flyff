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
        if(empty(env('SQLSRV_HOST')))
            throw new RuntimeException('Please follow the wiki to properly install the plugin');
        
        $users = User::all();
        $users->each(function($user){
            $user->access_token = Str::random(128);
            $user->save();
        });

        if(!Schema::connection('sqlsrv')->hasTable('ACCOUNT_TBL')) {
            plugins()->disable('flyff');
            throw new RuntimeException('Flyff database has not been setup');
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
