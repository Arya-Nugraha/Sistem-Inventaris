@extends('layouts.app')

@section('title', 'Tambah Supplier')
@section('header', 'Tambah Supplier Baru')

@section('content')

    <div class="max-w-lg">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <form method="POST" action="{{ route('supplier.store') }}">
                @csrf

                {{-- Field Nama Supplier --}}
                <div class="mb-5">
                    <label for="nama_supplier" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Supplier <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_supplier"
                        name="nama_supplier"
                        value="{{ old('nama_supplier') }}"
                        placeholder="Contoh: PT Sinar Abadi"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('nama_supplier') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    >
                    {{-- Pesan error per-field --}}
                    @error('nama_supplier')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Alamat --}}
                <div class="mb-5">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                        Alamat
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="3" class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                {{-- Field Telepon --}}
                <div class="mb-5">
                    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">
                        Telepon
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id= "telepon"
                           name= "telepon"
                           placeholder="Contoh: 08212345678"
                           value="{{ old('telepon')}}"
                           class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                                  {{ $errors->has('telepon') ? 'border-red-400 bg-red-50' : 'border-gray-300'}}"
                           >
                    @error('telepon')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                        Simpan
                    </button>
                    <a href="{{ route('supplier.index') }}"
                       class="text-sm text-gray-500 hover:text-gray-700">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
