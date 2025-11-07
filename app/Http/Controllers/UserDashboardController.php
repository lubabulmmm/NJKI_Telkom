<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Data dummy untuk chart (7 bulan terakhir)
        $chartData = [
            'categories' => collect(range(6, 0))->map(function ($monthsAgo) {
                return now()->subMonths($monthsAgo)->format('M');
            })->toArray(),
            'data' => [4000, 3000, 5000, 4000, 7000, 8000, 9000]
        ];

        // Data dummy untuk investasi terakhir
        $recentInvestments = [
            [
                'name' => 'Properti Apartemen Central Park',
                'value' => 125000,
                'date' => now()->subDays(2)->format('d M Y'),
                'profit' => 5.2
            ],
            [
                'name' => 'Saham PT. Bumi Resources',
                'value' => 87500,
                'date' => now()->subDays(5)->format('d M Y'),
                'profit' => -2.1
            ],
            [
                'name' => 'Usaha Warung Kopi',
                'value' => 225000,
                'date' => now()->subDays(10)->format('d M Y'),
                'profit' => 8.7
            ],
            [
                'name' => 'Kripto Ethereum',
                'value' => 45600,
                'date' => now()->subDays(15)->format('d M Y'),
                'profit' => 12.3
            ]
        ];

        return view('dashboard', compact('chartData', 'recentInvestments'));
    }
}