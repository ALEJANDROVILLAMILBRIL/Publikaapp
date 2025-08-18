<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (Auth::user()->role->name === 'admin')
                        <div class="flex flex-wrap -mx-3 mb-8">
                            <!-- Total Users -->
                            <div class="w-full sm:w-1/3 px-3 mb-6">
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                                    <div class="text-blue-500 text-4xl mb-4">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ __("Total Users") }}</h4>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</p>
                                </div>
                            </div>

                            <!-- Total Products -->
                            <div class="w-full sm:w-1/3 px-3 mb-6">
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                                    <div class="text-green-500 text-4xl mb-4">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ __("Total Products") }}</h4>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_products'] }}</p>
                                </div>
                            </div>

                            <!-- Total Categories -->
                            <div class="w-full sm:w-1/3 px-3 mb-6">
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 text-center">
                                    <div class="text-yellow-500 text-4xl mb-4">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ __("Total Categories") }}</h4>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_categories'] }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif (Auth::user()->role->name === 'customer')
                        {{ __("You're logged in!") }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
