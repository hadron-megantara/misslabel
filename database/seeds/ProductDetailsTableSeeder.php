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
        $productDetail->price = '80000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = 'Hazna Khimar';
        $productDetail->price = '90000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = 'Kimar Queensha';
        $productDetail->price = '93000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = 'Khimar Kupu-Kupu';
        $productDetail->price = '75000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = 'Kimar Tasya';
        $productDetail->price = '100000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = "Khimar Syar'i Delisa";
        $productDetail->price = '97000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();

	    $productDetail = new ProductDetail();
	    $productDetail->name = "Khimar Syar'i Aisyah";
        $productDetail->price = '98000';
        $productDetail->unit = 'pcs';
	    $productDetail->save();
    }
}
