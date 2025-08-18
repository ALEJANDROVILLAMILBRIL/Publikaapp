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
                                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-3 items-end">
                                        <!-- Campo Name -->
                                        <div class="flex flex-col w-full">
                                            <label for="name" class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">{{ __('Name') }}</label>
                                            <input type="text" id="name" name="name" value="{{ request('name') }}"
                                            placeholder="{{ __('Enter name') }}"
                                            class="px-3 py-2 text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm w-full">
                                        </div>

                                        <!-- Campo Creation Date -->
                                        <div class="flex flex-col w-full">
                                            <label for="created_at" class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">{{ __('Creation date') }}</label>
                                            <input type="date" id="created_at" name="created_at" value="{{ request('created_at') }}"
                                            class="px-3 py-2 text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm w-full">
                                        </div>

                                        <!-- Botones en una fila -->
                                        <div class="flex gap-2 w-full sm:w-auto justify-between sm:justify-start lg:col-span-1 xl:col-span-2">
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
                        <table class="w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    <th class="px-6 py-4 text-left text-sm font-semibold">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-hashtag text-gray-400"></i>
                                            ID
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-tags text-gray-400"></i>
                                            {{ __('Name') }}
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                            {{ __('Created At') }}
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold">
                                        <div class="flex items-center justify-center gap-2">
                                            <i class="fas fa-cogs text-gray-400"></i>
                                            {{ __('Actions') }}
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4">
                                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-semibold text-blue-600 dark:text-blue-300">{{ $category->id }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $category->created_at->format('Y-m-d') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('admin.categories.edit', $category->slug) }}"
                                                    class="inline-flex items-center px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-lg transition-all"
                                                    title="{{ __('Edit') }}"
                                                    aria-label="{{ __('Edit') }}">
                                                    <i class="fas fa-edit mr-1"></i>
                                                </a>
                                                <form id="deleteForm_{{ $category->slug }}" action="{{ route('admin.categories.destroy', $category->slug) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDelete('{{ $category->slug }}')"
                                                        class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-all"
                                                        title="{{ __('Delete') }}"
                                                        aria-label="{{ __('Delete') }}">
                                                        <i class="fas fa-trash-alt mr-1"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-inbox text-2xl text-gray-400"></i>
                                                </div>
                                                <p class="text-gray-500 dark:text-gray-400 font-medium">{{ __('No data available in this table') }}</p>
                                            </div>
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
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-xs font-semibold text-blue-600 dark:text-blue-300">{{ $category->id }}</span>
                                        </div>
                                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $category->name }}</h3>
                                    </div>
                                    <div class="flex gap-1">
                                        <a href="{{ route('admin.categories.edit', $category->slug) }}"
                                            class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold px-3 py-1.5 rounded">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form id="deleteForm_{{ $category->slug }}" action="{{ route('admin.categories.destroy', $category->slug) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete('{{ $category->slug }}')"
                                                class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ __('Created At') }}: {{ $category->created_at->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                        <i class="fas fa-inbox text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">{{ __('No data available in this table') }}</p>
                                </div>
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
