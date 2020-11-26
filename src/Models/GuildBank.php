<?php

namespace Azuriom\Plugin\Flyff\Models;

use Illuminate\Database\Eloquent\Model;
use Azuriom\Plugin\Flyff\Models\FlyffGuild;

class GuildBank extends Model
{
    protected $table = 'CHARACTER_01_DBF.dbo.GUILD_BANK_TBL';
    public $timestamps = false;
    public $incrementing = false;

    protected $connection = 'sqlsrv';

    public function guild()
    {
        return $this->belongsTo(FlyffGuild::class, 'm_idGuild', 'm_idGuild')->withoutGlobalScopes(['valid']);
    }
}