<?php

namespace Azuriom\Plugin\Flyff\Controllers\Admin;

use Illuminate\Http\Request;
use Azuriom\Plugin\Flyff\Models\Mail;
use Azuriom\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class MailController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $bigQuery = Mail::whereHas('receiver', function (Builder $query) use ($search){
            $query->where('m_szName', 'like', "%$search%");
        })->orWhereHas('sender', function (Builder $query) use ($search){
            $query->where('m_szName', 'like', "%$search%");
        })->orWhere('szTitle' , 'like', "%$search%");
        
        if (is_numeric($search)) {
            $bigQuery->orWhere('dwItemId', $search);
            $bigQuery->orWhere('nMail', $search);
            $bigQuery->orWhere('nGold', $search);
        }
        return view('flyff::admin.mails.index', [
            'mails' => $bigQuery->paginate(20),
            'search' => $search
        ]);
    }

}