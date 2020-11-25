<?php

namespace Azuriom\Plugin\Flyff\Models\Trades;

use Illuminate\Database\Eloquent\Model;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;
use Azuriom\Plugin\Flyff\Models\Trades\TradeItem;

class TradeDetail extends Model
{
    protected $table = 'LOGGING_01_DBF.dbo.tblTradeDetailLog';
    public $timestamps = false;
    public $incrementing = false;

    public function character()
    {
        return $this->hasOne(FlyffCharacter::class, 'm_idPlayer','idPlayer')->withoutGlobalScopes(['valid']);
    }

    public function sentItems()
    {
        return $this->hasMany(TradeItem::class, 'idPlayer', 'idPlayer')->where('TradeID', $this->TradeID);
    }
}