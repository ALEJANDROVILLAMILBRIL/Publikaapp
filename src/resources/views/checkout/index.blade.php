<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fas fa-credit-card"></i>
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-lg sm:rounded-xl overflow-hidden">

                <!-- Resumen del pedido -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-6">
                        {{ __('Order Summary') }}
                    </h3>

                    <div class="space-y-4">
                        @foreach($carts as $cart)
                            <div class="flex justify-between items-center bg-white dark:bg-gray-900 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $cart->product->image_url ? asset('storage/' . $cart->product->image) : asset('images/products/product-image.svg') }}"
                                        alt="{{ $cart->product->name }}"
                                        class="w-14 h-14 rounded-lg object-cover shadow"
                                        width="56" height="56">
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $cart->product->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Quantity') }}: {{ $cart->quantity }}</p>
                                    </div>
                                </div>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">
                                    ${{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-300 dark:border-gray-600 mt-6 pt-6">
                        <div class="flex justify-between items-center">
                            <p class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('Total') }}:</p>
                            <p class="text-2xl font-bold text-blue-600">${{ number_format($total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Métodos de pago -->
                <form action="{{ route('checkout.process') }}" method="POST" class="p-8">
                    @csrf

                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-6">
                        {{ __('Payment Method') }}
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <!-- Cash Payment -->
                        <label class="payment-option flex items-start p-6 rounded-lg cursor-pointer transition-all duration-200 relative"
                               style="border: 2px solid #2563eb; background-color: #eff6ff;">
                            <input type="radio" name="payment_method" value="cash" class="sr-only" checked>
                            <div class="payment-indicator w-6 h-6 rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0"
                                 style="border: 2px solid #3b82f6; background-color: white;">
                                <div class="dot w-3 h-3 rounded-full" style="background-color: #3b82f6;"></div>
                            </div>
                            <div class="flex items-start gap-4 flex-1">
                                <div class="bg-green-100 dark:bg-green-900 p-3 rounded-lg flex-shrink-0">
                                    <i class="fas fa-money-bill-wave text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ __('Cash Payment') }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Pay in cash when you receive your order') }}</p>
                                </div>
                            </div>
                        </label>

                        <!-- PayPal -->
                        <label class="payment-option flex items-start p-6 rounded-lg cursor-pointer transition-all duration-200 relative"
                               style="border: 2px solid #d1d5db; background-color: white;">
                            <input type="radio" name="payment_method" value="paypal" class="sr-only">
                            <div class="payment-indicator w-6 h-6 rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0"
                                 style="border: 2px solid #d1d5db; background-color: white;">
                                <div class="dot w-3 h-3 rounded-full" style="background-color: transparent;"></div>
                            </div>
                            <div class="flex items-start gap-4 flex-1">
                                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg flex-shrink-0">
                                    <i class="fab fa-paypal text-blue-600 dark:text-blue-400 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ __('PayPal') }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Secure payment via PayPal') }}</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Indicador visual adicional -->
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500">
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            <strong>{{ __('Selected method') }}:</strong>
                            <span id="selected-method" class="text-blue-600 dark:text-blue-400 font-semibold ml-1">{{ __('Cash Payment') }}</span>
                        </p>
                    </div>

                    <!-- Notas adicionales -->
                    <div class="mb-8">
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Additional Notes') }} ({{ __('Optional') }})
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white"
                                  placeholder="{{ __('Special instructions for your order...') }}"></textarea>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex gap-4">
                        <a href="{{ route('carts.index') }}"
                           class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-6 py-3 rounded-lg font-medium text-center hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            {{ __('Back to Cart') }}
                        </a>
                        <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            {{ __('Place Order') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const options = document.querySelectorAll(".payment-option");
            const selectedMethodText = document.getElementById('selected-method');

            function resetAllOptions() {
                options.forEach(opt => {
                    opt.style.border = '2px solid #d1d5db';
                    opt.style.backgroundColor = 'white';

                    const indicator = opt.querySelector(".payment-indicator");
                    const dot = opt.querySelector(".dot");

                    if (indicator) {
                        indicator.style.border = '2px solid #d1d5db';
                    }
                    if (dot) {
                        dot.style.backgroundColor = 'transparent';
                    }

                    const radio = opt.querySelector("input[type='radio']");
                    if (radio) {
                        radio.checked = false;
                    }
                });
            }

            function selectOption(option) {
                resetAllOptions();

                option.style.border = '2px solid #2563eb';
                option.style.backgroundColor = '#eff6ff';

                const indicator = option.querySelector(".payment-indicator");
                const dot = option.querySelector(".dot");
                const radio = option.querySelector("input[type='radio']");

                if (indicator) {
                    indicator.style.border = '2px solid #3b82f6';
                }
                if (dot) {
                    dot.style.backgroundColor = '#3b82f6';
                }
                if (radio) {
                    radio.checked = true;

                    if (selectedMethodText) {
                        if (radio.value === 'cash') {
                            selectedMethodText.textContent = '{{ __("Cash Payment") }}';
                        } else if (radio.value === 'paypal') {
                            selectedMethodText.textContent = 'PayPal';
                        }
                    }
                }
            }

            options.forEach(option => {
                option.addEventListener("click", function(e) {
                    e.preventDefault();
                    selectOption(this);
                });
            });

            const cashOption = document.querySelector("input[value='cash']");
            if (cashOption) {
                const cashLabel = cashOption.closest('.payment-option');
                if (cashLabel) {
                    selectOption(cashLabel);
                }
            }
        });
    </script>
    @endsection
</x-app-layout>
