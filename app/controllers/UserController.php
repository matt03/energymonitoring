<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
       $user = User::all();
        return View::make('user.index', compact('user'));
	}
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function profile()
    {

        return View::make('user.profile');
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('user.add');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $user=array(

            'firstName' => Input::get('firstname'),
            'middleName' => Input::get('middlename'),
            'lastName' => Input::get('lastname'),
            'username' => Input::get('username'),
            'password' =>Input::get('password'),
            'password_confirm'=>Input::get('password_confirm'),
            'email' => Input::get('email'),
            'phoneNumber' => Input::get('phonenumber'),
            'role' => Input::get('role_id'),

        );
        // create the validation rules ------------------------
        $rules = array(
            'firstName'        => 'required', 						   // just a normal required validation
            'lastName'         => 'required', 						   // just a normal required validation
            'username'         => 'required', 						   // just a normal required validation
            'email'            => 'required|email|unique:rsmsa_users', 	// required and must be unique
            'password'         => 'required',                           // just a normal required validation
            'password_confirm' => 'required|same:password' 			    // required and has to match the password field
        );
        // validate against the inputs from our form
        $validator = Validator::make($user,$rules);
        // check if the validator failed -----------------------
        if ($validator->fails()) {
            // redirect our user back to the form with the errors from the validator
            return Redirect::to('user/add')
                ->withErrors($validator);
        }else{
            $user = User::create(array(
                'firstName' => Input::get('firstname'),
                'middleName' => Input::get('middlename'),
                'lastName' => Input::get('lastname'),
                'username' => Input::get('username'),
                'password' =>Hash::make(Input::get('password')),
                'email' => Input::get('email'),
                'phoneNumber' => Input::get('phonenumber'),
                'role' => Input::get('role_id'),

            ));


            $msg = "Added successful!";

        return View::make('user.add',compact('user','msg'));
        }

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

		$user = User::find($id);
        $user->firstName=Input::get('firstname');
        $user->middleName=Input::get('middlename');
        $user->lastName=Input::get('lastname');
        $user->username=Input::get('username');
        $user->email=Input::get('email');
        $user->phoneNumber=Input::get('phonenumber');
        $user->role=Input::get('role_id');
      
        $user->save();

        $msg = "Edited successful!";

        return View::make('user.edit',compact('user','msg'));




	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $user = User::find($id);
        return View::make('user.edit', compact('user'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
      $user = User::find($id);
      $user->delete();


	}





    /**
     * Show the profile for the given user.
     */
    public function showProfile()
    {
        return View::make('user.profile');
    }


    /**
     *
     * Update the specified resource in storage.
     *
     * @param  int
     * @return Response
     */
    public function updateProfile()
    {
        return View::make('user.profileEdit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function editProfile($id)
    {

        $user = User::find($id);
        $user->firstName=Input::get('firstname');
        $user->middleName=Input::get('middlename');
        $user->lastName=Input::get('lastname');
        $user->username=Input::get('username');
        $user->email=Input::get('email');
        $user->phoneNumber=Input::get('phonenumber');

        $user->save();

        return Redirect::to("userprofile")->With("alert-success","Profile edited successful!");


}



}
