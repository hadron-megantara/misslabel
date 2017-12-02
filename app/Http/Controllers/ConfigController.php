<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Color;
use App\Seller;
use App\ProductDetail;

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

        return view("config.product", array('user' => $user, 'seller' => $seller));
    }

    public function getProduct(Request $request){
        $product = ProductDetail::select(['id', 'name', 'description', 'price', 'unit'])->orderBy('updated_at', 'desc')->get();
     
        return Datatables::of($product)->make();
    }

    public function storeProduct(Request $request){
        $product = new ProductDetail;

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->unit = $request->unit;

        $product->save();

        return redirect('/config/product')->with('success', 'Sukses menambah Produk');
    }

    public function updateProduct(Request $request){
        $product = ProductDetail::find($request->id);
        
        $product->name = $request->name;
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
}
