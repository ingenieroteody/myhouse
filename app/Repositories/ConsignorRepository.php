<?php

namespace App\Repositories;

use App\Consignor;


class ConsignorRepository 
{	
	protected $consignor;
	
	public function __construct(Consignor $consignor) {
		$this->consignor = $consignor;
	}
		
	public function getAllActive() {
		return $this->consignor->where('is_deleted',0)->get();
	}
}
