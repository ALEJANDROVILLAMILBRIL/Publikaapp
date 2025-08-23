<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fas fa-shopping-cart"></i>
            {{ __('My Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-lg sm:rounded-xl p-8">
                @if($carts->isEmpty())
                    <div class="text-center py-16">
                        <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-6"></i>
                        <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('Your cart is empty') }}</p>
                        <a href="{{ route('homepage') }}"
                           class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium shadow">
                            {{ __('Go Shopping') }}
                        </a>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($carts as $cart)
                            <div class="flex items-center gap-6 border-b border-gray-200 dark:border-gray-700 pb-6">
                                <!-- Imagen -->
                                <div class="w-28 h-28 flex-shrink-0 overflow-hidden rounded-lg shadow">
                                    <img src="{{ $cart->product->image_url ?? asset('storage/' . $cart->product->image) }}"
                                         alt="{{ $cart->product->name }}"
                                         class="w-full h-full object-cover">
                                </div>

                                <!-- Detalles -->
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                                        {{ $cart->product->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $cart->product->category->name ?? __('Uncategorized') }}
                                    </p>
                                    <p class="text-blue-600 dark:text-blue-400 font-semibold mt-2 text-lg">
                                        ${{ number_format($cart->product->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Cantidad -->
                                <div class="flex items-center gap-3">
                                    <form action="{{ route('carts.update', $cart->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="action" value="decrease"
                                            class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded hover:bg-gray-300 dark:hover:bg-gray-600 font-bold">
                                            -
                                        </button>
                                        <input type="text" name="quantity" value="{{ $cart->quantity }}"
                                            class="w-14 text-center border rounded dark:bg-gray-800 dark:text-white">
                                        <button type="submit" name="action" value="increase"
                                            class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded hover:bg-gray-300 dark:hover:bg-gray-600 font-bold">
                                            +
                                        </button>
                                    </form>
                                </div>

                                <!-- Eliminar -->
                                <form action="{{ route('carts.destroy', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-700 text-lg">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="mt-8 flex justify-between items-center">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                            {{ __('Total') }}:
                            <span class="text-blue-600 dark:text-blue-400">
                                ${{ number_format($carts->sum(fn($c) => $c->product->price * $c->quantity), 0, ',', '.') }}
                            </span>
                        </h3>
                        <a href="#" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold shadow">
                            {{ __('Proceed to Checkout') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
