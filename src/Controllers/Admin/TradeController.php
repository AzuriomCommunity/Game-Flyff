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
        return view('flyff::admin.trades.index', [
            'trades' => Trade::paginate(20),
        ]);
    }


    public function show (Trade $trade)
    {
        return view('flyff::admin.trades.show', [
            'trade' => $trade,
        ]);
    }
}