<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Indonesia;
use App\Expense;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        return view("expense.list", array('user' => $user));
    }

    public function get(Request $request){
        $expense = Expense::select(['id', 'description', 'value', 'date'])->orderBy('updated_at', 'desc');
     
        return Datatables::of($expense)->make();
    }

    public function store(Request $request){
        $expense = new Expense;

        $expense->description = $request->description;
        $expense->value = $request->value;
        $expense->date = $request->date;

        $expense->save();

        return redirect('/expense/list')->with('success', 'Sukses menambah data pengeluaran');
    }

    public function update(Request $request){
        $expense = Expense::find($request->expenseId);
        
        $expense->description = $request->description;
        $expense->value = $request->value;
        $expense->date = $request->date;

        $expense->save();

        return redirect('/expense/list')->with('success', 'Sukses mengubah data pengeluaran');
    }

    public function destroy(Request $request){
        $expense = Expense::find($request->expenseId);

        $expense->delete();

        return redirect('/expense/list')->with('success', 'Sukses menghapus data pengeluaran');
    }
}
