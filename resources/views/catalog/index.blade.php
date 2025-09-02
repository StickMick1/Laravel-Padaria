<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catálogo de Produtos') }}
        </h2>
    </x-slot>

    <div class="py-6 px-2 sm:px-4 lg:px-8">
        <!-- Container flexível com wrap -->
        <div class="max-w-7xl mx-auto flex flex-wrap justify-start gap-3">
            @forelse($products as $product)
                <!-- Mini card -->
                <div class="bg-white shadow rounded-md overflow-hidden flex flex-col flex-shrink-0 w-32 sm:w-36 md:w-40 lg:w-36">
                    @if($product->image_path)
                        <img src="{{ asset('storage/'.$product->image_path) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-20 sm:h-24 md:h-28 lg:h-24 object-cover">
                    @endif
                    <div class="p-2 flex flex-col flex-1">
                        <h3 class="text-xs sm:text-sm font-semibold truncate">{{ $product->name }}</h3>
                        <p class="text-gray-600 mt-1 text-xs sm:text-sm">R$ {{ number_format($product->unit_price, 2, ',', '.') }}</p>
                        <a href="{{ route('catalog.show', $product) }}"
                           class="mt-auto inline-block mt-1 px-2 py-1 bg-blue-600 text-white text-xs sm:text-sm rounded hover:bg-blue-700 text-center">
                            Add Carrinho
                        </a>
                    </div>
                </div>
            @empty
                <p class="w-full text-center text-gray-500">Nenhum produto disponível no momento.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>




