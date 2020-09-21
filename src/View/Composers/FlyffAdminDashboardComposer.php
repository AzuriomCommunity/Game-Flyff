<?php

namespace Azuriom\Plugin\Flyff\View\Composers;

use Azuriom\Plugin\Flyff\Models\FlyffGuild;
use Azuriom\Plugin\Flyff\Models\FlyffAccount;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;
use Azuriom\Extensions\Plugin\AdminDashboardCardComposer;

class FlyffAdminDashboardComposer extends AdminDashboardCardComposer
{
    public function getCards()
    {
        return [
            'flyff_accounts' => [
                'color' => 'warning',
                'name' => 'user\'s account',
                'value' => FlyffAccount::count(),
                'icon' => 'fas fa-money-bill-wave',
            ],
            'created_guilds' => [
                'color' => 'warning',
                'name' => 'in-game guilds',
                'value' => FlyffGuild::count(),
                'icon' => 'fas fa-money-bill-wave',
            ],
            'flyff_characters' => [
                'color' => 'warning',
                'name' => 'in-game characters',
                'value' => FlyffCharacter::count(),
                'icon' => 'fas fa-money-bill-wave',
            ],
        ];
    }
}
