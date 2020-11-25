<?php

namespace Azuriom\Plugin\Flyff\Models\Trades;

use Illuminate\Database\Eloquent\Model;

class TradeItem extends Model
{
    protected $table = 'LOGGING_01_DBF.dbo.tblTradeItemLog';
    public $timestamps = false;
    public $incrementing = false;
}