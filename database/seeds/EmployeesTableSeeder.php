<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = new Employee();
	    $employee->name = 'Joko';
	    $employee->phone = '0856188394015';
	    $employee->save();

	    $employee = new Employee();
	    $employee->name = 'Bejo';
	    $employee->phone = '081249403031';
	    $employee->save();

	    $employee = new Employee();
	    $employee->name = 'Paijo';
	    $employee->phone = '0856937483738';
	    $employee->save();

	    $employee = new Employee();
	    $employee->name = 'James';
	    $employee->phone = '0856717364734';
	    $employee->save();

	    $employee = new Employee();
	    $employee->name = 'Budi';
	    $employee->phone = '0812848495502';
	    $employee->save();
    }
}
