@extends('layouts.app')

@section('title', 'Barang Masuk')
@section('header', 'Manajemen Barang Masuk')

@section('content')

    {{-- Tombol Tambah --}}
    <div class="mb-6">
        <a href="{{ route('barangmasuk.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            ＋ Tambah Barang Masuk
        </a>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4 w-12">No</th>
                    <th class="px-6 py-4">Barang</th>
                    <th class="px-6 py-4">Supplier</th>
                    <th class="px-6 py-4">Jumlah</th>
                    <th class="px-6 py-4">Tanggal Masuk</th>
                    <th class="px-6 py-4">Keterangan</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($barangmasuks as $index => $barangmasuk)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $barangmasuk->barang->nama_barang ?? 'Barang #' . $barangmasuk->id_barang }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $barangmasuk->supplier->nama_supplier ?? 'Supplier #' . $barangmasuk->id_supplier }}
                        </td>
                        <td class="px-6 py-4 text-gray-700 font-semibold text-green-600">
                            +{{ $barangmasuk->jumlah }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $barangmasuk->tanggal_masuk }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $barangmasuk->keterangan }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('barangmasuk.edit', $barangmasuk) }}"
                                   class="inline-flex items-center gap-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                    ✏️ Edit
                                </a>

                                {{-- Tombol Hapus --}}
                                <form method="POST" action="{{ route('barangmasuk.destroy', $barangmasuk) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus barang masuk ini? Stok barang akan dikembalikan/dikurangi.')">
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
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                            Belum ada data barang masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Jumlah data --}}
    <p class="mt-3 text-xs text-gray-400">Total: {{ $barangmasuks->count() }} Barang Masuk</p>

@endsection
