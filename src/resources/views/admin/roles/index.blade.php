<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Role') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full">
                        <div class="bg-white mb-4 dark:bg-gray-800 rounded-lg shadow">
                            <div class="bg-blue-600 text-white px-4 py-2 rounded-t-lg">
                                <h3 class="text-lg font-semibold">{{ __('Search Section') }}</h3>
                            </div>
                            <form method="GET" action="{{ route('admin.roles.index') }}">
                            <div class="p-4">
                                <div class="flex flex-wrap gap-4 items-end">
                                <!-- Campo Name -->
                                <div class="flex flex-col w-full sm:w-1/4">
                                    <label for="name" class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Name') }}</label>
                                    <input type="text" id="name" name="name" value="{{ request('name') }}"
                                    placeholder="{{ __('Enter name') }}"
                                    class="mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                                </div>
                        
                                <!-- Campo Creation Date -->
                                <div class="flex flex-col w-full sm:w-1/4">
                                    <label for="created_at" class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Creation date') }}</label>
                                    <input type="date" id="created_at" name="created_at" value="{{ request('created_at') }}"
                                    class="mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                                </div>
                        
                                <!-- Botones -->
                                <div class="flex gap-2 mt-6">
                                    <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-md shadow-md transition-all">
                                    {{ __('Search') }}
                                    </button>
                                    @if(request()->has('name') || request()->has('created_at'))
                                        <a href="{{ route('admin.roles.index') }}"
                                            class="bg-red-600 flex items-center hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-md shadow-md transition-all">
                                            {{ __('Clear') }}
                                        </a>
                                    @endif
                                </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                                                                                                                                 
                    <div class="overflow-x-auto">
                        <table class="table-fixed w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    <th class="w-1/12 px-6 py-4 text-center text-sm font-semibold">ID</th>
                                    <th class="w-4/12 px-6 py-4 text-center text-sm font-semibold">{{ __('Name') }}</th>
                                    <th class="w-3/12 px-6 py-4 text-center text-sm font-semibold">{{ __('Created At') }}</th>
                                    <th class="w-4/12 px-6 py-4 text-center text-sm font-semibold">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $rol)
                                    <tr class="border-t border-gray-200 dark:border-gray-700">
                                        <td class="px-6 py-4 text-center">{{ $rol->id }}</td>
                                        <td class="px-6 py-4 text-center">{{ $rol->name }}</td>
                                        <td class="px-6 py-4 text-center">{{ $rol->created_at->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('admin.roles.show', $rol->slug) }}"
                                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white dark:text-gray-100 text-sm font-semibold px-3 py-2 rounded"
                                                    title="{{ __('View') }}"
                                                    aria-label="{{ __('View') }}">
                                                    <i class="fas fa-eye"></i>
                                                 </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('No data available in this table') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $roles->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>