@extends('layouts.app')

@section('title', 'Edit Barang Keluar')
@section('header', 'Edit Barang Keluar')

@section('content')

    <div class="max-w-lg">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            {{--
                Form edit harus pakai method PUT, tapi HTML hanya mendukung GET dan POST.
                Laravel menyediakan @method('PUT') sebagai solusinya — ini bukan JS,
                hanya field hidden yang dikirim bersama form POST biasa.
            --}}
            <form method="POST" action="{{ route('barangkeluar.update', $barangkeluar) }}">
                @csrf
                @method('PUT')

                {{-- Field ID Barang --}}
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
                            <option value="{{ $id }}" {{ old('id_barang', $barangkeluar->id_barang) == $id ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_barang')
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
                        name="jumlah"
                        id="jumlah"
                        value="{{ old('jumlah', $barangkeluar->jumlah) }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('jumlah') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                    @error('jumlah')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Field Tanggal Keluar --}}
                <div class="mb-5">
                    <label for="tanggal_keluar" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Keluar <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        name="tanggal_keluar"
                        id="tanggal_keluar"
                        value="{{ old('tanggal_keluar', $barangkeluar->tanggal_keluar)}}"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('tanggal_keluar') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                    @error('tanggal_keluar')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Field Penerima --}}
                <div class="mb-5">
                    <label for="penerima" class="block text-sm font-medium text-gray-700 mb-1">
                        Penerima <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="penerima"
                        id="penerima"
                        value="{{ old('penerima', $barangkeluar->penerima)}}"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('penerima') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >
                    @error('penerima')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Field Keterangan --}}
                <div class="mb-5">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">
                        Keterangan <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="keterangan"
                        id="keterangan"
                        rows="3"
                        placeholder="Masukkan keterangan..."
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('keterangan') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        required
                    >{{ old('keterangan', $barangkeluar->keterangan) }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                        Update
                    </button>
                    <a href="{{ route('barangkeluar.index') }}"
                       class="text-sm text-gray-500 hover:text-gray-700">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
