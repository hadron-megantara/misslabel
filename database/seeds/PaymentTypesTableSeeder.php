<?php

use Illuminate\Database\Seeder;
use App\PaymentType;

class PaymentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentType = new PaymentType();
	    $paymentType->name = 'Uang Tunai';
	    $paymentType->save();

	    $paymentType = new PaymentType();
	    $paymentType->name = 'Transfer';
	    $paymentType->save();

	    $paymentType = new PaymentType();
	    $paymentType->name = 'Hutang';
	    $paymentType->save();

	    $paymentType = new PaymentType();
	    $paymentType->name = 'Giro';
	    $paymentType->save();
    }
}
