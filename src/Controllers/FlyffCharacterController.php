<?php

namespace Azuriom\Plugin\Flyff\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;

class FlyffCharacterController extends Controller
{
    /**
     * Show the home plugin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $characters = FlyffCharacter::paginate(50);
        return view('flyff::characters.index', ['characters' => $characters]);
    }

    public function show(FlyffCharacter $character)
    {
        return view('flyff::characters.show', ['character' => $character]);
    }
}
