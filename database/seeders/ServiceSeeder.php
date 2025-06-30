<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('services')->insert([
            ['nama' => 'Express', 'harga' => 5000, 'deskripsi' => '1 hari selesai'],
            ['nama' => 'Dry Cleaning', 'harga' => 7000, 'deskripsi' => 'Cuci kering khusus'],
            ['nama' => 'Delivery', 'harga' => 3000, 'deskripsi' => 'Antar jemput'],
            ['nama' => 'Next Day', 'harga' => 4000, 'deskripsi' => 'Selesai besok'],
        ]);
    }
}