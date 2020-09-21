<?php

namespace Azuriom\Plugin\Flyff\Controllers;

use Azuriom\Plugin\Flyff\Models\User;
use Azuriom\Http\Controllers\Controller;

class FlyffHomeController extends Controller
{
    /**
     * Show the home plugin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::ofUser(auth()->user());
        return view('flyff::index', ['user'=>$user]);
    }
}
