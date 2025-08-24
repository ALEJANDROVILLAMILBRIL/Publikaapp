<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 flex items-center gap-2">
            <i class="fas fa-comments"></i>
            {{ __('My Reports') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if($actions->isEmpty())
            <div class="text-center py-16">
                <i class="fas fa-comment-slash text-6xl text-gray-300 mb-6"></i>
                <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('No reports yet') }}</p>
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

                        {{-- Orden asociada --}}
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            {{ __('Order #:') }} {{ $action->order->order_number ?? __('Unknown') }}
                        </p>

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

                        {{-- Estado de solución --}}
                        <div class="mt-4">
                            @if(($action->solved_by_seller || $action->solved_by_admin) && $action->solved_by_user)
                                <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fas fa-check-circle text-green-600"></i>
                                        <span class="text-green-600 dark:text-green-400 font-semibold">{{ __('Fully resolved') }}</span>
                                    </div>
                                    @if(!empty($action->solution_notes))
                                        <p class="text-sm text-green-700 dark:text-green-300">
                                            <strong>{{ __('Solution provided') }}:</strong> {{ $action->solution_notes }}
                                        </p>
                                    @endif
                                </div>
                            @elseif($action->solved_by_seller || $action->solved_by_admin)
                                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                    <div class="flex items-center gap-2 mb-3">
                                        <i class="fas fa-info-circle text-blue-600"></i>
                                        <span class="text-blue-600 dark:text-blue-400 font-semibold">{{ __('Solution provided - Awaiting your confirmation') }}</span>
                                    </div>

                                    @if(!empty($action->solution_notes))
                                        <div class="mb-4 p-3 bg-blue-100 dark:bg-blue-800/30 rounded-md">
                                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                                <strong>{{ __('Solution details') }}:</strong><br>
                                                {{ $action->solution_notes }}
                                            </p>
                                        </div>
                                    @endif

                                    <p class="text-sm text-blue-700 dark:text-blue-300 mb-8">
                                        {{ __('The seller/administrator has addressed your report. Please review the solution and confirm if the issue has been resolved to your satisfaction.') }}
                                    </p>

                                    {{-- Botón para confirmar resolución --}}
                                    <form id="confirmForm_{{ $action->id }}" action="{{ route('customer.orders.actions.confirm', $action) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button"
                                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700
                                                       text-white font-medium rounded-lg shadow-sm transition-colors duration-200
                                                       focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                                onclick="confirmResolution('{{ $action->id }}')">
                                            <i class="fas fa-thumbs-up mr-2"></i>
                                            {{ __('Confirm resolution') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                {{-- Pendiente resolución --}}
                                <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-hourglass-half text-yellow-600"></i>
                                        <span class="text-yellow-600 dark:text-yellow-400 font-semibold">{{ __('Pending resolution') }}</span>
                                    </div>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                                        {{ __('Your report is being reviewed by our team. You will be notified once a solution is provided.') }}
                                    </p>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="mt-6">
                {{ $actions->links() }}
            </div>
        @endif
    </div>
    @section('script')
        <script type="text/javascript">
        function confirmResolution(actionId) {
            swal({
                title: @json(__('Confirm resolution?')),
                text: @json(__('Are you satisfied with the solution provided? This will mark the report as fully resolved.')),
                icon: 'question',
                buttons: {
                    cancel: @json(__('Cancel')),
                    confirm: {
                        text: @json(__('Confirm resolution')),
                        value: true,
                        className: 'btn-success'
                    }
                },
                dangerMode: false
            }).then((willConfirm) => {
                if (willConfirm) {
                    document.getElementById('confirmForm_' + actionId).submit();
                }
            });
        }
        </script>
    @endsection
</x-app-layout>
