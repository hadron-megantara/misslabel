<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Material;
use App\MaterialIn;
use App\ConvectionList;
use App\ConvectionMaterialIn;
use App\Product;
use App\DeliveryNote;
use App\Warehouse;
use App\Store;
use Carbon\Carbon;

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

        $warehouse = 0;
        if($request->has('warehouse')){
            $warehouse = $request->warehouse;
        } else{
            $firstWarehouse = Warehouse::first();
            $warehouse = $firstWarehouse->id;
        }

        return view("warehouse.list", array('user' => $user, 'warehouseList' => $warehouseList, 'warehouse' => $warehouse, 'storeList' => $storeList));
    }

    public function getStock(Request $request){
        if($request->has('warehouse') && $request->warehouse != ''){
            $product = Product::select('id','name','material_type','color', 'description', 'total','unit')->where('warehouse_id', $request->warehouse)->where('status', 1)->orderBy('updated_at','desc')->get();
        } else{
            $product = Product::select('id','name','material_type','color', 'description','total','unit')->where('status', 1)->orderBy('updated_at','desc')->get();
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
}
