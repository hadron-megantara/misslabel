<?php

use Illuminate\Database\Seeder;
use App\Color;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color = new Color();
	    $color->name = 'Putih';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Hitam';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Hijau';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Hijau Botol';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Ungu';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Merah';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Marun';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Abu-abu Tua';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Coklat Tua';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Biru Langit/Telur Asin';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Ungu Muda';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Baby Pink';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Manggis';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Dusty Pink';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Hijau Daun';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Ungu Terong';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Abu-abu Muda';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Mocca';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Coklat Muda';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Kuning Kunyit';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Hijau Tosca';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Biru Tosca';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Hijau Mint';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Pink Fanta';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Benhur Tua';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Hijau Lumut';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Benhur Tua';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Merah Ati';
	    $color->save();

	    $color = new Color();
	    $color->name = 'Biru Dongker';
	    $color->save();
    }
}
