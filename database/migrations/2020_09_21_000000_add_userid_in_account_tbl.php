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
        if (!extension_loaded('sqlsrv') || !extension_loaded('pdo_sqlsrv')) {
            plugins()->disable('flyff');
            throw new RuntimeException('sqlsrv and pdo_sqlsrv extensions are missing or you are using the wrong version');
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
