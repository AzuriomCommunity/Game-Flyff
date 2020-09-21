<?php

namespace Azuriom\Plugin\Flyff\Models;

use Illuminate\Support\Collection;
use Azuriom\Models\User as BaseUser;

/**
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Shop\Models\PaymentItem[] $items
 */
class User extends BaseUser
{
    /**
     * Get all the payment items purchased by this user.
     */
    public function accounts()
    {
        return $this->hasMany(FlyffAccount::class, 'Azuriom_user_id');
    }

    /**
     * @param  \Azuriom\Models\User  $baseUser
     * @return static
     */
    public static function ofUser(BaseUser $baseUser)
    {
        return (new self())->newFromBuilder($baseUser->getAttributes());
    }

    /**
     * Return all characters for this user.
     *
     * @return Collection
     */
    public function getCharactersAttribute(): Collection
    {
        $characters = new Collection();

        $this->accounts->each(function (FlyffAccount $account) use (&$characters) {
            if (!$account->is_banned) {
                $characters = $characters->merge($account->characters);
            }
        });

        return $characters;
    }
}
