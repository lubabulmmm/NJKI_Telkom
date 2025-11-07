<?php

namespace Database\Seeders;

use App\Models\Bandwidth;
use App\Models\Item;
use Illuminate\Database\Seeder;

class BandwidthSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua item yang sudah dibuat
        $items = Item::all();

        // Jika tidak ada item, buat dulu itemnya
        if ($items->isEmpty()) {
            $this->call(ItemSeeder::class);
            $items = Item::all();
        }

        // Harga dasar untuk setiap item
        $basePrices = [
            'Internet Provider A' => 50000,  // Harga dasar untuk Provider A
            'Internet Provider B' => 60000,  // Harga dasar untuk Provider B
            'Internet Provider C' => 70000,  // Harga dasar untuk Provider C
            'Indihome' => 150000,
            'Telkomsel' => 30000,
            'HSI' => 230000,
            'Astinet' => 180000,
        ];

        // Buat bandwidth untuk setiap item
        foreach ($items as $item) {
            $basePrice = $basePrices[$item->nama_barang]; // Ambil harga dasar berdasarkan nama barang

            for ($bw = 1; $bw <= 250; $bw++) {
                // Hitung harga berdasarkan bandwidth (misal: harga dasar * bw)
                $price = $basePrice * $bw;

                Bandwidth::create([
                    'bw' => $bw,
                    'price' => $price,
                    'item_id' => $item->id,
                ]);
            }
        }
    }
}