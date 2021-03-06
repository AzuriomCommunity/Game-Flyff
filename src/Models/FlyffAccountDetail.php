<?php

namespace Azuriom\Plugin\Flyff\Models;

use Illuminate\Database\Eloquent\Model;
use Azuriom\Games\Others\Servers\FlyffServerBridge;

class FlyffAccountDetail extends Model
{
    /** @var string */
    protected $primaryKey = 'account';

    protected $connection = 'sqlsrv';

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'ACCOUNT_DBF.dbo.ACCOUNT_TBL_DETAIL';

    /** @var bool */
    public $timestamps = false;

    /** @var array */
    protected $fillable = [
        'account',
        'gamecode',
        'tester',
        'm_chLoginAuthority',
        'BlockTime',
        'EndTime',
        'WebTime',
        'isuse',
        'email',
        'secession',
        'regdate',
    ];

    /** @var array */
    protected $dates = [
        'secession',
        'regdate',
    ];

}