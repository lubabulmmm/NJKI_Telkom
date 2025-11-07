<x-app-layout>


    <div class="ml-0 sm:ml-60 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8">
            <div class="flex-1 overflow-y-auto p-6 mt-4 min-h-screen">
                <div class="border-b mb-8 border-gray-200 pb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600">User</p>
                            <h2 class="font-bold text-2xl text-red-700 leading-tight">
                                {{ __('Dashboard') }}
                            </h2>
                        </div>
                        <div class="text-sm text-gray-500">
                            Last updated: {{ now()->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>

                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
