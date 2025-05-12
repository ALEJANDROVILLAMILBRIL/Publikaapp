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
                    <a href="{{ route('admin.categories.create') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-6">
                        + {{__('New Category') }}
                    </a>

                    <div class="w-full">
                        <div class="bg-white mb-4 dark:bg-gray-800 rounded-lg shadow">
                            <div class="bg-blue-600 text-white px-4 py-2 rounded-t-lg">
                                <h3 class="text-lg font-semibold">{{ __('Search Section') }}</h3>
                            </div>
                            <form method="GET" action="{{ route('admin.categories.index') }}">
                                <div class="p-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                                        <!-- Campo Name -->
                                        <div class="flex flex-col w-full">
                                            <label for="name" class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Name') }}</label>
                                            <input type="text" id="name" name="name" value="{{ request('name') }}"
                                            placeholder="{{ __('Enter name') }}"
                                            class="mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm w-full">
                                        </div>
                                    
                                        <!-- Campo Creation Date -->
                                        <div class="flex flex-col w-full">
                                            <label for="created_at" class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Creation date') }}</label>
                                            <input type="date" id="created_at" name="created_at" value="{{ request('created_at') }}"
                                            class="mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm w-full">
                                        </div>
                                    
                                        <!-- Botones en una fila -->
                                        <div class="flex gap-4 w-full sm:w-auto justify-between sm:justify-start md:col-span-2">
                                            <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-md shadow-md transition-all w-full sm:w-auto">
                                            {{ __('Search') }}
                                            </button>
                                            @if(request()->has('name') || request()->has('created_at'))
                                                <a href="{{ route('admin.categories.index') }}"
                                                class="bg-red-600 flex items-center justify-center hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-md shadow-md transition-all w-full sm:w-auto">
                                                {{ __('Clear') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="hidden md:block overflow-x-auto">
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
                                @forelse ($categories as $category)
                                    <tr class="border-t border-gray-200 dark:border-gray-700">
                                        <td class="px-6 py-4 text-center">{{ $category->id }}</td>
                                        <td class="px-6 py-4 text-center">{{ $category->name }}</td>
                                        <td class="px-6 py-4 text-center">{{ $category->created_at->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('admin.categories.edit', $category->slug) }}"
                                                    class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white dark:text-gray-100 text-sm font-semibold px-3 py-2 rounded"
                                                    title="{{ __('Edit') }}"
                                                    aria-label="{{ __('Edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                 </a>
                                                <form id="deleteForm_{{ $category->slug }}" action="{{ route('admin.categories.destroy', $category->slug) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDelete('{{ $category->slug }}')"
                                                        class="inline-block bg-red-600 hover:bg-red-700 text-white dark:text-gray-100 text-sm font-semibold px-3 py-2 rounded"
                                                        title="{{ __('Delete') }}"
                                                        aria-label="{{ __('Delete') }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
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

                    <!-- Versión de tarjetas para pantallas pequeñas -->
                    <div class="md:hidden">
                        @forelse ($categories as $category)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 rounded-lg shadow mb-3">
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-start space-x-2">
                                        <span class="text-gray-500 dark:text-gray-400 font-medium w-24">{{ __('ID') }}:</span>
                                        <span class="text-gray-800 dark:text-gray-100 flex-1">{{ $category->id }}</span>
                                    </div>
                                    <div class="flex items-start space-x-2">
                                        <span class="text-gray-500 dark:text-gray-400 font-medium w-24">{{ __('Name') }}:</span>
                                        <span class="text-gray-800 dark:text-gray-100 flex-1">{{ $category->name }}</span>
                                    </div>
                                    <div class="flex items-start space-x-2">
                                        <span class="text-gray-500 dark:text-gray-400 font-medium w-24">{{ __('Created At') }}:</span>
                                        <span class="text-gray-800 dark:text-gray-100 flex-1">{{ $category->created_at->format('Y-m-d') }}</span>
                                    </div>
                                    <div class="flex pt-2" style="gap: 10px;">
                                        <a href="{{ route('admin.categories.edit', $category->slug) }}"
                                        class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white dark:text-gray-100 text-sm font-semibold px-3 py-2 rounded">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form id="deleteForm_{{ $category->slug }}" action="{{ route('admin.categories.destroy', $category->slug) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete('{{ $category->slug }}')"
                                                class="inline-block bg-red-600 hover:bg-red-700 text-white dark:text-gray-100 text-sm font-semibold px-3 py-2 rounded"
                                                title="{{ __('Delete') }}"
                                                aria-label="{{ __('Delete') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 dark:text-gray-400">
                                {{ __('No data available in this table') }}
                            </div>
                        @endforelse
                    </div>
                    
                    <div class="mt-4">
                        {{ $categories->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script type="text/javascript">
        function confirmDelete(slug) {
            swal({
                title: @json(__('messages.confirm_title')),
                text: @json(__('messages.confirm_text')),
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    document.getElementById('deleteForm_' + slug).submit();
                }
            });
        }
        </script>
    @endsection
</x-app-layout>