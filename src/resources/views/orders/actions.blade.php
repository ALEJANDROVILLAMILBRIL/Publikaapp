<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fas fa-comments"></i>
            {{ __('Order comments #:') }} {{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if($actions->isEmpty())
            <div class="text-center py-16">
                <i class="fas fa-comment-slash text-6xl text-gray-300 mb-6"></i>
                <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('No comments yet') }}</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($actions as $action)
                    <div class="p-4 bg-white dark:bg-gray-900 shadow-md rounded-xl border-l-4
                        {{ $action->action_type === 'return_request' ? 'border-red-500' : 'border-yellow-500' }}">

                        {{-- Encabezado --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3">
                            <span class="text-base font-semibold text-gray-800 dark:text-gray-200">
                                {{ $action->action_type === 'return_request' ? __('Return request') : __('Incident report') }}
                            </span>
                            <span class="text-xs text-gray-500 mt-1 sm:mt-0">
                                {{ $action->created_at->diffForHumans() }}
                            </span>
                        </div>

                        {{-- Descripción --}}
                        <p class="text-gray-700 dark:text-gray-400 text-sm mb-3">
                            {{ $action->description }}
                        </p>

                        {{-- Contacto --}}
                        <div class="flex flex-col gap-1 text-sm text-gray-600 dark:text-gray-400">
                            @if(!empty($action->phone_number))
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-phone text-gray-500"></i>
                                    <span>{{ $action->phone_number }}</span>
                                </div>
                            @endif
                            @if(!empty($action->email))
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-envelope text-gray-500"></i>
                                    <a href="mailto:{{ $action->email }}"
                                       class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $action->email }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
