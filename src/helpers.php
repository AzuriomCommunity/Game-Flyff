<?php

if (! function_exists('flyff_hash_mdp')) {
    function flyff_hash_mdp(string $password)
    {
        return md5(env('MD5_HASH_KEY', 'kikugalanet').$password);
    }
}