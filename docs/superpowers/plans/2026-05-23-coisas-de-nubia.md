# Coisas de Núbia — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a Laravel showcase website "Coisas de Núbia" displaying handcrafted products (crochê, bordados, doces) with WhatsApp contact, supporting both image and looping video media.

**Architecture:** Static data-driven showcase with no database — all products defined in `config/products.php`. Four pages (home + 3 categories) built with Blade templates and TailwindCSS via CDN. Media cards detect `type: 'video'` or `type: 'image'` and render appropriately, with videos set to autoplay, muted and loop.

**Tech Stack:** Laravel 13, Blade, TailwindCSS (CDN), Alpine.js (CDN), PHP 8.2 (via Docker)

**WhatsApp da Núbia:** `5511968699610`

## ⚠️ Docker Setup

PHP is NOT installed natively. All PHP/artisan commands must run via Docker:
```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
docker-compose run --rm app php artisan [command]
docker-compose run --rm app php artisan test
```
The docker-compose.yml mounts `.:/var/www` so files written to the project directory are available inside the container.

---

## File Structure

```
coisasdenubia/
├── app/Http/Controllers/
│   ├── HomeController.php
│   └── CategoryController.php
├── config/
│   └── products.php
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── components/
│   │   ├── product-card.blade.php
│   │   └── whatsapp-button.blade.php
│   ├── home.blade.php
│   └── categories/
│       ├── croche.blade.php
│       ├── bordados.blade.php
│       └── doces.blade.php
├── routes/web.php
└── tests/Feature/PagesTest.php
```

---

### Task 1: Create Laravel Project ✅ DONE
Laravel 13.11.2 created via Docker. Git initialized at commit f7754e4.

---

### Task 2: Configure Product Data

**Files:**
- Create: `config/products.php`

- [ ] **Step 1: Create the products config**

Create `/home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia/config/products.php`:

```php
<?php

return [
    'whatsapp' => '5511968699610',

    'croche' => [
        [
            'name'        => 'Tapete de Crochê',
            'description' => 'Tapete artesanal feito à mão com fio de algodão.',
            'price'       => '80,00',
            'type'        => 'image',
            'media'       => null,
        ],
        [
            'name'        => 'Capa de Almofada',
            'description' => 'Capa de almofada em crochê, diversas cores disponíveis.',
            'price'       => '45,00',
            'type'        => 'image',
            'media'       => null,
        ],
        [
            'name'        => 'Saquinho de Crochê',
            'description' => 'Saquinho artesanal, ideal para presente.',
            'price'       => '35,00',
            'type'        => 'video',
            'media'       => null,
        ],
    ],

    'bordados' => [
        [
            'name'        => 'Pano de Prato Bordado',
            'description' => 'Pano de prato com bordado colorido feito à mão.',
            'price'       => '30,00',
            'type'        => 'image',
            'media'       => null,
        ],
        [
            'name'        => 'Caminho de Mesa Bordado',
            'description' => 'Caminho de mesa com flores bordadas, perfeito para decoração.',
            'price'       => '75,00',
            'type'        => 'image',
            'media'       => null,
        ],
        [
            'name'        => 'Toalha Bordada',
            'description' => 'Toalha de rosto com bordado personalizado.',
            'price'       => '40,00',
            'type'        => 'video',
            'media'       => null,
        ],
    ],

    'doces' => [
        [
            'name'        => 'Pão de Mel',
            'description' => 'Recheado com doce de leite, coberto com chocolate.',
            'price'       => '8,00',
            'type'        => 'image',
            'media'       => null,
        ],
        [
            'name'        => 'Bolo no Pote',
            'description' => 'Bolo artesanal em pote individual, várias opções de sabor.',
            'price'       => '15,00',
            'type'        => 'video',
            'media'       => null,
        ],
        [
            'name'        => 'Caixa de Pão de Mel',
            'description' => 'Caixa com 6 pães de mel, ideal para presente.',
            'price'       => '45,00',
            'type'        => 'image',
            'media'       => null,
        ],
    ],

    'destaques' => ['croche.0', 'bordados.0', 'doces.0'],
];
```

- [ ] **Step 2: Commit**

```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
git add config/products.php
git commit -m "feat: add product data config"
```

---

### Task 3: Configure Routes and Controllers

**Files:**
- Modify: `routes/web.php`
- Create: `app/Http/Controllers/HomeController.php`
- Create: `app/Http/Controllers/CategoryController.php`
- Create: `tests/Feature/PagesTest.php`

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/PagesTest.php`:

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_home_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Coisas de Núbia');
    }

    public function test_croche_page_loads(): void
    {
        $response = $this->get('/croche');
        $response->assertStatus(200);
        $response->assertSee('Crochê');
    }

    public function test_bordados_page_loads(): void
    {
        $response = $this->get('/bordados');
        $response->assertStatus(200);
        $response->assertSee('Bordados');
    }

    public function test_doces_page_loads(): void
    {
        $response = $this->get('/doces');
        $response->assertStatus(200);
        $response->assertSee('Doces');
    }
}
```

- [ ] **Step 2: Run tests to verify they fail**

```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
docker-compose run --rm app php artisan test tests/Feature/PagesTest.php
```

Expected: All 4 tests FAIL.

- [ ] **Step 3: Create HomeController**

Create `app/Http/Controllers/HomeController.php`:

```php
<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $products = config('products');
        $destaques = [];
        foreach ($products['destaques'] as $key) {
            [$category, $index] = explode('.', $key);
            $destaques[] = array_merge($products[$category][(int) $index], ['category' => $category]);
        }
        return view('home', compact('destaques'));
    }
}
```

- [ ] **Step 4: Create CategoryController**

Create `app/Http/Controllers/CategoryController.php`:

```php
<?php

namespace App\Http\Controllers;

class CategoryController extends Controller
{
    public function show(string $category)
    {
        $products = config("products.{$category}");
        abort_if($products === null, 404);
        return view("categories.{$category}", compact('products'));
    }
}
```

- [ ] **Step 5: Update routes**

Replace entire contents of `routes/web.php`:

```php
<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/croche',   [CategoryController::class, 'show'])->defaults('category', 'croche');
Route::get('/bordados', [CategoryController::class, 'show'])->defaults('category', 'bordados');
Route::get('/doces',    [CategoryController::class, 'show'])->defaults('category', 'doces');
```

- [ ] **Step 6: Commit**

```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
git add routes/web.php app/Http/Controllers/HomeController.php app/Http/Controllers/CategoryController.php tests/Feature/PagesTest.php
git commit -m "feat: add routes and controllers"
```

---

### Task 4: Create Main Layout

**Files:**
- Create: `resources/views/layouts/app.blade.php`
- Create: `resources/views/components/whatsapp-button.blade.php`

- [ ] **Step 1: Create WhatsApp button component**

Create `resources/views/components/whatsapp-button.blade.php`:

```blade
@props(['message' => 'Olá! Vi seus artesanatos e quero saber mais 😊'])

<a
    href="https://wa.me/{{ config('products.whatsapp') }}?text={{ urlencode($message) }}"
    target="_blank"
    rel="noopener"
    class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg transition-transform hover:scale-110 flex items-center gap-2"
    aria-label="Contato via WhatsApp"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.555 4.116 1.528 5.847L.057 23.784a.5.5 0 0 0 .612.641l6.094-1.6A11.93 11.93 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.933 9.933 0 0 1-5.07-1.385l-.36-.214-3.742.981.999-3.648-.235-.374A9.94 9.94 0 0 1 2 12c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10z"/>
    </svg>
    <span class="hidden sm:inline text-sm font-medium">WhatsApp</span>
</a>
```

- [ ] **Step 2: Create main layout**

Create `resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coisas de Núbia') | Artesanatos</title>
    <meta name="description" content="@yield('description', 'Artesanatos feitos com amor: crochê, bordados, pão de mel e muito mais.')">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'rose-cream':  '#FDF8F5',
                        'rose-soft':   '#E8A0A0',
                        'rose-deep':   '#C97B7B',
                        'rose-dark':   '#3D2C2C',
                    },
                    fontFamily: {
                        display: ['Georgia', 'serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { background-color: #FDF8F5; color: #3D2C2C; font-family: 'Inter', system-ui, sans-serif; }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm sticky top-0 z-40" x-data="{ open: false }">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="font-display text-xl font-bold text-[#C97B7B] tracking-wide">
                🌸 Coisas de Núbia
            </a>

            {{-- Desktop menu --}}
            <ul class="hidden md:flex gap-8 text-sm font-medium items-center">
                <li><a href="/" class="hover:text-[#C97B7B] transition-colors">Início</a></li>
                <li><a href="/croche" class="hover:text-[#C97B7B] transition-colors">Crochê</a></li>
                <li><a href="/bordados" class="hover:text-[#C97B7B] transition-colors">Bordados</a></li>
                <li><a href="/doces" class="hover:text-[#C97B7B] transition-colors">Doces</a></li>
                <li>
                    <a href="https://wa.me/{{ config('products.whatsapp') }}" target="_blank"
                       class="bg-[#E8A0A0] hover:bg-[#C97B7B] text-white px-5 py-2 rounded-full transition-colors">
                        Contato
                    </a>
                </li>
            </ul>

            {{-- Mobile hamburger --}}
            <button @click="open = !open" class="md:hidden text-[#3D2C2C] p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-transition class="md:hidden bg-white border-t border-pink-100 px-4 pb-4">
            <ul class="flex flex-col gap-4 pt-4 text-sm font-medium">
                <li><a href="/" @click="open=false" class="block hover:text-[#C97B7B]">Início</a></li>
                <li><a href="/croche" @click="open=false" class="block hover:text-[#C97B7B]">Crochê</a></li>
                <li><a href="/bordados" @click="open=false" class="block hover:text-[#C97B7B]">Bordados</a></li>
                <li><a href="/doces" @click="open=false" class="block hover:text-[#C97B7B]">Doces</a></li>
                <li><a href="https://wa.me/{{ config('products.whatsapp') }}" target="_blank" class="block text-[#C97B7B] font-semibold">WhatsApp</a></li>
            </ul>
        </div>
    </nav>

    {{-- Page content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-pink-100 mt-16">
        <div class="max-w-6xl mx-auto px-4 py-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left">
                <p class="font-display text-lg font-bold text-[#C97B7B]">🌸 Coisas de Núbia</p>
                <p class="text-sm text-gray-500 mt-1">Artesanatos feitos com amor ❤️</p>
            </div>
            <div class="flex gap-6 text-sm">
                <a href="/croche" class="hover:text-[#C97B7B] transition-colors">Crochê</a>
                <a href="/bordados" class="hover:text-[#C97B7B] transition-colors">Bordados</a>
                <a href="/doces" class="hover:text-[#C97B7B] transition-colors">Doces</a>
            </div>
            <a href="https://wa.me/{{ config('products.whatsapp') }}" target="_blank"
               class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-full text-sm transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.555 4.116 1.528 5.847L.057 23.784a.5.5 0 0 0 .612.641l6.094-1.6A11.93 11.93 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.933 9.933 0 0 1-5.07-1.385l-.36-.214-3.742.981.999-3.648-.235-.374A9.94 9.94 0 0 1 2 12c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10z"/>
                </svg>
                Falar no WhatsApp
            </a>
        </div>
        <p class="text-center text-xs text-gray-400 pb-6">© {{ date('Y') }} Coisas de Núbia. Feito com carinho.</p>
    </footer>

    <x-whatsapp-button />

</body>
</html>
```

- [ ] **Step 3: Commit**

```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
git add resources/views/layouts/app.blade.php resources/views/components/whatsapp-button.blade.php
git commit -m "feat: add main layout with navbar and footer"
```

---

### Task 5: Create Product Card Component

**Files:**
- Create: `resources/views/components/product-card.blade.php`

- [ ] **Step 1: Create the product card component**

Create `resources/views/components/product-card.blade.php`:

```blade
@props(['product'])

@php
    $whatsapp = config('products.whatsapp');
    $message  = urlencode("Olá Núbia! Vi o produto *{$product['name']}* no site e tenho interesse 😊");
@endphp

<div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition-all hover:-translate-y-1 duration-200">

    {{-- Media area --}}
    <div class="aspect-square bg-pink-50 overflow-hidden relative">
        @if($product['type'] === 'video' && $product['media'])
            <video
                class="w-full h-full object-cover"
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
                src="{{ $product['media'] }}"
            ></video>

        @elseif($product['type'] === 'image' && $product['media'])
            <img
                src="{{ $product['media'] }}"
                alt="{{ $product['name'] }}"
                class="w-full h-full object-cover"
                loading="lazy"
            >

        @else
            <div class="w-full h-full flex flex-col items-center justify-center gap-3 bg-pink-50">
                @if($product['type'] === 'video')
                    <svg class="w-14 h-14 text-[#E8A0A0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                    </svg>
                    <span class="text-xs text-[#E8A0A0] font-medium">Vídeo em breve</span>
                @else
                    <svg class="w-14 h-14 text-[#E8A0A0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xs text-[#E8A0A0] font-medium">Foto em breve</span>
                @endif
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

        <a
            href="https://wa.me/{{ $whatsapp }}?text={{ $message }}"
            target="_blank"
            rel="noopener"
            class="mt-4 block text-center bg-[#E8A0A0] hover:bg-[#C97B7B] text-white rounded-full py-2.5 text-sm font-medium transition-colors"
        >
            Tenho interesse!
        </a>
    </div>
</div>
```

- [ ] **Step 2: Commit**

```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
git add resources/views/components/product-card.blade.php
git commit -m "feat: add product card component with image/video/placeholder support"
```

---

### Task 6: Create Home Page

**Files:**
- Create: `resources/views/home.blade.php`

- [ ] **Step 1: Create home view**

Create `resources/views/home.blade.php`:

```blade
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
```

- [ ] **Step 2: Run test**

```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
docker-compose run --rm app php artisan test tests/Feature/PagesTest.php --filter=test_home_page_loads
```

Expected: PASS

- [ ] **Step 3: Commit**

```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
git add resources/views/home.blade.php
git commit -m "feat: add home page with hero, about and highlights sections"
```

---

### Task 7: Create Category Pages

**Files:**
- Create: `resources/views/categories/croche.blade.php`
- Create: `resources/views/categories/bordados.blade.php`
- Create: `resources/views/categories/doces.blade.php`

- [ ] **Step 1: Create crochê page**

Create `resources/views/categories/croche.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Crochê')
@section('description', 'Peças de crochê feitas à mão: tapetes, almofadas, saquinhos e muito mais.')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <span class="text-6xl">🧶</span>
        <h1 class="font-display text-4xl font-bold text-[#3D2C2C] mt-4">Crochê</h1>
        <p class="text-gray-500 mt-3 max-w-lg mx-auto">
            Peças únicas feitas à mão com muito carinho. Cada uma é especial!
        </p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</div>
@endsection
```

- [ ] **Step 2: Create bordados page**

Create `resources/views/categories/bordados.blade.php`:

```blade
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
```

- [ ] **Step 3: Create doces page**

Create `resources/views/categories/doces.blade.php`:

```blade
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
```

- [ ] **Step 4: Run all tests**

```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
docker-compose run --rm app php artisan test tests/Feature/PagesTest.php
```

Expected: All 4 tests PASS.

- [ ] **Step 5: Commit**

```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
git add resources/views/categories/
git commit -m "feat: add category pages for crochê, bordados and doces"
```

---

### Task 8: Final Verification

- [ ] **Step 1: Run full test suite**

```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
docker-compose run --rm app php artisan test
```

Expected: All tests green.

- [ ] **Step 2: Start server via Docker**

```bash
cd /home/arthur/Desktop/Unifecaf/win-syncSe/coisasdenubia
docker-compose up -d
```

Open `http://localhost:8000` and verify all pages.

---

## Adding Real Media Later

**To add a photo:**
1. Copy image to `public/images/` (e.g., `public/images/tapete.jpg`)
2. In `config/products.php`: `'type' => 'image', 'media' => '/images/tapete.jpg'`

**To add a video:**
1. Copy video to `public/videos/` (e.g., `public/videos/saquinho.mp4`)
2. In `config/products.php`: `'type' => 'video', 'media' => '/videos/saquinho.mp4'`
3. Video autoplays silently in loop — no extra config needed.
