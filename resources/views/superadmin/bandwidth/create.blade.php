<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Bandwidth Entry') }}
        </h2>
    </x-slot> --}}
    <div class="ml-0 sm:ml-60 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8">
            <div class="flex-1 overflow-y-auto mt-8 p-6 min-h-screen">

                <!-- Success/Error Notification -->
                @if (session('success'))
                    <div id="success-notification"
                        class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-lg transform transition-all duration-500 ease-in-out opacity-100 translate-x-0">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Success!</span>
                            <span class="ml-2">{{ session('success') }}</span>
                            <button onclick="closeNotification('success-notification')"
                                class="ml-auto text-green-500 hover:text-green-700">
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
                    <div id="error-notification"
                        class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-lg transform transition-all duration-500 ease-in-out opacity-100 translate-x-0">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Error!</span>
                            <span class="ml-2">{{ session('error') }}</span>
                            <button onclick="closeNotification('error-notification')"
                                class="ml-auto text-red-500 hover:text-red-700">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="font-extrabold text-2xl text-red-800 leading-tight">
                        {{ __('Tambah Bandwidth') }}
                    </h2>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('superadmin.bandwidth.store') }}" id="bandwidth-form">
                        @csrf
                        <div class="mb-4">
                            <label for="item_id" class="block text-gray-700 font-medium mb-2">Item</label>
                            <select name="item_id" id="item_id"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                <option value="">Pilih Item</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('item_id')
                                <div class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="bw" class="block text-gray-700 font-medium mb-2">Bandwidth (Mbps)</label>
                            <input type="number" name="bw" id="bw"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                value="{{ old('bw') }}" placeholder="Masukkan bandwidth dalam Mbps" required />
                            @error('bw')
                                <div class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 font-medium mb-2">Harga (IDR)</label>
                            <input type="number" name="price" id="price"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                value="{{ old('price') }}" placeholder="Masukkan harga dalam IDR" required />
                            @error('price')
                                <div class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4 flex justify-between gap-4">
                            <!-- Add Bandwidth Button -->
                            <button type="submit" id="submit-button"
                                class="bg-green-500 hover:bg-green-600 text-white p-3 rounded-lg w-1/2 font-medium transition-all duration-200 transform hover:scale-105 focus:ring-4 focus:ring-green-300 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Bandwidth
                            </button>

                            <!-- Back Button -->
                            <button type="button" onclick="history.back()"
                                class="bg-red-500 hover:bg-red-600 text-white p-3 rounded-lg w-1/2 font-medium transition-all duration-200 transform hover:scale-105 focus:ring-4 focus:ring-red-300 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                                </svg>
                                Kembali
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Modal for Confirmation -->
    <div id="confirmation-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 w-96 mx-4 transform transition-all duration-300 scale-95">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 ml-3">Konfirmasi Penambahan Bandwidth</h3>
            </div>
            <p id="modal-message" class="text-gray-700 mb-6">Apakah Anda yakin ingin menambahkan bandwidth ini?</p>
            <div class="flex justify-end space-x-3">
                <!-- Cancel button -->
                <button id="cancel-button"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg font-medium transition-colors">
                    Batal
                </button>
                <!-- OK button -->
                <button id="confirm-button"
                    class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-colors">
                    Ya, Tambahkan
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-500"></div>
            <span class="text-gray-700 font-medium">Menyimpan data...</span>
        </div>
    </div>

    <script>
        // Auto hide notifications after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = ['success-notification', 'error-notification'];

            notifications.forEach(function(notificationId) {
                const notification = document.getElementById(notificationId);
                if (notification) {
                    // Auto hide after 5 seconds
                    setTimeout(function() {
                        closeNotification(notificationId);
                    }, 5000);
                }
            });
        });

        // Function to close notification with animation
        function closeNotification(notificationId) {
            const notification = document.getElementById(notificationId);
            if (notification) {
                notification.classList.add('opacity-0', 'translate-x-full');
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 500);
            }
        }

        // JavaScript to handle custom modal confirmation
        document.getElementById('bandwidth-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission immediately

            // Get form values
            let itemSelect = document.getElementById('item_id');
            let itemName = itemSelect.options[itemSelect.selectedIndex].text;
            let bandwidthValue = document.getElementById('bw').value;
            let priceValue = document.getElementById('price').value;

            // Validate form
            if (!itemSelect.value || !bandwidthValue || !priceValue) {
                alert('Mohon lengkapi semua field yang diperlukan.');
                return;
            }

            // Set the modal message dynamically
            document.getElementById('modal-message').innerHTML =
                `Apakah Anda yakin ingin menambahkan bandwidth <strong>${bandwidthValue} Mbps</strong> untuk item <strong>"${itemName}"</strong> dengan harga <strong>Rp ${parseInt(priceValue).toLocaleString('id-ID')}</strong>?`;

            // Show the confirmation modal with animation
            const modal = document.getElementById('confirmation-modal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.querySelector('.bg-white').classList.remove('scale-95');
                modal.querySelector('.bg-white').classList.add('scale-100');
            }, 10);
        });

        // Handle confirmation button click
        document.getElementById('confirm-button').addEventListener('click', function() {
            // Hide modal
            hideModal();

            // Show loading overlay
            document.getElementById('loading-overlay').classList.remove('hidden');

            // Submit the form
            setTimeout(() => {
                document.getElementById('bandwidth-form').submit();
            }, 500);
        });

        // Handle cancel button click
        document.getElementById('cancel-button').addEventListener('click', function() {
            hideModal();
        });

        // Function to hide modal with animation
        function hideModal() {
            const modal = document.getElementById('confirmation-modal');
            modal.querySelector('.bg-white').classList.remove('scale-100');
            modal.querySelector('.bg-white').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        // Close modal when clicking outside
        document.getElementById('confirmation-modal').addEventListener('click', function(event) {
            if (event.target === this) {
                hideModal();
            }
        });

        // Format price input with thousand separators
        document.getElementById('price').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        // Validate bandwidth input (only positive numbers)
        document.getElementById('bw').addEventListener('input', function(e) {
            let value = e.target.value;
            if (value < 0) {
                e.target.value = '';
            }
        });
    </script>
</x-app-layout>
