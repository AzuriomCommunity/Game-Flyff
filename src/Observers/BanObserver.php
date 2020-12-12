<?php

namespace Azuriom\Plugin\Flyff\Observers;

use Azuriom\Models\Ban;
use Azuriom\Plugin\Flyff\Models\User;

class BanObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(Ban $ban)
    {
        $user = User::ofUser($ban->user);

        $user->accounts->each(function ($account) {
            $account->detail->BlockTime = today()->addYears(10)->format('Ymd');
            $account->detail->save();
        });

        $user->characters->each(function ($character) {
            $character->isblock = 'D';
            $character->save();
        });
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(Ban $ban)
    {
        $user = User::ofUser($ban->user);

        $user->accounts->each(function ($account) {
            $account->detail->BlockTime = today()->subDays(1)->format('Ymd');
            $account->detail->save();
        });

        $user->characters->each(function ($character) {
            $character->isblock = 'F';
            $character->save();
        });
    }
}
