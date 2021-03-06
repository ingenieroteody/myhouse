<?php

namespace App\Repositories;

use App\Transaction;


class TransactionRepository
{

	protected $transaction;

	public function __construct(Transaction $transaction) {
		$this->transaction = $transaction;
	}

	public function find($id) {
		return $this->transaction->where('is_deleted',0)->where('id',$id)->first();
	}
	
	public function getAllActive() {
		return $this->transaction->where('is_deleted',0)->get();
	}
	
	public function getAllActiveTransactionsToday() {
		return $this->transaction->where('is_deleted',0)->whereDate('created_at','=',date('Y-m-d'))->get();
	}
	
	public function getMostSoldItems($date, $number) {
		return $this->transaction->select(\DB::raw('COUNT(quantity) AS total_quantity'),\DB::raw('SUM(total_price) AS total_price'), 'item_id')->with('item')->where('is_deleted',0)->whereDate('created_at','=',$date)->groupBy('item_id')->orderBy('total_quantity','DESC')->get(); 
	}
	
	public function hasTransaction($id) {
		if(count($this->transaction->where('item_id',$id)->where('is_deleted',0)->take(1)->get()) > 0) {
			return true;
		} else {
			return false;
		}
	}
}
