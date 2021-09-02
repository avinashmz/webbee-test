<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slots = [
            [
                'start' => '8:00',
                'end' => '8:30'
            ],
            [
                'start' => '8:30',
                'end' => '9:00'
            ],
            [
                'start' => '9:00',
                'end' => '9:30'
            ],
            [
                'start' => '9:30',
                'end' => '10:00'
            ],
            [
                'start' => '10:00',
                'end' => '10:30'
            ],
            [
                'start' => '10:30',
                'end' => '11:00'
            ],
            [
                'start' => '11:00',
                'end' => '11:30'
            ],
            [
                'start' => '11:30',
                'end' => '12:00'
            ],
            [
                'start' => '13:00',
                'end' => '13:30'
            ],
            [
                'start' => '13:30',
                'end' => '14:00'
            ],
            [
                'start' => '14:00',
                'end' => '14:30'
            ],
            [
                'start' => '15:00',
                'end' => '15:30'
            ],
            [
                'start' => '15:30',
                'end' => '16:00'
            ],
            [
                'start' => '16:00',
                'end' => '16:30'
            ],
            [
                'start' => '16:30',
                'end' => '17:00'
            ],
            [
                'start' => '17:00',
                'end' => '17:30'
            ],
            [
                'start' => '17:30',
                'end' => '18:00'
            ],
            [
                'start' => '18:00',
                'end' => '18:30'
            ],
            [
                'start' => '18:30',
                'end' => '19:00'
            ],
            [
                'start' => '19:00',
                'end' => '19:30'
            ],
            [
                'start' => '19:30',
                'end' => '20:00'
            ]
        ];

        DB::table('slots')->insert($slots);
    }
}
