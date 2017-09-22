<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Indonesia;
use App\Material;
use App\MaterialType;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $materialType = MaterialType::all();

        return view("material.list", array('user' => $user, 'materialType' => $materialType));
    }

    public function getMaterial(){
        $material = Material::select(['id', 'material_type', 'length', 'width', 'description', 'price', 'date_purchase'])->orderBy('updated_at', 'desc');
     
        return Datatables::of($material)->make();
    }

    public function storeMaterial(Request $request){
        $material = new Material;

        $material->material_type = $request->materialName;
        $material->length = $request->materialLength;
        $material->width = $request->materialWidth;
        $material->description = $request->materialDescription;
        $material->price = $request->materialPrice;
        $material->date_purchase = $request->materialDatePurchase;

        $material->save();

        return redirect('/material');
    }

    public function updateMaterial(Request $request){
        $material = Material::find($request->materialId);
        
        $material->material_type = $request->materialName;
        $material->length = $request->materialLength;
        $material->width = $request->materialWidth;
        $material->description = $request->materialDescription;
        $material->price = $request->materialPrice;
        $material->date_purchase = $request->materialDatePurchase;

        $material->save();

        return redirect('/material');
    }

    public function destroyMaterial(Request $request){
        $material = Material::find($request->materialId);

        $material->delete();

        return redirect('/material');
    }

    public function type(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        return view("material.type", array('user' => $user));
    }

    public function getMaterialType(){
        $materialType = MaterialType::select(['id', 'name'])->orderBy('updated_at', 'desc');
     
        return Datatables::of($materialType)->make();
    }

    public function storeMaterialType(Request $request){
        $materialType = new MaterialType;

        $materialType->name = $request->materialTypeName;

        $materialType->save();

        return redirect('/material-type');
    }

    public function updateMaterialType(Request $request){
        $materialType = MaterialType::find($request->materialTypeId);
        
        $materialType->name = $request->materialTypeName;

        $materialType->save();

        return redirect('/material-type');
    }

    public function destroyMaterialType(Request $request){
        $materialType = MaterialType::find($request->materialTypeId);

        $materialType->delete();

        return redirect('/material-type');
    }

    public function convection(Request $request){

    }
}
