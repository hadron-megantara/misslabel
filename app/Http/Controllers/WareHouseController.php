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
use App\WarehouseDelivery;
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
            $product = Product::join('product_details', 'products.product_detail_id', '=', 'product_details.id')->select(['products.id', 'products.name', 'products.material_type', 'products.color', 'products.length', 'products.description', 'products.total', 'products.unit', 'product_details.name'])->where('products.status', 1)->where('products.warehouse_id', $request->warehouse)->orderBy('products.updated_at', 'desc')->get();
        } else{
            $product = Product::join('product_details', 'products.product_detail_id', '=', 'product_details.id')->select(['products.id', 'products.name', 'products.material_type', 'products.color', 'products.length', 'products.description', 'products.total', 'products.unit', 'product_details.name'])->where('products.status', 1)->orderBy('products.updated_at', 'desc')->get();
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

    public function deliveryNote(Request $request){
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

        $dateFrom = '';
        if($request->has('dateFrom')){
            $dateFrom = $request->dateFrom;
        }

        $dateTo = '';
        if($request->has('dateTo')){
            $dateTo = $request->dateTo;
        }

        return view("warehouse.delivery-note", array('user' => $user, 'warehouseList' => $warehouseList, 'warehouse' => $warehouse, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo));
    }

    public function getDeliveryNote(Request $request){
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

        if($request->has('warehouse') && $request->warehouse != ''){
            $warehouseDelivery = WarehouseDelivery::join('warehouses', 'warehouse_delivery.warehouse_id', '=', 'warehouses.id')->select(['warehouses.name', 'warehouse_delivery.id', 'warehouse_delivery.description', 'warehouse_delivery.file_path', 'warehouse_delivery.date_delivery'])->orderBy('warehouse_delivery.updated_at', 'desc')->where('warehouse_delivery.warehouse_id', $request->warehouse)->whereBetween('warehouse_delivery.date_delivery', [new Carbon($dateFrom), new Carbon($dateTo)])->get();
        } else{
            $warehouseDelivery = WarehouseDelivery::join('warehouses', 'warehouse_delivery.warehouse_id', '=', 'warehouses.id')->select(['warehouses.name', 'warehouse_delivery.id', 'warehouse_delivery.description', 'warehouse_delivery.file_path', 'warehouse_delivery.date_delivery'])->orderBy('warehouse_delivery.updated_at', 'desc')->whereBetween('warehouse_delivery.date_delivery', [new Carbon($dateFrom), new Carbon($dateTo)])->get();
        }

        return Datatables::of($warehouseDelivery)->make();
    }

    public function downloadNote(Request $request){
        if($request->has('id')){
            $file = WarehouseDelivery::find($request->id);
            return response()->download(storage_path("app/".$file->file_path));
        }
    }
}
