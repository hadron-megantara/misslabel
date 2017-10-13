<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Indonesia;
use App\Material;
use App\MaterialType;
use App\MaterialIn;
use App\MaterialSeller;
use App\ConvectionList;
use App\Expense;
use Carbon\Carbon;

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

        $status = 0;
        if($request->has('status')){
            $status = $request->status;
        }

        $dateFrom = '';
        if($request->has('dateFrom')){
            $dateFrom = $request->dateFrom;
        }

        $dateTo = '';
        if($request->has('dateTo')){
            $dateTo = $request->dateTo;
        }

        $materialType = MaterialType::all();

        $convectionList = ConvectionList::all();

        return view("material.list", array('user' => $user, 'materialType' => $materialType, 'status' => $status, 'convectionList' => $convectionList, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo));
    }

    public function getMaterial(Request $request){
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

        if($request->has('status')){
            if($request->status != 2){
                $status = $request->status;
                $material = Material::select(['id', 'material_type', 'length', 'color', 'description', 'price', 'date_purchase', 'status'])->orderBy('updated_at', 'desc')->where('status', $request->status)->whereBetween('date_purchase', [new Carbon($dateFrom), new Carbon($dateTo)]);
            } else{
                $material = Material::select(['id', 'material_type', 'length', 'color', 'description', 'price', 'date_purchase', 'status'])->orderBy('updated_at', 'desc')->whereBetween('date_purchase', [$dateFrom, $dateTo]);
            }
        } else{
            $material = Material::select(['id', 'material_type', 'length', 'color', 'description', 'price', 'date_purchase', 'status'])->orderBy('updated_at', 'desc')->whereDate('date_purchase', '>=', $request->dateFrom)->whereBetween('date_purchase', [new Carbon($dateFrom), new Carbon($dateTo)]);
        }
     
        return Datatables::of($material)->make();
    }

    public function storeMaterial(Request $request){
        $material = new Material;

        $material->material_type = $request->materialName;
        $material->length = $request->materialLength;
        $material->color = $request->materialColor;
        $material->description = $request->materialDescription;
        $material->price = $request->materialPrice;
        $material->date_purchase = $request->materialDatePurchase;

        $material->save();

        $expense = new Expense;
        $expense->value = $request->materialPrice;
        $expense->date = $request->materialDatePurchase;
        $expense->save();

        return redirect('/material');
    }

    public function updateMaterial(Request $request){
        $material = Material::find($request->materialId);
        
        $material->material_type = $request->materialName;
        $material->length = $request->materialLength;
        $material->color = $request->materialColor;
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

    public function sendMaterial(Request $request){
        $material = Material::find($request->materialId);
        $material->status = 1;
        $material->convection_id = $request->convectionId;
        $material->date_convection = date('Y-m-d');
        $material->save();

        $materialIn = MaterialIn::where('material_type', $request->materialType)->where('color', $request->materialColor)->where('convection_id', $request->convectionId)->first();

        if($materialIn == null){
            $materialIn = new MaterialIn;
            $materialIn->material_type = $request->materialType;
            $materialIn->color = $request->materialColor;
            $materialIn->length = $request->materialLength;
            $materialIn->convection_id = $request->convectionId;
        } else{
            $materialIn->length = $materialIn->length + $request->materialLength;
        }

        $materialIn->save();

        return redirect('/material')->with('success', 'Sukses mengirim bahan ke konveksi');
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

        return redirect('/material/type');
    }

    public function updateMaterialType(Request $request){
        $materialType = MaterialType::find($request->materialTypeId);
        
        $materialType->name = $request->materialTypeName;

        $materialType->save();

        return redirect('/material/type');
    }

    public function destroyMaterialType(Request $request){
        $materialType = MaterialType::find($request->materialTypeId);

        $materialType->delete();

        return redirect('/material/type');
    }

    public function transaction(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $status = 0;
        if($request->has('status')){
            $status = $request->status;
        }

        $dateFrom = '';
        if($request->has('dateFrom')){
            $dateFrom = $request->dateFrom;
        }

        $dateTo = '';
        if($request->has('dateTo')){
            $dateTo = $request->dateTo;
        }

        $materialType = MaterialType::all();

        $convectionList = ConvectionList::all();

        return view("material.transaction", array('user' => $user, 'materialType' => $materialType, 'status' => $status, 'convectionList' => $convectionList, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo));
    }

    public function seller(Request $request)
    {
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $materialSeller = MaterialSeller::all();

        return view("material.material_seller", array('user' => $user, 'materialSeller' => $materialSeller));
    }

    public function getMaterialSeller(Request $request){
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

        if($request->has('status')){
            if($request->status != 2){
                $status = $request->status;
                $material = Material::select(['id', 'material_type', 'length', 'color', 'description', 'price', 'date_purchase', 'status'])->orderBy('updated_at', 'desc')->where('status', $request->status)->whereBetween('date_purchase', [new Carbon($dateFrom), new Carbon($dateTo)]);
            } else{
                $material = Material::select(['id', 'material_type', 'length', 'color', 'description', 'price', 'date_purchase', 'status'])->orderBy('updated_at', 'desc')->whereBetween('date_purchase', [$dateFrom, $dateTo]);
            }
        } else{
            $material = Material::select(['id', 'material_type', 'length', 'color', 'description', 'price', 'date_purchase', 'status'])->orderBy('updated_at', 'desc')->whereDate('date_purchase', '>=', $request->dateFrom)->whereBetween('date_purchase', [new Carbon($dateFrom), new Carbon($dateTo)]);
        }
     
        return Datatables::of($material)->make();
    }

    public function storeMaterialSeller(Request $request){
        $material = new Material;

        $material->material_type = $request->materialName;
        $material->length = $request->materialLength;
        $material->color = $request->materialColor;
        $material->description = $request->materialDescription;
        $material->price = $request->materialPrice;
        $material->date_purchase = $request->materialDatePurchase;

        $material->save();

        $expense = new Expense;
        $expense->value = $request->materialPrice;
        $expense->date = $request->materialDatePurchase;
        $expense->save();

        return redirect('/material');
    }

    public function updateMaterialSeller(Request $request){
        $material = Material::find($request->materialId);
        
        $material->material_type = $request->materialName;
        $material->length = $request->materialLength;
        $material->color = $request->materialColor;
        $material->description = $request->materialDescription;
        $material->price = $request->materialPrice;
        $material->date_purchase = $request->materialDatePurchase;

        $material->save();

        return redirect('/material');
    }

    public function destroyMaterialSeller(Request $request){
        $material = Material::find($request->materialId);

        $material->delete();

        return redirect('/material');
    }
}
