<?php

namespace App\Repositories;

use App\User;


class UserRepository
{
    /**
     * Get all Users.
     *
     * @param  User  $user
     * @return Collection
     */
    public function all()
    {
        return User::all();
    }
}
