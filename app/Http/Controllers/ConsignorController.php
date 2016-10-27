<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Consignor;
use App\Repositories\ConsignorRepository;

class ConsignorController extends Controller
{
   /**
     * The consignor repository instance.
     *
     * @var ConsignorRepository
     */ 
    protected $consignors;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(ConsignorRepository $consignors)
    {
        $this->middleware('auth');

        $this->consignors = $consignors;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('consignors.index', [
            'consignors' => $this->consignors->getAllActive()
        ]);
    }
	
	/**
     * Create a new consignor.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|max:35',
			'lastname' => 'required|max:40',
        ]);
		
		$consignor = new Consignor;
		$consignor->firstname = trim($request->firstname);
		$consignor->lastname = trim($request->lastname);
		
		$consignor->save();
		
        /*$request->consignor()->items()->create([
            'firstname' => $request->firstname,
			'lastname' => $request->lastname,
        ]);*/

        return redirect('/consignors');
    }
	
	public function delete(Request $request,$id) {
	
		$consignor = Consignor::find($id);
		
		$activeItems = array();
		
		foreach($consignor->items as $key => $item) {
			if($item->is_deleted == 0) {
				array_push($activeItems,$item);
			}
		}
		
		if(count($activeItems) > 0) {
			$count = count($activeItems);
			$msg = "Cannot delete " . $consignor->firstname . " " . $consignor->lastname . ". Has $count active item" . ($count > 1 ? "s" : "") ;
			return redirect('/consignors')->with('error',$msg);
		}
		
		$consignor->is_deleted = 1;
		
		$consignor->save();
	
	    return redirect('/consignors');
	}

}
