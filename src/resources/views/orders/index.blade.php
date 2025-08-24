<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fas fa-list-alt"></i>
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-lg sm:rounded-xl p-8">
                @if($orders->isEmpty())
                    <div class="text-center py-16">
                        <i class="fas fa-receipt text-6xl text-gray-300 mb-6"></i>
                        <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('You haven\'t placed any orders yet') }}</p>
                        <a href="{{ route('homepage') }}"
                           class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium shadow">
                            {{ __('Start Shopping') }}
                        </a>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($orders as $order)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                                {{ __('Order') }} #{{ $order->order_number }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $order->created_at->format('M d, Y - g:i A') }}
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                                {{ [
                                                    'paid' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                    'failed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                ][$order->payment_status] ?? '' }}">
                                                {{ [
                                                    'paid' => __('Paid'),
                                                    'pending' => __('Pending Payment'),
                                                    'failed' => __('Payment Failed'),
                                                ][$order->payment_status] ?? $order->payment_status }}
                                            </span>
                                            <span class="text-xl font-bold text-blue-600">
                                                ${{ number_format($order->total_amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <div class="grid md:grid-cols-2 gap-6 mb-4">
                                        <div>
                                            <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-2">{{ __('Items') }}:</h4>
                                            <div class="space-y-2">
                                                @foreach($order->orderItems->take(3) as $item)
                                                    <div class="flex items-center gap-3">
                                                        <img src="{{ $item->product->image_url ? asset('storage/' . $item->product->image) : asset('images/products/product-image.svg') }}"
                                                             alt="{{ $item->product->name }}"
                                                             class="w-8 h-8 rounded object-cover">
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                                            {{ $item->product->name }} ({{ $item->quantity }})
                                                        </span>
                                                    </div>
                                                @endforeach
                                                @if($order->orderItems->count() > 3)
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ __('and :count more items', ['count' => $order->orderItems->count() - 3]) }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-2">{{ __('Payment Method') }}:</h4>
                                            <div class="flex items-center gap-2">
                                                @if($order->payment_method === 'cash')
                                                    <i class="fas fa-money-bill-wave text-green-600"></i>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Cash Payment') }}</span>
                                                @else
                                                    <i class="fab fa-paypal text-blue-600"></i>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">PayPal</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap justify-end items-start gap-3 mt-3">
                                        <!-- Ver detalles -->
                                        <a href="{{ route('orders.show', $order->slug) }}"
                                            class="inline-flex items-center justify-center min-h-[44px] px-5 py-2.5 rounded-lg text-sm font-semibold
                                                bg-blue-600 text-white hover:bg-blue-700 shadow-sm transition-all whitespace-nowrap
                                                w-full sm:w-auto">
                                            <i class="fas fa-eye mr-2"></i> {{ __('View details') }}
                                        </a>

                                        @if($order->payment_status === 'paid' && $order->order_status === 'accepted')
                                            <!-- Devolver compra -->
                                            <div x-data="{ open: false }" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                                                <form action="{{ route('customer.orders.returnRequest', $order) }}" method="POST" class="flex flex-col sm:flex-row gap-2 w-full">
                                                    @csrf

                                                    <!-- Textarea y acciones -->
                                                    <div x-show="open" x-transition class="flex flex-col sm:flex-row gap-2 w-full">
                                                        <textarea x-ref="returnNote" name="description" rows="2"
                                                            placeholder="Escribe una nota (opcional)"
                                                            class="w-full sm:w-64 border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm"></textarea>

                                                        <div class="flex gap-2">
                                                            <button type="submit"
                                                                class="inline-flex items-center justify-center min-h-[44px] px-4 py-2.5 rounded-lg text-sm font-semibold
                                                                    bg-red-600 text-white hover:bg-red-700 shadow-sm">
                                                                <i class="fas fa-paper-plane mr-2"></i> {{ __('Send') }}
                                                            </button>
                                                            <button type="button"
                                                                @click="open = false; $refs.returnNote.value='';"
                                                                class="inline-flex items-center justify-center min-h-[44px] px-4 py-2.5 rounded-lg text-sm font-semibold
                                                                    bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Botón abrir -->
                                                    <button type="button"
                                                        @click="open = true; $nextTick(() => $refs.returnNote.focus())"
                                                        x-show="!open"
                                                        class="inline-flex items-center justify-center min-h-[44px] px-5 py-2.5 rounded-lg text-sm font-semibold
                                                            bg-red-600 text-white hover:bg-red-700 shadow-sm whitespace-nowrap">
                                                        <i class="fas fa-undo-alt mr-2"></i> {{ __('Return purchase') }}
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- Reportar incidente -->
                                            <div x-data="{ open: false }" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                                                <form action="{{ route('customer.orders.incidentReport', $order) }}" method="POST" class="flex flex-col sm:flex-row gap-2 w-full">
                                                    @csrf

                                                    <!-- Textarea y acciones -->
                                                    <div x-show="open" x-transition class="flex flex-col sm:flex-row gap-2 w-full">
                                                        <textarea x-ref="incidentNote" name="description" rows="2"
                                                            placeholder="Describe el incidente (opcional)"
                                                            class="w-full sm:w-64 border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 text-sm"></textarea>

                                                        <div class="flex gap-2">
                                                            <button type="submit"
                                                                class="inline-flex items-center justify-center min-h-[44px] px-4 py-2.5 rounded-lg text-sm font-semibold
                                                                    bg-yellow-500 text-black hover:bg-yellow-600 shadow-sm">
                                                                <i class="fas fa-paper-plane mr-2"></i> {{ __('Send') }}
                                                            </button>
                                                            <button type="button"
                                                                @click="open = false; $refs.incidentNote.value='';"
                                                                class="inline-flex items-center justify-center min-h-[44px] px-4 py-2.5 rounded-lg text-sm font-semibold
                                                                    bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Botón abrir -->
                                                    <button type="button"
                                                        @click="open = true; $nextTick(() => $refs.incidentNote.focus())"
                                                        x-show="!open"
                                                        class="inline-flex items-center justify-center min-h-[44px] px-5 py-2.5 rounded-lg text-sm font-semibold
                                                            bg-yellow-500 text-black hover:bg-yellow-600 shadow-sm whitespace-nowrap">
                                                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ __('Incident report') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Paginación -->
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
