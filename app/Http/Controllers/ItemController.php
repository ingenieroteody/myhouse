<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Item;
use App\Consignor;
use App\Http\Requests;
use App\Repositories\ItemRepository;
use App\Repositories\ConsignorRepository;
use App\Repositories\TransactionRepository;

class ItemController extends Controller
{
	 /**
     * The item repository instance.
     *
     * @var ItemRepository
     */ 
    protected $items;

	/**
     * The consignor repository instance.
     *
     * @var ConsignorRepository
     */ 
    protected $consignors;
	
	/**
     * The transaction repository instance.
     *
     * @var TransactionRepository
     */ 
    protected $transactions;
	
	/**
	 * Validation rules
	 *
	 * 
	 */
	protected $rules = array(
		'code' => 'required|max:15',
		'name' => 'required|max:50',
		'price' => 'required|numeric|between:0,9999.99',
		'consignor_id' => 'required|exists:consignors,id'
	);
	
    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(ItemRepository $items,ConsignorRepository $consignors,TransactionRepository $transactions)
    {
        $this->middleware('auth');

        $this->items = $items;
		$this->consignors = $consignors;
		$this->transactions = $transactions;
    }
	
	/**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('items.index', [
            'items' => $this->items->getAllActive(),
			'consignors' => $this->consignors->getAllActive()
        ]);
    }
	
	/**
     * Create a new item.
     *
     * @param  Request  $request
     * @return Response
    */ 
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(),$this->rules);
		
		$validator->after(function($validator) use ($request) {
			//check if item code exists
			if($this->items->isItemCodeExist(trim($request->input('code')))) {
				$validator->errors()->add('code','Item code already exists');
			}
		});

		
		if ($validator->fails()) {
            return redirect('/items')->withErrors($validator)->withInput();
        }
		
		$item = new Item;
		$item->code = trim($request->input('code'));
		$item->name = trim($request->input('name'));
		$item->price = trim($request->input('price'));
		$item->consignor_id = trim($request->input('consignor_id'));
		$item->save();

        return redirect('/items');
    }
	
	/**
     * Update existing item.
     *
     * @param  Request  $request
     * @return Response
    */ 
	public function ajaxUpdate(Request $request) {

		$validator = Validator::make($request->all(),$this->rules);
		
		if ($validator->fails()) {		
		
			$response = array(
				"type" => "error",
				"text" => $validator->errors()->messages(),
				"layout" => "topLeft"
			);
			
			return \Response::json($response);
        }
		
		//check if item code exists
		$this->item->findByItemCode(trim($request->input('code')));
		
		$item = $this->items->find($request->input('id'));
		$item->code = trim($request->input('code'));
		$item->name = trim($request->input('name'));
		$item->price = trim($request->input('price'));
		$item->consignor_id = trim($request->input('consignor_id'));
		$item->save();		
		$item->consignor->firstname;
		
		
		$text = "Item $item->code succesfully updated";
		
		$response = array(
			"type" => "success",
			"text" => $text,
			"layout" => "topLeft",
			"data" => $item
		);
		
        return \Response::json($response);
	}
	
	/**
     * Get item details via AJAX
     *
     * @param  Request  $request
     * @return Response
    */ 
    public function ajaxGet(Request $request,$id)
    {

		$item = $this->items->find($id);
		
        return \Response::json($item);
    }
	
	/**
     * delete item via AJAX
     *
     * @param  Request  $request
     * @return Response $response
    */ 
    public function ajaxDelete(Request $request)
    {

		$id = trim($request->input('id'));
	
		$item = $this->items->find($id);
	
		if($this->transactions->hasTransaction($id)==true) {
			$type = "error";
			$text = $item->code . " has active transactions";
		} else {
			$type = "success";
			$text = $item->code . " successfully deleted";
			
			$item = $this->items->find($id);
			$item->is_deleted = 1;
			$item->save();
		}
	
		$response = array(
			"type" => $type,
			"text" => $text,
			"layout" => "topLeft"
		);
		
        return \Response::json($response);
    }
	
	/**
	 * update stock via AJAX
	 *
	 * @param Request $request
	 * @return Response json
	*/
	public function ajaxUpdateStock(Request $request) {
	
		$validator = Validator::make($request->all(), ['stock' => 'required|numeric|between:0,9999']);
	
		$mode = strtoupper(trim($request->input('mode')));
		$stock = trim($request->input('stock'));
	
		$item = $this->items->find($request->input('id'));
		
		if($mode == "ADD") {
			$item->stocks = $stock + $item->stocks;
		}
		if($mode == "MINUS") {
			$item->stocks = $item->stocks - $stock;
		}
				
		
		$validator->after(function($validator) use ($stock, $item) {
			if($stock < 0 || $item->stocks < 0) { 
				$validator->errors()->add('stock','Number of stocks should be greater than 0');
			}
		});
				
		if($validator->fails()) {
		
			$response = array(
				"type" => "error",
				"text" => $validator->errors()->first('stock'),
				"layout" => "topLeft",
				"data" => $mode
			);
			
			return \Response::json($response);
		}				
				
		$item->save();
		
		$response = array(
			"type" => "success",
			"text" => $item,
			"layout" => "topLeft",
			"data" => $mode
		);
	
		return \Response::json($response);
	}
}
