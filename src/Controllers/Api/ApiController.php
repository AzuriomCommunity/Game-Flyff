<?php

namespace Azuriom\Plugin\Flyff\Controllers\Api;

use Illuminate\Http\Request;
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
        $user = User::firstWhere('Azuriom_user_access_token', $request->input('access_token'));

        if ($user === null) {
            return response()->json(['status' => false, 'message' => 'Invalid token'], 422);
        }

        $character = $user->characters()->where('m_szName', $request->input('playerName'))->first();

        if ($character === null) { //tried to save an image for another player.
            return response()->json(['status' => false, 'message' => 'Unkown character'], 422);
        }

        $request->file('avatar')->storeAs(
            "public/flyff/avatars/{$user->Azuriom_user_id}",
            $request->input('playerName').'.png'
        );

        return response()->json(['status' => true, 'message' => 'Image Saved!']);
    }
}
