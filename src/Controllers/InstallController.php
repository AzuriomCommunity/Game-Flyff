<?php

namespace Azuriom\Plugin\Flyff\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;

class InstallController extends Controller
{
    public function index()
    {
        Setting::updateSettings(['flyff_installed' => 1]);

        return redirect()->route('home');
    }
}
