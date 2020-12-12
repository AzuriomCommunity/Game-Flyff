<?php

namespace Azuriom\Plugin\Flyff\Models;

use Illuminate\Support\Carbon;
use Azuriom\Plugin\Flyff\Models\Bank;
use Azuriom\Plugin\Flyff\Models\Mail;
use Azuriom\Plugin\Flyff\Models\Pocket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Azuriom\Plugin\Flyff\Models\Inventory;
use Azuriom\Plugin\Flyff\Models\FlyffGuildMember;
use Azuriom\Games\Others\Servers\FlyffServerBridge;

/**
 * Class FlyffCharacter
 *
 * @property string m_idPlayer
 * @property string serverindex
 * @property string m_szName
 * @property int playerslot
 * @property int dwWorldID
 * @property int m_dwIndex
 * @property double m_vScale_x
 * @property int m_dwMotion
 * @property double m_vPos_x
 * @property double m_vPos_y
 * @property double m_vPos_z
 * @property double m_fAngle
 * @property string m_szCharacterKey
 * @property int m_nHitPoint
 * @property int m_nManaPoint
 * @property int m_nFatiguePoint
 * @property int m_nFuel
 * @property int m_dwSkinSet
 * @property int m_dwHairMesh
 * @property int m_dwHairColor
 * @property int m_dwHeadMesh
 * @property int m_dwSex
 * @property int m_dwRideItemIdx
 * @property int m_dwGold
 * @property int m_nJob
 * @property string m_pActMover
 * @property int m_nStr
 * @property int m_nSta
 * @property int m_nDex
 * @property int m_nInt
 * @property int m_nLevel
 * @property int m_nMaximumLevel
 * @property int m_nExp1
 * @property int m_nExp2
 * @property string m_aJobSkill
 * @property string m_aLicenseSkill
 * @property string m_aJobLv
 * @property int m_dwExpertLv
 * @property int m_idMarkingWorld
 * @property double m_vMarkingPos_x
 * @property double m_vMarkingPos_y
 * @property double m_vMarkingPos_z
 * @property int m_nRemainGP
 * @property int m_nRemainLP
 * @property int m_nFlightLv
 * @property int m_nFxp
 * @property int m_nTxp
 * @property string m_lpQuestCntArray
 * @property string m_chAuthority
 * @property int m_dwMode
 * @property int m_idparty
 * @property string m_idCompany
 * @property int m_idMuerderer
 * @property int m_nFame
 * @property int m_nDeathExp
 * @property int m_nDeathLevel
 * @property int m_dwFlyTime
 * @property int m_nMessengerState
 * @property string blockby
 * @property int TotalPlayTime
 * @property string isblock
 * @property string End_Time
 * @property string BlockTime
 * @property int m_tmAccFuel
 * @property string m_tGuildMember
 * @property int m_dwSkillPoint
 * @property string m_aCompleteQuest
 * @property int m_dwReturnWorldID
 * @property double m_vReturnPos_x
 * @property double m_vReturnPos_y
 * @property double m_vReturnPos_z
 * @property int MultiServer
 * @property int m_SkillPoint
 * @property int m_SkillLv
 * @property int m_SkillExp
 * @property int dwEventFlag
 * @property int dwEventTime
 * @property int dwEventElapsed
 * @property int PKValue
 * @property int PKPropensity
 * @property int PKExp
 * @property int AngelExp
 * @property int AngelLevel
 * @property int m_dwPetId
 * @property int m_nExpLog
 * @property int m_nAngelExpLog
 * @property int m_nCoupon
 * @property int m_nHonor
 * @property int m_nLayer
 * @property int m_nCampusPoint
 * @property int idCampus
 * @property string m_aCheckedQuest
 * @property int tKeepTime
 * @property int m_dwMadrigalGiftExp
 * @property int m_tmLogout
 * @property Carbon CreateTime
 * @property Carbon FinalLevelDt
 *
 * @property FlyffAccount flyffAccount
 * @property FlyffGuildMember guildMember
 * @property FlyffGuild guild
 * @property Bank bank
 * @property Mail mails
 * @property Pocket pocket
 * @property Inventory inventory
 *
 * @property string SexIcon
 * @property int MasterRank
 * @property bool HasMasterRank
 * @property string TotalTimePlayed
 * @property string AvatarUrl
 * @property string JobName
 * @property string JobIcon
 * @property string WorldName
 *
 * @method static Builder valid()
 */
class FlyffCharacter extends Model
{
    /** @var string */
    protected $primaryKey = 'm_idPlayer';

    protected $connection = 'sqlsrv';

    /** @var bool */
    public $incrementing = false;

    protected static function booted()
    {
        static::addGlobalScope('valid', function (Builder $builder) {
            $builder->where('isblock', '=', 'F');
        });
    }

    /** @var string */
    protected $table = 'CHARACTER_01_DBF.dbo.CHARACTER_TBL';

    /** @var bool */
    public $timestamps = false;

    /** @var array */
    protected $casts = [
        'playerslot' => 'int',
        'dwWorldID' => 'int',
        'm_dwIndex' => 'int',
        'm_vScale_x' => 'float',
        'm_dwMotion' => 'int',
        'm_vPos_x' => 'float',
        'm_vPos_y' => 'float',
        'm_vPos_z' => 'float',
        'm_fAngle' => 'float',
        'm_nHitPoint' => 'int',
        'm_nManaPoint' => 'int',
        'm_nFatiguePoint' => 'int',
        'm_nFuel' => 'int',
        'm_dwSkinSet' => 'int',
        'm_dwHairMesh' => 'int',
        'm_dwHairColor' => 'int',
        'm_dwHeadMesh' => 'int',
        'm_dwSex' => 'int',
        'm_dwRideItemIdx' => 'int',
        'm_dwGold' => 'int',
        'm_nJob' => 'int',
        'm_nStr' => 'int',
        'm_nSta' => 'int',
        'm_nDex' => 'int',
        'm_nInt' => 'int',
        'm_nLevel' => 'int',
        'm_nMaximumLevel' => 'int',
        'm_nExp1' => 'int',
        'm_nExp2' => 'int',
        'm_dwExpertLv' => 'int',
        'm_idMarkingWorld' => 'int',
        'm_vMarkingPos_x' => 'float',
        'm_vMarkingPos_y' => 'float',
        'm_vMarkingPos_z' => 'float',
        'm_nRemainGP' => 'int',
        'm_nRemainLP' => 'int',
        'm_nFlightLv' => 'int',
        'm_nFxp' => 'int',
        'm_nTxp' => 'int',
        'm_dwMode' => 'int',
        'm_idparty' => 'int',
        'm_idMuerderer' => 'int',
        'm_nFame' => 'int',
        'm_nDeathExp' => 'int',
        'm_nDeathLevel' => 'int',
        'm_dwFlyTime' => 'int',
        'm_nMessengerState' => 'int',
        'TotalPlayTime' => 'int',
        'm_tmAccFuel' => 'int',
        'm_dwSkillPoint' => 'int',
        'm_dwReturnWorldID' => 'int',
        'm_vReturnPos_x' => 'float',
        'm_vReturnPos_y' => 'float',
        'm_vReturnPos_z' => 'float',
        'MultiServer' => 'int',
        'm_SkillPoint' => 'int',
        'm_SkillLv' => 'int',
        'm_SkillExp' => 'int',
        'dwEventFlag' => 'int',
        'dwEventTime' => 'int',
        'dwEventElapsed' => 'int',
        'PKValue' => 'int',
        'PKPropensity' => 'int',
        'PKExp' => 'int',
        'AngelExp' => 'int',
        'AngelLevel' => 'int',
        'm_dwPetId' => 'int',
        'm_nExpLog' => 'int',
        'm_nAngelExpLog' => 'int',
        'm_nCoupon' => 'int',
        'm_nHonor' => 'int',
        'm_nLayer' => 'int',
        'm_nCampusPoint' => 'int',
        'idCampus' => 'int',
        'tKeepTime' => 'int',
        'm_dwMadrigalGiftExp' => 'int',
        'm_tmLogout' => 'int',
    ];

    /** @var array */
    protected $dates = [
        'CreateTime',
        'FinalLevelDt',
    ];

    public function getRouteKeyName()
    {
        return 'm_szName';
    }

    /**
     * Return the account for this character.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flyffAccount()
    {
        return $this->belongsTo(FlyffAccount::class, 'account', 'account');
    }

    /**
     * Return the guild for this character.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guild()
    {
        return $this->hasOneThrough(FlyffGuild::class, FlyffGuildMember::class, 'm_idPlayer', 'm_idGuild', 'm_idPlayer', 'm_idGuild');
    }

    /**
     * Return the guild member for this character.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function guildMember()
    {
        return $this->hasOne(FlyffGuildMember::class, 'm_idPlayer', 'm_idPlayer');
    }

    /**
     * Return HTML icon gender for this character.
     *
     * @return string
     */
    public function getSexIconAttribute(): string
    {
        return plugin_asset('flyff', "img/sex_icons/{$this->m_dwSex}.png");
        ;
    }

    /**
     * Return number of master rank for this character.
     *
     * @return int|null
     */
    public function getMasterRankAttribute(): ?int
    {
        if ($this->m_nJob > 16 && $this->m_nJob < 24) {
            if ($this->m_nLevel >= 110) {
                return 6;
            } elseif ($this->m_nLevel >= 100) {
                return 5;
            } elseif ($this->m_nLevel >= 90) {
                return 4;
            } elseif ($this->m_nLevel >= 80) {
                return 3;
            } elseif ($this->m_nLevel >= 70) {
                return 2;
            } elseif ($this->m_nLevel >= 60) {
                return 1;
            }
        }
        return null;
    }

    /**
     * Determine if this character have a master rank.
     *
     * @return bool
     */
    public function getHasMasterRankAttribute(): bool
    {
        return !is_null($this->master_rank);
    }

    /**
     * Determine if this character is valid.
     *
     * @return bool
     */
    public function getIsValidAttribute(): bool
    {
        // TODO: verifier si le character appartien bien à l'utilisateur, que le compte n'est pas banni et que le personnage est valid (isblock = 'F')
        
        return $this->isblock == 'F';
    }

    /**
     * Return formatted total time played for this character.
     *
     * @return string
     */
    public function getTotalTimePlayedAttribute(): string
    {
        return Carbon::now()->subSeconds($this->TotalPlayTime)->diffForHumans(null, true);
    }

    public function getAvatarUrlAttribute()
    {
        if (Storage::exists("public/flyff/avatars/{$this->flyffAccount->Azuriom_user_id}/{$this->m_szName}.png")) {
            return Storage::url("public/flyff/avatars/{$this->flyffAccount->Azuriom_user_id}/{$this->m_szName}.png");
        }
            
        return plugin_asset('flyff', 'img/unknown_avatar.png');
    }

    public function getJobNameAttribute()
    {
        return trans("flyff::messages.jobs.{$this->m_nJob}");
    }

    public function getJobIconAttribute()
    {
        if ($master = $this->MasterRank) {
            return plugin_asset('flyff', "img/jobs/master/{$this->m_nJob}_$master.png");
        }

        return plugin_asset('flyff', "img/jobs/{$this->m_nJob}.png");
    }

    public function getWorldNameAttribute()
    {
        return trans("flyff::messages.world_names.{$this->dwWorldID}");
    }

    public function pocket()
    {
        return $this->hasOne(Pocket::class, 'idPlayer', 'm_idPlayer');
    }

    public function bank()
    {
        return $this->hasOne(Bank::class, 'm_idPlayer', 'm_idPlayer');
    }

    public function mails()
    {
        return $this->hasMany(Mail::class, 'idReceiver', 'm_idPlayer');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'm_idPlayer', 'm_idPlayer');
    }
}
