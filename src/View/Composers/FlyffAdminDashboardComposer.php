<?php

namespace Azuriom\Plugin\Flyff\View\Composers;

use Azuriom\Extensions\Plugin\AdminDashboardCardComposer;
use Azuriom\Plugin\Flyff\Models\FlyffAccount;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;
use Azuriom\Plugin\Flyff\Models\FlyffGuild;

class FlyffAdminDashboardComposer extends AdminDashboardCardComposer
{
    public function getCards()
    {
        try {
            $user_count = FlyffAccount::count();
            $guild_count = FlyffGuild::count();
            $character_count = FlyffCharacter::count();
        } catch (\Throwable $th) {
            $user_count = 0;
            $guild_count = 0;
            $character_count = 0;
        }

        return [
            'flyff_accounts' => [
                'color' => 'warning',
                'name' => 'user\'s account',
                'value' => $user_count,
                'icon' => 'bi bi-bar-chart-line-fill',
            ],
            'created_guilds' => [
                'color' => 'warning',
                'name' => 'in-game guilds',
                'value' => $guild_count,
                'icon' => 'bi bi-bar-chart-line-fill',
            ],
            'flyff_characters' => [
                'color' => 'warning',
                'name' => 'in-game characters',
                'value' => $character_count,
                'icon' => 'bi bi-bar-chart-line-fill',
            ],
        ];
    }
}
