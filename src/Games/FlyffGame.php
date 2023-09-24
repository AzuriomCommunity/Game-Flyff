<?php

namespace Azuriom\Plugin\Flyff\Games;

use Azuriom\Games\Game;
use Azuriom\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Azuriom\Plugin\Flyff\Games\FlyffServerBridge;

class FlyffGame extends Game
{
    public function name()
    {
        return 'Flyff';
    }
    public function id()
    {
        return 'flyff';
    }

    public function getAvatarUrl(User $user, int $size = 64)
    {
        $files = Storage::files("public/flyff/avatars/{$user->id}");
        if (count($files) > 0) {
            return url(Storage::url(Arr::random($files)));
        } else {
            return plugin_asset('flyff', 'img/unknown_avatar.png');
        }
    }

    public function getUserUniqueId(string $name)
    {
        return $name;
    }

    public function getUserName(User $user)
    {
        return $user->name;
    }

    public function getSupportedServers()
    {
        return [
            'flyff-server' => FlyffServerBridge::class,
        ];
    }
}
