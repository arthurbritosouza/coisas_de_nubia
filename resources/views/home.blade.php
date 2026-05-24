@extends('layouts.app')

@section('title', 'Início')
@section('description', 'Artesanatos feitos com amor: crochê, bordados, pão de mel e muito mais. Encomende pelo WhatsApp!')

@section('content')

{{-- Hero --}}
<section style="background: linear-gradient(135deg, #FDF0F0 0%, #FDF8F5 100%);" class="py-20 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="font-display text-5xl md:text-6xl font-bold text-[#3D2C2C] leading-tight">
            Artesanatos feitos<br>
            <span class="text-[#C97B7B]">com amor</span> 🌸
        </h1>
        <p class="mt-6 text-lg text-gray-600 max-w-xl mx-auto leading-relaxed">
            Cada peça é única, criada à mão pela Núbia com muito carinho e dedicação.
            Crochê, bordados, pão de mel e muito mais!
        </p>
        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/croche"
               class="bg-[#E8A0A0] hover:bg-[#C97B7B] text-white px-8 py-3 rounded-full font-medium transition-colors">
                Ver artesanatos
            </a>
            <a href="https://wa.me/{{ config('products.whatsapp') }}" target="_blank"
               class="border-2 border-[#E8A0A0] text-[#C97B7B] hover:bg-[#E8A0A0] hover:text-white px-8 py-3 rounded-full font-medium transition-colors">
                Falar no WhatsApp
            </a>
        </div>
    </div>
</section>

{{-- Sobre a Núbia --}}
<section class="max-w-4xl mx-auto px-4 py-16 text-center">
    <div class="bg-white rounded-3xl p-10 shadow-sm">
        <div class="w-24 h-24 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6 text-5xl">
            🧶
        </div>
        <h2 class="font-display text-3xl font-bold text-[#3D2C2C]">Quem é a Núbia?</h2>
        <p class="mt-4 text-gray-600 leading-relaxed max-w-2xl mx-auto">
            Apaixonada pelo artesanato, a Núbia cria peças únicas com muito cuidado e amor.
            De tapetes de crochê a pães de mel irresistíveis, cada trabalho carrega um pedacinho
            do seu coração. Faça seu pedido e leve um presente especial para quem você ama!
        </p>
    </div>
</section>

{{-- Categorias --}}
<section class="max-w-6xl mx-auto px-4 pb-8">
    <h2 class="text-center font-display text-3xl font-bold text-[#3D2C2C] mb-10">Nossas categorias</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="/croche"
           class="group bg-white rounded-2xl p-8 text-center shadow-sm hover:shadow-md transition-all hover:-translate-y-1 duration-200">
            <span class="text-5xl">🧶</span>
            <h3 class="mt-4 font-semibold text-xl text-[#3D2C2C] group-hover:text-[#C97B7B] transition-colors">Crochê</h3>
            <p class="text-sm text-gray-500 mt-2">Tapetes, almofadas, saquinhos e muito mais</p>
        </a>
        <a href="/bordados"
           class="group bg-white rounded-2xl p-8 text-center shadow-sm hover:shadow-md transition-all hover:-translate-y-1 duration-200">
            <span class="text-5xl">🪡</span>
            <h3 class="mt-4 font-semibold text-xl text-[#3D2C2C] group-hover:text-[#C97B7B] transition-colors">Bordados</h3>
            <p class="text-sm text-gray-500 mt-2">Panos de prato, toalhas e caminhos de mesa</p>
        </a>
        <a href="/doces"
           class="group bg-white rounded-2xl p-8 text-center shadow-sm hover:shadow-md transition-all hover:-translate-y-1 duration-200">
            <span class="text-5xl">🍯</span>
            <h3 class="mt-4 font-semibold text-xl text-[#3D2C2C] group-hover:text-[#C97B7B] transition-colors">Doces</h3>
            <p class="text-sm text-gray-500 mt-2">Pão de mel, bolos no pote e delícias artesanais</p>
        </a>
    </div>
</section>

{{-- Destaques --}}
<section class="max-w-6xl mx-auto px-4 py-16">
    <h2 class="text-center font-display text-3xl font-bold text-[#3D2C2C] mb-2">Destaques</h2>
    <p class="text-center text-gray-500 mb-10">Uma seleção especial de cada categoria</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($destaques as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
    <div class="text-center mt-10">
        <a href="/croche" class="text-[#C97B7B] hover:underline text-sm font-medium">Ver todos os artesanatos →</a>
    </div>
</section>

@endsection
