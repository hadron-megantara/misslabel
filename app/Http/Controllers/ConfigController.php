<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Color;
use App\Seller;
use App\PaymentType;
use App\ProductDetail;
use App\ProductModel;

class ConfigController extends Controller
{
    public function color(Request $request){
    	$user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $color = Color::get();

        return view("config.color", array('user' => $user, 'color' => $color));
    }

    public function getColor(Request $request){
        $color = Color::select(['id', 'name'])->orderBy('updated_at', 'desc')->get();
     
        return Datatables::of($color)->make();
    }

    public function storeColor(Request $request){
        $color = new Color;

        $color->name = $request->color;

        $color->save();

        return redirect('/config/color')->with('success', 'Sukses menambah warna');
    }

    public function updateColor(Request $request){
        $color = Color::find($request->id);
        
        $color->name = $request->color;

        $color->save();

        return redirect('/config/color')->with('success', 'Sukses mengubah warna');
    }

    public function destroyColor(Request $request){
        $color = Color::find($request->id);

        $color->delete();

        return redirect('/config/color')->with('success', 'Sukses menghapus warna');
    }

    public function seller(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $seller = Seller::get();

        return view("config.seller", array('user' => $user, 'seller' => $seller));
    }

    public function getSeller(Request $request){
        $color = Seller::select(['id', 'name', 'phone', 'description'])->orderBy('updated_at', 'desc')->get();
     
        return Datatables::of($color)->make();
    }

    public function storeSeller(Request $request){
        $seller = new Seller;

        $seller->name = $request->name;
        $seller->phone = $request->phone;
        $seller->description = $request->description;

        $seller->save();

        return redirect('/config/seller')->with('success', 'Sukses menambah penjual');
    }

    public function updateSeller(Request $request){
        $seller = Seller::find($request->id);
        
        $seller->name = $request->name;
        $seller->phone = $request->phone;
        $seller->description = $request->description;

        $seller->save();

        return redirect('/config/seller')->with('success', 'Sukses mengubah penjual');
    }

    public function destroySeller(Request $request){
        $seller = Seller::find($request->id);

        $seller->delete();

        return redirect('/config/seller')->with('success', 'Sukses menghapus penjual');
    }

    public function product(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $seller = Seller::get();
        $productModel = ProductModel::all();
        $color = Color::orderBy('name', 'asc')->get();

        return view("config.product", array('user' => $user, 'seller' => $seller, 'productModel' => $productModel, 'color' => $color));
    }

    public function getProduct(Request $request){
        $product = ProductDetail::join('product_models', 'product_details.product_model_id', '=', 'product_models.id')->join('colors', 'product_details.color_id', '=', 'colors.id')->selectRaw('product_details.id, product_models.name, colors.name as color, product_details.description, product_details.price, product_details.unit, product_models.id as model_id')->orderBy('product_details.updated_at', 'desc')->get();
     
        return Datatables::of($product)->make();
    }

    public function storeProduct(Request $request){
        $product = new ProductDetail;

        $product->product_model_id = $request->productModelId;
        $product->color_id = $request->color;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->unit = $request->unit;

        $product->save();

        return redirect('/config/product')->with('success', 'Sukses menambah Produk');
    }

    public function updateProduct(Request $request){
        $product = ProductDetail::find($request->id);
        
        $product->product_model_id = $request->productModelId;
        $product->color_id = $request->color;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->unit = $request->unit;

        $product->save();

        return redirect('/config/product')->with('success', 'Sukses mengubah Produk');
    }

    public function destroyProduct(Request $request){
        $product = ProductDetail::find($request->id);

        $product->delete();

        return redirect('/config/product')->with('success', 'Sukses menghapus Produk');
    }

    public function paymentType(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $paymentType = PaymentType::get();

        return view("config.payment-type", array('user' => $user, 'paymentType' => $paymentType));
    }

    public function getPaymentType(Request $request){
        $paymentType = PaymentType::select(['id', 'name'])->orderBy('updated_at', 'desc')->get();
     
        return Datatables::of($paymentType)->make();
    }

    public function storePaymentType(Request $request){
        $paymentType = new PaymentType;
        $paymentType->name = $request->name;

        $paymentType->save();

        return redirect('/config/payment-type')->with('success', 'Sukses menambah tipe pembayaran');
    }

    public function updatePaymentType(Request $request){
        $paymentType = PaymentType::find($request->id);
        $paymentType->name = $request->name;

        $paymentType->save();

        return redirect('/config/payment-type')->with('success', 'Sukses mengubah tipe pembayaran');
    }

    public function destroyPaymentType(Request $request){
        $paymentType = PaymentType::find($request->id);

        $paymentType->delete();

        return redirect('/config/payment-type')->with('success', 'Sukses menghapus tipe pembayaran');
    }

    public function productModel(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $seller = Seller::get();

        return view("config.product-model", array('user' => $user, 'seller' => $seller));
    }

    public function getProductModel(Request $request){
        $product = ProductModel::select(['id', 'name'])->orderBy('updated_at', 'desc')->get();
     
        return Datatables::of($product)->make();
    }

    public function storeProductModel(Request $request){
        $product = new ProductModel;

        $product->name = $request->name;

        $product->save();

        return redirect('/config/product-model')->with('success', 'Sukses menambah Model');
    }

    public function updateProductModel(Request $request){
        $product = ProductModel::find($request->id);
        
        $product->name = $request->name;

        $product->save();

        return redirect('/config/product-model')->with('success', 'Sukses mengubah Model');
    }

    public function destroyProductModel(Request $request){
        $product = ProductModel::find($request->id);

        $product->delete();

        return redirect('/config/product-model')->with('success', 'Sukses menghapus Model');
    }
}
