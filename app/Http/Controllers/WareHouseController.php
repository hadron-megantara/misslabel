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
use App\WarehouseStock;
use App\WarehouseDelivery;
use App\WarehouseProduct;
use App\WarehouseStore;
use App\Store;
use App\StoreStock;
use App\StoreIn;
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
        if($request->has('warehouse') && $request->warehouse != 0){
            $product = WarehouseStock::join('product_details', 'warehouse_stocks.product_detail_id', '=', 'product_details.id')->join('product_models', 'product_details.product_model_id', '=', 'product_models.id')->join('colors', 'product_details.color_id', '=', 'colors.id')->selectRaw('product_details.id, product_models.name, warehouse_stocks.material_type, colors.name as color, colors.id as color_id, product_details.description, warehouse_stocks.total')->where('warehouse_stocks.warehouse_id', $request->warehouse)->where('warehouse_stocks.total', '>', 0)->orderBy('warehouse_stocks.updated_at', 'desc')->get();
        } else{
            $product = WarehouseStock::join('product_details', 'warehouse_stocks.product_detail_id', '=', 'product_details.id')->join('product_models', 'product_details.product_model_id', '=', 'product_models.id')->join('colors', 'product_details.color_id', '=', 'colors.id')->select(['product_details.id', 'product_models.name', 'warehouse_stocks.material_type', 'colors.name', 'product_details.description', 'warehouse_stocks.total'])->where('warehouse_stocks.total', '>', 0)->orderBy('warehouse_stocks.updated_at', 'desc')->get();
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

    public function transferStock(Request $request){
        if($request->has('productId') && $request->has('productTotal') && $request->has('storeId') && $request->has('deliveryDate') && $request->has('warehouseId')){
            $warehouseStore = new WarehouseStore;
            $warehouseStore->warehouse_id = $request->warehouseId;
            $warehouseStore->store_id = $request->storeId;
            $warehouseStore->description = $request->description;
            $warehouseStore->date_delivery = $request->deliveryDate;
            $warehouseStore->save();

            $count = count($request->productId);

            for($i=0;$i < $count;$i++){
                $warehouseStock = WarehouseStock::where('warehouse_id', $request->warehouseId)->where('product_detail_id', $request->productId[$i])->first();
                $totalRest = (int) $warehouseStock->total - (int) $request->productTotal[$i];
                $warehouseStock->total = $totalRest;
                $warehouseStock->save();

                $storeIn = new StoreIn;
                $storeIn->product_detail_id = $request->productId[$i];
                $storeIn->warehouse_store_id = $warehouseStore->id;
                $storeIn->total_product = $request->productTotal[$i];
                $storeIn->material_type = $warehouseStock->material_type;
                $storeIn->color = $warehouseStock->color;
                $storeIn->status = 0;
                $storeIn->save();
            }

            return redirect('/warehouse/stock')->with('success', 'Sukses menyimpan data toko');
        } else{

        }
    }
}
