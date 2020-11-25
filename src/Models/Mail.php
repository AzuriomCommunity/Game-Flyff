<?php

namespace Azuriom\Plugin\Flyff\Models;

use Azuriom\Plugin\Flyff\Models\User;
use Illuminate\Database\Eloquent\Model;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;
use Azuriom\Games\Others\Servers\FlyffServerBridge;

class Mail extends Model
{
    protected $table = 'CHARACTER_01_DBF.dbo.MAIL_TBL';
    public $timestamps = false;
    public $incrementing = false;

    public function sender()
    {
        return $this->hasOne(FlyffCharacter::class, 'm_idPlayer','idSender')->withoutGlobalScopes(['valid']);
    }

    public function receiver()
    {
        return $this->hasOne(FlyffCharacter::class,  'm_idPlayer','idReceiver' )->withoutGlobalScopes(['valid']);
    }
}