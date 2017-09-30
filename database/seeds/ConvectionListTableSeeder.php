<?php

use Illuminate\Database\Seeder;
use App\ConvectionList;

class ConvectionListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $convectionList = new ConvectionList();
	    $convectionList->name = 'Konveksi A';
	    $convectionList->description = 'Jl Pamungkas Raya No 1';
	    $convectionList->save();

	    $convectionList2 = new ConvectionList();
	    $convectionList2->name = 'Konveksi B';
	    $convectionList2->description = 'Jl Panahan Raya No 23';
	    $convectionList2->save();

        $convectionList3 = new ConvectionList();
        $convectionList3->name = 'Konveksi C';
        $convectionList3->description = 'Jl Taman Rawa Pening 1 no 21A';
        $convectionList3->save();

        $convectionList4 = new ConvectionList();
        $convectionList4->name = 'Konveksi D';
        $convectionList4->description = 'Jl KH Royani 1 no 5';
        $convectionList4->save();

        $convectionList5 = new ConvectionList();
        $convectionList5->name = 'Konveksi E';
        $convectionList5->description = 'Jl Sudirman Raya No 5';
        $convectionList5->save();
    }
}
