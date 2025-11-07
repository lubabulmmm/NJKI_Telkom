<x-app-layout>
    <div class="ml-0 sm:ml-60 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8">
            <div class="flex-1 overflow-y-auto p-6 mt-8 min-h-screen">
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600">User</p>
                            <h2 class="font-bold text-2xl text-red-700 leading-tight">
                                {{ __('Calculator Invesment') }}
                            </h2>
                        </div>
                        <div class="text-sm text-gray-500">
                            Time: {{ now()->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
                <script>
                    tailwind.config = {
                        theme: {
                            extend: {
                                colors: {
                                    primary: {
                                        50: '#eff6ff',
                                        500: '#3b82f6',
                                        600: '#2563eb',
                                        700: '#1d4ed8'
                                    }
                                }
                            }
                        }
                    }
                </script>
                <style>
                    .glassmorphism {
                        backdrop-filter: blur(16px);
                        -webkit-backdrop-filter: blur(16px);
                    }

                    .gradient-bg {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    }

                    .card-shadow {
                        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                    }

                    .revenue-item {
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    }

                    .revenue-item:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                    }

                    .btn-hover {
                        transition: all 0.3s ease;
                    }

                    .btn-hover:hover {
                        transform: translateY(-1px);
                    }
                </style>

                {{-- <body class="gradient-bg min-h-screen">
                        <div class="container mx-auto p-4 lg:p-8"> --}}
                <!-- Header -->
                <div class="bg-white/90 mt-8 glassmorphism rounded-3xl card-shadow mb-8">
                    <div class="bg-gradient-to-r from-red-600 to-orange-600 text-white p-8 rounded-t-3xl">
                        <div class="text-center">
                            <h1 class="text-4xl font-bold mb-2">🧮 Investment Calculator</h1>
                            <p class="text-xl opacity-90">Comprehensive Financial Analysis Tool</p>
                        </div>
                    </div>

                    <div class="p-8">
                        <!-- Revenue Calculation Section -->
                        <div class="mb-12">
                            <div class="flex items-center mb-6">
                                <div class="w-1 h-8 bg-gradient-to-b from-blue-500 to-purple-500 rounded-full mr-4">
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800">💰 Revenue Calculation</h2>
                            </div>

                            <div id="form-container" class="space-y-4 mb-6"></div>

                            <button id="add-row" type="button"
                                class="btn-hover bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>Add Revenue Item</span>
                            </button>

                            <!-- Total Revenue Display -->
                            <div
                                class="mt-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl">
                                <label for="grand-total" class="block text-lg font-bold text-blue-900 mb-2">
                                    💎 Total Revenue
                                </label>
                                <input type="text" id="grand-total" readonly
                                    class="w-full text-2xl font-bold text-blue-900 bg-transparent border-none focus:outline-none">
                            </div>
                        </div>

                        <!-- Investment Parameters Section -->
                        <div class="mb-8">
                            <div class="flex items-center mb-6">
                                <div class="w-1 h-8 bg-gradient-to-b from-green-500 to-blue-500 rounded-full mr-4">
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800">⚙️ Investment Parameters &
                                    Results
                                </h2>
                            </div>

                            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                                <!-- Input Parameters -->
                                <div class="bg-white rounded-2xl p-6 card-shadow">
                                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                                        📊 Input Parameters
                                    </h3>

                                    <div class="space-y-6">
                                        <div>
                                            <label for="customer-name"
                                                class="block text-sm font-semibold text-gray-700 mb-2">
                                                👤 Customer Name
                                            </label>
                                            <input type="text" id="customer-name" placeholder="Enter customer name"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                                        </div>

                                        <div>
                                            <label for="capex"
                                                class="block text-sm font-semibold text-gray-700 mb-2">
                                                💼 CAPEX (Rp)
                                            </label>
                                            <input type="text" id="capex" placeholder="Enter CAPEX amount"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                                        </div>

                                        <div>
                                            <label for="opex"
                                                class="block text-sm font-semibold text-gray-700 mb-2">
                                                🔧 OPEX (%)
                                            </label>
                                            <input type="number" id="opex" step="0.01"
                                                placeholder="Enter OPEX percentage"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                                        </div>

                                        <div>
                                            <label for="wacc"
                                                class="block text-sm font-semibold text-gray-700 mb-2">
                                                📈 WACC (%)
                                            </label>
                                            <input type="number" id="wacc" step="0.01"
                                                placeholder="Enter WACC percentage"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                                        </div>

                                        <div>
                                            <label for="bhp"
                                                class="block text-sm font-semibold text-gray-700 mb-2">
                                                🏢 BHP (%)
                                            </label>
                                            <input type="number" id="bhp" step="0.01"
                                                placeholder="Enter BHP percentage"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                                        </div>

                                        <div>
                                            <label for="minimal-irr"
                                                class="block text-sm font-semibold text-gray-700 mb-2">
                                                🎯 Minimal IRR (%)
                                            </label>
                                            <input type="number" id="minimal-irr" step="0.01"
                                                placeholder="Enter minimal IRR percentage"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                                        </div>
                                    </div>
                                </div>

                                <!-- Calculated Results -->
                                <div class="bg-white rounded-2xl p-6 card-shadow">
                                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                        📋 Calculated Results
                                    </h3>

                                    <div class="space-y-6">
                                        <div
                                            class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 border-2 border-yellow-200 rounded-xl">
                                            <label for="depreciation"
                                                class="block text-sm font-semibold text-amber-800 mb-2">
                                                📉 Depreciation (3 Years)
                                            </label>
                                            <input type="text" id="depreciation" readonly
                                                class="w-full text-lg font-semibold text-amber-900 bg-transparent border-none focus:outline-none">
                                        </div>

                                        <div
                                            class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl">
                                            <label for="npv"
                                                class="block text-sm font-semibold text-green-800 mb-2">
                                                💹 Net Present Value
                                            </label>
                                            <input type="text" id="npv" readonly
                                                class="w-full text-lg font-semibold text-green-900 bg-transparent border-none focus:outline-none">
                                        </div>

                                        <div
                                            class="p-4 bg-gradient-to-r from-purple-50 to-indigo-50 border-2 border-purple-200 rounded-xl">
                                            <label for="irr"
                                                class="block text-sm font-semibold text-purple-800 mb-2">
                                                🎲 Internal Rate of Return
                                            </label>
                                            <div class="flex items-center justify-between">
                                                <input type="text" id="irr" readonly
                                                    class="flex-1 text-lg font-semibold text-purple-900 bg-transparent border-none focus:outline-none">
                                                <span id="irr-status"
                                                    class="ml-3 px-3 py-1 rounded-full text-xs font-bold"></span>
                                            </div>
                                        </div>

                                        <div
                                            class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl">
                                            <label for="payback-period"
                                                class="block text-sm font-semibold text-blue-800 mb-2">
                                                ⏰ Payback Period
                                            </label>
                                            <input type="text" id="payback-period" readonly
                                                class="w-full text-lg font-semibold text-blue-900 bg-transparent border-none focus:outline-none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add this before the Save Section -->
                        <div class="mb-8">
                            <div class="flex items-center mb-6">
                                <div class="w-1 h-8 bg-gradient-to-b from-gray-500 to-gray-600 rounded-full mr-4">
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800">📝 Additional Notes</h2>
                            </div>

                            <div class="bg-white rounded-2xl p-6 card-shadow">
                                <textarea id="notes" placeholder="Add any additional notes or comments about this calculation..."
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors h-32"></textarea>
                            </div>
                        </div>

                        <!-- Save Section -->
                        <div class="text-center pt-8 border-t-2 border-gray-200">
                            <button id="save-button" type="button"
                                class="btn-hover bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-4 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl flex items-center space-x-3 mx-auto">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <span>Save Calculation</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirmation Modal -->
            <div id="confirmation-modal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-xl transform transition-all">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Penyimpanan</h3>
                        <p class="text-sm text-gray-500 mb-6">
                            Apakah Anda yakin ingin menyimpan perhitungan ini? Pastikan semua data sudah benar dan data
                            dapat diubah diarship.
                        </p>
                        <div class="flex justify-center space-x-4">
                            <button id="cancel-save" type="button"
                                class="btn-hover bg-gray-200 text-gray-800 px-6 py-2 rounded-lg font-medium">
                                Batal
                            </button>
                            <button id="confirm-save" type="button"
                                class="btn-hover bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-2 rounded-lg font-medium">
                                Ya, Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Notification -->
            <div id="success-notification" class="fixed top-4 right-4 z-50 hidden">
                <div
                    class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-lg w-full max-w-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 id="success-title" class="text-sm font-medium text-green-800">Berhasil
                                Disimpan!</h3>
                            <p id="success-message" class="text-sm text-green-600 mt-1">Perhitungan
                                investasi
                                telah disimpan.</p>
                        </div>
                        <button type="button"
                            class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
                            onclick="hideSuccess()">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Error Notification -->
            <div id="error-notification" class="fixed top-4 right-4 z-50 hidden">
                <div
                    class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-lg w-full max-w-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 id="error-title" class="text-sm font-medium text-red-800">Gagal Menyimpan
                            </h3>
                            <p id="error-message" class="text-sm text-red-600 mt-1">Terjadi kesalahan saat
                                menyimpan data.</p>
                        </div>
                        <button type="button"
                            class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"
                            onclick="hideError()">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', async function() {
                    // Elements
                    const formContainer = document.getElementById('form-container');
                    const addRowButton = document.getElementById('add-row');
                    const grandTotalInput = document.getElementById('grand-total');
                    const capexInput = document.getElementById('capex');
                    const opexInput = document.getElementById('opex');
                    const waccInput = document.getElementById('wacc');
                    const bhpInput = document.getElementById('bhp');
                    const minimalIrrInput = document.getElementById('minimal-irr');
                    const depreciationInput = document.getElementById('depreciation');
                    const npvInput = document.getElementById('npv');
                    const irrInput = document.getElementById('irr');
                    const paybackPeriodInput = document.getElementById('payback-period');
                    const irrStatusSpan = document.getElementById('irr-status');
                    const confirmationModal = document.getElementById('confirmation-modal');
                    const cancelSaveButton = document.getElementById('cancel-save');
                    const confirmSaveButton = document.getElementById('confirm-save');

                    // Variables
                    let items = [];
                    let saveData = null;

                    // Notification functions
                    function showSuccess(title, message) {
                        document.getElementById('success-title').textContent = title;
                        document.getElementById('success-message').textContent = message;
                        document.getElementById('success-notification').classList.remove('hidden');
                        setTimeout(hideSuccess, 5000);
                    }

                    function hideSuccess() {
                        document.getElementById('success-notification').classList.add('hidden');
                    }

                    function showError(title, message) {
                        document.getElementById('error-title').textContent = title;
                        document.getElementById('error-message').textContent = message;
                        document.getElementById('error-notification').classList.remove('hidden');
                        setTimeout(hideError, 5000);
                    }

                    function hideError() {
                        document.getElementById('error-notification').classList.add('hidden');
                    }

                    // Fetch items for select dropdown
                    async function fetchItems() {
                        try {
                            const response = await fetch('/api/items');
                            items = await response.json();
                        } catch (error) {
                            console.error('Failed to fetch items:', error);
                            // Fallback data
                            items = [{
                                    id: 1,
                                    nama_barang: 'Internet Dedicated'
                                },
                                {
                                    id: 2,
                                    nama_barang: 'Internet Shared'
                                },
                                {
                                    id: 3,
                                    nama_barang: 'Cloud Hosting'
                                },
                                {
                                    id: 4,
                                    nama_barang: 'VPN Service'
                                }
                            ];
                        }
                    }

                    // Create row for adding items
                    function createRow() {
                        const rowId = `row-${Date.now()}`;
                        const row = document.createElement('div');
                        row.className =
                            'revenue-item bg-white p-6 rounded-2xl border-2 border-gray-100 hover:border-blue-300 transition-all duration-300';

                        row.innerHTML = `
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                                        <div class="lg:col-span-2">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">🔗 Item Name</label>
                                            <select data-row-id="${rowId}" class="item-select w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-colors">
                                                <option value="" disabled selected>Select item</option>
                                                ${items.map(item => `<option value="${item.id}">${item.nama_barang}</option>`).join('')}
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">📡 Bandwidth</label>
                                            <select data-row-id="${rowId}" class="bandwidth-select w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-colors" disabled>
                                                <option value="" disabled selected>Select bandwidth</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">📦 Quantity</label>
                                            <input data-row-id="${rowId}" type="number" class="quantity-input w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-colors" value="1" min="1">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">📅 Months</label>
                                            <input data-row-id="${rowId}" type="number" class="duration-input w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-colors" value="1" min="1">
                                        </div>
                                        <div class="lg:col-span-1 flex flex-col">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">💵 Price</label>
                                            <input data-row-id="${rowId}" type="text" class="price-input w-full px-3 py-2 border-2 border-gray-200 rounded-lg bg-gray-50" readonly>
                                            <button type="button" class="remove-row mt-2 bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 flex items-center justify-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span class="hidden sm:inline">Remove</span>
                                            </button>
                                        </div>
                                    </div>
                                `;

                        formContainer.appendChild(row);

                        const itemSelect = row.querySelector('.item-select');
                        const bandwidthSelect = row.querySelector('.bandwidth-select');
                        const quantityInput = row.querySelector('.quantity-input');
                        const durationInput = row.querySelector('.duration-input');
                        const priceInput = row.querySelector('.price-input');

                        itemSelect.addEventListener('change', async function() {
                            const itemId = this.value;
                            try {
                                const response = await fetch(`/api/bandwidth/${itemId}`);
                                const bandwidths = await response.json();

                                bandwidthSelect.innerHTML =
                                    '<option value="" disabled selected>Select bandwidth</option>';
                                bandwidths.forEach(bw => {
                                    const option = document.createElement('option');
                                    option.value = bw.id;
                                    option.textContent = `${bw.bw} Mbps`;
                                    option.dataset.price = bw.price;
                                    bandwidthSelect.appendChild(option);
                                });

                                bandwidthSelect.disabled = false;
                            } catch (error) {
                                console.error('Failed to fetch bandwidth data:', error);
                                showError('Error', 'Failed to load bandwidth options');
                            }
                        });

                        // Calculating price and grand total
                        bandwidthSelect.addEventListener('change', calculatePrice);
                        quantityInput.addEventListener('input', calculatePrice);
                        durationInput.addEventListener('input', calculatePrice);

                        async function calculatePrice() {
                            const selectedOption = bandwidthSelect.options[bandwidthSelect.selectedIndex];
                            const bandwidthPrice = selectedOption ? Number(selectedOption.dataset.price) : 0;
                            const quantity = Number(quantityInput.value);
                            const duration = Number(durationInput.value);

                            const totalPrice = bandwidthPrice * quantity * duration;
                            priceInput.value = `Rp${totalPrice.toLocaleString('id-ID')}`;
                            await calculateGrandTotal();
                        }

                        // Removing row
                        row.querySelector('.remove-row').addEventListener('click', function() {
                            formContainer.removeChild(row);
                            calculateGrandTotal();
                        });
                    }

                    // Calculate Grand Total
                    async function calculateGrandTotal() {
                        const priceInputs = formContainer.querySelectorAll('.price-input');
                        let grandTotal = 0;

                        priceInputs.forEach(input => {
                            const value = Number(input.value.replace(/[^0-9]/g, '')) || 0;
                            grandTotal += value;
                        });

                        grandTotalInput.value = `Rp${grandTotal.toLocaleString('id-ID')}`;
                        await calculateInvestmentMetrics(grandTotal);
                    }

                    // Investment calculations
                    async function calculateInvestmentMetrics(revenue) {
                        // Get input values and convert them to numbers
                        const capex = Number(capexInput.value.replace(/[^0-9]/g, '')) || 0;
                        const opexPercentage = Number(opexInput.value.replace(/[^0-9.]/g, '')) || 0;
                        const waccPercentage = Number(waccInput.value.replace(/[^0-9.]/g, '')) || 0;
                        const bhpPercentage = Number(bhpInput.value.replace(/[^0-9.]/g, '')) || 0;
                        const minimalIrrPercentage = Number(minimalIrrInput.value.replace(/[^0-9.]/g, '')) || 0;

                        // Basic calculations
                        const depreciation = capex / 3;

                        // Prepare cash flows array
                        const cashFlows = [-capex]; // Year 0 (initial investment - negative)

                        // Calculate for years 1-3
                        for (let year = 1; year <= 3; year++) {
                            // Revenue tetap sama setiap tahun
                            const currentRevenue = revenue;

                            // O&M (OPEX) = CAPEX × OPEX percentage
                            const omCost = (capex * opexPercentage) / 100;

                            // BHP & Marketing = Revenue × BHP percentage
                            const bhpMarketingCost = (revenue * bhpPercentage) / 100;

                            // Total expenses untuk tahun ini
                            const totalExpenses = omCost + bhpMarketingCost;

                            // EBITDA = Revenue - Operating Expenses
                            const ebitda = currentRevenue - totalExpenses;

                            // EBIT = EBITDA - Depreciation
                            const ebit = ebitda - depreciation;

                            // Tax = 30% dari EBIT (jika positif)
                            const taxes = Math.max(0, ebit * 0.30);

                            // NOPAT = EBIT - Tax
                            const nopat = ebit - taxes;

                            // Net Cash Flow = NOPAT + Depreciation
                            const netCashFlow = nopat + depreciation;

                            cashFlows.push(netCashFlow);
                        }

                        // Calculate NPV
                        // ...existing code...
                        // Calculate NPV dengan diskonto minimal IRR
                        const discountRate = minimalIrrPercentage / 100;
                        const npv = cashFlows[0] +
                            cashFlows[1] / (1 + discountRate) +
                            cashFlows[2] / Math.pow(1 + discountRate, 2) +
                            cashFlows[3] / Math.pow(1 + discountRate, 3);

                        // Update UI
                        depreciationInput.value = `Rp${depreciation.toLocaleString('id-ID')}`;
                        npvInput.value = `Rp${Math.round(npv).toLocaleString('id-ID')}`;
                        // ...existing code...
                        // Calculate and update IRR
                        const irr = calculateProperIRR(cashFlows);
                        const irrPercentage = irr * 100;
                        irrInput.value = `${irrPercentage.toFixed(2)}%`;

                        // Update IRR status
                        const irrStatus = document.getElementById('irr-status');
                        if (irrStatus) {
                            const isViable = irrPercentage >= minimalIrrPercentage;
                            irrStatus.textContent = isViable ? 'LAYAK' : 'TIDAK LAYAK';
                            irrStatus.className = `ml-3 px-3 py-1 rounded-full text-xs font-bold ${
                                isViable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                            }`;
                        }

                        // Update Payback Period
                        paybackPeriodInput.value = calculateProperPaybackPeriod(cashFlows, minimalIrrPercentage);
                    }

                    // Proper IRR calculation using Newton-Raphson method
                    function calculateProperIRR(cashFlows, guess = 0.1) {
                        const maxIteration = 1000;
                        const tolerance = 0.00001;

                        // Check if there's a sign change in cash flows (required for valid IRR)
                        let hasSignChange = false;
                        for (let i = 1; i < cashFlows.length; i++) {
                            if ((cashFlows[i - 1] < 0 && cashFlows[i] > 0) ||
                                (cashFlows[i - 1] > 0 && cashFlows[i] < 0)) {
                                hasSignChange = true;
                                break;
                            }
                        }

                        if (!hasSignChange) {
                            return 0; // No valid IRR
                        }

                        let irr = guess;

                        for (let i = 0; i < maxIteration; i++) {
                            let npv = 0;
                            let derivative = 0;

                            for (let t = 0; t < cashFlows.length; t++) {
                                npv += cashFlows[t] / Math.pow(1 + irr, t);
                                if (t > 0) { // derivative doesn't include t=0
                                    derivative -= t * cashFlows[t] / Math.pow(1 + irr, t + 1);
                                }
                            }

                            if (Math.abs(npv) < tolerance) {
                                return irr;
                            }

                            if (Math.abs(derivative) < tolerance) {
                                break; // Derivative too small, stop iteration
                            }

                            let newIrr = irr - (npv / derivative);

                            // Ensure IRR doesn't go below -100%
                            if (newIrr <= -1) {
                                newIrr = irr / 2;
                            }

                            irr = newIrr;
                        }

                        return irr;
                    }

                    // Proper Payback Period calculation
                    function calculateProperPaybackPeriod(cashFlows, minimalIrrPercentage) {
                        // Hitung discounted net cash flow (mulai dari tahun 1)
                        const discountRate = minimalIrrPercentage / 100;
                        const discounted = [cashFlows[0]]; // Tahun 0 tetap (biasanya negatif)
                        for (let t = 1; t < cashFlows.length; t++) {
                            discounted.push(cashFlows[t] / Math.pow(1 + discountRate, t));
                        }

                        // Hitung cumulative discounted net cash flow
                        let cumulativeFlows = [];
                        let cumulative = 0;
                        for (let cf of discounted) {
                            cumulative += cf;
                            cumulativeFlows.push(cumulative);
                        }

                        // Cari years sesuai rumus Anda
                        let years = 0;
                        if (cumulativeFlows[1] < 0 && cumulativeFlows[2] >= 0) {
                            years = 1;
                        } else if (cumulativeFlows[2] < 0 && cumulativeFlows[3] >= 0) {
                            years = 2;
                        }

                        // Hitung months proporsional
                        let months = 0;
                        if (years === 1) {
                            months = (-cumulativeFlows[1] / (cumulativeFlows[2] - cumulativeFlows[1])) * 12;
                        } else if (years === 2) {
                            months = (-cumulativeFlows[2] / (cumulativeFlows[3] - cumulativeFlows[2])) * 12;
                        }
                        months = Math.round(months);

                        // Handle special case where months calculation results in 12
                        if (months === 12) {
                            years++;
                            months = 0;
                        }

                        // Format hasil
                        if (years === 0 && months === 0) {
                            return "Investasi belum kembali dalam 3 tahun";
                        } else {
                            // Tambahkan 6 bulan seperti di calculator jika perlu
                            let totalMonths = years * 12 + months;
                            let newYears = Math.floor(totalMonths / 12);
                            let newMonths = totalMonths % 12;
                            return `${totalMonths > 0 ? newYears + ' tahun ' : ''}${newMonths > 0 ? newMonths + ' bulan' : ''}`;
                        }
                    }

                    // Event listener for CAPEX input
                    capexInput.addEventListener('input', function() {
                        let value = this.value.replace(/[^0-9]/g, '');
                        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        this.value = value;

                        const capex = Number(value.replace(/[^0-9]/g, '')) || 0;
                        const depreciation = capex / 3;
                        depreciationInput.value = `Rp${depreciation.toLocaleString('id-ID')}`;

                        const grandTotal = Number(grandTotalInput.value.replace(/[^0-9]/g, '')) || 0;
                        if (grandTotal > 0) {
                            calculateInvestmentMetrics(grandTotal);
                        }
                    });

                    // Event listeners for other inputs
                    [opexInput, waccInput, bhpInput, minimalIrrInput].forEach(input => {
                        input.addEventListener('input', function() {
                            const grandTotal = Number(grandTotalInput.value.replace(/[^0-9]/g, '')) ||
                                0;
                            if (grandTotal > 0) {
                                calculateInvestmentMetrics(grandTotal);
                            }
                        });
                    });

                    // Save button functionality
                    document.getElementById("save-button").addEventListener("click", async function() {
                        try {
                            // Collect all form data
                            const capex = Number(capexInput.value.replace(/[^0-9]/g, '')) || 0;
                            const opex = Number(opexInput.value.replace(/[^0-9.]/g, '')) || 0;
                            const wacc = Number(waccInput.value.replace(/[^0-9.]/g, '')) || 0;
                            const bhp = Number(bhpInput.value.replace(/[^0-9.]/g, '')) || 0;
                            const minimalIrr = Number(minimalIrrInput.value.replace(/[^0-9.]/g, '')) || 0;
                            const totalRevenue = Number(grandTotalInput.value.replace(/[^0-9]/g, '')) || 0;
                            const depreciation = capex / 3;

                            // Validate required fields
                            if (capex <= 0) {
                                showError('Validasi Gagal', 'CAPEX harus diisi dan lebih besar dari 0');
                                return;
                            }

                            const customerName = document.getElementById('customer-name').value.trim();
                            if (!customerName) {
                                showError('Validasi Gagal', 'Nama pelanggan harus diisi');
                                return;
                            }

                            // Collect items data
                            const items = [];
                            const rows = formContainer.querySelectorAll('.revenue-item');

                            if (rows.length === 0) {
                                showError('Validasi Gagal', 'Silakan tambahkan minimal satu item revenue');
                                return;
                            }

                            let hasValidItem = false;
                            rows.forEach(row => {
                                const itemSelect = row.querySelector('.item-select');
                                const bandwidthSelect = row.querySelector('.bandwidth-select');
                                const quantityInput = row.querySelector('.quantity-input');
                                const durationInput = row.querySelector('.duration-input');
                                const priceInput = row.querySelector('.price-input');

                                const itemId = itemSelect ? itemSelect.value : null;
                                const bandwidthId = bandwidthSelect ? bandwidthSelect.value : null;
                                const quantity = quantityInput ? Number(quantityInput.value) : 0;
                                const duration = durationInput ? Number(durationInput.value) : 0;
                                const price = priceInput ? Number(priceInput.value.replace(
                                    /[^0-9]/g, '')) : 0;

                                if (itemId && bandwidthId && quantity > 0 && duration > 0 && price >
                                    0) {
                                    items.push({
                                        item_id: itemId,
                                        bandwidth_id: bandwidthId,
                                        quantity: quantity,
                                        duration: duration,
                                        price: price
                                    });
                                    hasValidItem = true;
                                }
                            });

                            if (!hasValidItem) {
                                showError('Validasi Gagal',
                                    'Silakan lengkapi minimal satu item dengan data yang valid');
                                return;
                            }

                            // Calculate investment metrics untuk mendapatkan nilai yang akurat
                            const cashFlows = [-capex]; // Year 0: Initial investment (negative)

                            // Calculate cash flows for years 1-3
                            for (let year = 1; year <= 3; year++) {
                                // OPEX dihitung dari persentase CAPEX
                                const opexAmount = (opex / 100) * capex;

                                // BHP dihitung dari persentase revenue
                                const bhpAmount = (bhp / 100) * totalRevenue;

                                // EBITDA = Revenue - Operating Expenses
                                const ebitda = totalRevenue - opexAmount - bhpAmount;

                                // EBIT = EBITDA - Depreciation
                                const ebit = ebitda - depreciation;

                                // Tax = 30% dari EBIT (jika positif)
                                const taxes = Math.max(0, ebit * 0.30);

                                // NOPAT = EBIT - Tax
                                const nopat = ebit - taxes;

                                // Net Cash Flow = NOPAT + Depreciation
                                const netCashFlow = nopat + depreciation;

                                cashFlows.push(netCashFlow);
                            }

                            // Calculate NPV
                            const npvValue = cashFlows[0] + // Initial investment (year 0)
                                cashFlows[1] / (1 + wacc / 100) + // Year 1
                                cashFlows[2] / Math.pow(1 + wacc / 100, 2) + // Year 2
                                cashFlows[3] / Math.pow(1 + wacc / 100, 3); // Year 3

                            // Calculate IRR
                            const irrValue = calculateProperIRR(cashFlows);

                            // Calculate Payback Period
                            const paybackPeriodValue = calculateProperPaybackPeriod(cashFlows);

                            // Prepare data untuk dikirim ke server
                            saveData = {
                                customer_name: customerName, // Add this line
                                items: items,
                                capex: capex,
                                opex: opex,
                                wacc: wacc,
                                bhp: bhp,
                                minimal_irr: minimalIrr,
                                total_revenue: totalRevenue,
                                depreciation: depreciation,
                                npv: npvValue,
                                irr: irrValue,
                                payback_period: paybackPeriodValue,
                                notes: document.getElementById('notes').value // Add this line
                            };

                            // Tampilkan modal konfirmasi
                            confirmationModal.classList.remove('hidden');

                        } catch (error) {
                            console.error("Error preparing save data:", error);
                            showError('Kesalahan Sistem', "Terjadi kesalahan saat mempersiapkan data.");
                        }
                    });

                    // Confirm save button functionality
                    confirmSaveButton.addEventListener('click', async function() {
                        const modal = document.getElementById('confirmation-modal');
                        const button = this;

                        try {
                            // Tampilkan loading state
                            button.innerHTML = `
                                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Menyimpan...
                                    `;
                            button.disabled = true;

                            // Kirim data ke server
                            const response = await fetch('/user/api/save-archive', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]')?.getAttribute('content') ||
                                        '',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(saveData),
                            });

                            const result = await response.json();

                            if (response.ok && result.success) {
                                showSuccess('Berhasil Disimpan!',
                                    'Perhitungan investasi telah disimpan ke arsip.');
                                console.log('Archive saved:', result.archive);
                            } else {
                                console.error('Server response:', result);
                                if (result.errors) {
                                    let errorMessage = "Gagal menyimpan data:\n";
                                    Object.keys(result.errors).forEach(field => {
                                        errorMessage += `${result.errors[field].join(', ')}\n`;
                                    });
                                    showError('Validasi Gagal', errorMessage);
                                } else {
                                    showError('Gagal Menyimpan', result.message ||
                                        "Terjadi kesalahan saat menyimpan data");
                                }
                            }
                        } catch (error) {
                            console.error("Terjadi kesalahan saat menyimpan data:", error);
                            showError('Kesalahan Jaringan',
                                "Terjadi kesalahan jaringan. Silakan coba lagi.");
                        } finally {
                            modal.classList.add('hidden');
                            button.innerHTML = 'Ya, Simpan';
                            button.disabled = false;
                        }
                    });

                    // Cancel save button functionality
                    cancelSaveButton.addEventListener('click', function() {
                        document.getElementById('confirmation-modal').classList.add('hidden');
                    });

                    // Initialize
                    await fetchItems();
                    addRowButton.addEventListener('click', createRow);
                    createRow();
                });
            </script>
            {{-- </div> --}}
</x-app-layout>
