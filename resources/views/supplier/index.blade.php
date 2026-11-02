@extends('layouts.app')

@section('title', 'Supplier')
@section('header', 'Manajemen Supplier - Perbaiki fitur tambah data dan edit')

@section('content')

    {{-- Tombol Tambah --}}
    <div class="mb-6">
        <a href="{{ route('supplier.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            ＋ Tambah Supplier
        </a>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4 w-12">No</th>
                    <th class="px-6 py-4">Nama Supplier</th>
                    <th class="px-6 py-4">Alamat</th>
                    <th class="px-6 py-4">Telepon</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($suppliers as $index => $supplier)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $supplier->nama_supplier }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $supplier->alamat }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $supplier->telepon }}</td>
                        <td class="px-6 py-4 text-gray-500">
                             <div class="flex items-center justify-center gap-2">
                                
                                {{-- Tombol Edit --}}
                                <a href="{{ route('supplier.edit', $supplier) }}"
                                   class="inline-flex items-center gap-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                    <b>Edit</b>
                                </a>

                                <form method="POST" action="{{ route('supplier.destroy', $supplier) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-800 text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                        🗑️ Hapus
                                    </button>
                                </form>
                                
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                            Belum ada data supplier.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Jumlah data --}}
    <p class="mt-3 text-xs text-gray-400">Total: {{ $suppliers->count() }} Supplier</p>

@endsection