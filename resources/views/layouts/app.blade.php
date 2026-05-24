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
                        'rose-cream': '#FDF8F5',
                        'rose-soft':  '#E8A0A0',
                        'rose-deep':  '#C97B7B',
                        'rose-dark':  '#3D2C2C',
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
