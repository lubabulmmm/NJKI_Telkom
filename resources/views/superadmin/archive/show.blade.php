<x-app-layout>
    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14">
            <!-- Header Section -->
            <div class="flex flex-col border-b mt-8 md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Investment Analysis Details</h1>
                    <p class="text-gray-600 mt-2">Detailed view of the investment calculation</p>
                </div>
                <a href="{{ route('superadmin.investment.archive.index') }}"
                    class="flex items-center text-red-600 hover:text-red-800 mt-4 md:mt-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Archives
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <!-- Card Header with Gradient -->
                <div class="bg-gradient-to-r from-red-600 to-orange-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-white">Calculation Summary</h2>
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium {{ $archive->is_viable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $archive->is_viable ? 'Viable Investment' : 'Not Viable' }}
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- User Info Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            User Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium">{{ $archive->user->name }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $archive->user->email }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Calculation Date</p>
                                <p class="font-medium">{{ $archive->calculation_date->format('d M Y, H:i') }}</p>
                            </div>
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

                    <!-- Key Metrics Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                            </svg>
                            Key Metrics
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                                <p class="text-sm text-gray-500">IRR</p>
                                <p
                                    class="text-2xl font-bold {{ $archive->is_viable ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($archive->irr, 2) }}%
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Minimum required:
                                    {{ $archive->minimal_irr_percentage }}%</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg border-l-4 border-purple-500">
                                <p class="text-sm text-gray-500">NPV</p>
                                <p
                                    class="text-2xl font-bold {{ $archive->npv >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp{{ number_format($archive->npv, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="bg-orange-50 p-4 rounded-lg border-l-4 border-orange-500">
                                <p class="text-sm text-gray-500">Payback Period</p>
                                <p class="text-2xl font-bold">{{ $archive->payback_period }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Input Parameters Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Input Parameters
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500">CAPEX</p>
                                <p class="font-medium">Rp{{ number_format($archive->capex, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500">OPEX Percentage</p>
                                <p class="font-medium">{{ $archive->opex_percentage }}%</p>
                            </div>
                            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500">WACC Percentage</p>
                                <p class="font-medium">{{ $archive->wacc_percentage }}%</p>
                            </div>
                            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500">BHP Percentage</p>
                                <p class="font-medium">{{ $archive->bhp_percentage }}%</p>
                            </div>
                            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500">Total Revenue</p>
                                <p class="font-medium">Rp{{ number_format($archive->total_revenue, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Results Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Calculation Results
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500">Depreciation</p>
                                <p class="font-medium">Rp{{ number_format($archive->depreciation, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500">Net Present Value (NPV)</p>
                                <p class="font-medium {{ $archive->npv >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp{{ number_format($archive->npv, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500">Internal Rate of Return (IRR)</p>
                                <p class="font-medium {{ $archive->is_viable ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($archive->irr, 2) }}%
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Cash Flows Section -->
                    @if (!empty($cashFlows))
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                        clip-rule="evenodd" />
                                </svg>
                                Cash Flows
                            </h3>
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
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
                                                    Cash Flow
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($cashFlows as $year => $flow)
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        Year {{ $year }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        Rp{{ number_format($flow, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $flow >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ $flow >= 0 ? 'Positive' : 'Negative' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Notes Section -->
                    @if ($archive->notes)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                                        clip-rule="evenodd" />
                                </svg>
                                Additional Notes
                            </h3>
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            {{ $archive->notes }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
