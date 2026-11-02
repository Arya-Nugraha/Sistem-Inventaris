@extends('layouts.app')

@section('title', 'Edit Supplier')
@section('header', 'Edit Supplier Baru')

@section('content')

    <div class="max-w-lg">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            {{--
                Form edit harus pakai method PUT, tapi HTML hanya mendukung GET dan POST.
                Laravel menyediakan @method('PUT') sebagai solusinya — ini bukan JS,
                hanya field hidden yang dikirim bersama form POST biasa.
            --}}
            <form method="POST" action="{{ route('supplier.update', $supplier) }}">
                @csrf
                @method('PUT')

                {{-- Field Nama Barang Keluar --}}
                <div class="mb-5">
                    <label for="nama_supplier" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Supplier <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_supplier"
                        name="nama_supplier"
                        value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                        placeholder="Contoh: CV. Sinar Jaya"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('nama_supplier') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    >
                    @error('nama_supplier')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Alamat --}}
                <div class="mb-5">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="alamat"
                        name="alamat"
                        value="{{ old('alamat', $supplier->alamat) }}"
                        placeholder="Contoh:Jl. Teknologi No. 123, Jakarta"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('alamat') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    >
                    @error('alamat')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field No Telepon --}}
                <div class="mb-5">
                    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">
                        No Telepon <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="telepon"
                        name="telepon"
                        value="{{ old('telepon', $supplier->telepon) }}"
                        placeholder="Contoh: 08123456789"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('telepon') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    >
                    @error('telepon')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                        Update
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
