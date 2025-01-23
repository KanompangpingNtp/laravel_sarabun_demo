<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Agency;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['agency_name' => 'บริษัท GM SKY'],
            ['agency_name' => 'โปรแกรมเมอร์'],
            ['agency_name' => 'ผู้บริหาร'],
        ];

        foreach ($data as $item) {
            Agency::create($item);
        }
    }
}
