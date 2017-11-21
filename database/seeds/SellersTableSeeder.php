<?php

use Illuminate\Database\Seeder;
use App\Seller;

class SellersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seller = new Seller();
	    $seller->name = 'Penjual Satu';
	    $seller->phone = '08617274844825';
	    $seller->description = 'keterangan penjual';
	    $seller->save();

	    $seller = new Seller();
	    $seller->name = 'Penjual Dua';
	    $seller->phone = '08771823838494';
	    $seller->description = 'keterangan penjual dua';
	    $seller->save();

	    $seller = new Seller();
	    $seller->name = 'Penjual Tiga';
	    $seller->phone = '0812647272828';
	    $seller->description = 'keterangan penjual tiga';
	    $seller->save();

	    $seller = new Seller();
	    $seller->name = 'Penjual Empat';
	    $seller->phone = '08124949505059';
	    $seller->description = 'keterangan penjual empat';
	    $seller->save();

	    $seller = new Seller();
	    $seller->name = 'Penjual Lima';
	    $seller->phone = '08674832023032';
	    $seller->description = 'keterangan penjual lima';
	    $seller->save();
    }
}
