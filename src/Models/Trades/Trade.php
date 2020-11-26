<?php

namespace Azuriom\Plugin\Flyff\Models\Trades;

use Illuminate\Database\Eloquent\Model;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;
use Azuriom\Plugin\Flyff\Models\Trades\TradeItem;
use Azuriom\Plugin\Flyff\Models\Trades\TradeDetail;

/**
 * @property int TradeID
 * @property string serverindex
 * @property int WorldID
 * @property Carbon TradeDt
 */
class Trade extends Model
{
    protected $table = 'LOGGING_01_DBF.dbo.tblTradeLog';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ['TradeID','serverindex'];

    protected $connection = 'sqlsrv';
    
    protected $dates = [
        'TradeDt',
    ];

    public function getRouteKeyName() {
        return 'TradeID';
    }

    public function firstTradeDetail()
    {
        return $this->hasOne(TradeDetail::class, 'TradeID', 'TradeID')->orderBy('idPlayer', 'asc')->limit(1);
    }

    public function secondTradeDetail()
    {
        return $this->hasOne(TradeDetail::class, 'TradeID', 'TradeID')->orderBy('idPlayer', 'desc')->limit(1);
    }
}