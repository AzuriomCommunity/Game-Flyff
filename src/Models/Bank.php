<?php

namespace Azuriom\Plugin\Flyff\Models;

use Illuminate\Database\Eloquent\Model;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;

class Bank extends Model
{
    protected $table = 'CHARACTER_01_DBF.dbo.BANK_TBL';
    public $timestamps = false;
    public $incrementing = false;
    protected $connection = 'sqlsrv';

    public function character()
    {
        return $this->belongsTo(FlyffCharacter::class, 'm_idPlayer', 'm_idPlayer')->withoutGlobalScopes(['valid']);
    }
}