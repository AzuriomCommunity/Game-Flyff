<?php

namespace Azuriom\Plugin\Flyff\Models;

use Illuminate\Database\Eloquent\Model;
use Azuriom\Games\Others\Servers\FlyffServerBridge;

class FlyffAccount extends Model
{
    protected $table = 'ACCOUNT_TBL';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'account';
    
    protected $fillable = [
        'account',
        'password',
        'isuse',
        'member',
        'id_no1',
        'id_no2',
        'realname',
        'reload',
        'OldPassword',
        'TempPassword',
        'Azuriom_user_id',
    ];

    protected $casts = [
        'Azuriom_user_id' => 'int',
    ];

    public function getConnectionName()
    {
        FlyffServerBridge::setOdbcDatasource('ACCOUNT_DBF');
        return 'flyff';
    }

    /**
     * Return the detail for this account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detail()
    {
        return $this->hasOne(FlyffAccountDetail::class, 'account', 'account');
    }

    /**
     * Return all characters for this account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters()
    {
        return $this->hasMany(FlyffCharacter::class, 'account', 'account');
    }
}
