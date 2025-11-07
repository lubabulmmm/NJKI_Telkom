<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Memanggil UserSeeder untuk menambahkan data pengguna
        $this->call([
            ItemSeeder::class,
            BandwidthSeeder::class,
            UserSeeder::class
            ]);
    }
}
