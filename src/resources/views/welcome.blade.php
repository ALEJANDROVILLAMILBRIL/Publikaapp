<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'PublikaApp') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 min-h-screen">
        <!-- Header Estilo MercadoLibre -->
        <header class="bg-yellow-400 shadow-lg">
            <div class="container mx-auto px-4">
                <!-- Top Bar -->
                <div class="flex items-center justify-between py-2 text-sm">
                    <div class="flex space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                   class="text-gray-800 hover:text-gray-900 font-medium">
                                    {{ __('Dashboard') }}
                                </a>
                            @else
                                <a href="{{ url('/') }}"
                                   class="text-gray-800 hover:text-gray-900">
                                    {{ __('Home') }}
                                </a>
                                <a href="{{ route('login') }}"
                                   class="text-gray-800 hover:text-gray-900">
                                    {{ __('Log in') }}
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="text-gray-800 hover:text-gray-900">
                                        {{ __('Register') }}
                                    </a>
                                @endif
                            @endauth
                        @endif

                        <div class="flex items-center space-x-2">
                            <a href="{{ route('lang.switch', 'en') }}"
                               class="{{ app()->getLocale() === 'en' ? 'font-bold' : '' }} text-gray-800">
                               EN
                            </a>
                            <span class="text-gray-600">|</span>
                            <a href="{{ route('lang.switch', 'es') }}"
                               class="{{ app()->getLocale() === 'es' ? 'font-bold' : '' }} text-gray-800">
                               ES
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Header -->
                <div class="flex items-center py-4">
                    <!-- Logo -->
                    <div class="flex-shrink-0 mr-8">
                        <img
                            src="{{ asset('images/LogoPA.png') }}"
                            alt="Logo"
                            class="w-20 h-20 fill-current text-gray-500 object-contain"
                        />
                    </div>

                    <!-- Search Bar -->
                    <div class="flex-1 max-w-2xl mx-4">
                        <form action="{{ route('homepage') }}" method="GET">
                            <div class="relative flex">
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="{{ __("Search products, brands and more...") }}"
                                    class="w-full px-4 py-3 rounded-l-sm border-0 focus:outline-none text-gray-700 shadow-sm"
                                >
                                <button type="submit" class="bg-white px-4 py-3 border-l border-gray-300 rounded-r-sm hover:bg-gray-50 shadow-sm">
                                    <i class="fas fa-search text-gray-600"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Cart -->
                    <div class="flex items-center ml-4">
                            <a href="{{ route('carts.index') }}" class="flex items-center text-gray-800 hover:text-gray-900 relative">
                            <i class="fas fa-shopping-cart text-xl mr-2"></i>

                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-6">

            <!-- Products Section -->
            @if ($products->count())
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">{{ __('Featured Products') }}</h2>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($products as $product)
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow cursor-pointer border border-gray-200">
                            <div class="relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-48 object-cover rounded-t-lg">
                                @else
                                    <img src="{{ asset('images/products/product-image.svg') }}"
                                        alt="Default image"
                                        class="w-full h-48 object-cover rounded-t-lg bg-gray-100">
                                @endif

                                @if($product->quantity > 0)
                                    <div class="absolute top-2 left-2">
                                        <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">{{ __('AVAILABLE') }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <h3 class="text-sm text-gray-800 mb-2 line-clamp-2 hover:text-blue-600">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-xs text-gray-500 mb-2">
                                    {{ $product->category->name ?? __('Uncategorized') }}
                                </p>
                                <div class="mb-3">
                                    <div class="text-2xl font-bold text-gray-900">
                                        ${{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 mb-3 line-clamp-2">
                                    {{ $product->description }}
                                </p>
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                    <span>{{ __('Stock') }}: {{ $product->quantity }}</span>
                                    @if($product->quantity < 5)
                                        <span class="text-orange-600 font-medium">{{ __('Last units!') }}</span>
                                    @endif
                                </div>
                                @auth
                                    <form action="{{ route('carts.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors text-sm font-medium">
                                            {{ __('Add to Cart') }}
                                        </button>
                                    </form>
                                @else
                                    <button onclick="showLoginAlert()" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors text-sm font-medium">
                                        {{ __('Add to Cart') }}
                                    </button>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-8">
                    {{ $products->appends(request()->except('page'))->links('vendor.pagination.custom') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="bg-white rounded-lg shadow-sm p-8 max-w-md mx-auto">
                        <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('No products available') }}</h3>
                        <p class="text-gray-600 mb-4">{{ __('We are working to add new products soon') }}</p>
                        <button class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition-colors">
                            {{ __('Browse Categories') }}
                        </button>
                    </div>
                </div>
            @endif
        </div>

       <!-- Footer -->
        <footer class="bg-yellow-400 border-t mt-12">
            <div class="container mx-auto px-4 py-6 flex flex-col md:flex-row items-center justify-between">
                <!-- Brand -->
                <div class="mb-4 md:mb-0 text-black font-semibold text-lg">
                    <img
                        src="{{ asset('images/LogoPA.png') }}"
                        alt="Logo"
                        class="w-20 h-20 fill-current text-gray-500 object-contain"
                    />
                </div>

                <!-- Social Icons -->
                <div class="flex space-x-4">
                    <a href="#" class="text-black hover:text-gray-800">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="#" class="text-black hover:text-gray-800">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-black hover:text-gray-800">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-black hover:text-gray-800">
                        <i class="fab fa-youtube text-xl"></i>
                    </a>
                </div>

                <!-- Copyright -->
                <div class="mt-4 md:mt-0 text-black text-sm">
                    &copy; {{ date('Y') }} PublikaApp. {{ __('All rights reserved.') }}.
                </div>
            </div>
        </footer>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript">
            function showLoginAlert() {
                swal({
                    title: "{{ __('Sign in required') }}",
                    text: "{{ __('You need to sign in to add products to your cart') }}",
                    icon: 'info',
                    buttons: {
                        cancel: "{{ __('Cancel') }}",
                        login: {
                            text: "{{ __('Sign In') }}",
                            value: "login",
                            className: "btn-primary"
                        }
                    }
                }).then((value) => {
                    if (value === "login") {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            }
        </script>
        @include('components.accessibility-menu')
    </body>
</html>
