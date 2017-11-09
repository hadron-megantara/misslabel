<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Indonesia;
use App\Material;
use App\MaterialTransaction;
use App\MaterialTransactionRelation;
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

    public function getTransaction(Request $request){
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

        $materialTransaction = MaterialTransaction::select(['id', 'seller', 'description', 'price', 'date_purchase'])->orderBy('updated_at', 'desc')->whereBetween('date_purchase', [new Carbon($dateFrom), new Carbon($dateTo)]);

        return Datatables::of($materialTransaction)->make();
    }

    public function downloadNote(Request $request){
        if($request->has('id')){
            $file = MaterialTransaction::find($request->id);
            header("Content-length: ".$file->size);
            header("Content-type: ".$file->mime);
            header("Content-Disposition: attachment; filename=".$file->name);
            echo $file->file;
        }
    }

    public function storeTransaction(Request $request){
        if($request->hasFile('materialNote'))
        {
            // $f = $request->file('materialNote');
            // $materialTransaction->name = $f->getClientOriginalName();
            // $materialTransaction->file = base64_encode(file_get_contents($f->getRealPath()));
            // $materialTransaction->mime = $f->getMimeType();
            // $materialTransaction->size = $f->getSize();
            
            $f = $request->file('materialNote');
            $path = $request->file('materialNote')->store('note');
            $path = $request->file('materialNote')->storeAs(
                'note', $request->user()->id
            );
            dd($path);
        }

        // $materialTransaction = new MaterialTransaction;
        // $materialTransaction->seller = $request->materialSeller;
        // $materialTransaction->description = $request->materialDescription;
        // $materialTransaction->price = $request->materialTotalPrice;
        // $materialTransaction->date_purchase = $request->materialDatePurchase;



        // $materialTransaction->save();

        // for($i=0;$i < $request->totalMaterial; $i++){
        //     $material = new Material;
        //     $material->material_type = $request->materialName[$i];
        //     $material->length = $request->materialLength[$i];
        //     $material->color = $request->materialColor[$i];
        //     $material->price = $request->materialPrice[$i];
        //     $material->save();

        //     $materialRelation = new MaterialTransactionRelation;
        //     $materialRelation->id_transaction = $materialTransaction->id;
        //     $materialRelation->id_material = $material->id;
        //     $materialRelation->save();

        // }

        return redirect('/material/transaction');
    }

    public function updateTransaction(Request $request){
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

    public function destroyTransaction(Request $request){
        $material = Material::find($request->materialId);

        $material->delete();

        return redirect('/material');
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
        $materialSeller = MaterialSeller::select(['id', 'name', 'description'])->orderBy('updated_at', 'desc')->get();
     
        return Datatables::of($materialSeller)->make();
    }

    public function storeMaterialSeller(Request $request){
        $materialSeller = new MaterialSeller;

        $materialSeller->name = $request->sellerName;
        $materialSeller->description = $request->sellerDescription;

        $materialSeller->save();

        return redirect('/material/seller');
    }

    public function updateMaterialSeller(Request $request){
        $materialSeller = MaterialSeller::find($request->sellerId);
        
        $materialSeller->name = $request->sellerName;
        $materialSeller->description = $request->sellerDescription;

        $materialSeller->save();

        return redirect('/material/seller');
    }

    public function destroyMaterialSeller(Request $request){
        $materialSeller = MaterialSeller::find($request->sellerId);

        $materialSeller->delete();

        return redirect('/material/seller');
    }
}
