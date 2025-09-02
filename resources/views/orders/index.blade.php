<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr>
                                <th class="px-3 py-2 text-left">Código</th>
                                <th class="px-3 py-2">Status</th>
                                <th class="px-3 py-2">Itens</th>
                                <th class="px-3 py-2">Total</th>
                                <th class="px-3 py-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-t">
                                    <td class="px-3 py-2">{{ $order->code }}</td>
                                    <td class="px-3 py-2">{{ ucfirst($order->status) }}</td>
                                    <td class="px-3 py-2">{{ $order->items->sum('quantity') }}</td>
                                    <td class="px-3 py-2">
                                        R$ {{ number_format($order->total_cents, 2, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2 space-x-2">
                                        <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:underline">
                                            Ver
                                        </a>
                                        @if($order->isPendente())
                                            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:underline">
                                                    Cancelar
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('orders.ticket', $order) }}" class="text-green-600 hover:underline">
                                            Ficha (PDF)
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
