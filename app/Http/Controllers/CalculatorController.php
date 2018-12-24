<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CalculatorController extends Controller
{
    public function index(Request $request){
        return view("calculator");
    }
}
