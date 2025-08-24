<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fas fa-comments"></i>
            {{ __('Comentarios del pedido #:') }} {{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if($actions->isEmpty())
            <div class="text-center py-16">
                <i class="fas fa-comment-slash text-6xl text-gray-300 mb-6"></i>
                <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('No hay comentarios aún.') }}</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($actions as $action)
                    <div class="p-4 bg-white dark:bg-gray-900 shadow rounded-lg border-l-4
                        {{ $action->type === 'return_request' ? 'border-red-500' : 'border-yellow-500' }}">

                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                {{ $action->type === 'return_request' ? __('Solicitud de devolución') : __('Reporte de incidente') }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $action->created_at->diffForHumans() }}</span>
                        </div>

                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $action->description }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('orders.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('Volver') }}
            </a>
        </div>
    </div>
</x-app-layout>
