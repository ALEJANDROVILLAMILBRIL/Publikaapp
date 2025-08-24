<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fas fa-comments"></i>
            {{ __('Order comments #:') }} {{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if($actions->isEmpty())
            <div class="text-center py-16">
                <i class="fas fa-comment-slash text-6xl text-gray-300 mb-6"></i>
                <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('No comments yet') }}</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($actions as $action)
                    <div class="p-4 bg-white dark:bg-gray-900 shadow-md rounded-xl border-l-4
                        {{ $action->action_type === 'return_request' ? 'border-red-500' : 'border-yellow-500' }}">

                        {{-- Encabezado --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3">
                            <span class="text-base font-semibold text-gray-800 dark:text-gray-200">
                                {{ $action->action_type === 'return_request' ? __('Return request') : __('Incident report') }}
                            </span>
                            <span class="text-xs text-gray-500 mt-1 sm:mt-0">
                                {{ $action->created_at->diffForHumans() }}
                            </span>
                        </div>

                        {{-- Descripción --}}
                        <p class="text-gray-700 dark:text-gray-400 text-sm mb-3">
                            {{ $action->description }}
                        </p>

                        {{-- Contacto --}}
                        <div class="flex flex-col gap-1 text-sm text-gray-600 dark:text-gray-400">
                            @if(!empty($action->phone_number))
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-phone text-gray-500"></i>
                                    <span>{{ $action->phone_number }}</span>
                                </div>
                            @endif
                            @if(!empty($action->email))
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-envelope text-gray-500"></i>
                                    <a href="mailto:{{ $action->email }}"
                                       class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $action->email }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Estado y resolución --}}
                        <div class="mt-4">
                            @if(($action->solved_by_seller || $action->solved_by_admin) && $action->solved_by_user)
                                {{-- Completamente resuelto (seller/admin Y usuario) --}}
                                <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fas fa-check-circle text-green-600"></i>
                                        <span class="text-green-600 dark:text-green-400 font-semibold">{{ __('Fully resolved') }}</span>
                                    </div>
                                    @if(!empty($action->solution_notes))
                                        <p class="text-sm text-green-700 dark:text-green-300">
                                            <strong>{{ __('Solution notes') }}:</strong> {{ $action->solution_notes }}
                                        </p>
                                    @endif
                                </div>
                            @elseif($action->solved_by_seller || $action->solved_by_admin)
                                {{-- Resuelto por seller/admin, esperando confirmación del usuario --}}
                                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fas fa-clock text-blue-600"></i>
                                        <span class="text-blue-600 dark:text-blue-400 font-semibold">{{ __('Awaiting customer confirmation') }}</span>
                                    </div>
                                    @if(!empty($action->solution_notes))
                                        <p class="text-sm text-blue-700 dark:text-blue-300">
                                            <strong>{{ __('Solution provided') }}:</strong> {{ $action->solution_notes }}
                                        </p>
                                    @endif
                                </div>
                            @else
                                {{-- Pendiente de resolución - Mostrar formulario --}}
                                <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                    <div class="flex items-center gap-2 mb-3">
                                        <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                        <span class="text-yellow-600 dark:text-yellow-400 font-semibold">{{ __('Pending resolution') }}</span>
                                    </div>

                                    <form id="resolveForm_{{ $action->id }}" action="{{ route('orders.actions.resolve', $action) }}" method="POST" class="space-y-3">
                                        @csrf
                                        @method('PATCH')

                                        {{-- Campo opcional para notas de solución --}}
                                        <div class="mb-8">
                                            <label for="solution_notes_{{ $action->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                {{ __('Solution notes') }} <span class="text-gray-500">({{ __('Optional') }})</span>
                                            </label>
                                            <textarea
                                                id="solution_notes_{{ $action->id }}"
                                                name="solution_notes"
                                                rows="3"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                                       bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100
                                                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                                placeholder="{{ __('Describe how this issue was resolved or what action was taken...') }}"></textarea>
                                        </div>

                                        {{-- Botón resolver --}}
                                        <button type="button"
                                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700
                                                       text-white font-medium rounded-lg shadow-sm transition-colors duration-200
                                                       focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                                onclick="confirmResolve('{{ $action->id }}')">
                                            <i class="fas fa-check mr-2"></i>
                                            {{ __('Resolve report') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    @section('script')
        <script type="text/javascript">
        function confirmResolve(actionId) {
            swal({
                title: @json(__('Are you sure?')),
                text: @json(__('Are you sure you want to mark this report as resolved?')),
                icon: 'warning',
                buttons: {
                    cancel: @json(__('Cancel')),
                    confirm: {
                        text: @json(__('Resolve report')),
                        value: true,
                        className: 'btn-success'
                    }
                },
                dangerMode: false
            }).then((willResolve) => {
                if (willResolve) {
                    document.getElementById('resolveForm_' + actionId).submit();
                }
            });
        }
        </script>
    @endsection
</x-app-layout>
