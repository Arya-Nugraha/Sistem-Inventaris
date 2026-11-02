<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem Inventaris')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-60 bg-slate-800 text-white flex flex-col min-h-screen fixed top-0 left-0">
        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-slate-700">
            <span class="text-lg font-bold tracking-wide">Sistem Informasi Inventaris</span>
        </div>

        {{-- Menu Navigasi --}}
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                🏠 Dashboard
            </a>
            <a href="{{ route('kategori.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('kategori.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                🏷️ Kategori
            </a>
            <a href="{{ route('supplier.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('supplier.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                🏭 Supplier
            </a>
            <a href="{{ route('barang.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('barang.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                📦 Barang
            </a>
            <a href="{{ route('barangmasuk.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('barangmasuk.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                📥 Barang Masuk
            </a>
            <a href="{{ route('barangkeluar.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('barangkeluar.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                📤 Barang Keluar
            </a>
        </nav>

        {{-- Logout --}}
        <div class="px-3 py-4 border-t border-slate-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium
                               text-slate-300 hover:bg-red-600 hover:text-white transition-colors">
                    🚪 Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Konten Utama --}}
    <main class="ml-60 flex-1 flex flex-col min-h-screen">

        {{-- Header halaman --}}
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
            <span class="text-sm text-gray-500">{{ auth()->user()->name ?? '-' }}</span>
        </header>

        {{-- Area konten --}}
        <div class="flex-1 p-8">
            {{-- Alert pesan sukses/error --}}
            @include('partials.alert')

            @yield('content')
        </div>
    </main>

</body>
</html>