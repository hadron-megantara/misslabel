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
        $storeName = '';
        if($request->has('store') || session::has('store')){
            if($request->has('store') && $request->store != ''){
                $store = $request->store;
                $storeName = $request->storeName;
            } else if(session('store') != '' && session('store') != null){
                $store = session('store');
            }
        }

        $payment = 0;
        if($request->has('payment') || session::has('payment')){
            if($request->has('payment')){
                $payment = $request->payment;
            } else{
                $payment = session('payment');
            }
        }

        $yearList = array();
        for($i = date('Y');$i > 1990;$i--){
            $yearList[] = $i;
        }

        $dateFrom = '';
        if($request->has('dateFrom')){
            $dateFrom = $request->dateFrom;
        }

        $dateTo = '';
        if($request->has('dateTo')){
            $dateTo = $request->dateTo;
        }

        if($store != 0 && $payment != 0){
            $transactionData = StoreTransaction::selectRaw('YEAR(date) as year, SUM(final_price) AS value')->where('store_id', $store)->where('payment_type_id', $payment)->orderBy('date')->groupBy(DB::raw("YEAR(date)"))->get();
        } else if($store != 0 && $payment == 0){
            $transactionData = StoreTransaction::selectRaw('YEAR(date) as year, SUM(final_price) AS value')->where('store_id', $store)->whereYear('date', '=', $year)->orderBy('date')->groupBy(DB::raw("YEAR(date)"))->get();
        } else if($store == 0 && $payment != 0){
            $transactionData = StoreTransaction::selectRaw('YEAR(date) as year, SUM(final_price) AS value')->where('payment_type_id', $payment)->orderBy('date')->groupBy(DB::raw("YEAR(date)"))->get();
        } else{
            $transactionData = StoreTransaction::selectRaw('YEAR(date) as year, SUM(final_price) AS value')->orderBy('date')->groupBy(DB::raw("YEAR(date)"))->get();
        }

        if(count($transactionData) > 0){
            foreach($transactionData as $transactionData){
                $transactionDataArray[] = array('year' => $transactionData->year, 'value' => $transactionData->value);
            }
        } else{
            $transactionDataArray = null;
        }

        return view("report.sales-year", array('user' => $user, 'store' => $store, 'storeList' => $storeList, 'productDetail' => $productDetail, 'paymentType' => $paymentType, 'payment' => $payment, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'yearList' => $yearList, 'transactionDataArray' => $transactionDataArray, 'storeName' => $storeName));
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
        $storeName = '';
        if($request->has('store') || session::has('store')){
            if($request->has('store') && $request->store != ''){
                $store = $request->store;
                $storeName = $request->storeName;
            } else if(session('store') != '' && session('store') != null){
                $store = session('store');
            }
        }

        $payment = 0;
        if($request->has('payment') || session::has('payment')){
            if($request->has('payment')){
                $payment = $request->payment;
            } else{
                $payment = session('payment');
            }
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

        $dateFrom = '';
        if($request->has('dateFrom')){
            $dateFrom = $request->dateFrom;
        }

        $dateTo = '';
        if($request->has('dateTo')){
            $dateTo = $request->dateTo;
        }

        if($store != 0 && $payment != 0){
            $transactionData = StoreTransaction::selectRaw('MONTHNAME(date) as month, SUM(final_price) AS value')->where('store_id', $store)->where('payment_type_id', $payment)->whereYear('date', '=', $year)->orderBy('date')->groupBy(DB::raw("MONTHNAME(date)"))->get();
        } else if($store != 0 && $payment == 0){
            $transactionData = StoreTransaction::selectRaw('MONTHNAME(date) as month, SUM(final_price) AS value')->where('store_id', $store)->whereYear('date', '=', $year)->orderBy('date')->groupBy(DB::raw("MONTHNAME(date)"))->get();
        } else if($store == 0 && $payment != 0){
            $transactionData = StoreTransaction::selectRaw('MONTHNAME(date) as month, SUM(final_price) AS value')->where('payment_type_id', $payment)->whereYear('date', '=', $year)->orderBy('date')->groupBy(DB::raw("MONTHNAME(date)"))->get();
        } else{
            $transactionData = StoreTransaction::selectRaw('MONTHNAME(date) as month, SUM(final_price) AS value')->whereYear('date', '=', $year)->orderBy('date')->groupBy(DB::raw("MONTHNAME(date)"))->get();
        }

        $expenseData = Expense::selectRaw('MONTHNAME(date) as month, SUM(value) AS value')->whereYear('date', '=', $year)->orderBy('date')->groupBy(DB::raw("MONTHNAME(date)"))->get();

        if(count($expenseData) > 0){
            foreach($expenseData as $expenseData){
                $expenseDataArray[] = array('month' => $expenseData->month, 'value' => $expenseData->value);
            }
        } else{
            $expenseDataArray = null;
        }

        if(count($transactionData) > 0){
            foreach($transactionData as $transactionData){
                $transactionDataArray[] = array('month' => $transactionData->month, 'value' => $transactionData->value);
            }
        } else{
            $transactionDataArray = null;
        }

        return view("report.sales-month", array('user' => $user, 'store' => $store, 'storeList' => $storeList, 'productDetail' => $productDetail, 'paymentType' => $paymentType, 'payment' => $payment, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'yearList' => $yearList, 'year' => $year, 'transactionDataArray' => $transactionDataArray, 'storeName' => $storeName, 'expenseDataArray' => $expenseDataArray));
    }

    public function turnOverMonth(Request $request){
    	setlocale(LC_ALL, "ID");

        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $storeList = Store::all();
        $productDetail = ProductDetail::all();
        $paymentType = PaymentType::all();

        $store = 0;
        $storeName = '';
        if($request->has('store') || session::has('store')){
            if($request->has('store') && $request->store != ''){
                $store = $request->store;
                $storeName = $request->storeName;
            } else if(session('store') != '' && session('store') != null){
                $store = session('store');
            }
        }

        $payment = 0;
        if($request->has('payment') || session::has('payment')){
            if($request->has('payment')){
                $payment = $request->payment;
            } else{
                $payment = session('payment');
            }
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

        $dateFrom = '';
        if($request->has('dateFrom')){
            $dateFrom = $request->dateFrom;
        }

        $dateTo = '';
        if($request->has('dateTo')){
            $dateTo = $request->dateTo;
        }

        if($store != 0 && $payment != 0){
            $transactionData = StoreTransaction::selectRaw('MONTHNAME(date) as month, SUM(final_price) AS value')->where('store_id', $store)->where('payment_type_id', $payment)->whereYear('date', '=', $year)->orderBy('date')->groupBy(DB::raw("MONTHNAME(date)"))->get();
        } else if($store != 0 && $payment == 0){
            $transactionData = StoreTransaction::selectRaw('MONTHNAME(date) as month, SUM(final_price) AS value')->where('store_id', $store)->whereYear('date', '=', $year)->orderBy('date')->groupBy(DB::raw("MONTHNAME(date)"))->get();
        } else if($store == 0 && $payment != 0){
            $transactionData = StoreTransaction::selectRaw('MONTHNAME(date) as month, SUM(final_price) AS value')->where('payment_type_id', $payment)->whereYear('date', '=', $year)->orderBy('date')->groupBy(DB::raw("MONTHNAME(date)"))->get();
        } else{
            $transactionData = StoreTransaction::selectRaw('MONTHNAME(date) as month, SUM(final_price) AS value')->whereYear('date', '=', $year)->orderBy('date')->groupBy(DB::raw("MONTHNAME(date)"))->get();
        }

        if(count($transactionData) > 0){
            foreach($transactionData as $transactionData){
                $transactionDataArray[] = array('month' => $transactionData->month, 'value' => $transactionData->value);
            }
        } else{
            $transactionDataArray = null;
        }

        return view("report.turn-over-month", array('user' => $user, 'store' => $store, 'storeList' => $storeList, 'productDetail' => $productDetail, 'paymentType' => $paymentType, 'payment' => $payment, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'yearList' => $yearList, 'year' => $year, 'transactionDataArray' => $transactionDataArray, 'storeName' => $storeName));
    }

    public function turnOverYear(Request $request){
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
