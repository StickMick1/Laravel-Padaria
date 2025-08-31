<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Movimentação de Estoque</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <a href="{{ route('stockmovements.create') }}" 
           class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">
           Registrar Movimentação
        </a>

        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Produto</th>
                    <th class="px-4 py-2">Tipo</th>
                    <th class="px-4 py-2">Quantidade</th>
                    <th class="px-4 py-2">Motivo</th>
                    <th class="px-4 py-2">Estoque Antes</th>
                    <th class="px-4 py-2">Estoque Depois</th>
                    <th class="px-4 py-2">Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movements as $movement)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $movement->product->name }}</td>
                    <td class="px-4 py-2">{{ ucfirst($movement->type) }}</td>
                    <td class="px-4 py-2">{{ $movement->quantity }}</td>
                    <td class="px-4 py-2">{{ $movement->reason }}</td>
                    <td class="px-4 py-2">{{ $movement->stock_before }}</td>
                    <td class="px-4 py-2">{{ $movement->stock_after }}</td>
                    <td class="px-4 py-2">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $movements->links() }}
        </div>
    </div>
</x-app-layout>
