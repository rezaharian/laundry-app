<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('packages')->insert([
            ['nama' => 'Kiloan', 'deskripsi' => 'Laundry berdasarkan berat (kg)'],
            ['nama' => 'Satuan', 'deskripsi' => 'Laundry per item'],
            ['nama' => 'Karpet', 'deskripsi' => 'Laundry karpet per meter'],
            ['nama' => 'Gordyn', 'deskripsi' => 'Laundry gordyn per meter'],
        ]);
    }
}