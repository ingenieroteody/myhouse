<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Repositories\TransactionRepository;
use App\Repositories\ItemRepository;
use App\Repositories\ConsignorRepository;

class DashboardController extends Controller
{
   /**
     * The transaction repository instance.
     *
     * @var TransactionRepository
     */ 
	protected $transactions;
	
	/**
     * The item repository instance.
     *
     * @var ItemRepository
     */ 
	protected $items;

	/**
     * The Consignor repository instance.
     *
     * @var ConsignorRepository
     */ 
	protected $consignors;
	
    public function __construct(TransactionRepository $transactions, ItemRepository $items, ConsignorRepository $consignors) {
		$this->transactions = $transactions;
		$this->items = $items;
		$this->consignors = $consignors;
	}
	
	/**
     * Display a list of all transactions.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('dashboard.index');
    }
	
	/**
     * Get most sold items.
     *
     * @param  Request  $request
     * @return Response	$response
     */
	public function ajaxGetMostSoldItems(Request $request, $date) {
		
		$items = $this->transactions->getMostSoldItems($date,5);
							
		$response = array(
			"data" => $items
		);
		
		return \Response::json($response);
	}
}
