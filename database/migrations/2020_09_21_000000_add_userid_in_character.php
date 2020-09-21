<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Azuriom\Games\Others\Servers\FlyffServerBridge;

class AddUseridInCharacter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        FlyffServerBridge::setOdbcDatasource('ACCOUNT_DBF');
        $schema = Schema::connection('flyff');
        if(!$schema->hasTable('ACCOUNT_TBL')) {
            plugins()->disable('flyff');
            throw new RuntimeException('Flyff database has not been setup');
        }
        $schema->table('ACCOUNT_TBL', function (Blueprint $table) {
            $table->integer('Azuriom_user_id')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        FlyffServerBridge::setOdbcDatasource('ACCOUNT_DBF');
        Schema::connection('flyff')->table('ACCOUNT_TBL', function (Blueprint $table) {
            $table->dropColumn('Azuriom_user_id');
        });
    }
}
