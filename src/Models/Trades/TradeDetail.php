<?php

namespace Azuriom\Plugin\Flyff\Models\Trades;

use Illuminate\Database\Eloquent\Model;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;
use Azuriom\Plugin\Flyff\Models\Trades\TradeItem;

class TradeDetail extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'LOGGING_01_DBF.dbo.tblTradeDetailLog';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ['TradeID', 'serverindex', 'idPlayer'];

    protected $connection = 'sqlsrv';

    public function character()
    {
        return $this->hasOne(FlyffCharacter::class, 'm_idPlayer', 'idPlayer')->withoutGlobalScopes(['valid']);
    }

    /**
     * Laravel does not support hasMany on multiple foreign keys so
     * we use Compoships.
     */
    public function sentItems()
    {
        return $this->hasMany(TradeItem::class, ['TradeID','idPlayer'], ['TradeID','idPlayer']);
    }
}
