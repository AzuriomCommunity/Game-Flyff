<?php

use Azuriom\Models\User as BaseUser;
use Azuriom\Plugin\Flyff\Models\User;

if (! function_exists('flyff_hash_mdp')) {
    function flyff_hash_mdp(string $password)
    {
        return md5(env('MD5_HASH_KEY', 'kikugalanet').$password);
    }
}

if (! function_exists('flyff_user')) {

    function flyff_user(BaseUser $baseUser) {
        return User::ofUser($baseUser);
    }
}