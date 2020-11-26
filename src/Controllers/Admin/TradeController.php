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

        $query = Trade::whereHas('firstTradeDetail.character', function (Builder $query) use ($search){
            $query->where('m_szName', 'like', "%$search%");}
        )->orWhereHas('secondTradeDetail.character', function (Builder $query) use ($search){
            $query->where('m_szName', 'like', "%$search%");}
        );
        if (is_numeric($search)) {
            $query->orWhere('TradeID', $search);
        }
        return view('flyff::admin.trades.index', [
            'trades' => $query->paginate(20),
        ]);
    }


    public function show (Trade $trade)
    {
        return view('flyff::admin.trades.show', [
            'trade' => $trade,
        ]);
    }
}