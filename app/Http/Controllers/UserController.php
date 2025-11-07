<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan informasi nama user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Mencari user berdasarkan ID, jika tidak ada maka akan menampilkan pesan alternatif
        $user = User::find($id);

        // Mengecek apakah user ditemukan atau tidak
        if ($user) {
            // Jika ditemukan, menampilkan nama user
            return response()->json([
                'name' => $user->name,
            ]);
        } else {
            // Jika tidak ditemukan, menampilkan pesan "User not found!"
            return response()->json([
                'error' => 'User not found!',
            ], 404);
        }
    }

    /**
     * Menampilkan informasi nama user dengan optional() untuk mencegah error.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOptional($id)
    {
        // Menggunakan optional() untuk menghindari error jika user tidak ditemukan
        $user = User::find($id);

        return response()->json([
            'name' => optional($user)->name ?? 'User not found!',
        ]);
    }

    /**
     * Menampilkan informasi nama user dengan firstOrFail() untuk menangani exception.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOrFail($id)
    {
        try {
            // Menggunakan firstOrFail() untuk menangani exception jika user tidak ditemukan
            $user = User::findOrFail($id);

            return response()->json([
                'name' => $user->name,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika tidak ditemukan, menampilkan pesan error
            return response()->json([
                'error' => 'User not found!',
            ], 404);
        }
    }
}
