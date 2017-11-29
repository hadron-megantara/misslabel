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

class WareHouseController extends Controller
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

        $warehouse = 0;
        if($request->has('warehouse')){
            $warehouse = $request->warehouse;
        } else{
            $firstWarehouse = Warehouse::first();
            $warehouse = $firstWarehouse->id;
        }

        return view("warehouse.list", array('user' => $user, 'warehouseList' => $warehouseList, 'warehouse' => $warehouse));
    }

    public function getStock(Request $request){
        if($request->has('warehouse') && $request->warehouse != ''){
            $product = Product::select('id','name','material_type','color', 'description', 'total','unit')->where('warehouse_id', $request->warehouse)->where('status', 1)->orderBy('updated_at','desc')->get();
        } else{
            $product = Product::select('id','name','material_type','color', 'description','total','unit')->where('status', 1)->orderBy('updated_at','desc')->get();
        }

        return Datatables::of($product)->make();
    }

    public function warehouseList(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        return view("warehouse.warehouse-list", array('user' => $user));
    }

    public function getWarehouseList(){
        $warehouseList = Warehouse::select(['id', 'name', 'description'])->orderBy('updated_at', 'desc');
     
        return Datatables::of($warehouseList)->make();
    }

    public function storeWarehouseList(Request $request){
        $warehouseList = new Warehouse;

        $warehouseList->name = $request->warehouseListName;
        $warehouseList->description = $request->warehouseListDescription;

        $warehouseList->save();

        return redirect('/warehouse/warehouse-list')->with('success', 'Sukses menyimpan data gudang');
    }

    public function updateWarehouseList(Request $request){
        $warehouseList = Warehouse::find($request->warehouseListId);
        
        $warehouseList->name = $request->warehouseListName;
        $warehouseList->description = $request->warehouseListDescription;

        $warehouseList->save();

        return redirect('/warehouse/warehouse-list')->with('success', 'Sukses mengubah data gudang');
    }

    public function destroyWarehouseList(Request $request){
        $warehouseList = Warehouse::find($request->warehouseListId);

        $warehouseList->delete();

        return redirect('/warehouse/warehouse-list')->with('success', 'Sukses menghapus data gudang');
    }
}
