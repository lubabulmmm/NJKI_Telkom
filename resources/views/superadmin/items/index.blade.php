<x-app-layout>
    <div class="ml-0 sm:ml-60 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8">
            <div class="flex-1 overflow-y-auto mt-8 p-6 min-h-screen">
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600">Super Admin</p>
                            <h2 class="font-bold text-2xl text-red-700 leading-tight">
                                {{ __('Items') }}
                            </h2>
                        </div>
                        <div class="text-sm text-gray-500">
                            Last updated: {{ now()->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div id="successAlert"
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 relative animate-pulse">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Success!</span>
                            <span class="ml-2">{{ session('success') }}</span>
                            <button type="button"
                                class="absolute top-0 right-0 mt-3 mr-3 text-green-500 hover:text-green-700"
                                onclick="closeAlert('successAlert')">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div id="errorAlert"
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 relative animate-pulse">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Error!</span>
                            <span class="ml-2">{{ session('error') }}</span>
                            <button type="button"
                                class="absolute top-0 right-0 mt-3 mr-3 text-red-500 hover:text-red-700"
                                onclick="closeAlert('errorAlert')">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Title and Search Section -->
                <div
                    class="bg-white text-black border-b mt-8 p-8 rounded-t-3xl card-shadow flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                    <h2 class="text-3xl font-bold text-black">DATA ITEMS</h2>
                    <div class="w-full md:w-1/2 flex items-center space-x-2">
                        <!-- Search form -->
                        <form method="GET" action="{{ route('superadmin.items') }}"
                            class="w-full flex items-center space-x-2">
                            <input type="text" name="search" placeholder="Search..." value="{{ $search }}"
                                class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md w-full" />
                            <button type="submit"
                                class="flex items-center justify-center text-white bg-orange-300 hover:bg-orange-400 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                                Search
                            </button>
                        </form>

                        <!-- Add Item Button -->
                        <a href="{{ route('superadmin.items.create') }}"
                            class="ml-4 flex items-center justify-center text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-2 w-full transition-all ease-in-out duration-200">
                            <svg class="h-4 w-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 5.757v8.486M5.757 10h8.486M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Tambah Item
                        </a>
                    </div>
                </div>

                <!-- Pagination Section: Items per page selector -->
                <div class="p-4 border-b bg-white flex justify-between">
                    <div>
                        <form method="GET" action="{{ route('superadmin.items') }}">
                            <label for="perPage" class="mr-2">Items per page:</label>
                            <select name="perPage" id="perPage" onchange="this.form.submit()"
                                class="bg-gray-100 text-gray-700 p-2 w-full rounded-md">
                                <option value="15" {{ request()->get('perPage') == 15 ? 'selected' : '' }}>15
                                </option>
                                <option value="25" {{ request()->get('perPage') == 25 ? 'selected' : '' }}>25
                                </option>
                                <option value="50" {{ request()->get('perPage') == 50 ? 'selected' : '' }}>50
                                </option>
                                <option value="100" {{ request()->get('perPage') == 100 ? 'selected' : '' }}>100
                                </option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Data Table -->
                <div id="tableContainer" class="rounded-b-lg overflow-x-auto">
                    @if ($items->isEmpty())
                        <div class="bg-white p-8 text-center rounded-lg shadow">
                            <div class="text-5xl mb-4">😕</div>
                            <h3 class="text-xl font-semibold text-gray-700">No Items Found</h3>
                            <p class="text-gray-500 mt-2">
                                @if (request('search'))
                                    We couldn't find any items matching "{{ request('search') }}"
                                @else
                                    No items available in the database
                                @endif
                            </p>
                            @if (request('search'))
                                <a href="{{ route('superadmin.items') }}"
                                    class="mt-4 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Clear Search
                                </a>
                            @else
                                <a href="{{ route('superadmin.items.create') }}"
                                    class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Add New Item
                                </a>
                            @endif
                        </div>
                    @else
                        <table class="min-w-full table-auto">
                            <thead class="bg-white border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item
                                        Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $index => $item)
                                    <tr class="bg-white border-b hover:bg-red-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $items->firstItem() + $index }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->nama_barang }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('superadmin.items.edit', $item->id) }}"
                                                class="text-yellow-600 hover:text-yellow-900 ml-3">Edit</a>
                                            <button
                                                onclick="confirmDelete('{{ route('superadmin.items.delete', $item->id) }}', '{{ $item->nama_barang }}')"
                                                class="text-red-600 hover:text-red-900 ml-3">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <!-- Pagination Section: Links -->
                @if ($items->isNotEmpty())
                    <div id="paginationContainer" class="p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-sm text-gray-700">Showing {{ $items->firstItem() ?? 0 }} to
                                    {{ $items->lastItem() ?? 0 }} of {{ $items->total() ?? 0 }} entries</span>
                            </div>
                            <div>
                                {{ $items->appends(['perPage' => $perPage, 'search' => $search])->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');

            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s ease-out';
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.remove();
                    }, 500);
                }, 5000);
            }

            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.transition = 'opacity 0.5s ease-out';
                    errorAlert.style.opacity = '0';
                    setTimeout(() => {
                        errorAlert.remove();
                    }, 500);
                }, 5000);
            }
        });

        // Function to close alert manually
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.transition = 'opacity 0.3s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }

        // Double confirmation delete function with item name
        function confirmDelete(url, itemName) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Anda akan menghapus item: <strong>${itemName}</strong><br><br>Item yang dihapus tidak dapat dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((firstResult) => {
                if (firstResult.isConfirmed) {
                    // Konfirmasi kedua
                    Swal.fire({
                        title: 'Konfirmasi kedua',
                        html: `Anda yakin ingin menghapus item: <strong>${itemName}</strong>?<br><br>Klik 'Ya, Hapus Sekarang' untuk melanjutkan`,
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus Sekarang!',
                        cancelButtonText: 'Batalkan'
                    }).then((secondResult) => {
                        if (secondResult.isConfirmed) {
                            // Buat form dan submit
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;

                            const csrf = document.createElement('input');
                            csrf.type = 'hidden';
                            csrf.name = '_token';
                            csrf.value = '{{ csrf_token() }}';

                            const method = document.createElement('input');
                            method.type = 'hidden';
                            method.name = '_method';
                            method.value = 'DELETE';

                            form.appendChild(csrf);
                            form.appendChild(method);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
            });
        }
    </script>
</x-app-layout>
