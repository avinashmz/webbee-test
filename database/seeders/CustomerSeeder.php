<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            'first_name' => 'Avinash',
            'last_name' => 'Zala',
            'email' => 'avinash@xpertdeveloper.com'
        ];

        DB::table('customers')->insert($customers);
    }
}
