<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Repositories\UserRepository;

class UserController extends Controller
{

   /**
     * The User repository instance.
     *
     * @var UserRepository
     */ 
    protected $users;
	
	/**
     * Create a new controller instance.
     *
     * @param  UserRepository  $tasks
     * @return void
     */
	public function __construct(UserRepository $users) {
		$this->middleware('auth');
		$this->users = $users;
	}
	
	/**
     * Display all users.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('users.index', [
            'users' => $this->users->all(),
        ]);
    }
	
}
