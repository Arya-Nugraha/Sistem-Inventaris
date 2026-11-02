<?php

namespace App\Http\Controllers;

use App\Models\Barang\Barangs;
use App\Models\BarangMasuk\BarangMasuks;
use App\Models\Supplier\Suppliers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangmasuks = BarangMasuks::with(['barang', 'supplier'])->orderBy('id', 'desc')->get();

        return view('barang_masuk.index', compact('barangmasuks'));
    }

    public function create(): View
    {
        $barangOptions = Barangs::orderBy('nama_barang')->pluck('nama_barang', 'id');
        $supplierOptions = Suppliers::orderBy('nama_supplier')->pluck('nama_supplier', 'id');

        return view('barang_masuk.create', compact('barangOptions', 'supplierOptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'id_supplier' => 'required|exists:supplier,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ], [
            'id_barang.required' => 'Barang wajib dipilih.',
            'id_barang.exists' => 'Barang tidak valid.',
            'id_supplier.required' => 'Supplier wajib dipilih.',
            'id_supplier.exists' => 'Supplier tidak valid.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.',
        ]);

        DB::transaction(function () use ($request) {
            BarangMasuks::create($request->all());

            $barang = Barangs::findOrFail($request->id_barang);
            $barang->increment('stok', $request->jumlah);
        });

        return redirect()->route('barangmasuk.index')
            ->with('success', 'Barang masuk berhasil ditambahkan.');
    }

    public function edit(BarangMasuks $barangmasuk): View
    {
        $barangOptions = Barangs::orderBy('nama_barang')->pluck('nama_barang', 'id');
        $supplierOptions = Suppliers::orderBy('nama_supplier')->pluck('nama_supplier', 'id');

        return view('barang_masuk.edit', compact('barangmasuk', 'barangOptions', 'supplierOptions'));
    }

    public function update(Request $request, BarangMasuks $barangmasuk): RedirectResponse
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'id_supplier' => 'required|exists:supplier,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ], [
            'id_barang.required' => 'Barang wajib dipilih.',
            'id_barang.exists' => 'Barang tidak tersedia.',
            'id_supplier.required' => 'Supplier wajib dipilih.',
            'id_supplier.exists' => 'Supplier tidak tersedia.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.',
        ]);

        // Cek apakah barang sama atau diganti
        if ($barangmasuk->id_barang == $request->id_barang) {
            $barang = Barangs::findOrFail($barangmasuk->id_barang);
            $selisih = $request->jumlah - $barangmasuk->jumlah;

            // Jika jumlah dikurangi, cek apakah stok saat ini mencukupi
            if ($selisih < 0 && ($barang->stok + $selisih < 0)) {
                return back()->withErrors([
                    'jumlah' => "Perubahan gagal: stok saat ini ({$barang->stok}) tidak mencukupi untuk pengurangan sebanyak " . abs($selisih) . " unit. Sebagian barang sudah keluar/digunakan.",
                ])->withInput();
            }

            DB::transaction(function () use ($barangmasuk, $request, $barang, $selisih) {
                if ($selisih !== 0) {
                    $barang->increment('stok', $selisih);
                }
                $barangmasuk->update($request->all());
            });
        } else {
            // Kasus jika user mengganti pilihan barang
            $oldBarang = Barangs::findOrFail($barangmasuk->id_barang);
            $newBarang = Barangs::findOrFail($request->id_barang);

            // Cek apakah barang lama stoknya cukup untuk ditarik kembali
            if ($oldBarang->stok < $barangmasuk->jumlah) {
                return back()->withErrors([
                    'id_barang' => "Gagal mengganti barang: stok barang lama ({$oldBarang->nama_barang}) tersisa {$oldBarang->stok}, tidak mencukupi untuk ditarik kembali sebanyak {$barangmasuk->jumlah} unit.",
                ])->withInput();
            }

            DB::transaction(function () use ($barangmasuk, $request, $oldBarang, $newBarang) {
                $oldBarang->decrement('stok', $barangmasuk->jumlah);
                $newBarang->increment('stok', $request->jumlah);
                $barangmasuk->update($request->all());
            });
        }

        return redirect()->route('barangmasuk.index')
            ->with('success', 'Barang masuk berhasil diperbarui.');
    }

    public function destroy(BarangMasuks $barangmasuk): RedirectResponse
    {
        $barang = Barangs::findOrFail($barangmasuk->id_barang);

        // Cegah stok menjadi minus
        if ($barang->stok < $barangmasuk->jumlah) {
            return redirect()->route('barangmasuk.index')
                ->with('error', "Tidak dapat menghapus transaksi ini: stok barang saat ini tersisa {$barang->stok}, kurang dari jumlah transaksi ({$barangmasuk->jumlah}). Sebagian barang sudah keluar/digunakan.");
        }

        DB::transaction(function () use ($barangmasuk, $barang) {
            $barang->decrement('stok', $barangmasuk->jumlah);
            $barangmasuk->delete();
        });

        return redirect()->route('barangmasuk.index')
            ->with('success', 'Barang masuk berhasil dihapus.');
    }
}
