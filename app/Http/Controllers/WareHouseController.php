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

        $warehouse = 0;
        if($request->has('warehouse')){
            $warehouse = $request->warehouse;
        } else{
            $firstWarehouse = Warehouse::first();
            $warehouse = $firstWarehouse->id;
        }

        return view("warehouse.list", array('user' => $user, 'warehouseList' => $warehouseList, 'warehouse' => $warehouse));
    }

    public function getStock(Request $request){
        if($request->has('warehouse') && $request->warehouse != ''){
            $product = Product::select('id','name','material_type','color', 'description', 'total','unit')->where('warehouse_id', $request->warehouse)->where('status', 1)->orderBy('updated_at','desc')->get();
        } else{
            $product = Product::select('id','name','material_type','color', 'description','total','unit')->where('status', 1)->orderBy('updated_at','desc')->get();
        }

        return Datatables::of($product)->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
