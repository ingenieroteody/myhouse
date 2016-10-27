<?php

namespace App\Repositories;

use App\Item;


class ItemRepository
{
	protected $item;

	public function __construct(Item $item) {
		$this->item = $item;
	}

	public function getAllActive() {
		return $this->item->where('is_deleted',0)->get();
	}
	
	public function find($id) {
		return $this->item->find($id);
	}
	
	public function isItemCodeExist($code) {
		return $this->item->where('code',$code)->count() > 0 ? true : false;
	}
	
}
