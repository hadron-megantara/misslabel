<?php

use Illuminate\Database\Seeder;
use App\MaterialType;

class MaterialTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materialType = new MaterialType();
	    $materialType->name = 'SIFON/CHIFFON';
	    $materialType->save();

	    $materialType2 = new MaterialType();
	    $materialType2->name = 'HYCON';
	    $materialType2->save();

	    $materialType3 = new MaterialType();
	    $materialType3->name = 'VOILE';
	    $materialType3->save();

	    $materialType4 = new MaterialType();
	    $materialType4->name = 'SUTRA';
	    $materialType4->save();

	    $materialType5 = new MaterialType();
	    $materialType5->name = 'SPANDEK';
	    $materialType5->save();

	    $materialType6 = new MaterialType();
	    $materialType6->name = 'CERUTY';
	    $materialType6->save();

	    $materialType7 = new MaterialType();
	    $materialType7->name = 'HIGET';
	    $materialType7->save();

	    $materialType8 = new MaterialType();
	    $materialType8->name = 'RAYON';
	    $materialType8->save();

	    $materialType9 = new MaterialType();
	    $materialType9->name = 'PE/POLY ETHILENE';
	    $materialType9->save();

	    $materialType10 = new MaterialType();
	    $materialType10->name = 'TC/TETERON - COTTON';
	    $materialType10->save();

	    $materialType11 = new MaterialType();
	    $materialType11->name = 'KAOS';
	    $materialType11->save();

	    $materialType12 = new MaterialType();
	    $materialType12->name = 'RAJUT';
	    $materialType12->save();

	    $materialType13 = new MaterialType();
	    $materialType13->name = 'JERSEY';
	    $materialType13->save();

	    $materialType14 = new MaterialType();
	    $materialType14->name = 'KATUN';
	    $materialType14->save();

	    $materialType15 = new MaterialType();
	    $materialType15->name = 'KASHMIR';
	    $materialType15->save();

	    $materialType16 = new MaterialType();
	    $materialType16->name = 'POLYSTER';
	    $materialType16->save();
    }
}
