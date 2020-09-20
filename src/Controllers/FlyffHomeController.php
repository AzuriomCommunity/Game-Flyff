<?php

namespace Azuriom\Plugin\Flyff\Controllers;

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
        return view('flyff::index');
    }
}
