<?php

namespace Azuriom\Plugin\Flyff\Models;

use Illuminate\Database\Eloquent\Model;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;

class Mail extends Model
{
    protected $table = 'CHARACTER_01_DBF.dbo.MAIL_TBL';
    public $timestamps = false;
    public $incrementing = false;

    protected $connection = 'sqlsrv';

    public function sender()
    {
        return $this->hasOne(FlyffCharacter::class, 'm_idPlayer','idSender')->withoutGlobalScopes(['valid']);
    }

    public function receiver()
    {
        return $this->hasOne(FlyffCharacter::class, 'm_idPlayer','idReceiver')->withoutGlobalScopes(['valid']);
    }
}