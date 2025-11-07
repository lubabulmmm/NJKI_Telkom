<!-- resources/views/components/sidebar.blade.php -->

<aside class="bg-red-600 text-white w-60 h-screen p-4 flex flex-col fixed top-0 left-0 bottom-0 z-50 md:block">
    <!-- Logo -->
    <div class="flex items-center justify-center mb-6">
        <img src="/path/to/logo.png" alt="Logo" class="h-12 w-auto">
    </div>

    <!-- Navigation Links -->
    <nav>
        <ul>
            <li class="mb-4">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:bg-red-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-tachometer-alt text-xl"></i>
                    <span class="text-lg">Dashboard</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('tables') }}" class="flex items-center space-x-3 hover:bg-red-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-table text-xl"></i>
                    <span class="text-lg">Tables</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('billing') }}" class="flex items-center space-x-3 hover:bg-red-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-credit-card text-xl"></i>
                    <span class="text-lg">Billing</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('virtual-reality') }}" class="flex items-center space-x-3 hover:bg-red-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-cogs text-xl"></i>
                    <span class="text-lg">Virtual Reality</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('rtl') }}" class="flex items-center space-x-3 hover:bg-red-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-globe text-xl"></i>
                    <span class="text-lg">RTL</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('profile') }}" class="flex items-center space-x-3 hover:bg-red-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-user text-xl"></i>
                    <span class="text-lg">Profile</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('logout') }}" class="flex items-center space-x-3 hover:bg-red-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-sign-out-alt text-xl"></i>
                    <span class="text-lg">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
