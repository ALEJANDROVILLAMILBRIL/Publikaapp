<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fas fa-receipt"></i>
            {{ __('Order') }} #{{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-lg sm:rounded-xl overflow-hidden">

                <!-- Header de la orden -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold">{{ __('Order') }} #{{ $order->order_number }}</h3>
                            <p class="opacity-90 mt-1">{{ __('Placed on') }} {{ $order->created_at->format('M d, Y - g:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <div class="flex gap-2 mb-2">
                                <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-medium">
                                    @switch($order->payment_status)
                                        @case('paid')
                                            <i class="fas fa-check-circle"></i> {{ __('Paid') }}
                                            @break
                                        @case('pending')
                                            <i class="fas fa-clock"></i> {{ __('Pending Payment') }}
                                            @break
                                        @case('failed')
                                            <i class="fas fa-times-circle"></i> {{ __('Payment Failed') }}
                                            @break
                                        @default
                                            {{ ucfirst($order->payment_status) }}
                                    @endswitch
                                </span>
                                <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-medium">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </div>
                            <p class="text-3xl font-bold">${{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Información del pago -->
                    <div class="grid md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                                {{ __('Payment Information') }}
                            </h4>
                            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                                <div class="flex items-center gap-3 mb-3">
                                    @if($order->payment_method === 'cash')
                                        <div class="bg-green-100 dark:bg-green-900 p-2 rounded-lg">
                                            <i class="fas fa-money-bill-wave text-green-600 dark:text-green-400"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800 dark:text-gray-200">{{ __('Cash Payment') }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Pay on delivery') }}</p>
                                        </div>
                                    @else
                                        <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg">
                                            <i class="fab fa-paypal text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800 dark:text-gray-200">PayPal</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                @if($order->paypal_order_id)
                                                    ID: {{ $order->paypal_order_id }}
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($order->notes)
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                                {{ __('Order Notes') }}
                            </h4>
                            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                                <p class="text-gray-700 dark:text-gray-300">{{ $order->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Items de la orden -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                            {{ __('Order Items') }}
                        </h4>
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center gap-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                    <img src="{{ $item->product->image_url ? asset('storage/' . $item->product->image) : asset('images/products/product-image.svg') }}"
                                         alt="{{ $item->product->name }}"
                                         class="w-16 h-16 rounded object-cover">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-800 dark:text-gray-200">{{ $item->product->name }}</h5>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('Quantity') }}: {{ $item->quantity }} × ${{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Total -->
                        <div class="border-t border-gray-200 dark:border-gray-700 mt-6 pt-6">
                            <div class="flex justify-between items-center">
                                <p class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ __('Total') }}:</p>
                                <p class="text-2xl font-bold text-blue-600">${{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="flex gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('orders.index') }}"
                           class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-6 py-3 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            {{ __('All Orders') }}
                        </a>
                        <a href="{{ route('homepage') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            {{ __('Continue Shopping') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
