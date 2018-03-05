<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
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
use App\StoreTransfer;
use App\PaymentType;
use Carbon\Carbon;
use session;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function stock(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $warehouseList = Warehouse::all();
        $storeList = Store::all();
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

        return view("store.list", array('user' => $user, 'store' => $store, 'storeList' => $storeList, 'paymentType' => $paymentType));
    }

    public function getStock(Request $request){
        if($request->has('store') && $request->store != ''){
            $product = StoreStock::join('product_details', 'store_stocks.product_detail_id', '=', 'product_details.id')->join('product_models', 'product_details.product_model_id', '=', 'product_models.id')->join('colors', 'store_stocks.color_id', '=', 'colors.id')->selectRaw('store_stocks.id, product_models.name, product_details.description, product_details.price, product_details.unit, store_stocks.material_type, colors.name as color, store_stocks.total_product')->where('store_stocks.store_id', $request->store)->where('store_stocks.total_product', '>', '0')->orderBy('product_models.name', 'asc')->get();
        } else{
            $product = StoreStock::join('product_details', 'store_stocks.product_detail_id', '=', 'product_details.id')->join('product_models', 'product_details.product_model_id', '=', 'product_models.id')->join('colors', 'store_stocks.color_id', '=', 'colors.id')->selectRaw('product_models.name, product_details.description, product_details.price, product_details.unit, store_stocks.material_type, colors.name as color, store_stocks.total_product')->where('store_stocks.total_product', '>', '0')->orderBy('product_models.name', 'asc')->get();
        }

        return Datatables::of($product)->make();
    }

    public function storeList(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        return view("store.store-list", array('user' => $user));
    }

    public function getStoreList(){
        $storeList = Store::select(['id', 'name', 'description'])->orderBy('updated_at', 'desc');
     
        return Datatables::of($storeList)->make();
    }

    public function storeStoreList(Request $request){
        $storeList = new Store;

        $storeList->name = $request->storeListName;
        $storeList->description = $request->storeListDescription;

        $storeList->save();

        return redirect('/store/store-list')->with('success', 'Sukses menyimpan data toko');
    }

    public function updateStoreList(Request $request){
        $storeList = Store::find($request->storeListId);
        
        $storeList->name = $request->storeListName;
        $storeList->description = $request->storeListDescription;

        $storeList->save();

        return redirect('/store/store-list')->with('success', 'Sukses mengubah data toko');
    }

    public function destroyStoreList(Request $request){
        $storeList = Store::find($request->storeListId);

        $storeList->delete();

        return redirect('/store/store-list')->with('success', 'Sukses menghapus data toko');
    }

    public function incomingProduct(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $warehouseList = Warehouse::all();
        $storeList = Store::all();

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

        $warehouse = 0;
        if($request->has('warehouse') || session::has('warehouse')){
            if($request->has('warehouse')){
                $warehouse = $request->warehouse;
            } else{
                $warehouse = session('warehouse');
            }
        }

        return view("store.incoming-product", array('user' => $user, 'store' => $store, 'storeList' => $storeList, 'warehouseList' => $warehouseList, 'warehouse' => $warehouse));
    }

    public function getIncomingProduct(Request $request){
        if(($request->has('store') && $request->store != 0) && ($request->has('warehouse') && $request->warehouse != 0)){
            $product = StoreIn::join('product_details', 'store_in.product_detail_id', '=', 'product_details.id')->join('product_models', 'product_details.product_model_id', '=', 'product_models.id')->join('warehouse_stores', 'store_in.warehouse_store_id', '=', 'warehouse_stores.id')->join('warehouses', 'warehouse_stores.warehouse_id', '=', 'warehouses.id')->join('stores', 'warehouse_stores.store_id', '=', 'stores.id')->selectRaw('warehouses.name as warehouse_name, store_in.id, product_models.name, warehouse_stores.description, warehouse_stores.date_delivery, store_in.total_product, stores.name as store_name')->where('warehouse_stores.store_id', $request->store)->where('warehouses.id', $request->warehouse)->where('store_in.status', 0)->orderBy('warehouse_stores.date_delivery', 'desc')->get();
        } else if($request->has('store') && $request->store != 0){
            $product = StoreIn::join('product_details', 'store_in.product_detail_id', '=', 'product_details.id')->join('product_models', 'product_details.product_model_id', '=', 'product_models.id')->join('warehouse_stores', 'store_in.warehouse_store_id', '=', 'warehouse_stores.id')->join('warehouses', 'warehouse_stores.warehouse_id', '=', 'warehouses.id')->join('stores', 'warehouse_stores.store_id', '=', 'stores.id')->selectRaw('warehouses.name as warehouse_name, store_in.id, product_models.name, warehouse_stores.description, warehouse_stores.date_delivery, store_in.total_product, stores.name as store_name')->where('warehouse_stores.store_id', $request->store)->where('store_in.status', 0)->orderBy('warehouse_stores.date_delivery', 'desc')->get();
        } else if($request->has('warehouse') && $request->warehouse != 0){
            $product = StoreIn::join('product_details', 'store_in.product_detail_id', '=', 'product_details.id')->join('warehouse_stores', 'store_in.warehouse_store_id', '=', 'warehouse_stores.id')->join('warehouses', 'warehouse_stores.warehouse_id', '=', 'warehouses.id')->join('stores', 'warehouse_stores.store_id', '=', 'stores.id')->selectRaw('warehouses.name as warehouse_name, store_in.id, product_details.name, warehouse_stores.description, warehouse_stores.date_delivery, store_in.total_product, stores.name as store_name')->where('warehouses.id', $request->warehouse)->where('store_in.status', 0)->orderBy('warehouse_stores.date_delivery', 'desc')->get();
        } else{
            $product = StoreIn::join('product_details', 'store_in.product_detail_id', '=', 'product_details.id')->join('product_models', 'product_details.product_model_id', '=', 'product_models.id')->join('warehouse_stores', 'store_in.warehouse_store_id', '=', 'warehouse_stores.id')->join('warehouses', 'warehouse_stores.warehouse_id', '=', 'warehouses.id')->join('stores', 'warehouse_stores.store_id', '=', 'stores.id')->selectRaw('warehouses.name as warehouse_name, store_in.id, product_models.name, warehouse_stores.description, warehouse_stores.date_delivery, store_in.total_product, stores.name as store_name')->where('store_in.status', 0)->orderBy('warehouse_stores.date_delivery', 'desc')->get();
        }

        return Datatables::of($product)->make();
    }

    public function verificateIncomingProduct(Request $request){
        if($request->has('id')){
            $storeIn = StoreIn::find($request->id);

            if($storeIn != null){
                $storeIn->status = 1;
                $storeIn->save();

                $warehouseStore = WarehouseStore::find($storeIn->warehouse_store_id);

                $storeStock = StoreStock::where('store_id', $warehouseStore->store_id)->where('product_detail_id', $storeIn->product_detail_id)->where('material_type', $storeIn->material_type)->where('color_Id', $storeIn->color_id)->first();

                if($storeStock == null){
                    $storeStock = new StoreStock;
                    $storeStock->product_detail_id = $storeIn->product_detail_id;
                    $storeStock->store_id = $warehouseStore->store_id;
                    $storeStock->material_type = $storeIn->material_type;
                    $storeStock->color_id = $storeIn->color_id;
                    $storeStock->total_product = $storeIn->total_product;
                } else{
                    $storeStock->total_product = (int) $storeStock->total_product + (int) $storeIn->total_product;
                }

                $storeStock->save();

                return redirect('/store/incoming-product')->with(array('success' => 'Sukses verifikasi data', 'store' => $request->redirectStore));
            } else{
                return redirect('/store/incoming-product')->with('error', 'Terjadi kesalahan sistem, gagal memverifikasi data');
            }
        } else{
            return redirect('/store/incoming-product')->with('error', 'Terjadi kesalahan sistem, gagal memverifikasi data');
        }
    }

    public function addTransaction(Request $request){
        $storeTransaction = new StoreTransaction;
        $storeTransaction->payment_type_id = $request->paymentType;
        $storeTransaction->store_id = $request->storeId;
        $storeTransaction->price = $request->price;
        $storeTransaction->final_price = $request->finalPrice;
        $storeTransaction->date = $request->date;
        $storeTransaction->description = $request->description;
        $storeTransaction->status = 1;

        if($request->hasFile('note'))
        {
            $f = $request->file('note');
            $path = $request->file('note')->storeAs(
                'transaction_note', pathinfo($request->file('note')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$f->getClientOriginalExtension()
            );

            $storeTransaction->file_path = $path;
        }

        $storeTransaction->save();

        $countStock = count($request->storeStockId);
        for($i=0;$i < $countStock;$i++){
            $storeSold = new StoreSold;
            $storeSold->store_transaction_id = $storeTransaction->id;
            $storeSold->store_stock_id = $request->storeStockId[$i];
            $storeSold->price = $request->storeStockPrice[$i];
            $storeSold->total_price = (int) $request->storeStockPrice[$i] * (int) $request->storeStockTotal[$i];
            $storeSold->total_product = $request->storeStockTotal[$i];
            $storeSold->save();

            $storeStock = StoreStock::find($request->storeStockId[$i]);
            $storeStock->total_product = (int) $storeStock->total_product - (int) $request->storeStockTotal[$i];
            $storeStock->save();
        }

        return redirect('/store/stock')->with(array('success' => 'Sukses menambah transaksi', 'store' => $request->redirectStore));
    }

    public function sales(Request $request){
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
        }
        // } else{
        //     $firstStore = Store::first();
        //     $store = $firstStore->id;
        // }

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

        return view("store.sales", array('user' => $user, 'store' => $store, 'storeList' => $storeList, 'productDetail' => $productDetail, 'paymentType' => $paymentType, 'payment' => $payment, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo));
    }

    public function getSales(Request $request){
        if(!$request->has('dateFrom') || $request->dateFrom == ''){
            $dateFrom = '1990-01-01';
        } else{
            $dateFrom = $request->dateFrom;
        }

        if(!$request->has('dateTo') || $request->dateTo == ''){
            $dateTo = date('Y-m-d');
        } else{
            $dateTo = $request->dateTo;
        }

        if($request->has('store') && $request->store != '' && $request->store != 0 && $request->has('payment') && $request->payment != ''){
            $transaction = StoreTransaction::join('payment_types', 'store_transactions.payment_type_id', '=', 'payment_types.id')->join('stores', 'store_transactions.store_id', '=', 'stores.id')->selectRaw('store_transactions.id, payment_types.name, store_transactions.final_price, store_transactions.description, store_transactions.file_path, stores.name as store_name, store_transactions.date')->where('store_transactions.store_id', $request->store)->where('store_transactions.payment_type_id', $request->payment)->orderBy('store_transactions.date', 'desc')->whereBetween('store_transactions.date', [new Carbon($dateFrom), new Carbon($dateTo)])->get();
        } else if($request->has('store') && $request->store != '' && $request->store != 0){
            $transaction = StoreTransaction::join('payment_types', 'store_transactions.payment_type_id', '=', 'payment_types.id')->join('stores', 'store_transactions.store_id', '=', 'stores.id')->selectRaw('store_transactions.id, payment_types.name, store_transactions.final_price, store_transactions.description, store_transactions.file_path, stores.name as store_name, store_transactions.date')->where('store_transactions.store_id', $request->store)->orderBy('store_transactions.date', 'desc')->whereBetween('store_transactions.date', [new Carbon($dateFrom), new Carbon($dateTo)])->get();
        } else if($request->has('payment') && $request->payment != ''){
            $transaction = StoreTransaction::join('payment_types', 'store_transactions.payment_type_id', '=', 'payment_types.id')->join('stores', 'store_transactions.store_id', '=', 'stores.id')->selectRaw('store_transactions.id, payment_types.name, store_transactions.final_price, store_transactions.description, store_transactions.file_path, stores.name as store_name, store_transactions.date')->where('store_transactions.payment_type_id', $request->payment)->orderBy('store_transactions.date', 'desc')->whereBetween('store_transactions.date', [new Carbon($dateFrom), new Carbon($dateTo)])->get();
        } else{
            $transaction = StoreTransaction::join('payment_types', 'store_transactions.payment_type_id', '=', 'payment_types.id')->join('stores', 'store_transactions.store_id', '=', 'stores.id')->selectRaw('store_transactions.id, payment_types.name, store_transactions.final_price, store_transactions.description, store_transactions.file_path, stores.name as store_name, store_transactions.date')->orderBy('store_transactions.date', 'desc')->whereBetween('store_transactions.date', [new Carbon($dateFrom), new Carbon($dateTo)])->get();
        }

        return Datatables::of($transaction)->make();
    }

    public function transferStock(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $warehouseList = Warehouse::all();
        $storeList = Store::all();
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

        return view("store.transfer-stock", array('user' => $user, 'store' => $store, 'storeList' => $storeList, 'paymentType' => $paymentType));
    }

    public function transferStockProcess(Request $request){
        $description = '';
        $countStock = count($request->storeStockId);
        for($i=0;$i < $countStock;$i++){
            $storeStock = StoreStock::find($request->storeStockId[$i]);
            $storeStock->total_product = (int) $storeStock->total_product - (int) $request->storeStockTotal[$i];
            $storeStock->save();

            $storeStockTo = StoreStock::where('store_id', $request->storeTo)->where('product_detail_id', $storeStock->product_detail_id)->where('material_type', $storeStock->material_type)->where('color', $storeStock->color)->first();

            if($storeStockTo == null){
                $storeStockSave = new StoreStock;
                $storeStockSave->store_id = $request->storeTo;
                $storeStockSave->product_detail_id = $storeStockTo->product_detail_id;
                $storeStockSave->material_type = $storeStockTo->material_type;
                $storeStockSave->color = $storeStockTo->color;
                $storeStockSave->total_product = $request->storeStockTotal[$i];
                $storeStockSave->save();
            } else{
                $storeStockTo->total_product = (int) $storeStockTo->total_product + (int) $request->storeStockTotal[$i];
                $storeStockTo->save();
            }

            $productDetailData = ProductDetail::find($storeStock->product_detail_id);
            if($description == ''){
                $description = 'Transfer '.$productDetailData->name.' '.$request->storeStockTotal[$i].'pcs';
            } else{
                $description = $description. ' - '.$productDetailData->name.' '.$request->storeStockTotal[$i].'pcs';
            }
        }

        $storeTransfer = new StoreTransfer;
        $storeTransfer->store_from_id = $request->storeFrom;
        $storeTransfer->store_to_id = $request->storeTo;
        $storeTransfer->date = $request->date;
        $storeTransfer->description = $description;
        $storeTransfer->save();

        return redirect('/store/transfer-stock')->with('success', 'Sukses mentransfer barang');
    }

    public function transferStockHistory(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $storeList = Store::all();

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

        return view("store.transfer-stock-history", array('user' => $user, 'store' => $store, 'storeList' => $storeList));
    }

    public function getTransferStockHistory(Request $request){
        $stockHistory = StoreTransfer::join('stores as store_from', 'store_transfers.store_from_id', '=', 'store_from.id')->join('stores as store_to', 'store_transfers.store_to_id', '=', 'store_to.id')->selectRaw('store_from.name as stock_from, store_to.name as stock_to, store_transfers.date, store_transfers.description')->orderBy('store_transfers.updated_at', 'desc')->get();
        
        return Datatables::of($stockHistory)->make();
    }
}
