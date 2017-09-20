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

        $cities = Indonesia::allCities();

        return view("material.list", array('user' => $user, 'cities' => $cities));
    }

    public function type(Request $request){
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        return view("material.type", array('user' => $user));
    }

    public function getMaterialType(){
        $materialType = MaterialType::select(['id', 'name'])->orderBy('name', 'asc');
     
        return Datatables::of($materialType)->make();
    }

    public function convection(Request $request){

    }

    public function getCustomer(){
        $customers = Customer::select(['name', 'phone', 'store', 'city', 'description', 'id'])->orderBy('updated_at', 'desc');
     
        return Datatables::of($customers)->make();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new Customer;

        $customer->name = $request->customerName;
        $customer->phone = $request->customerStore;
        $customer->store = $request->customerPhone;
        $customer->city = $request->customerCity;
        $customer->description = $request->customerDescription;

        $customer->save();

        return redirect('/customer');
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
    public function update(Request $request)
    {
        $customer = Customer::find($request->customerId);
        
        $customer->name = $request->customerName;
        $customer->store = $request->customerStore;
        $customer->phone = $request->customerPhone;
        $customer->city = $request->customerCity;
        $customer->description = $request->customerDescription;

        $customer->save();

        return redirect('/customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(REQUEST $request)
    {
        $customer = Customer::find($request->customerId);

        $customer->delete();

        return redirect('/customer');
    }
}
