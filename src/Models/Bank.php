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

    /**
     * Return the character that owns $this.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function character()
    {
        return $this->belongsTo(FlyffCharacter::class, 'm_idPlayer', 'm_idPlayer')->withoutGlobalScopes(['valid']);
    }
}
