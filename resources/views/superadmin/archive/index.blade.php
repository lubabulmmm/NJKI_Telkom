<x-app-layout>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin-top: 1rem;
        }

        .pagination li {
            margin: 0 0.25rem;
        }

        .pagination li a,
        .pagination li span {
            display: inline-block;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            border: 1px solid #e2e8f0;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .pagination li a:hover {
            background-color: #edf2f7;
        }

        .pagination li.active span {
            background-color: #4299e1;
            color: white;
            border-color: #4299e1;
        }

        .pagination li.disabled span {
            color: #a0aec0;
            cursor: not-allowed;
            background-color: #f7fafc;
        }

        .filter-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-badge:hover {
            opacity: 0.8;
        }

        .filter-badge.active {
            background-color: #3b82f6;
            color: white;
        }

        .filter-badge.inactive {
            background-color: #e5e7eb;
            color: #4b5563;
        }
    </style>
    <div class="ml-0 sm:ml-60 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8">
            <div class="flex-1 overflow-y-auto p-6 mt-8 min-h-screen">
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600">Super Admin</p>
                            <h2 class="font-bold text-2xl text-red-700 leading-tight">
                                {{ __('Archive Investment') }}
                            </h2>
                        </div>
                        <div class="text-sm text-gray-500">
                            Last updated: {{ now()->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
                <div class="bg-white/90 mt-8 glassmorphism rounded-3xl card-shadow mb-8">
                    <!-- Header section -->
                    <div class="bg-white text-black border-b p-8 rounded-t-3xl">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-3xl font-bold mb-2">📁 All Investment Archives</h1>
                                <p class="text-lg opacity-90">History of all users' saved calculations</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        @if (session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif

                        <!-- Filter and Search Section -->
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                            <!-- Viability Filter -->
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-gray-700">Filter:</span>
                                <a href="{{ route('superadmin.investment.archive.index', array_merge(request()->query(), ['viability' => 'all'])) }}"
                                    class="filter-badge {{ request('viability', 'all') === 'all' ? 'active' : 'inactive' }}">
                                    All
                                </a>
                                <a href="{{ route('superadmin.investment.archive.index', array_merge(request()->query(), ['viability' => 'layak'])) }}"
                                    class="filter-badge {{ request('viability') === 'layak' ? 'active' : 'inactive' }}">
                                    LAYAK
                                </a>
                                <a href="{{ route('superadmin.investment.archive.index', array_merge(request()->query(), ['viability' => 'tidak-layak'])) }}"
                                    class="filter-badge {{ request('viability') === 'tidak-layak' ? 'active' : 'inactive' }}">
                                    TIDAK LAYAK
                                </a>
                            </div>

                            <!-- Items per page selector and Search -->
                            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-600">Show</span>
                                    <select id="per_page" class="border border-gray-300 rounded-md px-4 py-2 text-sm">
                                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5
                                        </option>
                                        <option value="10"
                                            {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>
                                            10
                                        </option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25
                                        </option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50
                                        </option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                    <span class="text-sm text-gray-600">entries</span>
                                </div>

                                <form method="GET" action="{{ route('superadmin.investment.archive.index') }}"
                                    class="relative">
                                    <input type="text" name="search" placeholder="Search archives..."
                                        value="{{ request('search') }}"
                                        class="border border-gray-300 rounded-md px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 w-full md:w-auto">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    @if (request('search'))
                                        <a href="{{ route('superadmin.investment.archive.index') }}"
                                            class="absolute right-2 top-2 text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </a>
                                    @endif
                                </form>
                            </div>
                        </div>

                        <!-- Archives Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            User</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Customer</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            CAPEX</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Revenue</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            NPV</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            IRR</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Payback</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($archives as $index => $archive)
                                        <tr class="hover:bg-red-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ ($archives->currentPage() - 1) * $archives->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $archive->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $archive->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $archive->customer_name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $archive->calculation_date->format('d M Y') }}</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $archive->calculation_date->format('H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Rp{{ number_format($archive->capex, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Rp{{ number_format($archive->total_revenue, 0, ',', '.') }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $archive->npv >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                Rp{{ number_format($archive->npv, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span
                                                        class="text-sm font-medium {{ $archive->is_viable ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ number_format($archive->irr, 2) }}%
                                                    </span>
                                                    <span
                                                        class="ml-2 px-2 py-1 text-xs rounded-full {{ $archive->is_viable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $archive->is_viable ? 'LAYAK' : 'TIDAK LAYAK' }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @php
                                                    // Parse the payback period from the database
                                                    $paybackPeriod = $archive->payback_period;

                                                    // Check if it's the special case
if (
    strpos(
        $paybackPeriod,
        'Investasi belum kembali dalam 3 tahun',
    ) !== false
) {
    echo $paybackPeriod;
} else {
    // Extract years and months
    $years = 0;
    $months = 0;

    if (preg_match('/(\d+) tahun/', $paybackPeriod, $yearMatches)) {
        $years = (int) $yearMatches[1];
    }

    if (
        preg_match('/(\d+) bulan/', $paybackPeriod, $monthMatches)
    ) {
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
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $archive->is_viable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $archive->is_viable ? 'LAYAK' : 'TIDAK LAYAK' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <a href="{{ route('superadmin.investment.archive.show', $archive->id) }}"
                                                        class="text-blue-600 hover:text-blue-900 p-1" title="View">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('superadmin.investment.archive.export', $archive->id) }}"
                                                        class="text-green-600 hover:text-green-900 p-1"
                                                        title="Download Excel">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </a>
                                                    <button type="button"
                                                        onclick="showDeleteModal('{{ route('superadmin.investment.archive.destroy', $archive->id) }}')"
                                                        class="text-red-600 hover:text-red-900 p-1" title="Delete">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                                                No investment archives found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $archives->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl transform transition-all w-full max-w-md mx-4">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm Deletion</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this archive? This action cannot
                    be undone.</p>
                <div class="flex justify-center space-x-4">
                    <button id="cancel-delete" type="button"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <form id="delete-form" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirm-delete"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Success Notification -->
    <div id="delete-success-notification" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-lg w-full max-w-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 id="delete-success-title" class="text-sm font-medium text-green-800">Successfully Deleted!
                    </h3>
                    <p id="delete-success-message" class="text-sm text-green-600 mt-1">The archive has been
                        permanently removed.</p>
                </div>
                <button type="button" onclick="hideDeleteSuccess()"
                    class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Items per page selection
            const perPageSelect = document.getElementById('per_page');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function() {
                    const perPage = this.value;
                    const url = new URL(window.location.href);

                    // Reset to page 1 when changing per_page
                    url.searchParams.set('page', '1');
                    url.searchParams.set('per_page', perPage);

                    window.location.href = url.toString();
                });
            }
        });

        // Delete modal functionality
        const deleteModal = document.getElementById('delete-modal');
        const cancelDeleteBtn = document.getElementById('cancel-delete');

        // Global function to show delete modal
        window.showDeleteModal = function(url) {
            const deleteForm = document.getElementById('delete-form');
            deleteForm.action = url;
            deleteModal.classList.remove('hidden');
        };

        // Cancel delete
        cancelDeleteBtn.addEventListener('click', function() {
            deleteModal.classList.add('hidden');
        });

        // Confirm delete
        document.getElementById('confirm-delete').addEventListener('click', async function(e) {
            e.preventDefault();
            const deleteForm = document.getElementById('delete-form');
            const confirmBtn = this;

            // Show loading state
            confirmBtn.innerHTML = `
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Deleting...
                `;
            confirmBtn.disabled = true;

            try {
                const response = await fetch(deleteForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to delete archive');
                }

                showDeleteSuccess('Archive Deleted', 'The archive has been successfully removed.');
                setTimeout(() => window.location.reload(), 1500);
            } catch (error) {
                console.error('Delete error:', error);
                showDeleteError('Error', error.message || 'Failed to delete archive');
            } finally {
                deleteModal.classList.add('hidden');
                confirmBtn.innerHTML = 'Delete';
                confirmBtn.disabled = false;
            }
        });

        // Notification functions
        function showDeleteSuccess(title, message) {
            document.getElementById('delete-success-title').textContent = title;
            document.getElementById('delete-success-message').textContent = message;
            document.getElementById('delete-success-notification').classList.remove('hidden');
            setTimeout(hideDeleteSuccess, 5000);
        }

        function hideDeleteSuccess() {
            document.getElementById('delete-success-notification').classList.add('hidden');
        }

        function showDeleteError(title, message) {
            document.getElementById('delete-error-title').textContent = title;
            document.getElementById('delete-error-message').textContent = message;
            document.getElementById('delete-error-notification').classList.remove('hidden');
            setTimeout(hideDeleteError, 5000);
        }

        function hideDeleteError() {
            document.getElementById('delete-error-notification').classList.add('hidden');
        }
    </script>
</x-app-layout>
