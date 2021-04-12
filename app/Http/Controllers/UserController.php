<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\User;

use App\Credit;
use Response,DB,Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailRegister;
use App\Mail\MailLogin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller {

 // -------------------- [ user registration view ] -------------
    public function index() {
    	if(Auth::check()) {
            return redirect()->route('home');
        }
        return view('register');
    }

// --------------------- [ Register user ] ----------------------
    public function userPostRegistration(Request $request) {

    	$rules = array(
    		    'first_name'        =>      'required',
            'last_name'         =>      'required',
            'email'             =>      'required|email',
            'password'          =>      'required|min:6',
            'confirm_password'  =>      'required|same:password',
            'phone_number'      =>      'nullable|min:10|max:10'
    		);

        $validator = Validator::make($request->all(), $rules);

        $input          =           $request->all();

        // return response()->json($request->phone_number);
 		if ($validator->fails())
		{
        return response()->json(['error'=>array_reverse($validator->getMessageBag()->toArray())]);

		}

        $email = $request->email;
        $isExists = User::where('email',$email)->first();

        if($isExists){
            return response()->json(array("exists" => true));
        }
        // if validation success then create an input array
        $inputArray      =           array(
            'first_name'        =>      $request->first_name,
            'last_name'         =>      $request->last_name,
            'email'             =>      $request->email,
            'password'          =>      Hash::make($request->password),
            'phone'             =>      $request->phone_number
        );

        $userModel = new User($inputArray);
        $userModel->save();
        $id = $userModel->id;

        $user = Auth::user();

        // if registration success then return with success message
        if(!is_null($id)) {

            $creditArray = array(
                'user_id'  => $id,
                'balance'  => 0
            );

            $credit = Credit::create($creditArray);

            if (isset($credit->id)) {

                Mail::to($email)->send(new MailRegister($user));

                if (Mail::failures()) {

                   return response()->json(['success'=> 'You have registered successfully.']);
                }else{

                    return response()->json(['success'=> 'You have registered successfully.']);
                }


            }

        }

        // else return with error message
        else {
            return response()->json(['error'=> 'Whoops! some error encountered. Please try again.']);
        }

		// return Response::json(array('success' => true), 200);
    }


// -------------------- [ User login view ] -----------------------
    public function userLoginIndex() {

    	if(Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }


// --------------------- [ User login ] ---------------------
    public function userPostLogin(Request $request) {

         $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
              ],
          	[
                  'email.required' => 'Email is required',
                  'password.required' => 'Password is required'
              ]);

       		if ($validator->fails()){
              	return response()->json(['error'=>array_reverse($validator->getMessageBag()->toArray())]);
       		}

        $credentials = $request->only('email', 'password');

        // check user using auth function
         if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $email = $user->email;

            //Mail::to($email)->send(new MailLogin($user));

            return response()->json(['success'=>'/']);

        }

        return response()->json(['error'=>['wrong-data'=>'Invalid Email or Passsword']]);


    }


// ------------------ [ User Dashboard Section ] ---------------------
    public function dashboard() {

        // check if user logged in
        if(Auth::check()) {
            return view('layouts/header');
        }

        return redirect::to("login")->withSuccess('Oopps! You do not have access');
    }


// ------------------- [ User logout function ] ----------------------
    public function logout(Request $request ) {
        $request->session()->flush();
        Auth::logout();
        return Redirect('login');
        }


    public function getUser()
    {
        $user = Auth::user();

        return response()->json($user);

    }


}
