<?php

namespace Azuriom\Plugin\Flyff\Controllers;

use Azuriom\Plugin\Flyff\Models\User;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Flyff\Models\FlyffGuild;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;

class FlyffRankingsController extends Controller
{
    /**
     * Show the home plugin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function guilds()
    {
        $guilds = FlyffGuild::paginate(10);
        return view('flyff::rankings.guilds', ['guilds'=>$guilds]);
    }

    public function players()
    {
        $characters = FlyffCharacter::paginate(50);
        return view('flyff::rankings.players', ['characters'=>$characters]);
    }
}