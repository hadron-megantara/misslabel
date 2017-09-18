<?php

use Illuminate\Database\Seeder;
use App\Customer;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $customer = new Customer();
	    $customer->name = 'Budi';
	    $customer->phone = '0857129484848';
	    $customer->store = 'Toko Makmur Jaya';
	    $customer->city = 'Tangerang';
	    $customer->description = 'Jl makmur satu no 5';
	    $customer->save();

	    $customer1 = new Customer();
	    $customer1->name = 'Joko';
	    $customer1->phone = '085747483993';
	    $customer1->store = 'Toko Sukarejo Jaya';
	    $customer1->city = 'Lampung';
	    $customer1->description = 'Jl Sarinem no 5';
	    $customer1->save();

	    $customer2 = new Customer();
	    $customer2->name = 'Anto';
	    $customer2->phone = '081244930029';
	    $customer2->store = 'Toko Maju Mundur';
	    $customer2->city = 'Medan';
	    $customer2->description = 'Jl Nasution no 21';
	    $customer2->save();

	    $customer3 = new Customer();
	    $customer3->name = 'Bejo';
	    $customer3->phone = '0812948383839';
	    $customer3->store = 'Toko Alon Alon';
	    $customer3->city = 'Surabaya';
	    $customer3->description = 'Jl Budi no 25';
	    $customer3->save();

	    $customer4 = new Customer();
	    $customer4->name = 'Didit';
	    $customer4->phone = '08575844930303';
	    $customer4->store = 'Toko Kelakon';
	    $customer4->city = 'Solo';
	    $customer4->description = 'Jl Panahan no 12';
	    $customer4->save();

	    $customer5 = new Customer();
	    $customer5->name = 'Yon';
	    $customer5->phone = '08123747448381';
	    $customer5->store = 'Toko Berbaju';
	    $customer5->city = 'Magelang';
	    $customer5->description = 'Jl Anakan no 9';
	    $customer5->save();

	    $customer6 = new Customer();
	    $customer6->name = 'Antox';
	    $customer6->phone = '081244930029';
	    $customer6->store = 'Toko Maju Mundurx';
	    $customer6->city = 'Medan';
	    $customer6->description = 'Jl Nasution no 21';
	    $customer6->save();

	    $customer7 = new Customer();
	    $customer7->name = 'Bejox';
	    $customer7->phone = '0812948383839';
	    $customer7->store = 'Toko Alon Alonx';
	    $customer7->city = 'Surabaya';
	    $customer7->description = 'Jl Budi no 25';
	    $customer7->save();

	    $customer8 = new Customer();
	    $customer8->name = 'Diditx';
	    $customer8->phone = '08575844930303';
	    $customer8->store = 'Toko Kelakonx';
	    $customer8->city = 'Solo';
	    $customer8->description = 'Jl Panahan no 12';
	    $customer8->save();

	    $customer9 = new Customer();
	    $customer9->name = 'Yonx';
	    $customer9->phone = '08123747448381';
	    $customer9->store = 'Toko Berbajux';
	    $customer9->city = 'Magelang';
	    $customer9->description = 'Jl Anakan no 9';
	    $customer9->save();

	    $customer10 = new Customer();
	    $customer10->name = 'Antos';
	    $customer10->phone = '081244930029';
	    $customer10->store = 'Toko Maju Mundurs';
	    $customer10->city = 'Medan';
	    $customer10->description = 'Jl Nasution no 21';
	    $customer10->save();

	    $customer11 = new Customer();
	    $customer11->name = 'Bejos';
	    $customer11->phone = '0812948383839';
	    $customer11->store = 'Toko Alon Alons';
	    $customer11->city = 'Surabaya';
	    $customer11->description = 'Jl Budi no 25';
	    $customer11->save();

	    $customer12 = new Customer();
	    $customer12->name = 'Didits';
	    $customer12->phone = '08575844930303';
	    $customer12->store = 'Toko Kelakons';
	    $customer12->city = 'Solo';
	    $customer12->description = 'Jl Panahan no 12';
	    $customer12->save();

	    $customer13 = new Customer();
	    $customer13->name = 'Yons';
	    $customer13->phone = '08123747448381';
	    $customer13->store = 'Toko Berbajus';
	    $customer13->city = 'Magelang';
	    $customer13->description = 'Jl Anakan no 9';
	    $customer13->save();

	    $customer14 = new Customer();
	    $customer14->name = 'Wakwaw';
	    $customer14->phone = '081244930029';
	    $customer14->store = 'Toko Maju Mundurs';
	    $customer14->city = 'Medan';
	    $customer14->description = 'Jl Nasution no 21';
	    $customer14->save();

	    $customer15 = new Customer();
	    $customer15->name = 'Cekss';
	    $customer15->phone = '0812948383839';
	    $customer15->store = 'Toko Alon Alons';
	    $customer15->city = 'Surabaya';
	    $customer15->description = 'Jl Budi no 25';
	    $customer15->save();

	    $customer16 = new Customer();
	    $customer16->name = 'Wiihhh';
	    $customer16->phone = '08575844930303';
	    $customer16->store = 'Toko Kelakons';
	    $customer16->city = 'Solo';
	    $customer16->description = 'Jl Panahan no 12';
	    $customer16->save();

	    $customer17 = new Customer();
	    $customer17->name = 'Wakakakaka';
	    $customer17->phone = '08123747448381';
	    $customer17->store = 'Toko Berbajus';
	    $customer17->city = 'Magelang';
	    $customer17->description = 'Jl Anakan no 9';
	    $customer17->save();
	}
}
