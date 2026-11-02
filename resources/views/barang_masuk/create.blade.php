@extends('layouts.app')

@section('title', 'Tambah Barang Masuk')
@section('header', 'Tambah Barang Masuk Baru')

@section('content')

    <div class="max-w-lg">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <form method="POST" action="{{ route('barangmasuk.store') }}">
                @csrf

                {{-- Field Nama Barang Masuk --}}
                {{-- <div class="mb-5">
                    <label for="nama_barang_masuk" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Barang Masuk <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_barang_masuk"
                        name="nama_barang_masuk"
                        value="{{ old('nama_barang_masuk') }}"
                        placeholder="Contoh: Elektronik"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('nama_barang_masuk') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    > --}}
                    {{-- Pesan error per-field --}}
                    {{-- @error('nama_barang_masuk')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                {{-- Field Barang --}}
                <div class="mb-5">
                    <label for="id_barang" class="block text-sm font-medium text-gray-700 mb-1">
                        Barang <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="id_barang"
                        id="id_barang"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('id_barang') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                        <option value="" disabled selected>Pilih barang</option>
                        @foreach ($barangOptions as $id => $nama)
                            <option value="{{ $id }}" {{ old('id_barang') == $id ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_barang')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Supplier --}}
                <div class="mb-5">
                    <label for="id_supplier" class="block text-sm font-medium text-gray-700 mb-1">
                        Supplier <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="id_supplier"
                        id="id_supplier"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('id_supplier') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                        <option value="" disabled selected>Pilih supplier</option>
                        @foreach ($supplierOptions as $id => $nama)
                            <option value="{{ $id }}" {{ old('id_supplier') == $id ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_supplier')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Jumlah --}}
                <div class="mb-5">
                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="jumlah"
                        name="jumlah"
                        value="{{ old('jumlah') }}"
                        placeholder="Contoh: 10"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('jumlah') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                    @error('jumlah')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Tanggal Masuk --}}
                <div class="mb-5">
                    <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Masuk <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="tanggal_masuk"
                        name="tanggal_masuk"
                        value="{{ old('tanggal_masuk') }}"
                        placeholder="Contoh: 2022-01-01"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('tanggal_masuk') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                    @error('tanggal_masuk')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Keterangan --}}
                <div class="mb-5">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">
                        Keterangan <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="keterangan"
                        name="keterangan"
                        value="{{ old('keterangan') }}"
                        placeholder="Contoh: Keterangan"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('keterangan') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                    @error('keterangan')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                        Simpan
                    </button>
                    <a href="{{ route('barangmasuk.index') }}"
                       class="text-sm text-gray-500 hover:text-gray-700">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
