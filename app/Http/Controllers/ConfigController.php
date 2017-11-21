<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Color;
use App\Seller;

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
}
