<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert(['name' => 'Barber Shop', 'open_date' => '2021-09-01 00:00:01', 'close_date' => '2021-09-30 11:59:59']);
    }
}
