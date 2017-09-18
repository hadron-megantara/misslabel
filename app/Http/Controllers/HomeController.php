<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $request->user()->authorizeRoles(['admin', 'manager']);

        return view("home", array('user' => $user));
    }

      /*
      public function someAdminStuff(Request $request)
      {
        $request->user()->authorizeRoles('manager');

        return view(‘some.view’);
      }
      */
}
