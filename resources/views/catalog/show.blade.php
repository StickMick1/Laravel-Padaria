<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-6 px-2 sm:px-4 lg:px-8 flex justify-center">
        <!-- Card compacto centralizado, igual ao mini-card do catálogo -->
        <div class="bg-white shadow rounded-md overflow-hidden flex flex-col w-32 sm:w-36 md:w-40 lg:w-36">
            
            <!-- Imagem do produto -->
            @if($product->image_path)
                <img src="{{ asset('storage/'.$product->image_path) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-20 sm:h-24 md:h-28 lg:h-24 object-cover">
            @else
                <div class="w-full h-20 sm:h-24 md:h-28 lg:h-24 bg-gray-100 flex items-center justify-center">
                    <span class="text-gray-400 text-xs">Sem imagem</span>
                </div>
            @endif

            <!-- Informações compactas -->
            <div class="p-2 flex flex-col flex-1">
                <h3 class="text-xs sm:text-sm font-semibold truncate">{{ $product->name }}</h3>
                <p class="text-gray-600 mt-1 text-xs sm:text-sm">R$ {{ number_format($product->unit_price, 2, ',', '.') }}</p>

                <!-- Formulário compacto -->
                <form action="{{ route('orders.store') }}" method="POST" class="mt-1 space-y-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center gap-1">
                        <label class="text-xs text-gray-700">Qtd:</label>
                        <input type="number" name="quantity" value="1" min="1"
                               class="border rounded p-1 w-12 text-xs">
                    </div>
                    <button type="submit"
                            class="w-full px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                        Comprar
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
