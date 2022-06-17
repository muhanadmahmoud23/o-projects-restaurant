<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Custmors Seed
        DB::table('customer')->insert([
            'name' => 'Muhanad Mahmoud',
            'phone' => '01110032911'
        ]);
        DB::table('customer')->insert([
            'name' => 'Mahmoud Hassan',
            'phone' => '01110032911'
        ]);
        DB::table('customer')->insert([
            'name' => 'Hussien Tawfik',
            'phone' => '01110032911'
        ]);

        //Tables Seed
        DB::table('table')->insert([
            'capacity' => '2',
        ]);
        DB::table('table')->insert([
            'capacity' => '4',
        ]);
        DB::table('table')->insert([
            'capacity' => '6',
        ]);
        DB::table('table')->insert([
            'capacity' => '7',
        ]);
        DB::table('table')->insert([
            'capacity' => '9',
        ]);

        //Waiters Seed
        DB::table('waiter')->insert([
            'name' => 'Mohamed Ali',
        ]);
        DB::table('waiter')->insert([
            'name' => 'Hassan Medhat',
        ]);

        // Meals Seed
        DB::table('meal')->insert([
            'price' => '25',
            'description' => 'Fries',
            'quantity_avaliable' => '5',
            'discount' => '10',
        ]);
        DB::table('meal')->insert([
            'price' => '220',
            'description' => 'Steak',
            'quantity_avaliable' => '5',
            'discount' => '15',
        ]);
        DB::table('meal')->insert([
            'price' => '70',
            'description' => 'Chicken',
            'quantity_avaliable' => '5',
            'discount' => '5',
        ]);
        DB::table('meal')->insert([
            'price' => '40',
            'description' => 'Sweet Corn',
            'quantity_avaliable' => '5',
            'discount' => '10',
        ]);
    }
}
