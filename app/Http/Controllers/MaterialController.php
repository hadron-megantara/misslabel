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
use App\Seller;
use App\Color;
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

        $materialTransaction = MaterialTransaction::join('sellers', 'material_transactions.seller_id', '=', 'sellers.id')->select(['material_transactions.id', 'material_transactions.seller_id', 'sellers.name', 'material_transactions.description', 'material_transactions.price', 'material_transactions.date_purchase'])->orderBy('material_transactions.updated_at', 'desc')->whereBetween('material_transactions.date_purchase', [new Carbon($dateFrom), new Carbon($dateTo)])->get();

        if($request->has('status')){
            if($request->status != 2){
                $status = $request->status;
                $material = Material::join('material_transactions', 'material_transactions.id', '=', 'materials.transaction_id')->select(['materials.id', 'materials.material_type', 'materials.length', 'materials.color', 'materials.price', 'materials.status', 'material_transactions.date_purchase'])->orderBy('materials.updated_at', 'desc')->where('materials.status', $request->status)->whereBetween('material_transactions.date_purchase', [new Carbon($dateFrom), new Carbon($dateTo)])->get();
            } else{
                $material = Material::join('material_transactions', 'material_transactions.id', '=', 'materials.transaction_id')->select(['materials.id', 'materials.material_type', 'materials.length', 'materials.color', 'materials.price', 'materials.status', 'material_transactions.date_purchase'])->orderBy('materials.updated_at', 'desc')->whereBetween('material_transactions.date_purchase', [new Carbon($dateFrom), new Carbon($dateTo)])->get();
            }
        } else{
            $material = Material::join('material_transactions', 'material_transactions.id', '=', 'materials.transaction_id')->select(['materials.id', 'materials.material_type', 'materials.length', 'materials.color', 'materials.price', 'materials.status', 'material_transactions.date_purchase'])->orderBy('materials.updated_at', 'desc')->whereBetween('material_transactions.date_purchase', [new Carbon($dateFrom), new Carbon($dateTo)])->get();
        }
     
        return Datatables::of($material)->make();
    }

    public function storeMaterial(Request $request){
        $material = new Material;

        $material->material_type = $request->materialName;
        $material->length = $request->materialLength;
        $material->color = $request->materialColor;
        $material->price = $request->materialPrice;

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
        $material->price = $request->materialPrice;

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

        return redirect('/material/list')->with('success', 'Sukses mengirim bahan ke konveksi');
    }

    public function getMaterialByTransactionId(Request $request){
        if($request->has('id')){
            $material = Material::where('transaction_id', $request->id)->get();

            return $material;
        }
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

        $seller = Seller::all();

        $color = Color::orderBy('name', 'asc')->get();

        $materialType = MaterialType::all();

        $convectionList = ConvectionList::all();

        return view("material.transaction", array('user' => $user, 'materialType' => $materialType, 'color' => $color, 'status' => $status, 'convectionList' => $convectionList, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'seller' => $seller));
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

        $materialTransaction = MaterialTransaction::join('sellers', 'material_transactions.seller_id', '=', 'sellers.id')->select(['material_transactions.id', 'material_transactions.seller_id', 'sellers.name', 'material_transactions.description', 'material_transactions.price', 'material_transactions.date_purchase'])->orderBy('material_transactions.updated_at', 'desc')->whereBetween('material_transactions.date_purchase', [new Carbon($dateFrom), new Carbon($dateTo)])->get();

        return Datatables::of($materialTransaction)->make();
    }

    public function downloadNote(Request $request){
        if($request->has('id')){
            $file = MaterialTransaction::find($request->id);
            return response()->download(storage_path("app/".$file->file_path));
        }
    }

    public function storeTransaction(Request $request){
        $materialTransaction = new MaterialTransaction;
        $materialTransaction->seller_id = $request->materialSeller;
        $materialTransaction->description = $request->materialDescription;
        $materialTransaction->price = $request->materialTotalPrice;
        $materialTransaction->date_purchase = $request->materialDatePurchase;

        if($request->hasFile('materialNote'))
        {
            $f = $request->file('materialNote');
            $path = $request->file('materialNote')->storeAs(
                'note', pathinfo($request->file('materialNote')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$f->getClientOriginalExtension()
            );

            $materialTransaction->file_path = $path;
        }

        $materialTransaction->save();

        for($i=0;$i < $request->totalMaterial; $i++){
            $material = new Material;
            $material->transaction_id = $materialTransaction->id;
            $material->material_type = $request->materialName[$i];
            $material->length = $request->materialLength[$i];
            $material->color = $request->materialColor[$i];
            $material->price = $request->materialPrice[$i];
            $material->save();
        }

        return redirect('/material/transaction')->with('success', 'Sukses menambah nota baru');
    }

    public function updateTransaction(Request $request){
        $materialTransaction = new MaterialTransaction;
        $materialTransaction->seller_id = $request->materialSeller;
        $materialTransaction->description = $request->materialDescription;
        $materialTransaction->price = $request->materialTotalPrice;
        $materialTransaction->date_purchase = $request->materialDatePurchase;

        if($request->hasFile('materialNote'))
        {
            $f = $request->file('materialNote');
            $path = $request->file('materialNote')->storeAs(
                'note', pathinfo($request->file('materialNote')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$f->getClientOriginalExtension()
            );

            $materialTransaction->file_path = $path;
        }

        $materialTransaction->save();

        for($i=0;$i < $request->totalMaterial; $i++){
            $material = new Material;
            $material->transaction_id = $materialTransaction->id;
            $material->material_type = $request->materialName[$i];
            $material->length = $request->materialLength[$i];
            $material->color = $request->materialColor[$i];
            $material->price = $request->materialPrice[$i];
            $material->save();
        }

        return redirect('/material/transaction')->with('success', 'Sukses mengubah nota');
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
