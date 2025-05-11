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
                                                <a href="{{ route('categories.edit', $category->slug) }}"
                                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-4 py-2 rounded">
                                                   {{ __('Edit') }}
                                                </a>
                                                <form id="deleteForm_{{ $category->slug }}" action="{{ route('categories.destroy', $category->slug) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDelete('{{ $category->slug }}')"
                                                        class="inline-block bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded">
                                                        {{ __('Delete') }}
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