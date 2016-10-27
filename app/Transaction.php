<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Item;
use App\Consignor;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['consignor_id','item_id,','quantity','price','total_price'];

	/**
	 * Get the consignor of this transaction
	 */
	public function consignor() {
		return $this->belongsTo(Consignor::class);
	}
	
	/**
	 * Get the item of this transaction
	 */
	public function item() {
		return $this->belongsTo(Item::class);
	}
}
