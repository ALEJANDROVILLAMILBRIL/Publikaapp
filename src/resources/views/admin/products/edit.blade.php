<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="mb-4 text-red-500">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product->slug) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Name') }}</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                                   class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2" required>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Price') }}</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01"
                                   class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2" required>
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Quantity') }}</label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}"
                                   class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2" required>
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Category') }}</label>
                            <select id="category_id" name="category_id"
                                    class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded dark:bg-blue-700 dark:hover:bg-blue-600">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
