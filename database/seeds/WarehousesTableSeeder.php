<?php

use Illuminate\Database\Seeder;
use App\Warehouse;

class WarehousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouse = new Warehouse();
	    $warehouse->name = 'Gudang A';
        $warehouse->description = 'Alamat Gudang A';
	    $warehouse->save();

	    $warehouse2 = new Warehouse();
	    $warehouse2->name = 'Gudang B';
        $warehouse2->description = 'Alamat Gudang B';
	    $warehouse2->save();
    }
}
