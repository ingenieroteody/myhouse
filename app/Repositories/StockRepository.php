<?php

namespace App\Repositories;

use App\Stock;
use App\User;

class StockRepository
{
    /**
     * Get all of the stocks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return Stock::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
	
	public function all() 
	{
		return Stock::all();
	}
}
