<?php

namespace Azuriom\Plugin\Flyff\Controllers\Admin;

use Illuminate\Http\Request;
use Azuriom\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Azuriom\Plugin\Flyff\Models\Trades\Trade;

class TradeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bigQuery = Trade::whereHas('firstTradeDetail.character', function (Builder $query) use ($search){
            $query->where('m_szName', 'like', "%$search%");
        })->orWhereHas('secondTradeDetail.character', function (Builder $query) use ($search){
            $query->where('m_szName', 'like', "%$search%");
        });

        if (is_numeric($search)) {
            $bigQuery->orWhere('TradeID', $search);
            $bigQuery->orWhereHas('firstTradeDetail', function (Builder $query) use ($search){
                $query->where('TradeGold', $search);
            });
            $bigQuery->orWhereHas('secondTradeDetail', function (Builder $query) use ($search){
                $query->where('TradeGold', $search);
            });
            $bigQuery->orWhereHas('firstTradeDetail.sentItems', function (Builder $query) use ($search){
                $query->where('ItemIndex', $search);
            });
            $bigQuery->orWhereHas('secondTradeDetail.sentItems', function (Builder $query) use ($search){
                $query->where('ItemIndex', $search);
            });
        }

        return view('flyff::admin.trades.index', [
            'trades' => $bigQuery->paginate(20),
            'search' => $search
        ]);
    }


    public function show (Trade $trade)
    {
        return view('flyff::admin.trades.show', [
            'trade' => $trade,
        ]);
    }
}