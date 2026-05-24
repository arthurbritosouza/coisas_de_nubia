@props(['product'])

@php
    $whatsapp = config('products.whatsapp');
    $message  = urlencode("Olá Núbia! Vi o produto *{$product['name']}* no site e tenho interesse 😊");

    // Suporta formato novo (array de mídia) e formato antigo (type + media únicos)
    if (!empty($product['media']) && is_array($product['media']) && isset($product['media'][0]) && is_array($product['media'][0])) {
        $mediaItems = $product['media'];
    } elseif (!empty($product['media'])) {
        $mediaItems = [['type' => $product['type'] ?? 'image', 'src' => $product['media']]];
    } else {
        $mediaItems = [];
    }
    $total = count($mediaItems);
@endphp

<div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition-all hover:-translate-y-1 duration-200"
     x-data="{ current: 0 }">

    {{-- Área de mídia com carrossel --}}
    <div class="aspect-square bg-pink-50 overflow-hidden relative">
        @if($total > 0)
            @foreach($mediaItems as $i => $item)
                <div x-show="current === {{ $i }}"
                     x-transition:enter="transition-opacity duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="absolute inset-0 w-full h-full">
                    @if($item['type'] === 'video')
                        <video class="w-full h-full object-cover"
                               autoplay muted loop playsinline preload="metadata"
                               src="{{ $item['src'] }}"></video>
                    @else
                        <img src="{{ $item['src'] }}"
                             alt="{{ $product['name'] }}"
                             class="w-full h-full object-cover" loading="lazy">
                    @endif
                </div>
            @endforeach

            @if($total > 1)
                {{-- Setas --}}
                <button @click="current = (current - 1 + {{ $total }}) % {{ $total }}"
                        class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg leading-none transition-colors">
                    ‹
                </button>
                <button @click="current = (current + 1) % {{ $total }}"
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg leading-none transition-colors">
                    ›
                </button>

                {{-- Bolinhas --}}
                <div class="absolute bottom-2 left-0 right-0 flex justify-center gap-1.5">
                    @for($i = 0; $i < $total; $i++)
                        <button @click="current = {{ $i }}"
                                :class="current === {{ $i }} ? 'bg-white scale-110' : 'bg-white/50'"
                                class="w-2 h-2 rounded-full transition-all duration-200"></button>
                    @endfor
                </div>
            @endif
        @else
            <div class="w-full h-full flex flex-col items-center justify-center gap-3">
                <svg class="w-14 h-14 text-[#E8A0A0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-xs text-[#E8A0A0] font-medium">Em breve</span>
            </div>
        @endif
    </div>

    {{-- Info --}}
    <div class="p-4">
        <h3 class="font-semibold text-[#3D2C2C] leading-tight">{{ $product['name'] }}</h3>
        <p class="text-sm text-gray-500 mt-1 leading-relaxed">{{ $product['description'] }}</p>

        @if(!empty($product['price']))
            <p class="text-[#C97B7B] font-bold text-lg mt-2">R$ {{ $product['price'] }}</p>
        @endif

        <a href="https://wa.me/{{ $whatsapp }}?text={{ $message }}"
           target="_blank" rel="noopener"
           class="mt-4 block text-center bg-[#E8A0A0] hover:bg-[#C97B7B] text-white rounded-full py-2.5 text-sm font-medium transition-colors">
            Tenho interesse!
        </a>
    </div>
</div>
