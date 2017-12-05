<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Expense;
use App\Material;
use App\MaterialIn;
use App\ConvectionList;
use App\ConvectionMaterialIn;
use App\Product;
use App\ProductDetail;
use App\DeliveryNote;
use App\Warehouse;
use App\WarehouseStore;
use App\Store;
use App\StoreStock;
use App\StoreIn;
use App\StoreSold;
use App\StoreTransaction;
use App\PaymentType;
use Carbon\Carbon;
use session;

class ReportController extends Controller
{
    public function salesYear(Request $request){
    	setlocale(LC_ALL, "ID");

        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $storeList = Store::all();
        $productDetail = ProductDetail::all();
        $paymentType = PaymentType::all();

        $store = 0;
        if($request->has('store') || session::has('store')){
            if($request->has('store')){
                $store = $request->store;
            } else{
                $store = session('store');
            }
        } else{
            $firstStore = Store::first();
            $store = $firstStore->id;
        }

        $payment = 0;
        if($request->has('payment') || session::has('payment')){
            if($request->has('payment')){
                $payment = $request->payment;
            } else{
                $payment = session('payment');
            }
        } else{
            $firstPaymentType = PaymentType::first();
            $payment = $firstPaymentType->id;
        }

        $dateFrom = '';
        if($request->has('dateFrom')){
            $dateFrom = $request->dateFrom;
        }

        $dateTo = '';
        if($request->has('dateTo')){
            $dateTo = $request->dateTo;
        }

        $expenseData = Expense::selectRaw('MONTH(date) as month, SUM(value) AS value')->orderBy('date')->groupBy(DB::raw("MONTH(date)"))->get();

        $expense = array();
        foreach($expenseData as $expenseData){
          $monthName = strftime("%B", mktime(0, 0, 0, $expenseData->month, 1));
          $expense[] = array('month' => $monthName, 'value' => $expenseData->value);
        }

        return view("report.sales-year", array('user' => $user, 'expense' => $expense, 'store' => $store, 'storeList' => $storeList, 'productDetail' => $productDetail, 'paymentType' => $paymentType, 'payment' => $payment, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo));
    }

    public function salesMonth(Request $request){
        setlocale(LC_ALL, "ID");

        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $storeList = Store::all();
        $productDetail = ProductDetail::all();
        $paymentType = PaymentType::all();

        $store = 0;
        if($request->has('store') || session::has('store')){
            if($request->has('store')){
                $store = $request->store;
            } else{
                $store = session('store');
            }
        } else{
            $firstStore = Store::first();
            $store = $firstStore->id;
        }

        $payment = 0;
        if($request->has('payment') || session::has('payment')){
            if($request->has('payment')){
                $payment = $request->payment;
            } else{
                $payment = session('payment');
            }
        } else{
            $firstPaymentType = PaymentType::first();
            $payment = $firstPaymentType->id;
        }

        $year = 0;
        if($request->has('year') || session::has('year')){
            if($request->has('year')){
                $year = $request->year;
            } else{
                $year = session('year');
            }
        } else{
            $year = date('Y');
        }

        $yearList = array();
        for($i = date('Y');$i > 1990;$i--){
            $yearList[] = $i;
        }

        $transactionData = StoreTransaction::selectRaw('MONTH(date) as month, SUM(final_price) AS value')->whereYear('date', '=', date('Y'))->orderBy('date')->groupBy(DB::raw("MONTH(date)"))->get();
        dd($transactionData);

        $expense = array();
        foreach($expenseData as $expenseData){
          $monthName = strftime("%B", mktime(0, 0, 0, $expenseData->month, 1));
          $expense[] = array('month' => $monthName, 'value' => $expenseData->value);
        }

        return view("report.sales-month", array('user' => $user, 'expense' => $expense, 'store' => $store, 'storeList' => $storeList, 'productDetail' => $productDetail, 'paymentType' => $paymentType, 'payment' => $payment, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'yearList' => $yearList, 'year' => $year));
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
