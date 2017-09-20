<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
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
