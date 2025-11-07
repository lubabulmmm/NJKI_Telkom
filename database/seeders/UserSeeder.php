<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan 1 superadmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin123'), // Gantilah dengan password yang lebih kuat
            'role' => 'superadmin', // Pastikan ada kolom 'role' di tabel users jika menggunakan role
            'profile_photo_path' => null, // Sesuaikan jika ada foto profil
        ]);

        // Menambahkan 5 user biasa
        foreach (range(1, 5) as $index) {
            User::create([
                'name' => 'User ' . $index,
                'email' => 'user' . $index . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'), // Gantilah dengan password yang lebih kuat
                'role' => 'user', // Menetapkan role sebagai 'user'
                'profile_photo_path' => null, // Sesuaikan jika ada foto profil
            ]);
        }
    }
}
