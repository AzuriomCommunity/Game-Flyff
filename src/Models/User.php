<?php

namespace Azuriom\Plugin\Flyff\Models;

use Illuminate\Support\Collection;
use Azuriom\Models\User as BaseUser;
use Azuriom\Plugin\Flyff\Models\FlyffAccount;
use Azuriom\Plugin\Flyff\Models\FlyffCharacter;

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

    public function characters()
    {
        return $this->hasManyThrough(FlyffCharacter::class, FlyffAccount::class, 'Azuriom_user_id', 'account', 'id', 'account');
    }
}
