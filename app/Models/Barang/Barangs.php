<?php

namespace App\Models\Barang;

use App\Models\Kategori\Kategoris;
use Illuminate\Database\Eloquent\Model;

class Barangs extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_kategori',
        'kode_barang',
        'nama_barang',
        'satuan',
        'stok',
        'harga',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategoris::class, 'id_kategori');
    }

    public function barangMasuk()
    {
        return $this->hasMany(\App\Models\BarangMasuk\BarangMasuks::class, 'id_barang');
    }

    public function barangKeluar()
    {
        return $this->hasMany(\App\Models\BarangKeluar\BarangKeluars::class, 'id_barang');
    }
}
