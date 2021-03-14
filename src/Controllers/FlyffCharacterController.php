<?php

namespace Azuriom\Plugin\Flyff\Controllers;

use Illuminate\Http\Request;
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
        $characters = FlyffCharacter::orderBy('TotalPlayTime', 'desc')->paginate(50);
        return view('flyff::characters.index', ['characters' => $characters]);
    }

    public function show(FlyffCharacter $character)
    {
        return view('flyff::characters.show', ['character' => $character]);
    }

    public function shop_update_character(Request $request)
    {
        $validated = $this->validate($request, [
            'character' => ['required'],
        ]);

        $id_serverindex = explode('_', $validated['character']);

        session(['m_idPlayer' => (int) $id_serverindex[0]]);
        session(['m_nServer'=> (int) $id_serverindex[1]]);

        return redirect()->route('shop.cart.index')->with('success', 'Player changed');
    }
}
