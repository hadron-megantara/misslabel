<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(REQUEST $request){
        $user = User::where('email', $request->email)->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                $userData = ["email" => $user->email, "name" => $user->name];
                Session::put('user', $userData);

                return redirect('/');
            } else{
                return redirect('login')->with('error', 'Email atau kata kunci salah');
            }
        } else{
            return redirect('login')->with('error', 'Email atau username tidak teerdaftar');
        }
    }

    public function logout(REQUEST $request){
        Session::forget('user');
        Session::flush();

        return redirect('/');
    }
}
