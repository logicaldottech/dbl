<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lead;
use Illuminate\Support\Collection;
// use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Arr;
use App\User;
use Illuminate\Support\Facades\Hash;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('app/index', ['user' => $user] );

    }


    public function init()
    {

         return redirect()->route('login');
    }

    public function viewProfile(){

      $user = Auth::user();
      return view('profile/main', ['user' => $user] );

    }

    public function viewUserProfile(){

      $user_id = Auth::user()->id;
      $user = User::with('credit')->find($user_id);

      $data[] = $user;
      return response()->json($data);

    }

    public function updateUserData(Request $request){

      $user_id = Auth::id();

      $first_name = $request->first_name;
      $last_name = $request->last_name;
      $email = $request->email;
      $phone = $request->phone;

      $check = $user = User::where('email', $email)
                          ->where('id', '!=', $user_id)->first();

      if ($check) {
        return response()->json("email_exists");
      }
      $userArr = array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'phone' => $phone,
        );

        $user = User::where('id', $user_id)
            ->update($userArr);

        $userData = User::with('credit')->where('id', $user_id)->get();
      return response()->json($userData);

    }

    public function updateUserpassword(Request $request){

        $user_id = Auth::id();
        $password = $request->password;

        $passArr = array(
          'password' => Hash::make($password),
          );

        $userPass = User::where('id', $user_id)
              ->update($passArr);

        return response()->json(true);
    }

}
