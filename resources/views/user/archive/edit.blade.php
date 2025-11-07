<x-app-layout>
    <div class="ml-0 sm:ml-60 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8">
            <div class="flex-1 overflow-y-auto p-6 mt-8 min-h-screen">
                <div class="bg-white/90 glassmorphism rounded-3xl card-shadow mb-8">
                    <div class="bg-gradient-to-r from-red-600 to-orange-600 text-white p-8 rounded-t-3xl">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-3xl font-bold mb-2">✏️ Edit Archive</h1>
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
                        <form action="{{ route('user.investment.archive.update', $archive->id) }}" method="POST"
                            id="archive-form">
                            @csrf
                            @method('PUT')

                            <!-- Hidden fields for calculation results -->
                            <input type="hidden" id="total_revenue" name="total_revenue"
                                value="{{ $archive->total_revenue }}">
                            <input type="hidden" id="npv" name="npv" value="{{ $archive->npv }}">
                            <input type="hidden" id="irr" name="irr" value="{{ $archive->irr }}">
                            <input type="hidden" id="payback_period" name="payback_period"
                                value="{{ $archive->payback_period }}">

                            <!-- Revenue Items Section -->
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 mb-8">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">💰 Revenue Items (Optional)</h3>
                                <div id="items-container">
                                    @foreach ($archive->items as $index => $item)
                                        <div class="item-group mb-6 p-4 border border-gray-200 rounded-lg">
                                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                                <!-- Item Selection -->
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-1">Item</label>
                                                    <select name="items[{{ $index }}][item_id]"
                                                        class="item-select w-full border border-gray-300 rounded-md px-3 py-2">
                                                        <option value="">Select Item</option>
                                                        @foreach ($items as $itemOption)
                                                            <option value="{{ $itemOption->id }}"
                                                                {{ $item->item_id == $itemOption->id ? 'selected' : '' }}
                                                                data-item="{{ json_encode($itemOption) }}">
                                                                {{ $itemOption->nama_barang }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Bandwidth Selection -->
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-1">Bandwidth</label>
                                                    <select name="items[{{ $index }}][bandwidth_id]"
                                                        class="bandwidth-select w-full border border-gray-300 rounded-md px-3 py-2">
                                                        <option value="">Select Bandwidth</option>
                                                        @foreach ($items->find($item->item_id)->bandwidths ?? [] as $bw)
                                                            <option value="{{ $bw->id }}"
                                                                {{ $item->bandwidth_id == $bw->id ? 'selected' : '' }}
                                                                data-price="{{ $bw->price }}"
                                                                data-bandwidth="{{ json_encode($bw) }}">
                                                                {{ $bw->bw }} Mbps
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Quantity Input -->
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                                    <input type="number" name="items[{{ $index }}][quantity]"
                                                        value="{{ $item->quantity }}" min="1"
                                                        class="quantity-input w-full border border-gray-300 rounded-md px-3 py-2">
                                                </div>

                                                <!-- Duration Input -->
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Duration
                                                        (Months)</label>
                                                    <input type="number" name="items[{{ $index }}][duration]"
                                                        value="{{ $item->duration }}" min="1"
                                                        class="duration-input w-full border border-gray-300 rounded-md px-3 py-2">
                                                </div>
                                            </div>

                                            <!-- Price Display -->
                                            <div class="mt-2">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                                <input type="text"
                                                    class="price-display w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
                                                    value="Rp{{ number_format($item->price * $item->quantity * $item->duration, 0, ',', '.') }}"
                                                    readonly>
                                                <input type="hidden" class="price-value"
                                                    value="{{ $item->price * $item->quantity * $item->duration }}">
                                            </div>

                                            <!-- Remove Item Button -->
                                            <button type="button"
                                                class="remove-item mt-2 text-red-600 hover:text-red-800 text-sm">
                                                Remove Item
                                            </button>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Add/Clear Item Buttons -->
                                <div class="flex space-x-4">
                                    <button type="button" id="add-item"
                                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                        + Add Revenue Item
                                    </button>
                                    <button type="button" id="clear-items"
                                        class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                                        Clear All Items
                                    </button>
                                </div>

                                <!-- Total Revenue Display -->
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Revenue</label>
                                    <input type="text" id="total-revenue-display"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
                                        value="Rp{{ number_format($archive->total_revenue, 0, ',', '.') }}" readonly>
                                </div>
                            </div>

                            <!-- Basic Information and Parameters -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                <!-- Basic Information -->
                                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-800 mb-4">📝 Basic Information</h3>
                                    <div class="space-y-4">
                                        <!-- Customer Name -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Customer
                                                Name</label>
                                            <input type="text" id="customer_name" name="customer_name"
                                                value="{{ $archive->customer_name }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                required>
                                        </div>

                                        <!-- CAPEX -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">CAPEX
                                                (Rp)</label>
                                            <input type="text" id="capex" name="capex"
                                                value="{{ number_format($archive->capex, 0, ',', '.') }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                required>
                                            <input type="hidden" id="capex_raw" name="capex_raw"
                                                value="{{ $archive->capex }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Parameters -->
                                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-800 mb-4">⚙️ Parameters</h3>
                                    <div class="space-y-4">
                                        <!-- OPEX Percentage -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">OPEX Percentage
                                                (%)</label>
                                            <input type="number" step="0.01" id="opex_percentage"
                                                name="opex_percentage" value="{{ $archive->opex_percentage }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                required>
                                        </div>

                                        <!-- WACC Percentage -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">WACC Percentage
                                                (%)</label>
                                            <input type="number" step="0.01" id="wacc_percentage"
                                                name="wacc_percentage" value="{{ $archive->wacc_percentage }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                required>
                                        </div>

                                        <!-- BHP Percentage -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">BHP Percentage
                                                (%)</label>
                                            <input type="number" step="0.01" id="bhp_percentage"
                                                name="bhp_percentage" value="{{ $archive->bhp_percentage }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                required>
                                        </div>

                                        <!-- Minimal IRR Percentage -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Minimal IRR
                                                Percentage (%)</label>
                                            <input type="number" step="0.01" id="minimal_irr_percentage"
                                                name="minimal_irr_percentage"
                                                value="{{ $archive->minimal_irr_percentage }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Calculation Results -->
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 mb-8">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">📊 Calculation Results</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">NPV</label>
                                        <input type="text" id="npv-display"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
                                            value="Rp{{ number_format($archive->npv, 0, ',', '.') }}" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">IRR (%)</label>
                                        <input type="text" id="irr-display"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
                                            value="{{ number_format($archive->irr, 2, ',', '.') }}" readonly>
                                        <span id="irr-status"
                                            class="mt-1 inline-block px-2 py-1 rounded-full text-xs font-bold {{ $archive->irr >= $archive->minimal_irr_percentage ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $archive->irr >= $archive->minimal_irr_percentage ? 'LAYAK' : 'TIDAK LAYAK' }}
                                        </span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Payback
                                            Period</label>
                                        <input type="text" id="payback-period-display"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
                                            value="{{ $archive->payback_period }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes Section -->
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 mb-8">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">📝 Additional Notes</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                        <textarea id="notes" name="notes" rows="4"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Add any additional notes or comments about this calculation...">{{ $archive->notes }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end space-x-4">
                                <a href="{{ route('user.investment.archive.index') }}"
                                    class="btn-hover bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="btn-hover bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format CAPEX input with thousand separators
            const capexInput = document.getElementById('capex');
            const capexRaw = document.getElementById('capex_raw');

            capexInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^0-9]/g, '');
                capexRaw.value = value;
                value = parseInt(value || 0).toLocaleString('id-ID');
                e.target.value = value;
            });

            // Function to calculate total revenue
            function calculateTotalRevenue() {
                let total = 0;
                document.querySelectorAll('.price-value').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                document.getElementById('total_revenue').value = total;
                document.getElementById('total-revenue-display').value = formatCurrency(total);
                return total;
            }

            // Function to format currency
            function formatCurrency(amount) {
                return 'Rp' + Math.round(amount).toLocaleString('id-ID');
            }

            // Function to calculate payback period (matches calculator view)
            function calculatePaybackPeriod(cashFlows) {
                // Calculate cumulative cash flows
                let cumulativeFlows = [];
                let cumulative = 0;
                for (let cf of cashFlows) {
                    cumulative += cf;
                    cumulativeFlows.push(cumulative);
                }

                // Calculate years part (matching calculator logic)
                let year1Condition = (cumulativeFlows[1] < 0 && cumulativeFlows[2] >= 0) ? 1 : 0;
                let year2Condition = (cumulativeFlows[2] < 0 && cumulativeFlows[3] >= 0) ? 2 : 0;
                let years = Math.max(year1Condition, year2Condition);

                // Calculate months part (matching calculator logic)
                let months1 = (year1Condition > 0) ?
                    (-cumulativeFlows[1] / (cumulativeFlows[2] - cumulativeFlows[1])) * 12 : 0;

                let months2 = (year2Condition > 0) ?
                    (-cumulativeFlows[2] / (cumulativeFlows[3] - cumulativeFlows[2])) * 12 : 0;

                let months = Math.round(Math.max(months1, months2));

                // Handle special case where months calculation results in 12
                if (months === 12) {
                    years++;
                    months = 0;
                }

                // Format the result (adding 6 months as in calculator view)
                if (years === 0 && months === 0) {
                    return "Investasi belum kembali dalam 3 tahun";
                } else {
                    // Add 6 months to the calculated payback period (as in calculator)
                    let totalMonths = years * 12 + months + 5;
                    let newYears = Math.floor(totalMonths / 12);
                    let newMonths = totalMonths % 12;
                    return `${newYears > 0 ? newYears + ' tahun ' : ''}${newMonths > 0 ? newMonths + ' bulan' : ''}`
                        .trim();
                }
            }

            // Function to calculate IRR (matches calculator view)
            function calculateIRR(cashFlows, guess = 0.1) {
                const maxIterations = 1000;
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

                for (let i = 0; i < maxIterations; i++) {
                    let npv = 0;
                    let derivative = 0;

                    for (let t = 0; t < cashFlows.length; t++) {
                        npv += cashFlows[t] / Math.pow(1 + guess, t);
                        if (t > 0) { // derivative doesn't include t=0
                            derivative -= t * cashFlows[t] / Math.pow(1 + guess, t + 1);
                        }
                    }

                    if (Math.abs(npv) < tolerance) {
                        return guess;
                    }

                    if (Math.abs(derivative) < tolerance) {
                        break; // Derivative too small, stop iteration
                    }

                    let newGuess = guess - (npv / derivative);

                    // Ensure IRR doesn't go below -100%
                    if (newGuess <= -1) {
                        newGuess = guess / 2;
                    }

                    guess = newGuess;
                }

                return guess;
            }

            // Function to perform investment calculation (matches calculator view)
            function performInvestmentCalculation() {
                const capex = parseFloat(capexRaw.value) || 0;
                const totalRevenue = calculateTotalRevenue();
                const opexPercentage = parseFloat(document.getElementById('opex_percentage').value) || 0;
                const waccPercentage = parseFloat(document.getElementById('wacc_percentage').value) || 0;
                const bhpPercentage = parseFloat(document.getElementById('bhp_percentage').value) || 0;
                const minimalIrr = parseFloat(document.getElementById('minimal_irr_percentage').value) || 0;

                // Calculate cash flows (matches calculator logic)
                const cashFlows = [-capex]; // Year 0: Initial investment (negative)

                // Calculate for years 1-3 (matches calculator logic)
                for (let year = 1; year <= 3; year++) {
                    // OPEX dihitung dari persentase CAPEX
                    const opexAmount = (opexPercentage / 100) * capex;

                    // BHP dihitung dari persentase revenue
                    const bhpAmount = (bhpPercentage / 100) * totalRevenue;

                    // Depreciation (straight-line over 3 years)
                    const depreciation = capex / 3;

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

                // Calculate NPV (matches calculator logic)
                const npvValue = (cashFlows[0] + // Initial investment (year 0)
                        cashFlows[1] / (1 + waccPercentage / 100) + // Year 1
                        cashFlows[2] / Math.pow(1 + waccPercentage / 100, 2) + // Year 2
                        cashFlows[3] / Math.pow(1 + waccPercentage / 100, 3)) - // Year 3
                    29000000; // Subtract 29 million as in calculator

                // Calculate IRR (matches calculator logic)
                const irrValue = calculateIRR(cashFlows);

                // Calculate Payback Period (matches calculator logic)
                const paybackPeriodValue = calculatePaybackPeriod(cashFlows);

                // Update display fields
                document.getElementById('npv').value = npvValue;
                document.getElementById('npv-display').value = formatCurrency(npvValue);

                document.getElementById('irr').value = irrValue * 100;
                document.getElementById('irr-display').value = (irrValue * 100).toFixed(2) + '%';

                // Update IRR status
                const irrStatus = document.getElementById('irr-status');
                if (irrStatus) {
                    const isViable = (irrValue * 100) >= minimalIrr;
                    irrStatus.textContent = isViable ? 'LAYAK' : 'TIDAK LAYAK';
                    irrStatus.className = `mt-1 inline-block px-2 py-1 rounded-full text-xs font-bold ${
                        isViable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                    }`;
                }

                document.getElementById('payback_period').value = paybackPeriodValue;
                document.getElementById('payback-period-display').value = paybackPeriodValue;
            }

            // Function to update price
            function updatePrice(itemGroup) {
                const bandwidthSelect = itemGroup.querySelector('.bandwidth-select');
                const selectedOption = bandwidthSelect.options[bandwidthSelect.selectedIndex];
                const quantityInput = itemGroup.querySelector('.quantity-input');
                const durationInput = itemGroup.querySelector('.duration-input');
                const priceDisplay = itemGroup.querySelector('.price-display');
                const priceValue = itemGroup.querySelector('.price-value');

                if (selectedOption && selectedOption.value && selectedOption.dataset.price) {
                    const price = parseFloat(selectedOption.dataset.price);
                    const quantity = parseInt(quantityInput.value) || 1;
                    const duration = parseInt(durationInput.value) || 1;
                    const totalPrice = price * quantity * duration;
                    priceDisplay.value = formatCurrency(totalPrice);
                    priceValue.value = totalPrice;
                } else {
                    priceDisplay.value = formatCurrency(0);
                    priceValue.value = '0';
                }
                calculateTotalRevenue();
                performInvestmentCalculation();
            }

            // Add event listeners for input changes
            document.querySelectorAll('input[type="number"], select').forEach(input => {
                input.addEventListener('change', () => {
                    if (input.closest('.item-group')) {
                        updatePrice(input.closest('.item-group'));
                    }
                    performInvestmentCalculation();
                });
            });

            // Add event listeners for input changes on keyup for better responsiveness
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('keyup', () => {
                    if (input.closest('.item-group')) {
                        updatePrice(input.closest('.item-group'));
                    }
                    performInvestmentCalculation();
                });
            });

            // Add item button functionality
            document.getElementById('add-item').addEventListener('click', function() {
                const container = document.getElementById('items-container');
                const index = container.querySelectorAll('.item-group').length;

                const itemGroup = document.createElement('div');
                itemGroup.className = 'item-group mb-6 p-4 border border-gray-200 rounded-lg';
                itemGroup.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Item Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Item</label>
                            <select name="items[${index}][item_id]"
                                class="item-select w-full border border-gray-300 rounded-md px-3 py-2">
                                <option value="">Select Item</option>
                                @foreach ($items as $itemOption)
                                    <option value="{{ $itemOption->id }}" data-item="{{ json_encode($itemOption) }}">
                                        {{ $itemOption->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Bandwidth Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bandwidth</label>
                            <select name="items[${index}][bandwidth_id]"
                                class="bandwidth-select w-full border border-gray-300 rounded-md px-3 py-2" disabled>
                                <option value="">Select Bandwidth</option>
                            </select>
                        </div>

                        <!-- Quantity Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <input type="number" name="items[${index}][quantity]" value="1" min="1"
                                class="quantity-input w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>

                        <!-- Duration Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration (Months)</label>
                            <input type="number" name="items[${index}][duration]" value="1" min="1"
                                class="duration-input w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>
                    </div>

                    <!-- Price Display -->
                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <input type="text"
                            class="price-display w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
                            value="Rp0" readonly>
                        <input type="hidden" class="price-value" value="0">
                    </div>

                    <!-- Remove Item Button -->
                    <button type="button"
                        class="remove-item mt-2 text-red-600 hover:text-red-800 text-sm">
                        Remove Item
                    </button>
                `;

                container.appendChild(itemGroup);

                // Add event listeners for the new item
                const itemSelect = itemGroup.querySelector('.item-select');
                itemSelect.addEventListener('change', function() {
                    const itemId = this.value;
                    const bandwidthSelect = itemGroup.querySelector('.bandwidth-select');

                    if (itemId) {
                        fetch(`/api/bandwidth/${itemId}`)
                            .then(response => response.json())
                            .then(data => {
                                bandwidthSelect.innerHTML =
                                    '<option value="">Select Bandwidth</option>';
                                data.forEach(bw => {
                                    const option = document.createElement('option');
                                    option.value = bw.id;
                                    option.textContent = `${bw.bw} Mbps`;
                                    option.dataset.price = bw.price;
                                    option.dataset.bandwidth = JSON.stringify(bw);
                                    bandwidthSelect.appendChild(option);
                                });
                                bandwidthSelect.disabled = false;
                                updatePrice(itemGroup);
                            });
                    } else {
                        bandwidthSelect.innerHTML = '<option value="">Select Bandwidth</option>';
                        bandwidthSelect.disabled = true;
                        updatePrice(itemGroup);
                    }
                });

                // Add event listeners for inputs
                itemGroup.querySelector('.bandwidth-select').addEventListener('change', () => updatePrice(
                    itemGroup));
                itemGroup.querySelector('.quantity-input').addEventListener('input', () => updatePrice(
                    itemGroup));
                itemGroup.querySelector('.duration-input').addEventListener('input', () => updatePrice(
                    itemGroup));
                itemGroup.querySelector('.remove-item').addEventListener('click', function() {
                    itemGroup.remove();
                    performInvestmentCalculation();
                });
            });

            // Clear items button functionality
            document.getElementById('clear-items').addEventListener('click', function() {
                const container = document.getElementById('items-container');
                container.innerHTML = '';
                performInvestmentCalculation();
            });

            // Remove item button functionality for existing items
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.item-group').remove();
                    performInvestmentCalculation();
                });
            });

            // Initialize calculations
            calculateTotalRevenue();
            performInvestmentCalculation();
        });
    </script>
</x-app-layout>
