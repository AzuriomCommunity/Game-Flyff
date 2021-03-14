<?php

namespace Azuriom\Plugin\Flyff\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Flyff\Models\FlyffGuild;

class FlyffGuildController extends Controller
{
    /**
     * Show the home plugin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guilds = FlyffGuild::orderBy('m_nWin', 'desc')->paginate(10);
        return view('flyff::guilds.index', ['guilds' => $guilds]);
    }

    public function show(FlyffGuild $guild)
    {
        return view('flyff::guilds.show', ['guild' => $guild]);
    }
}
