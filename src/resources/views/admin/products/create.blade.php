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

                    <form action="{{ route('admin.products.store') }}" method="POST">
                        @csrf

                         <!-- Campo de nombre -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Name') }}
                            </label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2"
                                required>
                        </div>

                        <!-- Campo de precio -->
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Price') }}
                            </label>
                            <input type="number" step="0.01" name="price" id="price"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2"
                                required>
                        </div>
                    
                        <!-- Campo de cantidad -->
                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Quantity') }}
                            </label>
                            <input type="number" name="quantity" id="quantity"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2"
                                required>
                        </div>
                    
                        <!-- Selección de categoría -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Category') }}
                            </label>
                            <select name="category_id" id="category_id"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2"
                                required>
                                <option value="" selected>{{ __('- Select -') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.products.index') }}"
                                class="mr-4 inline-block bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold px-4 py-2 rounded">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>