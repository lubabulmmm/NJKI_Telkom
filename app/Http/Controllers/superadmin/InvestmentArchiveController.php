<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\InvestmentArchive;
use Illuminate\Http\Request;

class InvestmentArchiveController extends Controller
{
    /**
     * Display a listing of the archived calculations.
     */
    public function index()
    {
        $archives = InvestmentArchive::with('user')
            ->when(request('viability') === 'layak', function ($query) {
                return $query->where('is_viable', true);
            })
            ->when(request('viability') === 'tidak-layak', function ($query) {
                return $query->where('is_viable', false);
            })
            ->when(request('search'), function ($query) {
                $search = request('search');
                return $query->where(function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('calculation_date', 'desc')
            ->paginate(request('per_page', 10))
            ->withQueryString();

        return view('superadmin.investment.archive.index', compact('archives'));
    }


    /**
     * Display the specified archived calculation.
     */
    public function show(InvestmentArchive $archive)
    {
        $archive->load('user');
        $cashFlows = json_decode($archive->cash_flows, true) ?? [];
        
        return view('superadmin.investment.archive.show', compact('archive', 'cashFlows'));
    }

    /**
     * Remove the specified archived calculation.
     */
    public function destroy(InvestmentArchive $archive)
    {
        $archive->delete();
        
        return redirect()->route('superadmin.investment.archive.index')
            ->with('success', 'Archive deleted successfully');
    }
}