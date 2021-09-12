<?php

namespace Azuriom\Plugin\Flyff\Controllers;

use Illuminate\Support\Facades\DB;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Flyff\Models\GuildSiegeLog;

class GuildSiegeLogController extends Controller
{
    /**
     * Show the home plugin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guildSieges = GuildSiegeLog::orderBy('happened_at', 'desc')->paginate(15);
        return view('flyff::guild-siege.index', ['guildSieges'=>$guildSieges]);
    }

    public function show(GuildSiegeLog $guildSiege)
    {
        return view('flyff::guild-siege.show', ['guildSiege'=>$guildSiege]);
    }
}
