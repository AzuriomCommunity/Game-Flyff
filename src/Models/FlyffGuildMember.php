<?php

namespace Azuriom\Plugin\Flyff\Models;

use Illuminate\Database\Eloquent\Model;
use Azuriom\Games\Others\Servers\FlyffServerBridge;

/**
 * Class FlyffGuildMember
 *
 * @property string m_idPlayer
 * @property string serverindex
 * @property string m_idGuild
 * @property string m_szAlias
 * @property int m_nWin
 * @property int m_nLose
 * @property int m_nSurrender
 * @property int m_nMemberLv
 * @property int m_nGiveGold
 * @property int m_nGivePxp
 * @property int m_idWar
 * @property int m_idVote
 * @property string isuse
 * @property int m_nClass
 * @property Carbon CreateTime
 *
 * @property string rank_logo
 * @property string rank_title
 *
 * @property Guild guild
 * @property Character character
 */
class FlyffGuildMember extends Model
{
    /** @var string */
    protected $table = 'CHARACTER_01_DBF.dbo.GUILD_MEMBER_TBL';

    protected $connection = 'sqlsrv';

    /** @var bool */
    public $timestamps = false;

    /** @var array */
    protected $casts = [
        'm_nWin' => 'int',
        'm_nLose' => 'int',
        'm_nSurrender' => 'int',
        'm_nMemberLv' => 'int',
        'm_nGiveGold' => 'int',
        'm_nGivePxp' => 'int',
        'm_idWar' => 'int',
        'm_idVote' => 'int',
        'm_nClass' => 'int',
    ];

    /** @var array */
    protected $dates = [
        'CreateTime',
    ];

    /**
     * Return guild for this guild member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guild()
    {
        return $this->belongsTo(FlyffGuild::class, 'm_idGuild', 'm_idGuild');
    }

    /**
     * Return character for this guild member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(FlyffCharacter::class, 'm_idPlayer', 'm_idPlayer');
    }

    public function getRankIconAttribute(): ?string
    {
       return plugin_asset('flyff', "img/guild/ranks/{$this->m_nMemberLv}.png"); 
    }

    /**
     * Return name of logo for his rank or null (it's not supposed to happen).
     *
     * @return null|string
     */
    public function getRankTitleAttribute(): ?string
    {
        return trans("flyff::messages.guild_ranks.{$this->m_nMemberLv}");
    }
}