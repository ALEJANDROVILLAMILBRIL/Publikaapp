<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.model_detail_intro', ['Name' => __('Role')]) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold flex items-center gap-2">
                            <i class="fas fa-user-shield text-indigo-500"></i>
                            {{ $role->name }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ __('messages.model_detail_description', ['name' => __('role')]) }}
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 mb-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ __('Slug') }}
                            </p>
                            <p class="text-base font-semibold">{{ $role->slug }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ __('Created At') }}
                            </p>
                            <p class="text-base font-semibold">{{ $role->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('admin.roles.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg">
                            <i class="fas fa-arrow-left mr-2"></i>
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>