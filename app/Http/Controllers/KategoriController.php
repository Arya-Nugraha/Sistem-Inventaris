<?php

namespace App\Http\Controllers;

use App\Models\Kategori\Kategoris;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    /**
     * Tampilkan daftar semua kategori.
     */
    public function index(): View
    {
        $kategoris = Kategoris::orderBy('nama_kategori')->get();

        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Tampilkan halaman form tambah kategori baru.
     */
    public function create(): View
    {
        return view('kategori.create');
    }

    /**
     * Simpan kategori baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        Kategoris::create($request->only('nama_kategori'));

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Tampilkan halaman form edit kategori.
     */
    public function edit(Kategoris $kategori): View
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Simpan perubahan kategori ke database.
     */
    public function update(Request $request, Kategoris $kategori): RedirectResponse
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,'.$kategori->id,
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        $kategori->update($request->only('nama_kategori'));

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori (soft delete).
     */
    public function destroy(Kategoris $kategori): RedirectResponse
    {
        if ($kategori->barang()->exists()) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori ini tidak dapat dihapus karena masih digunakan oleh data barang.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
