<?php

namespace App\Http\Controllers;

use App\Models\Barang\Barangs;
use App\Models\BarangKeluar\BarangKeluars;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangkeluars = BarangKeluars::with('barang')->orderBy('id', 'desc')->get();

        return view('barang_keluar.index', compact('barangkeluars'));
    }

    public function create(): View
    {
        $barangOptions = Barangs::orderBy('nama_barang')->pluck('nama_barang', 'id');
        return view('barang_keluar.create', compact('barangOptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'penerima' => 'required|string|max:255',
            'keterangan' => 'required|string|max:500',
        ], [
            'id_barang.required' => 'Barang wajib dipilih.',
            'id_barang.exists' => 'Barang tidak ditemukan.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal_keluar.required' => 'Tanggal keluar wajib diisi.',
            'penerima.required' => 'Penerima wajib diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.',
        ]);

        $barang = Barangs::findOrFail($request->id_barang);
        if ($barang->stok < $request->jumlah) {
            return back()->withErrors([
                'jumlah' => "Stok tidak mencukupi. Stok tersedia: {$barang->stok}",
            ])->withInput();
        }

        DB::transaction(function () use ($request, $barang) {
            BarangKeluars::create($request->all());
            $barang->decrement('stok', $request->jumlah);
        });

        return redirect()->route('barangkeluar.index')
            ->with('success', 'Barang keluar berhasil ditambahkan.');
    }

    public function edit(BarangKeluars $barangkeluar): View
    {
        $barangOptions = Barangs::orderBy('nama_barang')->pluck('nama_barang', 'id');
        return view('barang_keluar.edit', compact('barangkeluar', 'barangOptions'));
    }

    public function update(Request $request, BarangKeluars $barangkeluar): RedirectResponse
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'penerima' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'id_barang.required' => 'Barang harus dipilih.',
            'id_barang.exists' => 'Barang tidak ditemukan.',
            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal_keluar.required' => 'Tanggal keluar harus diisi.',
            'penerima.required' => 'Penerima harus diisi.',
            'penerima.max' => 'Penerima maksimal 255 karakter.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        // Cek apakah barang sama atau diganti
        if ($barangkeluar->id_barang == $request->id_barang) {
            $barang = Barangs::findOrFail($barangkeluar->id_barang);
            $stokSetelahKembali = $barang->stok + $barangkeluar->jumlah;

            if ($stokSetelahKembali < $request->jumlah) {
                return back()->withErrors([
                    'jumlah' => "Stok tidak mencukupi. Maksimal yang dapat dikeluarkan: {$stokSetelahKembali}",
                ])->withInput();
            }

            $selisih = $request->jumlah - $barangkeluar->jumlah;

            DB::transaction(function () use ($barangkeluar, $request, $barang, $selisih) {
                if ($selisih !== 0) {
                    $barang->decrement('stok', $selisih);
                }
                $barangkeluar->update($request->all());
            });
        } else {
            // Kasus jika user mengganti barang
            $oldBarang = Barangs::findOrFail($barangkeluar->id_barang);
            $newBarang = Barangs::findOrFail($request->id_barang);

            if ($newBarang->stok < $request->jumlah) {
                return back()->withErrors([
                    'jumlah' => "Stok barang pengganti ({$newBarang->nama_barang}) tidak mencukupi. Stok tersedia: {$newBarang->stok}",
                ])->withInput();
            }

            DB::transaction(function () use ($barangkeluar, $request, $oldBarang, $newBarang) {
                $oldBarang->increment('stok', $barangkeluar->jumlah);
                $newBarang->decrement('stok', $request->jumlah);
                $barangkeluar->update($request->all());
            });
        }

        return redirect()->route('barangkeluar.index')
            ->with('success', 'Data barang keluar berhasil diperbarui.');
    }

    public function destroy(BarangKeluars $barangkeluar): RedirectResponse
    {
        DB::transaction(function () use ($barangkeluar) {
            $barang = Barangs::findOrFail($barangkeluar->id_barang);
            $barang->increment('stok', $barangkeluar->jumlah);
            $barangkeluar->delete();
        });

        return redirect()->route('barangkeluar.index')
            ->with('success', 'Barang keluar berhasil dihapus.');
    }
}
