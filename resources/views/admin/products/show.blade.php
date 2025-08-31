<x-app-layout>
    <div class="container">
        <h1>Detalhes do Produto</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h3>{{ $product->name }}</h3>
                <p><strong>Categoria:</strong> {{ $product->category->name ?? 'Sem categoria' }}</p>
                <p><strong>Preço unitário:</strong> R$ {{ number_format($product->unit_price, 2, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($product->status) }}</p>
                <p><strong>Estoque Atual:</strong> {{ $product->current_stock }}</p>
                @if($product->image_path)
                    <p><img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" width="150"></p>
                @endif
            </div>
        </div>

        <h3>Histórico de Movimentações</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Quantidade</th>
                    <th>Motivo</th>
                    <th>Estoque Antes</th>
                    <th>Estoque Depois</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $movement)
                    <tr>
                        <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($movement->type === 'entrada')
                                <span class="text-success">Entrada</span>
                            @else
                                <span class="text-danger">Saída</span>
                            @endif
                        </td>
                        <td>{{ $movement->quantity }}</td>
                        <td>{{ $movement->reason }}</td>
                        <td>{{ $movement->stock_before }}</td>
                        <td>{{ $movement->stock_after }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhuma movimentação registrada para este produto.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Voltar</a>
    </div>
</x-app-layout>
