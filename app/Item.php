<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Consignor;
use App\Transaction;


class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code','name','price','consignor_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'consignor_id' => 'int',
    ];	
	
	/**
	 * Get the consignor that own the item
	 */
	public function consignor() {
		return $this->belongsTo(Consignor::class);
	}
	
	/**
	 * Get the transaction that own the item
	 */
	public function transaction() {
		return $this->hasMany(Transaction::class);
	}
}
