<?php

namespace Azuriom\Plugin\Flyff\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('flyff::admin.index');
    }
}
