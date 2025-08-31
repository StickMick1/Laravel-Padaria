<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Registrar Movimentação de Estoque</h2>
    </x-slot>

    <div class="max-w-lg mx-auto mt-6">
        <form method="POST" action="{{ route('stockmovements.store') }}" enctype="multipart/form-data"
              class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label class="block">Produto</label>
            
                <select name="product_id" class="form-control">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block">Tipo</label>
                <select name="type" class="form-control">
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block">Quantidade</label>
                <input type="number" name="quantity" class="form-control">
            </div>

            <div class="mb-4">
                <label class="block">Motivo</label>
                <input type="text" name="reason" class="form-control">
            </div>

            <button class="bg-green-500 text-white px-4 py-2 rounded">Salvar</button>
            <a href="{{ route('stockmovements.index') }}" class="ml-2 text-gray-600">Cancelar</a>
        </form>
    </div>
</x-app-layout>
