<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Errores de validación --}}
                    @if ($errors->any())
                        <div class="mb-4 text-red-500">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user->slug) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nombre (solo lectura) -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Name') }}
                            </label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $user->name) }}"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border
                                border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2"
                                readonly>
                        </div>

                        <!-- Email (solo lectura) -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Email') }}
                            </label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $user->email) }}"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border
                                border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2"
                                readonly>
                        </div>

                        <!-- Password -->
                        <div class="mb-4 input-group">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Password') }}
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                    class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border
                                    border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2 pr-10">
                                <button type="button" onclick="togglePassword('password', this)"
                                    class="toggle-eye">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4 input-group">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Confirm Password') }}
                            </label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border
                                    border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2 pr-10">
                                <button type="button" onclick="togglePassword('password_confirmation', this)"
                                    class="toggle-eye">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Rol -->
                        <div class="mb-4">
                            <label for="role_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Role') }}
                            </label>
                            <select name="role_id" id="role_id"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border
                                border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2"
                                required>
                                <option value="">{{ __('- Select -') }}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        @selected(old('role_id', $user->role_id) == $role->id)>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Departamento -->
                        <div class="mb-4">
                            <label for="region_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Department') }}
                            </label>
                            <select id="region_id" name="region_id"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border
                                    border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2"
                                required>
                                <option value="">{{ __('- Select -') }}</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}"
                                        @selected(old('region_id', $user->region_id) == $region->id)>
                                        {{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ciudad -->
                        <div class="mb-4">
                            <label for="city_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('City') }}
                            </label>
                            <select id="city_id" name="city_id"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border
                                    border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2"
                                required>
                                <option value="">{{ __('- Select -') }}</option>
                            </select>
                        </div>

                        <!-- Dirección -->
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Address') }}
                            </label>
                            <input type="text" name="address" id="address"
                                value="{{ old('address', $user->address) }}"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border
                                border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2">
                        </div>

                        <!-- Teléfono -->
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Phone') }}
                            </label>
                            <input type="text" name="phone" id="phone"
                                value="{{ old('phone', $user->phone) }}"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-700 border
                                border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 p-2">
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.users.index') }}"
                                class="mr-4 inline-block bg-gray-500 hover:bg-gray-600 text-white
                                text-sm font-semibold px-4 py-2 rounded">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                class="inline-block bg-blue-600 hover:bg-blue-700 text-white
                                text-sm font-semibold px-4 py-2 rounded">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <style>
    .input-group {
        position: relative;
        width: 100%;
    }

    .input-group input {
        width: 100%;
        padding-right: 2.5rem;
        box-sizing: border-box;
    }

    .toggle-eye {
        position: absolute;
        top: 50%;
        right: 0.75rem;
        transform: translateY(-50%);
        cursor: pointer;
        background: none;
        border: none;
        color: #666;
    }

    .toggle-eye:hover {
        color: #111;
    }
    </style>
    @section('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const cities = @json($cities);
                const regionSelect = document.getElementById('region_id');
                const citySelect = document.getElementById('city_id');

                function populateCities(regionId, selectedCityId = null) {
                    citySelect.innerHTML = '<option value="">{{ __("- Select -") }}</option>';

                    const filtered = cities.filter(c => c.region_id == regionId);
                    filtered.forEach(c => {
                        const opt = document.createElement('option');
                        opt.value = c.id;
                        opt.textContent = c.name;
                        citySelect.appendChild(opt);
                    });

                    if(selectedCityId) {
                        citySelect.value = selectedCityId;
                    }
                }

                regionSelect.addEventListener('change', function() {
                    populateCities(this.value);
                });

                const userCityId = '{{ old('city_id', $user->city_id) }}';
                const userCity = cities.find(c => c.id == userCityId);
                const initialRegion = userCity ? userCity.region_id : null;

                if(initialRegion) {
                    regionSelect.value = initialRegion;
                    populateCities(initialRegion, userCityId);
                }
            });
            function togglePassword(fieldId, button) {
                const input = document.getElementById(fieldId);
                const icon = button.querySelector("i");
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    input.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            }
        </script>
    @endsection
</x-app-layout>
