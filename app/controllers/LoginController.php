<?php

class LoginController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make('login');
    }
    public function login()
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'username'    => 'required', // make sure the email is an actual email
            'password' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

            // create our user data for the authentication
            $userdata = array(
                'username' 	=> Input::get('username'),
                'password' 	=> Input::get('password')
            );

            // attempt to do the login
            if(Input::get('remember') == "remember-me"){ //keep the user logged in
                if (Auth::attempt($userdata,true)) {
                    // validation successful!
                    // redirect them to the secure section or whatever
                    return Redirect::to('dashboard');
                } else {
                    // validation not successful, send back to form
                    return Redirect::to('login')->with("alert-fail","Incorrect username or password!!");
                }
            }else{
                if (Auth::attempt($userdata)) {
                    // validation successful!
                    // redirect them to the secure section or whatever
                    return Redirect::to('dashboard');
                } else {
                    // validation not successful, send back to form
                    return Redirect::to('login')->with("alert-fail","Incorrect username or password!!");
                }
            }


        }
    }
    public function logout()
    {
        Auth::logout(); // log the user out of our application
        return Redirect::to('login'); // redirect the user to the login screen
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
