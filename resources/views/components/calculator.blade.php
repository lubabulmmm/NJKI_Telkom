<div class="min-h-screen  p-4 md:p-8">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-gray-200">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
            Welcome to Calculator NJ <span class="text-red-600">KI</span>
        </h1>
        <p class="text-gray-600 mt-2">Investment Analysis Calculator</p>
    </div>

    <!-- Main Calculator Container -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Input Section -->
        <div class="p-6 md:p-8">
            <!-- Basic Parameters -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">CAPEX (Capital Expenditure)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                        <input type="text" id="capex"
                            class="pl-10 block w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan CAPEX">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">WACC (%)</label>
                    <div class="relative">
                        <input type="text" id="wacc"
                            class="block w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan WACC">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">%</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Minimal IRR (%)</label>
                    <div class="relative">
                        <input type="text" id="minimal-irr"
                            class="block w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan Minimal IRR">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">%</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">OPEX (%)</label>
                    <div class="relative">
                        <input type="text" id="opex"
                            class="block w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan OPEX">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">%</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">BHP (%)</label>
                    <div class="relative">
                        <input type="text" id="bhp"
                            class="block w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan BHP">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">%</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Depresiasi (3 Tahun)</label>
                    <input type="text" id="depreciation"
                        class="block w-full mt-1 p-3 bg-gray-100 border border-gray-300 rounded-lg" readonly>
                </div>
            </div>

            <!-- Dynamic Product Form -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Details</h3>
                <div id="form-container" class="space-y-4">
                    <!-- Dynamic rows will be added here -->
                </div>

                <button id="add-row"
                    class="mt-6 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-md transition duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Barang
                </button>
            </div>

            <!-- Grand Total -->
            <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                <label class="block text-sm font-medium text-blue-800">Grand Total (Revenue)</label>
                <div class="relative mt-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600">Rp</span>
                    <input type="text" id="grand-total"
                        class="pl-10 block w-full mt-1 p-3 bg-white border border-blue-200 rounded-lg text-blue-800 font-medium"
                        readonly>
                </div>
            </div>

            <!-- Calculation Results -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-medium text-gray-700">NPV</label>
                    <input type="text" id="npv"
                        class="block w-full mt-2 p-3 bg-white border border-gray-300 rounded-lg text-gray-800 font-medium"
                        readonly>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-medium text-gray-700">IRR</label>
                    <div class="relative mt-2">
                        <input type="text" id="irr"
                            class="block w-full p-3 bg-white border border-gray-300 rounded-lg text-gray-800 font-medium"
                            readonly>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">%</span>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-medium text-gray-700">Payback Period</label>
                    <input type="text" id="payback-period"
                        class="block w-full mt-2 p-3 bg-white border border-gray-300 rounded-lg text-gray-800 font-medium"
                        readonly>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
            <button id="save-button"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
                Save Calculation
            </button>
        </div>
    </div>
</div>

@vite(['resources/js/calculator.js'])
