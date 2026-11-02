<?php

namespace App\Http\Controllers;

use App\Models\Supplier\Suppliers;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Suppliers::orderBy('nama_supplier')->get();

        return view('supplier.index', compact('suppliers'));
    }

    public function create(): View
    {
        $supplierOptions = Suppliers::orderBy('nama_supplier')->pluck('nama_supplier', 'id');

        return view('supplier.create', compact('supplierOptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_supplier' => 'string|required|max:255',
            'alamat' => 'string|required|max:255',
            'telepon' => 'required|string|max:255',
        ],[
            'nama_supplier.required' => 'Nama supplier wajib di isi.',
            'alamat.required' => 'Alamat wajib di isi.',
            'telepon.required' => 'No Telepon wajib di isi.'
        ]);

        Suppliers::create($request->all('nama_supplier','alamat','telepon'));

        return redirect()->route('supplier.index')
        ->with('success','Supplier berhasil ditambahkan');
    }

    // Pop up untuk update data
    public function edit(Suppliers $supplier): View
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Suppliers $supplier): RedirectResponse
    {
        $request->validate([
            'nama_supplier' => 'string|required|max:255',
            'alamat' => 'string|required|max:255',
            'telepon' => 'string|required|max:255',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.max' => 'Nama supplier maksimal 255 karakter.',
            'alamat.required' => 'Alamat wajib diisi',
            'alamat.max' => 'Alamat maksimal 255 karakter',
            'telepon' => 'No telepon wajib diisi',
            'telepon.max' => 'No telepon maksimal 255 karakter',
        ]);

        $supplier->update($request->all('nama_supplier', 'alamat', 'telepon'));
        return redirect()->route('supplier.index')
        ->with('success','Supplier berhasil diupdate');
    }

    public function destroy(Suppliers $supplier): RedirectResponse
    {
        if ($supplier->barangMasuk()->exists()) {
            return redirect()->route('supplier.index')
                ->with('error', 'Supplier tidak dapat dihapus karena memiliki riwayat transaksi barang masuk.');
        }

        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus');
    }
}
