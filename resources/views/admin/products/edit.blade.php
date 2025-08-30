<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Editar Produto</h2>
    </x-slot>

    <div class="max-w-lg mx-auto mt-6">
        <form method="POST" action="{{ route('products.update', $product) }}" 
              enctype="multipart/form-data"
              class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block">Nome</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                       class="w-full border rounded px-3 py-2">
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block">Categoria</label>
                <select name="category_id" class="w-full border rounded px-3 py-2">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            @selected(old('category_id', $product->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block">Preço (centavos)</label>
                <input type="number" name="unit_price" 
                       value="{{ old('unit_price', $product->unit_price) }}" 
                       class="w-full border rounded px-3 py-2">
                @error('unit_price')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block">Imagem</label>
                @if($product->image_path)
                    <img src="{{ asset('storage/'.$product->image_path) }}" 
                         alt="{{ $product->name }}" class="h-20 mb-2">
                @endif
                <input type="file" name="image" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="active" @selected($product->status === 'ativo')>Ativo</option>
                    <option value="inactive" @selected($product->status === 'inativo')>Inativo</option>
                </select>
            </div>

            <button class="bg-blue-500 text-white px-4 py-2 rounded">Atualizar</button>
            <a href="{{ route('products.index') }}" class="ml-2 text-gray-600">Cancelar</a>
        </form>
    </div>
</x-app-layout>
