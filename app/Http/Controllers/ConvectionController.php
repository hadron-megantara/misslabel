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
use Carbon\Carbon;

class ConvectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $convectionList = ConvectionList::all();

        $convection = 0;
        if($request->has('convection')){
            $convection = $request->convection;
        } else{
            $firstConvection = ConvectionList::first();
            $convection = $firstConvection->id;
        }

        $status = 0;
        if($request->has('status')){
            $status = $request->status;
        }

        return view("convection.material-in", array('user' => $user, 'convectionList' => $convectionList, 'convection' => $convection, 'status' => $status));
    }

    public function getMaterialIn(Request $request){
        if(!$request->has('status') || $request->status == ''){
            $status = 0;
        } else{
            $status = $request->status;
        }

        if(!$request->has('convection') || $request->convection == '' || $request->convection == 0){
            $convectionMaterialIn = MaterialIn::selectRaw('id, material_type, color, SUM(length) AS length')->groupBy('id', 'convection_id', 'material_type', 'color')->orderBy('material_type')->where('status', $status)->where('length', '<>', 0)->get();
        } else{
            $convectionMaterialIn = MaterialIn::selectRaw('id, material_type, color, SUM(length) AS length, convection_id')->groupBy('id', 'convection_id', 'material_type', 'color')->orderBy('material_type')->where('status', $status)->where('length', '<>', 0)->where('convection_id', $request->convection)->get();
        }
        
        return Datatables::of($convectionMaterialIn)->make();
    }

    public function getMaterialInDetail(){
        $convectionMaterialIn = ConvectionMaterialIn::select(['id', 'material_type', 'length'])->orderBy('updated_at', 'desc');
     
        return Datatables::of($convectionMaterialIn)->make();
    }

    public function convectionList(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        return view("convection.list", array('user' => $user));
    }

    public function getConvectionList(){
        $convectionList = ConvectionList::select(['id', 'name', 'description'])->orderBy('updated_at', 'desc');
     
        return Datatables::of($convectionList)->make();
    }

    public function storeConvectionList(Request $request){
        $convectionList = new ConvectionList;

        $convectionList->name = $request->convectionListName;
        $convectionList->description = $request->convectionListDescription;

        $convectionList->save();

        return redirect('/convection/list');
    }

    public function updateConvectionList(Request $request){
        $convectionList = ConvectionList::find($request->convectionListId);
        
        $convectionList->name = $request->convectionListName;
        $convectionList->description = $request->convectionListDescription;

        $convectionList->save();

        return redirect('/convection/list');
    }

    public function destroyConvectionList(Request $request){
        $convectionList = ConvectionList::find($request->convectionListId);

        $convectionList->delete();

        return redirect('/convection/list');
    }

    public function convertToProduct(Request $request){
        $product = new Product;

        $product->name = $request->materialProductName;
        $product->description = $request->materialProductDescription;
        $product->material_type = $request->materialType;
        $product->color = $request->materialColor;
        $product->length = $request->materialLength;
        $product->price = $request->materialPrice;

        if($request->materialUnit == 'kodi'){
            $product->total = $request->materialTotal * 20;
        } else{
            $product->total = $request->materialTotal;
        }

        $product->unit = $request->materialUnit;

        $product->save();

        $materialIn = MaterialIn::find($request->materialId);

        if($materialIn != null){
            $materialIn->length = $materialIn->length - $request->materialLength;
            $materialIn->save();
        }

        $materialInConverted = MaterialIn::where('material_type', $request->materialType)->where('color', $request->materialColor)->where('convection_id', $request->materialConvectionId)->where('status', '1')->first();

        if($materialInConverted == null){
            $materialInConverted = new MaterialIn;
            $materialInConverted->material_type = $request->materialType;
            $materialInConverted->color = $request->materialColor;
            $materialInConverted->length = $request->materialLength;
            $materialInConverted->convection_id = $request->materialConvectionId;
            $materialInConverted->status = '1';
        } else{
            $materialInConverted->length = $materialIn->length + $request->materialLength;
        }

        $materialInConverted->save();

        return redirect('/convection/material-in')->with('success', 'Sukses konversi bahan ke produk');
    }

    public function product(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $convectionList = ConvectionList::all();
        $warehouseList = Warehouse::all();

        $product = Product::all();

        $convection = 0;
        if($request->has('convection')){
            $convection = $request->convection;
        } else{
            $firstConvection = ConvectionList::first();
            $convection = $firstConvection->id;
        }

        $status = 0;
        if($request->has('status')){
            $status = $request->status;
        }

        return view("convection.product", array('user' => $user, 'convectionList' => $convectionList, 'convection' => $convection, 'status' => $status, 'warehouseList' => $warehouseList));
    }

    public function getProduct(Request $request){
        if($request->has('productId')){
            $items = json_decode($request->productId);
        }

        $product = Product::select('id','name','material_type','color','length','price','description','total','unit')->whereNotIn('id', $items)->where('status', 0)->orderBy('updated_at','desc')->get();

        return Datatables::of($product)->make();
    }

    public function sendProduct(Request $request){
        if($request->has('deliveryNote')){
            $productItem = explode(',', $request->productId);
            $productId = '';
            foreach($productItem as $productItem){
                $productData = Product::find($productItem);
                $productData->status = 1;
                $productData->warehouse = $request->warehouseId;
                $productData->save();

                if($productId == ''){
                    $productId = $productItem;
                } else{
                    $productId = $productId.','.$productItem;
                }
            }

            $file = $request->file('deliveryNote');
            $deliveryNote = new DeliveryNote;
            $deliveryNote->product_id = $productId;
            $deliveryNote->name = $file->getClientOriginalName();
            $deliveryNote->file = base64_encode(file_get_contents($file->getRealPath()));
            $deliveryNote->mime = $file->getMimeType();
            $deliveryNote->size = $file->getSize();
            $deliveryNote->description = $request->description;
            $deliveryNote->save();

            return redirect('/convection/product')->with('success', 'Sukses menyimpan barang ke gudang');
        } else{
            return redirect('/convection/product')->with('error', 'Proses gagal, harap lampirkan surat jalan');
        }
    }

}
