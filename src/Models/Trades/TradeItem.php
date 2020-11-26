<?php

namespace Azuriom\Plugin\Flyff\Models\Trades;

use Illuminate\Database\Eloquent\Model;

class TradeItem extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'LOGGING_01_DBF.dbo.tblTradeItemLog';
    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey = ['TradeID', 'serverindex', 'idPlayer', 'ItemIndex', 'ItemSerialNum'];
}