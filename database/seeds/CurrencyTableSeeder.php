<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'name' => 'US Dollar',
            'initials' => 'USD'
        ]);

        DB::table('currencies')->insert([
            'name' => 'Euro',
            'initials' => 'EUR'
        ]);

        DB::table('currencies')->insert([
            'name' => 'Pound Sterling',
            'initials' => 'GBP'
        ]);

        DB::table('currencies')->insert([
            'name' => 'Brazilian Real',
            'initials' => 'BRL'
        ]);
    }
}
