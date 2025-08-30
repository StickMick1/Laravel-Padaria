<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Produtos</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <a href="{{ route('products.create') }}" 
           class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">
           Novo Produto
        </a>

        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nome</th>
                    <th class="px-4 py-2">Categoria</th>
                    <th class="px-4 py-2">Preço</th>
                    <th class="px-4 py-2">Estoque</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $product->id }}</td>
                    <td class="px-4 py-2">{{ $product->name }}</td>
                    <td class="px-4 py-2">{{ $product->category->name }}</td>
                    <td class="px-4 py-2">R$ {{ number_format($product->unit_price, 2, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $product->stock }}</td>
                    <td class="px-4 py-2">{{ $product->status }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('products.edit', $product) }}" class="text-blue-500">Editar</a>
                        <form action="{{ route('products.destroy', $product) }}" 
                              method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-500 ml-2">Desativar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
