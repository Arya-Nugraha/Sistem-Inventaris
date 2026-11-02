@extends('layouts.app')

@section('title', 'Edit Barang')
@section('header', 'Edit Barang')

@section('content')

    <div class="max-w-lg">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <form method="POST" action="{{ route('barang.update', $barang->id) }}">
                @csrf
                @method('PUT')

                {{-- Field Nama Barang --}}
                <div class="mb-5">
                    <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Barang <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_barang"
                        name="nama_barang"
                        value="{{ old('nama_barang', $barang->nama_barang) }}"
                        placeholder="Contoh: Elektronik"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('nama_barang') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                    {{-- Pesan error per-field --}}
                    @error('nama_barang')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Kategori --}}
                <div class="mb-5">
                    <label for="id_kategori" class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="id_kategori"
                        id="id_kategori"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('id_kategori') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                        <option value="" disabled selected>Pilih kategori</option>
                        @foreach ($kategoriOptions as $id => $nama)
                            <option value="{{ $id }}" {{ old('id_kategori', $barang->id_kategori) == $id ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>

                    @error('id_kategori')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Kode Barang --}}
                <div class="mb-5">
                    <label for="kode_barang" class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Barang <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="kode_barang"
                        name="kode_barang"
                        value="{{ old('kode_barang', $barang->kode_barang) }}"
                        placeholder="Contoh: BRG-001"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('kode_barang') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                    @error('kode_barang')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Satuan --}}
                <div class="mb-5">
                    <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">
                        Satuan <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="satuan"
                        name="satuan"
                        value="{{ old('satuan', $barang->satuan) }}"
                        placeholder="Contoh: Buah"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('satuan') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                    @error('satuan')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Stok (Readonly) --}}
                <div class="mb-5">
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">
                        Stok Saat Ini
                    </label>
                    <input
                        type="number"
                        id="stok"
                        value="{{ $barang->stok }}"
                        class="w-full border border-gray-200 bg-gray-100 rounded-lg px-3 py-2 text-sm text-gray-600 cursor-not-allowed"
                        readonly
                    >
                    <p class="mt-1 text-xs text-gray-500">ℹ️ Stok diperbarui otomatis melalui transaksi <strong>Barang Masuk</strong> dan <strong>Barang Keluar</strong>.</p>
                </div>

                {{-- Field Harga --}}
                <div class="mb-5">
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="harga"
                        name="harga"
                        value="{{ old('harga', $barang->harga) }}"
                        placeholder="Contoh: 10000"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('harga') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                    @error('harga')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                        Simpan
                    </button>
                    <a href="{{ route('barang.index') }}"
                       class="text-sm text-gray-500 hover:text-gray-700">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
