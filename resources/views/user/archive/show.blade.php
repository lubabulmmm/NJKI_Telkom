<x-app-layout>
    <div class="ml-0 sm:ml-60 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8">
            <div class="flex-1 overflow-y-auto p-6 mt-8 min-h-screen">
                <div class="bg-white/90 glassmorphism rounded-3xl card-shadow mb-8">
                    <div class="bg-gradient-to-r from-red-600 to-orange-600 text-white p-8 rounded-t-3xl">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-3xl font-bold mb-2">📊 Investment Details</h1>
                                <p class="text-lg opacity-90">Calculation from
                                    {{ $archive->calculation_date->format('d M Y H:i') }}</p>
                            </div>
                            <a href="{{ route('user.investment.archive.index') }}"
                                class="btn-hover bg-white text-blue-600 px-6 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                <span>Back to Archives</span>
                            </a>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <!-- Basic Information -->
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">📝 Basic Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Customer Name</p>
                                        <p class="font-medium">{{ $archive->customer_name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Calculation Date</p>
                                        <p class="font-medium">{{ $archive->calculation_date->format('d M Y H:i') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">CAPEX</p>
                                        <p class="font-medium">Rp{{ number_format($archive->capex, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Total Revenue</p>
                                        <p class="font-medium">
                                            Rp{{ number_format($archive->total_revenue, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Parameters -->
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">⚙️ Parameters</h3>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">OPEX Percentage</p>
                                        <p class="font-medium">{{ $archive->opex_percentage }}%</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">WACC Percentage</p>
                                        <p class="font-medium">{{ $archive->wacc_percentage }}%</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">BHP Percentage</p>
                                        <p class="font-medium">{{ $archive->bhp_percentage }}%</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Minimal IRR</p>
                                        <p class="font-medium">{{ $archive->minimal_irr_percentage }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Results -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <!-- NPV -->
                            <div
                                class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 shadow-sm border border-blue-200">
                                <h3 class="text-lg font-semibold text-blue-800 mb-2">💹 Net Present Value</h3>
                                <p
                                    class="text-2xl font-bold {{ $archive->npv >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                    Rp{{ number_format($archive->npv, 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-blue-600 mt-1">Weighted Average Cost of Capital:
                                    {{ $archive->wacc_percentage }}%</p>
                            </div>

                            <!-- IRR -->
                            <div
                                class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-6 shadow-sm border border-purple-200">
                                <h3 class="text-lg font-semibold text-purple-800 mb-2">🎲 Internal Rate of Return</h3>
                                <div class="flex items-center">
                                    <p
                                        class="text-2xl font-bold {{ $archive->is_viable ? 'text-purple-600' : 'text-red-600' }}">
                                        {{ number_format($archive->irr, 2) }}%
                                    </p>
                                    <span
                                        class="ml-3 px-3 py-1 rounded-full text-xs font-bold {{ $archive->is_viable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $archive->is_viable ? 'LAYAK' : 'TIDAK LAYAK' }}
                                    </span>
                                </div>
                                <p class="text-sm text-purple-600 mt-1">Minimal IRR:
                                    {{ $archive->minimal_irr_percentage }}%</p>
                            </div>

                            <!-- Payback Period -->
                            <div
                                class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 shadow-sm border border-green-200">
                                <h3 class="text-lg font-semibold text-green-800 mb-2">⏰ Payback Period</h3>
                                <p class="text-2xl font-bold text-green-600">
                                    @php
                                        // Parse the payback period from the database
                                        $paybackPeriod = $archive->payback_period;

                                        // Check if it's the special case
if (strpos($paybackPeriod, 'Investasi belum kembali dalam 3 tahun') !== false) {
    echo $paybackPeriod;
} else {
    // Extract years and months
    $years = 0;
    $months = 0;

    if (preg_match('/(\d+) tahun/', $paybackPeriod, $yearMatches)) {
        $years = (int) $yearMatches[1];
    }

    if (preg_match('/(\d+) bulan/', $paybackPeriod, $monthMatches)) {
        $months = (int) $monthMatches[1];
    }

    // Add 6 months as in the calculator
    $totalMonths = $years * 12 + $months;
    $newYears = floor($totalMonths / 12);
    $newMonths = $totalMonths % 12;

    // Format the output
    $formatted = '';
    if ($newYears > 0) {
        $formatted .= $newYears . ' tahun ';
    }
    if ($newMonths > 0) {
        $formatted .= $newMonths . ' bulan';
                                            }
                                            echo trim($formatted);
                                        }
                                    @endphp
                                </p>
                                <p class="text-sm text-green-600 mt-1">Time to recover initial investment</p>
                            </div>
                        </div>

                        <!-- Revenue Items -->
                        @if ($archive->items->count() > 0)
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 mb-8">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">💰 Revenue Items</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Item</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Bandwidth</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Quantity</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Duration (Months)</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Price</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($archive->items as $item)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $item->item->nama_barang ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $item->bandwidth->bw ?? 'N/A' }} Mbps
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $item->quantity }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $item->duration }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        Rp{{ number_format($item->price * $item->quantity * $item->duration, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- Financial Summary -->
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">📊 Financial Summary</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Year
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Revenue
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                OPEX
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                BHP
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Depreciation
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Net Cash Flow
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @for ($year = 1; $year <= 3; $year++)
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    Year {{ $year }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp{{ number_format($archive->total_revenue, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp{{ number_format(($archive->opex_percentage / 100) * $archive->capex, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp{{ number_format(($archive->bhp_percentage / 100) * $archive->total_revenue, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp{{ number_format($archive->depreciation, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @php
                                                        $opex = ($archive->opex_percentage / 100) * $archive->capex;
                                                        $bhp =
                                                            ($archive->bhp_percentage / 100) * $archive->total_revenue;
                                                        $ebitda = $archive->total_revenue - $opex - $bhp;
                                                        $ebit = $ebitda - $archive->depreciation;
                                                        $taxes = max(0, $ebit * 0.3);
                                                        $nopat = $ebit - $taxes;
                                                        $netCashFlow = $nopat + $archive->depreciation;
                                                    @endphp
                                                    Rp{{ number_format($netCashFlow, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        @if ($archive->notes)
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 mb-8">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">
                                    📝 Additional Notes
                                </h3>
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-gray-700">
                                                {{ $archive->notes }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('user.investment.archive.edit', $archive->id) }}"
                                class="btn-hover bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl">
                                Edit Archive
                            </a>
                            <a href="{{ route('user.investment.archive.export', $archive->id) }}"
                                class="btn-hover bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl">
                                Export to Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .glassmorphism {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .card-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-1px);
        }
    </style>
</x-app-layout>
