<?php

use Illuminate\Database\Seeder;
use App\ProductModel;

class ProductModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productModel = new ProductModel();
	    $productModel->name = 'Atayya Khimar';
	    $productModel->save();

	    $productModel = new ProductModel();
	    $productModel->name = 'Hazna Khimar';
	    $productModel->save();

	    $productModel = new ProductModel();
	    $productModel->name = 'Kimar Queensha';
	    $productModel->save();

	    $productModel = new ProductModel();
	    $productModel->name = 'Khimar Kupu-Kupu';
	    $productModel->save();

	    $productModel = new ProductModel();
	    $productModel->name = 'Kimar Tasya';
	    $productModel->save();

	    $productModel = new ProductModel();
	    $productModel->name = "Khimar Syar'i Delisa";
	    $productModel->save();

	    $productModel = new ProductModel();
	    $productModel->name = "Khimar Syar'i Aisyah";
	    $productModel->save();
    }
}
