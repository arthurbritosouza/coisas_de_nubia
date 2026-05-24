@extends('layouts.app')

@section('title', 'Doces')
@section('description', 'Doces artesanais: pão de mel recheado, bolos no pote e muito mais.')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <span class="text-6xl">🍯</span>
        <h1 class="font-display text-4xl font-bold text-[#3D2C2C] mt-4">Doces</h1>
        <p class="text-gray-500 mt-3 max-w-lg mx-auto">
            Feitos com ingredientes selecionados e muito amor. Encomende já!
        </p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</div>
@endsection
