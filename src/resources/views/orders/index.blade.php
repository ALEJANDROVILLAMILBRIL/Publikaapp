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
                                                @switch($order->payment_status)
                                                    @case('paid')
                                                        bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                        @break
                                                    @case('pending')
                                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                        @break
                                                    @case('failed')
                                                        bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                        @break
                                                @endswitch
                                            ">
                                                {{ ucfirst($order->payment_status) }}
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

                                    <div class="flex justify-end">
                                        <a href="{{ route('orders.show', $order->id) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                            {{ __('View Details') }}
                                        </a>
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
