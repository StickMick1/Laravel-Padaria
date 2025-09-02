<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pedidos (Admin)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="GET" class="mb-4">
                        <select name="status" onchange="this.form.submit()" class="border rounded p-2">
                            <option value="">-- Todos --</option>
                            @foreach(['pendente','aprovado','cancelado','entregue'] as $st)
                                <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                    </form>

                    <table class="min-w-full text-sm">
                        <thead>
                            <tr>
                                <th class="px-3 py-2 text-left">Código</th>
                                <th class="px-3 py-2">Cliente</th>
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
                                    <td class="px-3 py-2">{{ $order->user->name }}</td>
                                    <td class="px-3 py-2">{{ ucfirst($order->status) }}</td>
                                    <td class="px-3 py-2">{{ $order->items->sum('quantity') }}</td>
                                    <td class="px-3 py-2">
                                        R$ {{ number_format($order->total_cents, 2, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2 space-x-2">
                                        @if($order->isPendente())
                                            <form method="POST" action="{{ route('admin.orders.approve',$order) }}" class="inline">
                                                @csrf
                                                <button class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700">Aprovar</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.orders.cancel',$order) }}" class="inline">
                                                @csrf
                                                <button class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Cancelar</button>
                                            </form>
                                        @elseif($order->isAprovado())
                                            <form method="POST" action="{{ route('admin.orders.deliver',$order) }}" class="inline">
                                                @csrf
                                                <button class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Dar Baixa</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.orders.cancel',$order) }}" class="inline">
                                                @csrf
                                                <button class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Cancelar + Estorno</button>
                                            </form>
                                        @endif
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
