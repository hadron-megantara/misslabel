<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        setlocale(LC_ALL, "ID");

        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $expenseData = Expense::selectRaw('MONTH(date) as month, SUM(value) AS value')->orderBy('date')->groupBy(DB::raw("MONTH(date)"))->get();

        $expense = array();
        foreach($expenseData as $expenseData){
          $monthName = strftime("%B", mktime(0, 0, 0, $expenseData->month, 1));
          $expense[] = array('month' => $monthName, 'value' => $expenseData->value);
        }

        return view("home", array('user' => $user, 'expense' => $expense));
    }

      /*
      public function someAdminStuff(Request $request)
      {
        $request->user()->authorizeRoles('manager');

        return view(‘some.view’);
      }
      */
}
