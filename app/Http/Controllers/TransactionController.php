<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Transaction;
use App\Consignor;
use App\Item;

use App\Repositories\TransactionRepository;
use App\Repositories\ItemRepository;

class TransactionController extends Controller
{
   /**
     * The transaction repository instance.
     *
     * @var TransactionRepository
     */ 
	protected $transactions;
	
	/**
     * The Items repository instance.
     *
     * @var ItemRepository
     */ 
	protected $items;

    /**
     * Create a new controller instance.
     *
     * @param  TransactionRepository  $tasks
     * @return void
     */
	public function __construct(TransactionRepository $transactions, ItemRepository $items) {
		$this->middleware('auth');
		$this->transactions = $transactions;
		$this->items = $items;
	}
	
	/**
     * Display a list of all transactions.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('transactions.index', [
            'transactions' => $this->transactions->getAllActiveTransactionsToday(),
			'items' => $this->items->getAllActive()
        ]);
    }
	
	/**
     * Create a new transaction.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
		$rules = array(
            'item_id' => 'required|exists:items,id',
			'quantity' => 'required|numeric|between:0,9999',
			'price' => 'required|numeric|between:0,9999.99',
			'total_price' => 'required|numeric|between:0,9999.99'		
		);
	
		$validator = Validator::make($request->all(), $rules);

		if($validator->fails()) {
			return redirect('/transactions')->withErrors($validator)->withInput();
		}
		
		//fetch the purchased item
		$item = $this->items->find($request->input('item_id'));
				
		$transaction = new Transaction;
		$transaction->quantity = trim($request->input('quantity'));
		$transaction->price = trim($request->input('price'));
		$transaction->total_price = trim($request->input('total_price'));
		$transaction->item_id = trim($request->input('item_id'));
		$transaction->consignor_id = trim($item->consignor_id);
		$transaction->remarks = trim($request->input('remarks'));

		//check if there are stocks available
		$validator->after(function($validator) use ($transaction, $item) {
			if($item->stocks < $transaction->quantity) {
				$validator->errors()->add('stocks','Insufficient number of stocks. # of stocks available is ' . $item->stocks);
			}
		});

		if($validator->fails()) {
			return redirect('/transactions')->withErrors($validator)->withInput();
		}
		
		$item->stocks = $item->stocks - $transaction->quantity;
		
		DB::transaction(function() use($item,$transaction) {
			//persist to db
			$item->save();
			$item->transaction()->save($transaction);
		});
		
        return redirect('/transactions');
    }
	
	/**
     * Delete transaction.
     *
     * @param  Request  $request
     * @return Response	$response
     */
	public function ajaxDelete(Request $request) {
		
		$id = $request->input('id');
		
		$transaction = $this->transactions->find($id);
		$transaction->is_deleted = 1;
		
		$item = $transaction->item;
		$item->stocks = $item->stocks + $transaction->quantity;
		
		DB::transaction(function() use($item,$transaction) {
			//persist to db
			$transaction->save();
			$item->save();
		});
			
		$response = array(
			"type" => "success",
			"text" => "Transaction #" . $id ." successfully deleted",
			"layout" => "topLeft"
		);
		
		return \Response::json($response);
	}
}
