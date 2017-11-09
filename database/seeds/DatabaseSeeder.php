<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->call(RoleTableSeeder::class);
		$this->call(UserTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        // $this->call(MaterialTableSeeder::class);
        $this->call(MaterialTypeTableSeeder::class);
        $this->call(ConvectionListTableSeeder::class);
        $this->call(WarehousesTableSeeder::class);
        $this->call(ExpensessTableSeeder::class);
        $this->call(MaterialSellersTableSeeder::class);
        $this->call(MaterialColorsTableSeeder::class);
    }
}
