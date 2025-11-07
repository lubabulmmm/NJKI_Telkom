<!-- resources/views/superadmin/users/create.blade.php -->
<x-app-layout>
    <div class="ml-0 sm:ml-60 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8">
            <div class="flex-1 overflow-y-auto mt-8 p-6 min-h-screen">
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600">Super Admin</p>
                            <h2 class="font-bold text-2xl text-red-700 leading-tight">
                                {{ __('User') }}
                            </h2>
                        </div>
                        <div class="text-sm text-gray-500">
                            Last updated: {{ now()->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Success/Error Notification -->
                @if (session('success'))
                    <div id="successAlert"
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 relative animate-bounce">
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
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 relative animate-shake">
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

                <div class="bg-white shadow-md sm:rounded-lg rounded-lg">
                    <div class="p-6">
                        <!-- Form to add a new user -->
                        <form method="POST" action="{{ route('superadmin.users.store') }}" id="user-form">
                            @csrf

                            <!-- Name Field -->
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                    required>
                                @error('name')
                                    <span class="text-red-500 text-sm animate-pulse">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                    required>
                                @error('email')
                                    <span class="text-red-500 text-sm animate-pulse">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Role Field -->
                            <div class="mb-4">
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" id="role"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                    required>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                    {{-- <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>
                                        Superadmin</option> --}}
                                </select>
                                @error('role')
                                    <span class="text-red-500 text-sm animate-pulse">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" id="password"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                    required>
                                @error('password')
                                    <span class="text-red-500 text-sm animate-pulse">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password Confirmation Field -->
                            <div class="mb-4">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                    required>
                                @error('password_confirmation')
                                    <span class="text-red-500 text-sm animate-pulse">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Button Container: Add User & Back buttons -->
                            <div class="mb-4 flex justify-between">
                                <!-- Add User Button -->
                                <button type="button" id="submit-button"
                                    class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 w-1/2 text-center transform hover:scale-105 transition-all duration-200">
                                    Add User
                                </button>
                                <!-- Back Button -->
                                <a href="{{ route('superadmin.users') }}"
                                    class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 w-1/2 ml-4 text-center transform hover:scale-105 transition-all duration-200">
                                    Back
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div id="confirmation-modal"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full mx-4 transform scale-95 transition-transform duration-300"
                id="modal-content">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Are you sure you want to add the user "<span
                        id="userNameDisplay" class="font-bold text-green-600"></span>"?</h3>
                <div class="flex justify-between space-x-3">
                    <!-- Cancel button -->
                    <button id="cancel-button"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transform hover:scale-105 transition-all duration-200 w-1/2">Cancel</button>
                    <!-- OK button -->
                    <button id="confirm-button"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transform hover:scale-105 transition-all duration-200 w-1/2">OK</button>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div id="success-modal"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
            <div
                class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full mx-4 transform scale-95 transition-transform duration-300">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">User Added Successfully!</h3>
                    <p class="text-sm text-gray-500 mb-4">The user has been created and saved to the database.</p>
                </div>
            </div>
        </div>

        <style>
            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                25% {
                    transform: translateX(-5px);
                }

                75% {
                    transform: translateX(5px);
                }
            }

            .animate-shake {
                animation: shake 0.5s ease-in-out;
            }
        </style>

        <script>
            // Show the confirmation modal when the "Add User" button is clicked
            document.getElementById('submit-button').addEventListener('click', function() {
                const userName = document.getElementById('name').value;
                if (userName.trim() !== '') {
                    // Set the modal message dynamically
                    document.getElementById('userNameDisplay').textContent = userName;

                    // Show the confirmation modal with animation
                    const modal = document.getElementById('confirmation-modal');
                    const modalContent = document.getElementById('modal-content');
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modalContent.classList.remove('scale-95');
                        modalContent.classList.add('scale-100');
                    }, 10);
                }
            });

            // Handle cancel button click
            document.getElementById('cancel-button').addEventListener('click', function() {
                const modal = document.getElementById('confirmation-modal');
                const modalContent = document.getElementById('modal-content');
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            });

            // Submit the form when the user clicks "OK"
            document.getElementById('confirm-button').addEventListener('click', function() {
                // Hide confirmation modal
                document.getElementById('confirmation-modal').classList.add('hidden');

                // Show loading state
                const button = this;
                const originalText = button.textContent;
                button.innerHTML =
                    '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...';
                button.disabled = true;

                // Submit the form
                document.getElementById('user-form').submit();
            });

            // Prevent form submission on pressing Enter and show the confirmation modal instead
            document.getElementById('name').addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const userName = document.getElementById('name').value;
                    if (userName.trim() !== '') {
                        document.getElementById('userNameDisplay').textContent = userName;
                        const modal = document.getElementById('confirmation-modal');
                        const modalContent = document.getElementById('modal-content');
                        modal.classList.remove('hidden');
                        setTimeout(() => {
                            modalContent.classList.remove('scale-95');
                            modalContent.classList.add('scale-100');
                        }, 10);
                    }
                }
            });

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
        </script>
</x-app-layout>
