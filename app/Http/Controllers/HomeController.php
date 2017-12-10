<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\WarehouseStock;
use App\StoreStock;
use App\StoreTransaction;
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

        $stockWarehouse = WarehouseStock::selectRaw('SUM(total) as total')->first();

        $stockStore = StoreStock::selectRaw('SUM(total_product) as total')->first();
        $stockStoreDetail = StoreStock::join('stores', 'store_stocks.store_id', '=', 'stores.id')->selectRaw('stores.name, SUM(store_stocks.total_product) as total')->groupBy('stores.name')->get();

        $omset = StoreTransaction::selectRaw('SUM(final_price) as total')->whereMonth('date', '=', date('m'))->where('payment_type_id', '<>', '3')->first();
        $expense = Expense::selectRaw('SUM(value) as total')->first();
        $receivable = StoreTransaction::selectRaw('SUM(final_price) as total')->where('payment_type_id', '3')->first();
        $profit = (int) $omset->total - (int) $expense->total;

        return view("home", array('user' => $user, 'expense' => $expense, 'stockWarehouse' => $stockWarehouse, 'stockStore' => $stockStore, 'stockStoreDetail' => $stockStoreDetail, 'omset' => $omset, 'receivable' => $receivable, 'profit' => $profit));
    }

      /*
      public function someAdminStuff(Request $request)
      {
        $request->user()->authorizeRoles('manager');

        return view(‘some.view’);
      }
      */
}
