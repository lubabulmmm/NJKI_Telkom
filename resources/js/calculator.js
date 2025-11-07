// Investment Calculator Full JS - with AKI Analysis & Inputs

// Wait for DOM to be loaded
document.addEventListener('DOMContentLoaded', async function() {
    // HTML References
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

    let items = [];

    // Notification functions
    function showError(title, message) {
        document.getElementById('error-title').textContent = title;
        document.getElementById('error-message').textContent = message;
        document.getElementById('error-notification').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('error-notification').classList.add('hidden');
        }, 5000);
    }

    // Fetch all items
    async function fetchItems() {
        try {
            const response = await fetch('/api/items');
            items = await response.json();
        } catch (error) {
            console.error('Failed to fetch items:', error);
            items = [
                { id: 1, nama_barang: 'Internet Dedicated' },
                { id: 2, nama_barang: 'Internet Shared' },
                { id: 3, nama_barang: 'Cloud Hosting' },
                { id: 4, nama_barang: 'VPN Service' }
            ];
        }
    }

    function createRow() {
        const rowId = `row-${Date.now()}`;
        const row = document.createElement('div');
        row.className = 'revenue-item bg-white p-6 rounded-2xl border-2 border-gray-100 hover:border-blue-300 transition-all duration-300';

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
        `;    formContainer.appendChild(row);

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

            bandwidthSelect.innerHTML = '<option value="" disabled selected>Select bandwidth</option>';
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

    row.querySelector('.remove-row').addEventListener('click', function() {
        formContainer.removeChild(row);
        calculateGrandTotal();
    });
}

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

// The investmentMetrics calculation block
async function calculateInvestmentMetrics(revenue) {
    const capex = Number(capexInput.value.replace(/[^0-9]/g, '')) || 0;
    const opexPercentage = Number(opexInput.value.replace(/[^0-9.]/g, '')) || 0;
    const waccPercentage = Number(waccInput.value.replace(/[^0-9.]/g, '')) || 0;
    const bhpPercentage = Number(bhpInput.value.replace(/[^0-9.]/g, '')) || 0;
    const minimalIrrPercentage = Number(minimalIrrInput.value.replace(/[^0-9.]/g, '')) || 0;
    const depreciation = capex / 3;

    const expenses = [];
    const cashFlows = [];
    const discountedFlows = [];
    const cumulativeFlows = [];
    const depreciationArray = [0, depreciation, depreciation, depreciation];
    let asset = revenue;
    let cumulative = 0;

    const yearData = [{
        year: 0,
        revenue: 0,
        asset: 0,
        oAndM: 0,
        expense: 0,
        ebitda: 0,
        ebitdaMargin: 0,
        depreciation: 0,
        ebit: 0,
        tax: 0,
        nopat: 0,
        netCashFlow: -capex,
        discounted: -capex,
        cumulative: -capex
    }];

    cashFlows.push(-capex);
    discountedFlows.push(-capex);
    cumulative = -capex;
    cumulativeFlows.push(cumulative);

    for (let year = 1; year <= 3; year++) {
        asset = year === 1 ? revenue : asset - depreciation;
        const oAndM = (bhpPercentage / 100) * revenue;
        const bhp = (bhpPercentage / 100) * revenue;
        const totalExpense = oAndM + bhp;

        const yearlyRevenue = revenue;
        const ebitda = yearlyRevenue - totalExpense;
        const ebitdaMargin = revenue === 0 ? 0 : ebitda / yearlyRevenue;
        const ebit = ebitda - depreciation;
        const tax = ebit < 0 ? 0 : ebit * 0.3;
        const nopat = ebit - tax;
        const netCashFlow = nopat + depreciation;
        const discounted = netCashFlow / Math.pow(1 + (minimalIrrPercentage / 100), year);
        cumulative += discounted;

        yearData.push({
            year,
            revenue: yearlyRevenue,
            asset,
            oAndM,
            expense: totalExpense,
            ebitda,
            ebitdaMargin,
            depreciation,
            ebit,
            tax,
            nopat,
            netCashFlow,
            discounted,
            cumulative
        });

        cashFlows.push(netCashFlow);
        discountedFlows.push(discounted);
        cumulativeFlows.push(cumulative);
    }

    const npv = cashFlows[0] + discountedFlows.slice(1).reduce((a, b) => a + b, 0);
    const irr = calculateIRR(cashFlows);
    const paybackPeriod = calculatePaybackPeriodFromFlows(cumulativeFlows);

    npvInput.value = `Rp${Math.round(npv).toLocaleString()}`;
    irrInput.value = `${(irr * 100).toFixed(2)}% (${irr >= (minimalIrrPercentage / 100) ? 'Layak' : 'Tidak Layak'})`;
    paybackPeriodInput.value = paybackPeriod;
}

function calculateIRR(cashFlows) {
    const maxIterations = 1000;
    const tolerance = 0.0001;
    let guess = 0.1;
    let step = 0.05;

    for (let i = 0; i < maxIterations; i++) {
        const npv = cashFlows.reduce((acc, val, t) => acc + val / Math.pow(1 + guess, t), 0);
        if (Math.abs(npv) < tolerance) return guess;
        guess += npv > 0 ? step : -step;
        step *= 0.5;
    }
    return guess;
}

function calculatePaybackPeriodFromFlows(cumulativeFlows) {
    for (let i = 1; i < cumulativeFlows.length; i++) {
        if (cumulativeFlows[i] >= 0) {
            const prev = cumulativeFlows[i - 1];
            const diff = cumulativeFlows[i] - prev;
            const partial = Math.abs(prev) / diff;
            const total = i - 1 + partial;
            const tahun = Math.floor(total);
            const bulan = Math.round((total - tahun) * 12);
            return `${tahun} tahun ${bulan} bulan`;
        }
    }
    return 'Investasi belum kembali';
}

addRowButton.addEventListener('click', createRow);
capexInput.addEventListener('input', () => {
    const capex = Number(capexInput.value.replace(/[^0-9]/g, '')) || 0;
    depreciationInput.value = `Rp${(capex / 3).toLocaleString()}`;
    const grandTotal = Number(grandTotalInput.value.replace(/[^0-9]/g, '')) || 0;
    calculateInvestmentMetrics(grandTotal);
});

fetchItems();
createRow();
