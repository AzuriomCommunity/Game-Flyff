<?php

namespace Azuriom\Plugin\Flyff\Controllers\Api;

use Illuminate\Http\Request;
use Azuriom\Models\User as BaseUser;
use Azuriom\Plugin\Flyff\Models\User;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Flyff\Requests\UploadAvatarRequest;

class ApiController extends Controller
{
    /**
     * Show the plugin API default page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $baseUser = BaseUser::firstWhere('access_token', $request->input('access_token'));

        if ($baseUser === null) {
            return response()->json(['status' => false, 'message' => 'Invalid token'], 422);
        }

        if ($baseUser->is_banned) {
            return response()->json(['status' => false, 'message' => 'User banned'], 422);
        }
        
        $user = User::ofUser($baseUser);
        $character = $user->characters()->where('m_szName', $request->input('playerName'))->first();

        if($character === null) { //tried to save an image for another player.
            return response()->json(['status' => false, 'message' => 'Unkown character'], 422);
        }

        $request->file('avatar')->storeAs(
            "public/flyff/avatars/{$user->id}", $request->input('playerName').'.png'
        );
        return response()->json('Hello World!');
    }
}
