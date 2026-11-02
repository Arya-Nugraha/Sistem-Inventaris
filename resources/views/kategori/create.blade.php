@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('header', 'Tambah Kategori Baru')

@section('content')

    <div class="max-w-lg">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <form method="POST" action="{{ route('kategori.store') }}">
                @csrf

                {{-- Field Nama Kategori --}}
                <div class="mb-5">
                    <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_kategori"
                        name="nama_kategori"
                        value="{{ old('nama_kategori') }}"
                        placeholder="Contoh: Elektronik"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('nama_kategori') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    >
                    {{-- Pesan error per-field --}}
                    @error('nama_kategori')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                        Simpan
                    </button>
                    <a href="{{ route('kategori.index') }}"
                       class="text-sm text-gray-500 hover:text-gray-700">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
