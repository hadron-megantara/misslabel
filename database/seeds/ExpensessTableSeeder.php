<?php

use Illuminate\Database\Seeder;
use App\Expense;

class ExpensessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expense = new Expense();
	    $expense->value = 25000000;
	    $expense->date = '2017-01-20';
	    $expense->save();

	    $expense2 = new Expense();
	    $expense2->value = 50000000;
	    $expense2->date = '2017-01-30';
	    $expense2->save();

	    $expense3 = new Expense();
	    $expense3->value = 30000000;
	    $expense3->date = '2017-02-05';
	    $expense3->save();

	    $expense4 = new Expense();
	    $expense4->value = 28000000;
	    $expense4->date = '2017-02-10';
	    $expense4->save();

	    $expense5 = new Expense();
	    $expense5->value = 60000000;
	    $expense5->date = '2017-02-15';
	    $expense5->save();

	    $expense6 = new Expense();
	    $expense6->value = 75000000;
	    $expense6->date = '2017-02-22';
	    $expense6->save();

	    $expense7 = new Expense();
	    $expense7->value = 45000000;
	    $expense7->date = '2017-02-23';
	    $expense7->save();

	    $expense8 = new Expense();
	    $expense8->value = 24000000;
	    $expense8->date = '2017-02-28';
	    $expense8->save();

	    $expense9 = new Expense();
	    $expense9->value = 35000000;
	    $expense9->date = '2017-03-03';
	    $expense9->save();

	    $expense10 = new Expense();
	    $expense10->value = 27000000;
	    $expense10->date = '2017-03-09';
	    $expense10->save();

	    $expense11 = new Expense();
	    $expense11->value = 27000000;
	    $expense11->date = '2017-03-15';
	    $expense11->save();

	    $expense12 = new Expense();
	    $expense12->value = 28000000;
	    $expense12->date = '2017-03-20';
	    $expense12->save();

	    $expense13 = new Expense();
	    $expense13->value = 37500000;
	    $expense13->date = '2017-03-26';
	    $expense13->save();

	    $expense14 = new Expense();
	    $expense14->value = 27000000;
	    $expense14->date = '2017-03-30';
	    $expense14->save();

	    $expense15 = new Expense();
	    $expense15->value = 60000000;
	    $expense15->date = '2017-04-05';
	    $expense15->save();

	    $expense16 = new Expense();
	    $expense16->value = 78000000;
	    $expense16->date = '2017-04-12';
	    $expense16->save();

	    $expense17 = new Expense();
	    $expense17->value = 56000000;
	    $expense17->date = '2017-04-17';
	    $expense17->save();

	    $expense18 = new Expense();
	    $expense18->value = 25000000;
	    $expense18->date = '2017-04-24';
	    $expense18->save();

	    $expense19 = new Expense();
	    $expense19->value = 70000000;
	    $expense19->date = '2017-04-28';
	    $expense19->save();

	    $expense20 = new Expense();
	    $expense20->value = 30000000;
	    $expense20->date = '2017-04-30';
	    $expense20->save();

	    $expense21 = new Expense();
	    $expense21->value = 25000000;
	    $expense21->date = '2017-05-02';
	    $expense21->save();

	    $expense22 = new Expense();
	    $expense22->value = 40000000;
	    $expense22->date = '2017-05-05';
	    $expense22->save();
    }
}
