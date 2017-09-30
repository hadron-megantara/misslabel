<?php

use Illuminate\Database\Seeder;
use App\Material;

class MaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$material = new Material();
	    $material->material_type = 'SIFON/CHIFFON';
	    $material->length = 1000;
	    $material->color = 'merah';
	    $material->description = 'Sifon polos';
	    $material->price = 25000000;
	    $material->date_purchase = '2017-01-20';
	    $material->save();

	    $material2 = new Material();
	    $material2->material_type = 'SUTRA';
	    $material2->length = 2000;
	    $material2->color = 'Putih';
	    $material2->description = 'Sutra lembut';
	    $material2->price = 50000000;
	    $material2->date_purchase = '2017-01-30';
	    $material2->save();

	    $material3 = new Material();
	    $material3->material_type = 'VOILE';
	    $material3->length = 1000;
	    $material3->color = 'Hitam';
	    $material3->description = 'Keterangan bahan Voile';
	    $material3->price = 30000000;
	    $material3->date_purchase = '2017-02-05';
	    $material3->save();

	    $material4 = new Material();
	    $material4->material_type = 'SPANDEK';
	    $material4->length = 1000;
	    $material4->color = 'Hijau';
	    $material4->description = 'Keterangan bahan Spandek';
	    $material4->price = 28000000;
	    $material4->date_purchase = '2017-02-10';
	    $material4->save();

	    $material5 = new Material();
	    $material5->material_type = 'CERUTY';
	    $material5->length = 2000;
	    $material5->color = 'Merah';
	    $material5->description = 'Keterangan bahan ceruty';
	    $material5->price = 60000000;
	    $material5->date_purchase = '2017-02-15';
	    $material5->save();

	    $material6 = new Material();
	    $material6->material_type = 'RAYON';
	    $material6->length = 3000;
	    $material6->color = 'Hijau';
	    $material6->description = 'Keterangan bahan rayon';
	    $material6->price = 75000000;
	    $material6->date_purchase = '2017-02-22';
	    $material6->save();

	    $material7 = new Material();
	    $material7->material_type = 'KAOS';
	    $material7->length = 2000;
	    $material7->color = 'Biru';
	    $material7->description = 'Keterangan bahan kaos';
	    $material7->price = 45000000;
	    $material7->date_purchase = '2017-02-23';
	    $material7->save();

	    $material8 = new Material();
	    $material8->material_type = 'RAJUT';
	    $material8->length = 1000;
	    $material8->color = 'Ungu';
	    $material8->description = 'Keterangan bahan rajut';
	    $material8->price = 24000000;
	    $material8->date_purchase = '2017-02-28';
	    $material8->save();

	    $material9 = new Material();
	    $material9->material_type = 'JERSEY';
	    $material9->length = 3000;
	    $material9->color = 'Merah';
	    $material9->description = 'Keterangan bahan jersey';
	    $material9->price = 35000000;
	    $material9->date_purchase = '2017-03-03';
	    $material9->save();

	    $material10 = new Material();
	    $material10->material_type = 'KATUN';
	    $material10->length = 1000;
	    $material10->color = 'Hitam';
	    $material10->description = 'Keterangan bahan katun';
	    $material10->price = 27000000;
	    $material10->date_purchase = '2017-03-09';
	    $material10->save();

	    $material11 = new Material();
	    $material11->material_type = 'KASHMIR';
	    $material11->length = 1000;
	    $material11->color = 'Biru';
	    $material11->description = 'Keterangan bahan kashmir';
	    $material11->price = 27000000;
	    $material11->date_purchase = '2017-03-15';
	    $material11->save();

	    $material12 = new Material();
	    $material12->material_type = 'POLYSTER';
	    $material12->length = 1000;
	    $material12->color = 'Hijau';
	    $material12->description = 'Keterangan bahan polyster';
	    $material12->price = 28000000;
	    $material12->date_purchase = '2017-03-20';
	    $material12->save();

	    $material13 = new Material();
	    $material13->material_type = 'SIFON/CHIFFON';
	    $material13->length = 1500;
	    $material13->color = 'Merah';
	    $material13->description = 'Keterangan bahan sifon';
	    $material13->price = 37500000;
	    $material13->date_purchase = '2017-03-26';
	    $material13->save();

	    $material14 = new Material();
	    $material14->material_type = 'KAOS';
	    $material14->length = 2000;
	    $material14->color = 'Kuning';
	    $material14->description = 'Keterangan bahan kaos';
	    $material14->price = 27000000;
	    $material14->date_purchase = '2017-03-30';
	    $material14->save();

	    $material15 = new Material();
	    $material15->material_type = 'RAJUT';
	    $material15->length = 3000;
	    $material15->color = 'Biru';
	    $material15->description = 'Keterangan bahan rajut';
	    $material15->price = 60000000;
	    $material15->date_purchase = '2017-04-05';
	    $material15->save();

	    $material16 = new Material();
	    $material16->material_type = 'SUTRA';
	    $material16->length = 3500;
	    $material16->color = 'Merah';
	    $material16->description = 'Keterangan bahan sutra';
	    $material16->price = 78000000;
	    $material16->date_purchase = '2017-04-12';
	    $material16->save();

	    $material17 = new Material();
	    $material17->material_type = 'RAYON';
	    $material17->length = 2000;
	    $material17->color = 'Biru';
	    $material17->description = 'Keterangan bahan rayon';
	    $material17->price = 56000000;
	    $material17->date_purchase = '2017-04-17';
	    $material17->save();

	    $material18 = new Material();
	    $material18->material_type = 'KASHMIR';
	    $material18->length = 1000;
	    $material18->color = 'Merah';
	    $material18->description = 'Keterangan bahan kashmir';
	    $material18->price = 25000000;
	    $material18->date_purchase = '2017-04-24';
	    $material18->save();
    }
}
