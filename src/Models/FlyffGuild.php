<?php

namespace Azuriom\Plugin\Flyff\Models;

use Illuminate\Database\Eloquent\Model;
use Azuriom\Plugin\Flyff\Models\GuildBank;
use Azuriom\Games\Others\Servers\FlyffServerBridge;

/**
 * Class FlyffGuild
 *
 * @property string m_idGuild
 * @property string serverindex
 * @property int Lv_1
 * @property int Lv_2
 * @property int Lv_3
 * @property int Lv_4
 * @property int Pay_0
 * @property int Pay_1
 * @property int Pay_2
 * @property int Pay_3
 * @property int Pay_4
 * @property string m_szGuild
 * @property int m_nLevel
 * @property int m_nGuildGold
 * @property int m_nGuildPxp
 * @property int m_nWin
 * @property int m_nLose
 * @property int m_nSurrender
 * @property int m_nWinPoint
 * @property int m_dwLogo
 * @property string m_szNotice
 * @property string isuse
 * @property Carbon CreateTime
 *
 * @property bool has_logo
 * @property string logo
 * @property int max_members_count
 * @property string penyas
 *
 * @property FlyffCharacter leader
 * @property FlyffGuildMember members
 */
class FlyffGuild extends Model
{
    /** @var string */
    protected $primaryKey = 'm_idGuild';

    protected $connection = 'sqlsrv';

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'CHARACTER_01_DBF.dbo.GUILD_TBL';

    /** @var bool */
    public $timestamps = false;

    /** @var array */
    protected $casts = [
        'Lv_1' => 'int',
        'Lv_2' => 'int',
        'Lv_3' => 'int',
        'Lv_4' => 'int',
        'Pay_0' => 'int',
        'Pay_1' => 'int',
        'Pay_2' => 'int',
        'Pay_3' => 'int',
        'Pay_4' => 'int',
        'm_nLevel' => 'int',
        'm_nGuildGold' => 'int',
        'm_nGuildPxp' => 'int',
        'm_nWin' => 'int',
        'm_nLose' => 'int',
        'm_nSurrender' => 'int',
        'm_nWinPoint' => 'int',
        'm_dwLogo' => 'int',
    ];

    /** @var array */
    protected $dates = [
        'CreateTime',
    ];

    public function getRouteKeyName()
    {
        return 'm_szGuild';
    }

    /**
     * Return members for this guild.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(FlyffGuildMember::class, 'm_idGuild', 'm_idGuild')
            ->orderBy('m_nMemberLv')
            ->orderBy('m_nClass', 'DESC')
            ->orderBy('m_nGivePxp', 'DESC')
            ->orderBy('m_nGiveGold', 'DESC')
            ->orderBy('CreateTime');
    }

    /**
     * Return leader for this guild.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->members()->where('m_nClass', '=', 0)->get()->first()->character()->withoutGlobalScopes(['valid']);
    }

    /**
     * Determine if this guild has a logo.
     *
     * @return bool
     */
    public function getHasIconAttribute(): bool
    {
        return $this->m_dwLogo >= 1 && $this->m_dwLogo <= 27;
    }

    public function getIconAttribute(): string
    {
        if ($this->HasIcon) {
            return plugin_asset('flyff', "img/guild/icons/{$this->m_dwLogo}.jpg");
        }

        return plugin_asset('flyff', "img/guild/icons/unknown.png");
    }

    /**
     * Return max members count for this guild.
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getMaxMembersCountAttribute(): int
    {
        return self::maxMembersCount[$this->m_nLevel];
    }

    /**
     * Return  formatted penyas count string.
     *
     * @return string
     */
    public function getPenyasAttribute(): string
    {
        return number_format($this->m_nGuildGold, 0, '.', ' ');
    }

    public function bank()
    {
        return $this->hasOne(GuildBank::class, 'm_idGuild', 'm_idGuild');
    }

    protected const maxMembersCount = [
        1 => 30,
        2 => 30,
        3 => 32,
        4 => 32,
        5 => 34,
        6 => 34,
        7 => 36,
        8 => 36,
        9 => 38,
        10 => 38,
        11 => 40,
        12 => 40,
        13 => 42,
        14 => 42,
        15 => 44,
        16 => 44,
        17 => 46,
        18 => 46,
        19 => 48,
        20 => 48,
        21 => 49,
        22 => 50,
        23 => 51,
        24 => 52,
        25 => 53,
        26 => 54,
        27 => 55,
        28 => 56,
        29 => 57,
        30 => 58,
        31 => 59,
        32 => 60,
        33 => 61,
        34 => 62,
        35 => 63,
        36 => 64,
        37 => 65,
        38 => 66,
        39 => 67,
        40 => 68,
        41 => 69,
        42 => 70,
        43 => 71,
        44 => 72,
        45 => 73,
        46 => 74,
        47 => 75,
        48 => 76,
        49 => 77,
        50 => 80,
    ];
}
