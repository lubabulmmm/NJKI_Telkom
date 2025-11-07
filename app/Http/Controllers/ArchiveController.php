<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archive;
use App\Models\Bandwidth;  // Model Bandwidth
use Illuminate\Support\Facades\Validator;

class ArchiveController extends Controller
{
    /**
     * Menyimpan data input ke dalam tabel archive.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveArchive(Request $request)
    {
        // Validasi data yang diterima
        $validator = Validator::make($request->all(), [
            'bandwidth_id' => 'required|exists:bandwidths,id', // Validasi bandwidth_id
            'capex' => 'required|numeric',
            'opex' => 'required|numeric',
            'wacc' => 'required|numeric',
            'bhp' => 'required|numeric',
            'minimal_irr' => 'required|numeric',
            'depreciation' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        // Proses perhitungan berdasarkan inputan
        $quantity = $request->capex * 2;  // Misalnya perhitungan untuk quantity
        $duration = $request->opex + $request->wacc;  // Misalnya perhitungan untuk duration
        $totalPrice = $request->capex + $request->bhp + $request->wacc;  // Misalnya perhitungan untuk total price

        // Simpan data ke dalam tabel archive
        $archive = new Archive();
        $archive->bandwidth_id = $request->bandwidth_id;  // Ambil bandwidth_id dari input
        $archive->capex = $request->capex;
        $archive->opex = $request->opex;
        $archive->wacc = $request->wacc;
        $archive->bhp = $request->bhp;
        $archive->minimal_irr = $request->minimal_irr;
        $archive->depreciation = $request->depreciation;
        $archive->quantity = $quantity;
        $archive->duration = $duration;
        $archive->total_price = $totalPrice;
        $archive->created_at = now();
        $archive->updated_at = now();

        // Simpan data
        if ($archive->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data.',
            ]);
        }
    }
}
