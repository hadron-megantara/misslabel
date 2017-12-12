<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Material;
use App\MaterialIn;
use App\ConvectionList;
use App\ConvectionMaterialIn;
use App\ConvectionProduct;
use App\Product;
use App\DeliveryNote;
use App\Warehouse;
use App\WarehouseProduct;
use App\WarehouseDelivery;
use App\WarehouseStock;
use App\ProductDetail;
use App\Expense;
use Carbon\Carbon;
use session;

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
        $productDetailList = ProductDetail::all();

        $convection = 0;
        if($request->has('convection') || session::has('convection')){
            if($request->has('convection')){
                $convection = $request->convection;
            } else{
                $convection = session('convection');
            }
        } else{
            $firstConvection = ConvectionList::first();
            $convection = $firstConvection->id;
        }

        $status = 0;
        if($request->has('status')){
            $status = $request->status;
        }

        return view("convection.material-in", array('user' => $user, 'convectionList' => $convectionList, 'convection' => $convection, 'status' => $status, 'productDetailList' => $productDetailList));
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

        $product->product_detail_id = $request->materialProductName;
        $product->material_type = $request->materialType;
        $product->color = $request->materialColor;
        $product->length = $request->materialLength;

        if($request->materialUnit == 'kodi'){
            $product->total = $request->materialTotal * 20;
        } else{
            $product->total = $request->materialTotal;
        }

        $product->unit = $request->materialUnit;

        if($request->hasFile('note'))
        {
            $f = $request->file('note');
            $path = $request->file('note')->storeAs(
                'product_conversion', pathinfo($request->file('note')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$f->getClientOriginalExtension()
            );

            $product->file_path = $path;
        }

        $product->save();

        $convectionProduct =  new ConvectionProduct;
        $convectionProduct->product_id = $product->id;
        $convectionProduct->convection_id = $request->materialConvectionId;
        $convectionProduct->description  = $request->description;
        $convectionProduct->price = $request->materialPrice;
        $convectionProduct->date = $request->materialDate;
        $convectionProduct->save();

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

        $expense = new Expense;
        $expense->description = 'Konveksi : '.$request->description;
        $expense->value = $request->materialPrice;
        $expense->date = $request->materialDate;
        $expense->save();


        return redirect('/convection/material-in')->with(array('success'=>'Sukses konversi Produk', 'convection' => $request->materialConvectionId));
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

        $product = Product::join('product_details', 'products.product_detail_id', '=', 'product_details.id')->select(['products.id', 'product_details.name', 'products.material_type', 'products.color', 'products.length', 'product_details.description', 'products.total', 'products.unit'])->whereNotIn('products.id', $items)->where('products.status', 0)->orderBy('products.updated_at', 'desc')->get();

        return Datatables::of($product)->make();
    }

    public function sendProduct(Request $request){
        if($request->has('productId') && $request->has('warehouseId')){
            $explodedId = explode(",",$request->productId);
            $countId = count($explodedId);

            $productDelivery = '';
            for($i = 0;$i < $countId;$i++){
                $productData = Product::find($explodedId[$i]);
                $productData->status = 1;
                $productData->warehouse_id = $request->warehouseId;
                $productData->save();

                $warehouseStock  = WarehouseStock::where('product_detail_id', $productData->product_detail_id)->first();
                if($warehouseStock == null){
                    $warehouseStock = new WarehouseStock;
                    $warehouseStock->warehouse_id = $request->warehouseId;
                    $warehouseStock->product_detail_id = $productData->product_detail_id;
                    $warehouseStock->material_type = $productData->material_type;
                    $warehouseStock->color = $productData->color;
                    $warehouseStock->total = $productData->total;
                } else{
                    $warehouseStock->total = (int) $warehouseStock->total + (int) $productData->total;
                }
                $warehouseStock->save();

                $productDetail = ProductDetail::find($productData->product_detail_id);
                $warehouseData = Warehouse::find($request->warehouseId);
                if($productDelivery == ''){
                    $productDelivery = 'Pengiriman Barang ke Gudang '.$warehouseData->name.' : '.$productDetail->name.' '.$productData->total.'pcs';
                } else{
                    $productDelivery = $productDelivery.' - '.$productDetail->name.' '.$productData->total.'pcs';
                }
            }

            $expense = new Expense;
            $expense->description = $productDelivery;
            $expense->value = $request->deliveryPrice;
            $expense->date = $request->deliveryDate;
            $expense->save();

            $warehouseDelivery = new WarehouseDelivery;
            $warehouseDelivery->warehouse_id = $request->warehouseId;
            $warehouseDelivery->date_delivery = $request->deliveryDate;
            $warehouseDelivery->description = $request->description;
            $warehouseDelivery->price = $request->deliveryPrice;

            if($request->hasFile('deliveryNote'))
            {
                $f = $request->file('deliveryNote');
                $path = $request->file('deliveryNote')->storeAs(
                    'delivery_note', pathinfo($request->file('deliveryNote')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$f->getClientOriginalExtension()
                );

                $warehouseDelivery->file_path = $path;
            }

            $warehouseDelivery->save();

            for($j = 0;$j < $countId;$j++){
                $warehouseProduct = new WarehouseProduct;
                $warehouseProduct->warehouse_delivery_id = $warehouseDelivery->id;
                $warehouseProduct->product_id = $explodedId[$j];
                $warehouseProduct->save();
            }
            
            return redirect('/convection/product')->with('success', 'Sukses mengirim Produk ke Gudang');
        }
    }

    public function productIn(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $convectionList = ConvectionList::all();

        $convection = 0;
        if($request->has('convection') || session::has('convection')){
            if($request->has('convection')){
                $convection = $request->convection;
            } else{
                $convection = session('convection');
            }
        } else{
            $firstConvection = ConvectionList::first();
            $convection = $firstConvection->id;
        }

        $status = 0;
        if($request->has('status')){
            $status = $request->status;
        }

        return view("convection.product-in", array('user' => $user, 'convectionList' => $convectionList, 'convection' => $convection, 'status' => $status));
    }

    public function getProductIn(Request $request){
        if(!$request->has('status') || $request->status == ''){
            $status = 0;
        } else{
            $status = $request->status;
        }

        if(!$request->has('convection') || $request->convection == '' || $request->convection == 0){
            $convectionProductIn = Product::join('product_details', 'products.product_detail_id', '=', 'product_details.id')->select(['products.id', 'product_details.name', 'products.material_type', 'products.color', 'products.length', 'product_details.description', 'products.total', 'products.unit'])->where('products.status', 2)->orderBy('products.updated_at', 'desc')->get();
        } else{
            $convectionProductIn = Product::join('product_details', 'products.product_detail_id', '=', 'product_details.id')->select(['products.id', 'product_details.name', 'products.material_type', 'products.color', 'products.length', 'product_details.description', 'products.total', 'products.unit'])->where('products.status', 2)->where('products.convection_id', $request->convection)->orderBy('products.updated_at', 'desc')->get();
        }
        
        return Datatables::of($convectionProductIn)->make();
    }

    public function sendProductConvection(Request $request){
        $countId = count($request->productId);
        for($i = 0;$i < $countId;$i++){
            $productData = Product::find($request->productId[$i]);
            $productData->status = 2;
            $productData->convection_id = $request->convectionId;
            $productData->save();
        }

        return redirect('/convection/product')->with('success', 'Sukses mengirim produk ke konveksi');
    }

    public function sendProductFromConvection(Request $request){
        if($request->has('productId')){
            $productData = Product::find($request->productId);
            $productData->status = 0;
            $productData->save();

            $convectionProduct =  new ConvectionProduct;
            $convectionProduct->product_id = $request->productId;
            $convectionProduct->convection_id = $productData->convection_id;
            $convectionProduct->description = $request->productAccessories;
            $convectionProduct->price = $request->productPrice;
            $convectionProduct->save();

            return redirect('/convection/product-in')->with(array('success'=>'Sukses menyimpan data', 'convection' => $request->convectionIdRedirect));
        } else{
            return redirect('/convection/product-in')->with('error', 'Proses gagal, terjadi kesalahan sistem');
        }
    }

}
