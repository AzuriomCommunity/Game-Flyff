<?php

namespace Azuriom\Plugin\Flyff\Models;

use Azuriom\Plugin\Flyff\Models\User;
use Illuminate\Database\Eloquent\Model;
use Azuriom\Games\Others\Servers\FlyffServerBridge;

class FlyffAccount extends Model
{
    protected $table = 'ACCOUNT_DBF.dbo.ACCOUNT_TBL';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'account';
    protected $connection = 'sqlsrv';
    
    protected $fillable = [
        'account',
        'password',
        'isuse',
        'member',
        'realname',
        'Azuriom_user_id',
    ];

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

    /**
     * Return the Azuriom user.
     *
     * @return \Azuriom\Plugin\Flyff\Models\User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'Azuriom_user_id');
    }
}
