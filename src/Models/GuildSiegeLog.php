<?php

namespace Azuriom\Plugin\Flyff\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Azuriom\Plugin\Flyff\Models\FlyffAccount;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;

class GuildSiegeLog extends Model
{
    public $timestamps = false;

    protected $table = 'flyff_guild_siege_logs';

    protected $fillable = ['data', 'happened_at'];

    protected $casts = [
        'data' => 'array',
        'happened_at' => 'datetime',
    ];
}
