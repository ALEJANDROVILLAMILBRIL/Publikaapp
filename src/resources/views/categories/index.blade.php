<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('categories.create') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-6">
                        + {{__('New Category') }}
                    </a>

                    <div class="overflow-x-auto">
                        <table class="table-fixed w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    <th class="w-1/12 px-4 py-3 text-center text-sm font-semibold">ID</th>
                                    <th class="w-4/12 px-4 py-3 text-center text-sm font-semibold">{{ __('Name') }}</th>
                                    <th class="w-3/12 px-4 py-3 text-center text-sm font-semibold">{{ __('Created At') }}</th>
                                    <th class="w-4/12 px-4 py-3 text-center text-sm font-semibold">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr class="border-t border-gray-200 dark:border-gray-700">
                                        <td class="px-4 py-3 text-center">{{ $category->id }}</td>
                                        <td class="px-4 py-3 text-center">{{ $category->name }}</td>
                                        <td class="px-4 py-3 text-center">{{ $category->created_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <!-- Contenedor para las acciones, usando flexbox para distribuir los botones -->
                                            <div class="flex justify-center space-x-2">
                                                <!-- Editar -->
                                                <a href="{{ route('categories.edit', $category->slug) }}"
                                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-3 py-1 rounded">
                                                   {{ __('Edit') }}
                                                </a>
                                        
                                                <!-- Eliminar -->
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('{{ __('Are you sure?') }}')"
                                                            class="inline-block bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-3 py-1 rounded">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('No data available in this table') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>