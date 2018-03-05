<?php

use Illuminate\Database\Seeder;
use App\MaterialSeller;

class MaterialSellersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materialSeller = new MaterialSeller();
	    $materialSeller->name = 'Penjual A';
	    $materialSeller->description = 'Keterangan Penjual A';
	    $materialSeller->save();

	    $materialSeller2 = new MaterialSeller();
	    $materialSeller2->name = 'Penjual B';
	    $materialSeller2->description = 'Keterangan Penjual B';
	    $materialSeller2->save();

	    $materialSeller3 = new MaterialSeller();
	    $materialSeller3->name = 'Penjual C';
	    $materialSeller3->description = 'Keterangan Penjual C';
	    $materialSeller3->save();

	    $materialSeller4 = new MaterialSeller();
	    $materialSeller4->name = 'Penjual D';
	    $materialSeller4->description = 'Keterangan Penjual D';
	    $materialSeller4->save();
    }
}
