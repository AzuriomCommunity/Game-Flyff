<?php

namespace Azuriom\Plugin\Flyff\Controllers\Admin;

use Illuminate\Http\Request;
use Azuriom\Plugin\Flyff\Models\User;
use Azuriom\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

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

        foreach ($users as $user) {
            $user->refreshActiveBan();
        }
        
        return view('flyff::admin.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }
}
