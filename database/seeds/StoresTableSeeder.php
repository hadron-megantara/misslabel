<?php

use Illuminate\Database\Seeder;
use App\Store;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $store = new Store();
	    $store->name = 'Toko A';
        $store->description = 'Alamat Toko A';
	    $store->save();

	    $store = new Store();
	    $store->name = 'Toko B';
        $store->description = 'Alamat Toko B';
	    $store->save();
    }
}
