<?php

namespace App\Models\BarangMasuk;

use App\Models\Barang\Barangs;
use App\Models\Supplier\Suppliers;
use Illuminate\Database\Eloquent\Model;

class BarangMasuks extends Model
{
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id';
    protected $fillable = [
    'id_barang', 
    'id_supplier', 
    'jumlah', 
    'tanggal_masuk', 
    'keterangan',
];

public function barang()
{
    return $this->belongsTo(Barangs::class, 'id_barang');
}

public function supplier()
{
    return $this->belongsTo(Suppliers::class, 'id_supplier');
}
}
