<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        // Buat beberapa item
        $items = [
            ['nama_barang' => 'Internet Provider A'],
            ['nama_barang' => 'Internet Provider B'],
            ['nama_barang' => 'Internet Provider C'],
            ['nama_barang' => 'Indihome'],
            ['nama_barang' => 'Telkomsel'],
            ['nama_barang' => 'HSI'],
            ['nama_barang' => 'Astinet'],
           
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}