<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\InvestmentArchive;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display superadmin dashboard
     */
   // app/Http/Controllers/Superadmin/DashboardController.php

public function index()
{
    return view('superadmin.dashboard', [
        'usersCount' => User::count(),
        'calculationsCount' => InvestmentArchive::count(), // Pastikan ini ada
        'viableCount' => InvestmentArchive::where('is_viable', true)->count(),
        'nonViableCount' => InvestmentArchive::where('is_viable', false)->count(),
        'recentCalculations' => InvestmentArchive::with('user')
            ->latest()
            ->take(5)
            ->get()
    ]);
}
}