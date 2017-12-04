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

        return view("store.list", array('user' => $user, 'store' => $store, 'storeList' => $storeList));
    }

    public function getStock(Request $request){
        if($request->has('store') && $request->store != ''){
            $product = StoreStock::join('product_details', 'store_stocks.product_detail_id', '=', 'product_details.id')->selectRaw('store_stocks.id, product_details.name, product_details.description, product_details.price, product_details.unit, store_stocks.material_type, store_stocks.color, store_stocks.total_product')->where('store_stocks.store_id', $request->store)->orderBy('product_details.name', 'asc')->get();
        } else{
            $product = StoreStock::join('product_details', 'store_stocks.product_detail_id', '=', 'product_details.id')->selectRaw('product_details.name, product_details.description, product_details.price, product_details.unit, store_stocks.material_type, store_stocks.color, store_stocks.total_product')->orderBy('product_details.name', 'asc')->get();
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
        } else{
            $firstWarehouse = Warehouse::first();
            $warehouse = $firstWarehouse->id;
        }

        return view("store.incoming-product", array('user' => $user, 'store' => $store, 'storeList' => $storeList, 'warehouseList' => $warehouseList, 'warehouse' => $warehouse));
    }

    public function getIncomingProduct(Request $request){
        if(($request->has('store') && $request->store != '') && ($request->has('warehouse') && $request->warehouse != '')){
            $product = StoreIn::join('product_details', 'store_in.product_detail_id', '=', 'product_details.id')->join('warehouse_stores', 'store_in.warehouse_store_id', '=', 'warehouse_stores.id')->join('warehouses', 'warehouse_stores.warehouse_id', '=', 'warehouses.id')->selectRaw('warehouses.name as warehouse_name, product_details.id, product_details.name, warehouse_stores.description, warehouse_stores.date_delivery, store_in.total_product')->where('warehouse_stores.store_id', $request->store)->where('warehouses.id', $request->warehouse)->where('store_in.status', 0)->orderBy('warehouse_stores.date_delivery', 'desc')->get();
        } else if($request->has('store') && $request->store != ''){
            $product = StoreIn::join('product_details', 'store_in.product_detail_id', '=', 'product_details.id')->join('warehouse_stores', 'store_in.warehouse_store_id', '=', 'warehouse_stores.id')->join('warehouses', 'warehouse_stores.warehouse_id', '=', 'warehouses.id')->selectRaw('warehouses.name as warehouse_name, product_details.id, product_details.name, warehouse_stores.description, warehouse_stores.date_delivery, store_in.total_product')->where('warehouse_stores.store_id', $request->store)->where('store_in.status', 0)->orderBy('warehouse_stores.date_delivery', 'desc')->get();
        } else if($request->has('warehouse') && $request->warehouse != ''){
            $product = StoreIn::join('product_details', 'store_in.product_detail_id', '=', 'product_details.id')->join('warehouse_stores', 'store_in.warehouse_store_id', '=', 'warehouse_stores.id')->join('warehouses', 'warehouse_stores.warehouse_id', '=', 'warehouses.id')->selectRaw('warehouses.name as warehouse_name, product_details.id, product_details.name, warehouse_stores.description, warehouse_stores.date_delivery, store_in.total_product')->where('warehouses.id', $request->warehouse)->where('store_in.status', 0)->orderBy('warehouse_stores.date_delivery', 'desc')->get();
        } else{
            $product = StoreIn::join('product_details', 'store_in.product_detail_id', '=', 'product_details.id')->join('warehouse_stores', 'store_in.warehouse_store_id', '=', 'warehouse_stores.id')->join('warehouses', 'warehouse_stores.warehouse_id', '=', 'warehouses.id')->selectRaw('warehouses.name as warehouse_name, product_details.id, product_details.name, warehouse_stores.description, warehouse_stores.date_delivery, store_in.total_product')->where('store_in.status', 0)->orderBy('warehouse_stores.date_delivery', 'desc')->get();
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

                $storeStock = StoreStock::where('store_id', $warehouseStore->store_id)->where('product_detail_id', $storeIn->product_detail_id)->where('material_type', $storeIn->material_type)->where('color', $storeIn->color)->first();

                if($storeStock == null){
                    $storeStock = new StoreStock;
                    $storeStock->product_detail_id = $storeIn->product_detail_id;
                    $storeStock->store_id = $warehouseStore->store_id;
                    $storeStock->material_type = $storeIn->material_type;
                    $storeStock->color = $storeIn->color;
                    $storeStock->total_product = $storeIn->total_product;
                } else{
                    $storeStock->total_product = (int) $storeStock->total_product + (int) $storeIn->total_product;
                }

                $storeStock->save();

                return redirect('/store/incoming-product')->with('success', 'Sukses verifikasi data');
            } else{
                return redirect('/store/incoming-product')->with('error', 'Terjadi kesalahan sistem, gagal memverifikasi data');
            }
        } else{
            return redirect('/store/incoming-product')->with('error', 'Terjadi kesalahan sistem, gagal memverifikasi data');
        }
    }

    public function sales(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $storeList = Store::all();
        $productDetail = ProductDetail::all();

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

        return view("store.sales", array('user' => $user, 'store' => $store, 'storeList' => $storeList, 'productDetail' => $productDetail));
    }
}
