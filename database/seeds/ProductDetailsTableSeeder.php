<?php

use Illuminate\Database\Seeder;
use App\ProductDetail;

class ProductDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productDetail = new ProductDetail();
	    $productDetail->name = 'Atayya Khimar';
        $productDetail->description = 'Detail model Atayya';
        $productDetail->price = '80000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = 'Hazna Khimar';
        $productDetail->description = 'Detail model Hazna';
        $productDetail->price = '90000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = 'Kimar Queensha';
        $productDetail->description = 'Detail model Kimar Queensha';
        $productDetail->price = '93000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = 'Khimar Kupu-Kupu';
        $productDetail->description = 'Detail model Khimar Kupu-Kupu';
        $productDetail->price = '75000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = 'Kimar Tasya';
        $productDetail->description = 'Detail model Khimar Tasya';
        $productDetail->price = '100000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = "Khimar Syar'i Delisa";
        $productDetail->description = "Detail model Khimar Syar'i Delisa";
        $productDetail->price = '97000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = "Khimar Syar'i Aisyah";
        $productDetail->description = "Detail model Khimar Syar'i Aisyah";
        $productDetail->price = '98000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();
    }
}
