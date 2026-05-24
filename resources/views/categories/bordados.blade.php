@extends('layouts.app')

@section('title', 'Bordados')
@section('description', 'Bordados artesanais feitos à mão: panos de prato, toalhas e caminhos de mesa.')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <span class="text-6xl">🪡</span>
        <h1 class="font-display text-4xl font-bold text-[#3D2C2C] mt-4">Bordados</h1>
        <p class="text-gray-500 mt-3 max-w-lg mx-auto">
            Arte em cada ponto. Peças bordadas à mão com muito amor e dedicação.
        </p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</div>
@endsection
