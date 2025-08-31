<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Novo Produto</h2>
    </x-slot>

    <div class="max-w-lg mx-auto mt-6">
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data"
              class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label class="block">Nome</label>
                <input type="text" name="name" value="{{ old('name') }}" 
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
                            @selected(old('category_id') == $category->id)>
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
                <input type="number" name="unit_price" value="{{ old('unit_price') }}" 
                       class="w-full border rounded px-3 py-2">
                @error('unit_price')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block">Imagem</label>
                <input type="file" name="image" class="w-full border rounded px-3 py-2">
                @error('image')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="ativo" @selected(old('status') === 'ativo')>Ativo</option>
                    <option value="inativo" @selected(old('status') === 'inativo')>Inativo</option>
                </select>
            </div>

            <button class="bg-green-500 text-white px-4 py-2 rounded">Salvar</button>
            <a href="{{ route('products.index') }}" class="ml-2 text-gray-600">Cancelar</a>
        </form>
    </div>
</x-app-layout>
