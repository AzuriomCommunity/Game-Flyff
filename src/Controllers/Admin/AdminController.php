<?php

namespace Azuriom\Plugin\Flyff\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Flyff\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with(['ban', 'accounts'])
            ->when($search, function (Builder $query, string $search) {
                $query->scopes(['search' => $search]);
            })->paginate();

        return view('flyff::admin.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }
}
