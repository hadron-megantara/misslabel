<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales(Request $request){
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

        return view("report.sales", array('user' => $user, 'expense' => $expense));
    }

    public function turnOver(Request $request){
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

        return view("report.turn-over", array('user' => $user, 'expense' => $expense));
    }

    public function cash(Request $request){
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

        return view("report.cash", array('user' => $user, 'expense' => $expense));
    }

    public function freeCash(Request $request){
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

        return view("report.free-cash", array('user' => $user, 'expense' => $expense));
    }
}
