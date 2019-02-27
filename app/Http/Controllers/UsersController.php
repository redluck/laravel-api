<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller {

    /*---------------------------------------------------------------------------*
	| --construct()                                                              |
	*---------------------------------------------------------------------------*/
    public function __construct() {
        //Proteggiamo il controller con un middleware che ci impone il passaggio
        //del token ad ogni chiamata
        $this->middleware('auth:api');
    }
	
	/*---------------------------------------------------------------------------*
	| index() - lista                                                            |
	*---------------------------------------------------------------------------*/
    public function index() {
        return response()->json(
			[
				'data' => User::get(),
				'success' => true
			]
		);
	}
	
	/*---------------------------------------------------------------------------*
	| show() - ricerca per id                                                    |
	*---------------------------------------------------------------------------*/
    public function show($id) {
		$data = [];
		$message = '';
		try {
			$data = User::findOrFail($id);
			$success = true;
		} catch(\Exception $e) {
			$success = false;
			$message = $e->getMessage();
		}
		return compact('data', 'message', 'success');
		/*
		try {
			return response()->json(
				['data' => User::findOrFail($id)]
			);
		} catch(\Exception $e) {
			return response()->json(
				[
					'data' => [],
					'message' => $e->getMessage()
				]
			);
		}
		*/
	}
	
	/*---------------------------------------------------------------------------*
	| update() - modifica per id                                                 |
	*---------------------------------------------------------------------------*/
	public function update(Request $request, $id) {
        $data = [];
		$message = '';
		try {
			$user = User::findOrFail($id);
			$postData = $request->except('id', '_method');
			$postData['password'] = bcrypt('test');
			$success = $user->update($postData);
			$data = $user;
		} catch(\Exception $e) {
			$success = false;
			$message = $e->getMessage();
		}
		return compact('data', 'message', 'success');
	}
	
	/*---------------------------------------------------------------------------*
	| store() - immagazzinamento nello storage                                   |
	*---------------------------------------------------------------------------*/
	public function store(Request $request) {
		$data = [];
		$message = '';
		try {
			$user = new User();
			$postData = $request->except('id', '_method');
			$postData['password'] = bcrypt('test');
			$user->fill($postData);
			$success = $user->save();
			$data = $user;
		} catch(\Exception $e) {
			$success = false;
			$message = $e->getMessage();
		}
		return compact('data', 'message', 'success');
	}

	/*---------------------------------------------------------------------------*
	| destroy() - cancellazione per id                                           |
	*---------------------------------------------------------------------------*/
	public function destroy($id) {
		$data = [];
		$message = 'User deleted';
		try {
			$user = User::findOrFail($id);
			$data = $user;
			$success = $user->delete();
		} catch(\Exception $e) {
			$success = false;
			$message = 'User not found';
		}
		return compact('data', 'message', 'success');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}
