<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Item;
use App\Transaction;


class Consignor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname','lastname'];

	/**
	 * Get all items from consignor
	 */
    public function items() {
		return $this->hasMany(Item::class);
	}
	
	/**
	 * Get the consignor that own the item
	 */
	public function transaction() {
		return $this->hasMany(Transaction::class);
	}
}
