<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fas fa-store"></i>
            {{ __('Orders Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if($orders->isEmpty())
                <div class="text-center py-16">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-6"></i>
                    <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('No orders yet') }}</p>
                </div>
            @else
                @php
                    $paymentMethods = [
                        'cash' => __('Efectivo'),
                        'paypal' => 'PayPal',
                        'credit_card' => __('Tarjeta de crédito'),
                    ];

                    $paymentStatuses = [
                        'pending' => __('Pendiente'),
                        'paid' => __('Pagado'),
                        'failed' => __('Fallido'),
                    ];

                    $orderStatuses = [
                        'pending' => __('Pendiente'),
                        'accepted' => __('Aceptada'),
                        'rejected' => __('Rechazada'),
                    ];
                @endphp
                @foreach($orders as $order)
                    <div class="bg-white dark:bg-gray-900 shadow-lg sm:rounded-xl p-6 flex flex-col md:flex-row md:justify-between md:items-start gap-4">

                        {{-- Información principal --}}
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">
                                {{ __('Order #:') }} {{ $order->order_number }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Customer:') }} {{ $order->user->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Payment method:') }} {{ $paymentMethods[$order->payment_method] ?? $order->payment_method }}
                            </p>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Payment status:') }} {{ $paymentStatuses[$order->payment_status] ?? $order->payment_status }}
                            </p>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Order status:') }} {{ $orderStatuses[$order->order_status] ?? $order->order_status }}
                            </p>

                            @if($order->notes)
                                <div class="mt-4 p-3 bg-gray-100 dark:bg-gray-800 border-l-4 border-blue-500 rounded shadow-sm flex items-start gap-2">
                                    <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8M8 12h8m-6 5h6"/>
                                    </svg>
                                    <div class="text-sm text-gray-700 dark:text-gray-200">
                                        <span class="font-semibold">{{ __('Notes') }}:</span> {{ $order->notes }}
                                    </div>
                                </div>
                            @endif

                            {{-- Items --}}
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center gap-3 border rounded p-2">
                                        <img src="{{ $item->product->image_url ?? asset('images/products/product-image.svg') }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-16 h-16 rounded-lg object-cover">
                                        <div class="text-sm">
                                            <p class="font-semibold text-gray-700 dark:text-gray-200">{{ $item->product->name }}</p>
                                            <p class="text-gray-500 dark:text-gray-400">{{ __('Quantity:') }} {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Botones y selectores --}}
                        <div class="flex flex-col gap-2 md:items-end mt-4 md:mt-0">
                            <form action="{{ route('seller.orders.updateStatus', $order) }}" method="POST" class="flex flex-col gap-2 w-full md:w-auto">
                                @csrf
                                {{-- Solo mostrar payment_status para efectivo --}}
                                @if($order->payment_method === 'cash')
                                    <div class="relative">
                                        <select name="payment_status"
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 py-2 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                            <option value="pending" @selected($order->payment_status === 'pending')>{{ __('Pending') }}</option>
                                            <option value="paid" @selected($order->payment_status === 'paid')>{{ __('Paid') }}</option>
                                            <option value="failed" @selected($order->payment_status === 'failed')>{{ __('Failed') }}</option>
                                        </select>
                                        {{-- Flecha personalizada solo si usas appearance-none --}}
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                @endif

                                {{-- Order status --}}
                                <div class="relative">
                                    <select name="order_status"
                                        class="block w-full border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 py-2 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                        <option value="pending" @selected($order->order_status === 'pending')>{{ __('Pending') }}</option>
                                        <option value="accepted" @selected($order->order_status === 'accepted')>{{ __('Accepted') }}</option>
                                        <option value="rejected" @selected($order->order_status === 'rejected')>{{ __('Rejected') }}</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium shadow mt-2">
                                    {{ __('Update') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
