<?php

namespace App\Http\Controllers;

use App\Models\Barang\Barangs;
use App\Models\Kategori\Kategoris;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    /**
     * Menampilkan daftar barang.
     */
    public function index()
    {
        $barangs = Barangs::with('kategori')->orderBy('nama_barang')->get();
        $kategori = Kategoris::orderBy('nama_kategori')->get();

        return view('barang.index', compact('barangs', 'kategori'));
    }

    public function create(): View
    {
        $kategoriOptions = Kategoris::orderBy('nama_kategori')->pluck('nama_kategori', 'id');

        return view('barang.create', compact('kategoriOptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_barang' => 'required|string|max:20|unique:barang,kode_barang',
            'id_kategori' => 'required|exists:kategori,id',
            'nama_barang' => 'required|string|max:150',
            'satuan' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0',
        ], [
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'kode_barang.unique' => 'Kode barang sudah digunakan.',
            'id_kategori.exists' => 'Kategori tidak tersedia.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'satuan.required' => 'Satuan wajib diisi.',
            'stok.required' => 'Stok awal wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh bernilai negatif.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka bulat.',
            'harga.min' => 'Harga tidak boleh bernilai negatif.',
        ]);

        Barangs::create($request->only('id_kategori', 'kode_barang', 'nama_barang', 'satuan', 'stok', 'harga'));

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Barangs $barang): View
    {
        $kategoriOptions = Kategoris::orderBy('nama_kategori')->pluck('nama_kategori', 'id');
        return view('barang.edit', compact('barang', 'kategoriOptions'));
    }

    public function update(Request $request, Barangs $barang): RedirectResponse
    {
        $request->validate([
            'kode_barang' => 'required|string|max:20|unique:barang,kode_barang,' . $barang->id,
            'id_kategori' => 'required|exists:kategori,id',
            'nama_barang' => 'required|string|max:150',
            'satuan' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
        ], [
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'kode_barang.unique' => 'Kode barang sudah digunakan.',
            'id_kategori.exists' => 'Kategori tidak tersedia.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'satuan.required' => 'Satuan wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka bulat.',
            'harga.min' => 'Harga tidak boleh bernilai negatif.',
        ]);

        // Stok tidak diizinkan diubah langsung dari form master barang untuk menjaga integritas transaksi
        $barang->update($request->only('id_kategori', 'kode_barang', 'nama_barang', 'satuan', 'harga'));

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(Barangs $barang): RedirectResponse
    {
        if ($barang->barangMasuk()->exists() || $barang->barangKeluar()->exists()) {
            return redirect()->route('barang.index')
                ->with('error', 'Barang ini tidak dapat dihapus karena sudah memiliki riwayat transaksi barang masuk/keluar.');
        }

        $barang->delete();
        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus');
    }  
}
