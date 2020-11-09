<?php

namespace Azuriom\Plugin\Flyff\Games;

use Azuriom\Games\Game;
use Azuriom\Models\User;
use Azuriom\Plugin\Flyff\Games\FlyffServerBridge;

class FlyffGame extends Game
{
    public function name()
    {
        return 'Flyff';
    }

    public function getAvatarUrl(User $user, int $size = 64)
    {
        return 'https://www.gravatar.com/avatar/'.md5($user->email).'?d=mp&s='.$size;
    }

    public function getUserUniqueId(string $name)
    {
        return null;
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
