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

                    <!-- Sección de Ubicación -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-6">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ __('Delivery Location') }}
                        </h3>

                        <!-- Tabs -->
                        <div class="mb-6">
                            <div class="flex space-x-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg">
                                <button type="button" id="gps-tab" class="location-tab flex-1 px-4 py-2 text-sm font-medium rounded-md transition-colors bg-blue-600 text-white">
                                    <i class="fas fa-crosshairs mr-2"></i>{{ __('Current Location') }}
                                </button>
                                <button type="button" id="manual-tab" class="location-tab flex-1 px-4 py-2 text-sm font-medium rounded-md transition-colors text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                                    <i class="fas fa-edit mr-2"></i>{{ __('Manual Input') }}
                                </button>
                            </div>
                        </div>

                        <!-- GPS Content -->
                        <div id="gps-content" class="location-content">
                            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                            <i class="fas fa-satellite-dish mr-2"></i>{{ __('Current Location') }}
                                        </p>
                                        <p class="text-sm text-green-600 dark:text-green-400" id="gps-status">
                                            {{ __('Getting your location automatically...') }}
                                        </p>
                                    </div>
                                    <button type="button" id="refresh-location-btn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        <i class="fas fa-sync mr-2"></i>{{ __('Refresh') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Manual Content -->
                        <div id="manual-content" class="location-content hidden">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Latitude') }}
                                    </label>
                                    <input type="number" id="manual-latitude" step="any" placeholder="4.7110"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Longitude') }}
                                    </label>
                                    <input type="number" id="manual-longitude" step="any" placeholder="-74.0721"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Mapa interactivo -->
                        <div class="mt-6">
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-medium text-gray-800 dark:text-gray-200">
                                        <i class="fas fa-map mr-2"></i>{{ __('Interactive Map') }}
                                    </h4>
                                    <button type="button" id="toggle-map-btn" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        <i class="fas fa-eye mr-1"></i>{{ __('Show Map') }}
                                    </button>
                                </div>
                                <div id="map-container" class="hidden">
                                    <div id="map" style="height: 400px; border-radius: 8px;"></div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                        <i class="fas fa-info-circle mr-1"></i>{{ __('Click on the map to set delivery location') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Resumen de ubicación -->
                        <div id="location-summary" class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500 hidden">
                            <h4 class="font-medium text-blue-800 dark:text-blue-200 mb-2">
                                <i class="fas fa-map-pin mr-2"></i>{{ __('Selected Location') }}
                            </h4>
                            <div class="text-sm text-blue-700 dark:text-blue-300">
                                <p><strong>{{ __('Address') }}:</strong> <span id="display-address">-</span></p>
                                <p class="mt-1">
                                    <strong>{{ __('Coordinates') }}:</strong>
                                    <span id="display-coords">-</span>
                                </p>
                            </div>
                        </div>
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
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
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
        // Variables globales
        let map = null;
        let marker = null;
        let currentLat = 4.7110;
        let currentLng = -74.0721;

        // Elementos DOM
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const locationSummary = document.getElementById('location-summary');
        const displayAddress = document.getElementById('display-address');
        const displayCoords = document.getElementById('display-coords');
        const tabs = document.querySelectorAll('.location-tab');
        const contents = document.querySelectorAll('.location-content');
        const toggleMapBtn = document.getElementById('toggle-map-btn');
        const mapContainer = document.getElementById('map-container');

        // Actualizar inputs ocultos
        function updateHiddenInputs(lat, lng) {
            latInput.value = lat;
            lngInput.value = lng;
            currentLat = lat;
            currentLng = lng;
            updateLocationSummary();
        }

        // Actualizar resumen de ubicación
        function updateLocationSummary() {
            displayCoords.textContent = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
            locationSummary.classList.remove('hidden');

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${currentLat}&lon=${currentLng}&addressdetails=1`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        displayAddress.textContent = data.display_name;
                    } else {
                        displayAddress.textContent = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
                    }
                })
                .catch(() => {
                    displayAddress.textContent = `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;
                });
        }

        // Inicializar mapa
        function initMap() {
            if (map) return;

            map = L.map('map').setView([currentLat, currentLng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

            // Eventos del mapa
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                marker.setLatLng([lat, lng]);
                updateHiddenInputs(lat, lng);

                document.getElementById('manual-latitude').value = lat.toFixed(6);
                document.getElementById('manual-longitude').value = lng.toFixed(6);
            });

            marker.on('dragend', function(e) {
                const lat = e.target.getLatLng().lat;
                const lng = e.target.getLatLng().lng;
                updateHiddenInputs(lat, lng);
                document.getElementById('manual-latitude').value = lat.toFixed(6);
                document.getElementById('manual-longitude').value = lng.toFixed(6);
            });
        }

        // Gestión de tabs
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => {
                    t.classList.remove('bg-blue-600', 'text-white');
                    t.classList.add('text-gray-600', 'dark:text-gray-400');
                });
                contents.forEach(content => content.classList.add('hidden'));

                this.classList.add('bg-blue-600', 'text-white');
                this.classList.remove('text-gray-600', 'dark:text-gray-400');

                const tabId = this.id.replace('-tab', '-content');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });

        // Toggle mapa
        toggleMapBtn.addEventListener('click', function() {
            if (mapContainer.classList.contains('hidden')) {
                mapContainer.classList.remove('hidden');
                this.innerHTML = '<i class="fas fa-eye-slash mr-1"></i>{{ __("Hide Map") }}';
                setTimeout(() => {
                    initMap();
                    map.invalidateSize();
                }, 100);
            } else {
                mapContainer.classList.add('hidden');
                this.innerHTML = '<i class="fas fa-eye mr-1"></i>{{ __("Show Map") }}';
            }
        });

        // Función GPS
        function getGPSLocation(showSpinner = false) {
            const btn = document.getElementById('refresh-location-btn');
            const status = document.getElementById('gps-status');

            if (showSpinner) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>{{ __("Getting...") }}';
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        updateHiddenInputs(lat, lng);
                        status.textContent = '{{ __("Location obtained successfully!") }}';
                        status.classList.remove('text-red-600');
                        status.classList.add('text-green-600');

                        document.getElementById('manual-latitude').value = lat.toFixed(6);
                        document.getElementById('manual-longitude').value = lng.toFixed(6);

                        if (!mapContainer.classList.contains('hidden') && map) {
                            map.setView([lat, lng], 16);
                            marker.setLatLng([lat, lng]);
                        }

                        if (showSpinner) {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-check mr-2"></i>{{ __("Updated") }}';
                            setTimeout(() => {
                                btn.innerHTML = '<i class="fas fa-sync mr-2"></i>{{ __("Refresh") }}';
                            }, 2000);
                        }
                    },
                    function(error) {
                        status.textContent = '{{ __("Could not get location. Use manual input.") }}';
                        status.classList.remove('text-green-600');
                        status.classList.add('text-red-600');

                        if (showSpinner) {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-sync mr-2"></i>{{ __("Refresh") }}';
                        }
                    }
                );
            }
        }

        // Obtener ubicación automáticamente al cargar
        getGPSLocation(false);

        // Botón refresh GPS
        document.getElementById('refresh-location-btn').addEventListener('click', function() {
            getGPSLocation(true);
        });

        // Inputs manuales - actualización en tiempo real
        document.getElementById('manual-latitude').addEventListener('input', function() {
            const lat = parseFloat(this.value);
            if (!isNaN(lat) && lat >= -90 && lat <= 90) {
                currentLat = lat;
                latInput.value = lat;
                if (map && !mapContainer.classList.contains('hidden')) {
                    marker.setLatLng([currentLat, currentLng]);
                    map.panTo([currentLat, currentLng]);
                    updateLocationSummary();
                }
            }
        });

        document.getElementById('manual-longitude').addEventListener('input', function() {
            const lng = parseFloat(this.value);
            if (!isNaN(lng) && lng >= -180 && lng <= 180) {
                currentLng = lng;
                lngInput.value = lng;
                if (map && !mapContainer.classList.contains('hidden')) {
                    marker.setLatLng([currentLat, currentLng]);
                    map.panTo([currentLat, currentLng]);
                    updateLocationSummary();
                }
            }
        });

        // Payment options (código existente)
        const paymentOptions = document.querySelectorAll(".payment-option");
        const selectedMethodText = document.getElementById('selected-method');

        function resetAllPaymentOptions() {
            paymentOptions.forEach(opt => {
                opt.style.border = '2px solid #d1d5db';
                opt.style.backgroundColor = 'white';
                const indicator = opt.querySelector(".payment-indicator");
                const dot = opt.querySelector(".dot");
                if (indicator) indicator.style.border = '2px solid #d1d5db';
                if (dot) dot.style.backgroundColor = 'transparent';
                const radio = opt.querySelector("input[type='radio']");
                if (radio) radio.checked = false;
            });
        }

        function selectPaymentOption(option) {
            resetAllPaymentOptions();
            option.style.border = '2px solid #2563eb';
            option.style.backgroundColor = '#eff6ff';

            const indicator = option.querySelector(".payment-indicator");
            const dot = option.querySelector(".dot");
            const radio = option.querySelector("input[type='radio']");

            if (indicator) indicator.style.border = '2px solid #3b82f6';
            if (dot) dot.style.backgroundColor = '#3b82f6';
            if (radio) {
                radio.checked = true;
                if (selectedMethodText) {
                    selectedMethodText.textContent = radio.value === 'cash' ? '{{ __("Cash Payment") }}' : 'PayPal';
                }
            }
        }

        paymentOptions.forEach(option => {
            option.addEventListener("click", function(e) {
                e.preventDefault();
                selectPaymentOption(this);
            });
        });

        // Seleccionar cash por defecto
        const cashOption = document.querySelector("input[value='cash']");
        if (cashOption) {
            selectPaymentOption(cashOption.closest('.payment-option'));
        }
    });
    </script>
    @endsection
</x-app-layout>
