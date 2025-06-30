<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('package_items')->insert([
            // Kiloan
            ['package_id' => 1, 'nama_item' => 'Cuci Kering', 'satuan' => 'kg', 'tipe' => null, 'harga' => 7000],
            ['package_id' => 1, 'nama_item' => 'Cuci Gosok', 'satuan' => 'kg', 'tipe' => null, 'harga' => 10000],

            // Satuan
            ['package_id' => 2, 'nama_item' => 'Baju', 'satuan' => 'pcs', 'tipe' => null, 'harga' => 5000],
            ['package_id' => 2, 'nama_item' => 'Celana', 'satuan' => 'pcs', 'tipe' => null, 'harga' => 6000],
            ['package_id' => 2, 'nama_item' => 'Dasi', 'satuan' => 'pcs', 'tipe' => null, 'harga' => 3000],

            // Karpet
            ['package_id' => 3, 'nama_item' => 'Karpet Tipis', 'satuan' => 'meter', 'tipe' => 'tipis', 'harga' => 10000],
            ['package_id' => 3, 'nama_item' => 'Karpet Tebal', 'satuan' => 'meter', 'tipe' => 'tebal', 'harga' => 15000],

            // Gordyn
            ['package_id' => 4, 'nama_item' => 'Gordyn Tipis', 'satuan' => 'meter', 'tipe' => 'tipis', 'harga' => 11000],
            ['package_id' => 4, 'nama_item' => 'Gordyn Tebal', 'satuan' => 'meter', 'tipe' => 'tebal', 'harga' => 16000],
        ]);
    }
}