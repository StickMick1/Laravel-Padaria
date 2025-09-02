<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pedido {{ $order->code }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Total:</strong> R$ {{ number_format($order->total_cents, 2, ',', '.') }}</p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-3">Itens</h3>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr>
                            <th class="px-3 py-2 text-left">Produto</th>
                            <th class="px-3 py-2">Qtd</th>
                            <th class="px-3 py-2">Unit</th>
                            <th class="px-3 py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr class="border-t">
                                <td class="px-3 py-2">{{ $item->product->name }}</td>
                                <td class="px-3 py-2">{{ $item->quantity }}</td>
                                <td class="px-3 py-2">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                                <td class="px-3 py-2">R$ {{ number_format($item->total_cents, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex space-x-4">
                        <a href="{{ route('orders.pdf', $order) }}" target="_blank" style="display:inline-block; padding:8px 16px; background:#007bff; color:#fff; text-decoration:none; border-radius:4px;">
                            Baixar PDF
                        </a>

                @if($order->isPendente())
                    <form action="{{ route('orders.cancel', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Cancelar Pedido
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>