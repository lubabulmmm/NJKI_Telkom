<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Item') }}
        </h2>
    </x-slot> --}}

    <div class="ml-0 sm:ml-60 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8">
            <div class="flex-1 overflow-y-auto mt-8 p-6 min-h-screen">
                <!-- Success/Error Notification -->
                @if (session('success'))
                    <div id="successNotification"
                        class="fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-500 ease-in-out">
                        <div
                            class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-lg shadow-2xl border-l-4 border-green-300 max-w-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-200" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold">Success!</h3>
                                    <p class="text-sm opacity-90">{{ session('success') }}</p>
                                </div>
                                <button onclick="hideNotification('successNotification')"
                                    class="ml-4 text-green-200 hover:text-white transition-colors duration-200">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error') || $errors->any())
                    <div id="errorNotification"
                        class="fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-500 ease-in-out">
                        <div
                            class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-lg shadow-2xl border-l-4 border-red-300 max-w-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-red-200" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold">Error!</h3>
                                    <p class="text-sm opacity-90">
                                        @if (session('error'))
                                            {{ session('error') }}
                                        @else
                                            {{ $errors->first() }}
                                        @endif
                                    </p>
                                </div>
                                <button onclick="hideNotification('errorNotification')"
                                    class="ml-4 text-red-200 hover:text-white transition-colors duration-200">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="font-extrabold text-2xl text-red-800 leading-tight">
                        {{ __('Edit Items') }}
                    </h2>
                </div>
                <div class="p-6">
                    <form id="editItemForm" method="POST" action="{{ route('superadmin.items.update', $item->id) }}">
                        @csrf
                        @method('PUT') <!-- PUT method for updating the item -->
                        <div class="mb-4">
                            <label for="nama_barang" class="block text-sm font-medium text-gray-700">Item Name</label>
                            <input type="text" name="nama_barang" id="nama_barang"
                                value="{{ old('nama_barang', $item->nama_barang) }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('nama_barang') border-red-500 @enderror"
                                required>
                            @error('nama_barang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4 flex justify-between">
                            <!-- Update Item Button with equal size -->
                            <button type="button" id="confirmButton"
                                class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg w-1/2 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <span class="flex items-center justify-center">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Update Item
                                </span>
                            </button>

                            <!-- Back Button with equal size -->
                            <button type="button" onclick="history.back()"
                                class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg w-1/2 ml-4 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <span class="flex items-center justify-center">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Back
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal"
        class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50 hidden">
        <div
            class="bg-white p-6 rounded-lg shadow-2xl max-w-sm w-full transform scale-95 transition-transform duration-300">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-medium text-gray-700">Confirm Update</h3>
            </div>
            <p class="text-gray-600 mb-6">Are you sure you want to update the item "<span id="itemNameDisplay"
                    class="font-semibold text-gray-800"></span>"?</p>
            <div class="flex justify-between space-x-3">
                <button id="cancelButton"
                    class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transform hover:scale-105 transition-all duration-200">
                    Cancel
                </button>
                <button id="confirmSubmissionButton"
                    class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transform hover:scale-105 transition-all duration-200">
                    <span class="flex items-center justify-center">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        OK
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay"
        class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-2xl">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                <span class="ml-3 text-gray-700 font-medium">Updating item...</span>
            </div>
        </div>
    </div>

    <script>
        // Show notifications on page load
        window.addEventListener('DOMContentLoaded', function() {
            const successNotification = document.getElementById('successNotification');
            const errorNotification = document.getElementById('errorNotification');

            if (successNotification) {
                setTimeout(() => {
                    successNotification.classList.remove('translate-x-full');
                }, 100);

                // Auto hide after 5 seconds
                setTimeout(() => {
                    hideNotification('successNotification');
                }, 5000);
            }

            if (errorNotification) {
                setTimeout(() => {
                    errorNotification.classList.remove('translate-x-full');
                }, 100);

                // Auto hide after 7 seconds for errors
                setTimeout(() => {
                    hideNotification('errorNotification');
                }, 7000);
            }
        });

        function hideNotification(notificationId) {
            const notification = document.getElementById(notificationId);
            if (notification) {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }
        }

        // Show the confirmation modal when the "Update Item" button is clicked
        document.getElementById('confirmButton').addEventListener('click', function() {
            const itemName = document.getElementById('nama_barang').value;
            if (itemName.trim() !== '') {
                document.getElementById('itemNameDisplay').textContent = itemName;
                const modal = document.getElementById('confirmationModal');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.querySelector('.bg-white').classList.remove('scale-95');
                    modal.querySelector('.bg-white').classList.add('scale-100');
                }, 10);
            }
        });

        // Close the modal without submitting the form (Cancel button)
        document.getElementById('cancelButton').addEventListener('click', function() {
            closeModal();
        });

        function closeModal() {
            const modal = document.getElementById('confirmationModal');
            modal.querySelector('.bg-white').classList.remove('scale-100');
            modal.querySelector('.bg-white').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Submit the form when the user confirms (OK button)
        document.getElementById('confirmSubmissionButton').addEventListener('click', function() {
            closeModal();
            document.getElementById('loadingOverlay').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('editItemForm').submit();
            }, 300);
        });

        // Prevent form submission on pressing Enter and show the confirmation modal instead
        document.getElementById('nama_barang').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const itemName = document.getElementById('nama_barang').value;
                if (itemName.trim() !== '') {
                    document.getElementById('itemNameDisplay').textContent = itemName;
                    const modal = document.getElementById('confirmationModal');
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modal.querySelector('.bg-white').classList.remove('scale-95');
                        modal.querySelector('.bg-white').classList.add('scale-100');
                    }, 10);
                }
            }
        });

        // Close modal when clicking outside
        document.getElementById('confirmationModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });
    </script>

</x-app-layout>
