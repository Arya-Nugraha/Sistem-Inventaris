<?php

namespace App\Models\BarangKeluar;

use App\Models\Barang\Barangs;
use Illuminate\Database\Eloquent\Model;

class BarangKeluars extends Model
{
    protected $table = 'barang_keluar';

    protected $fillable = [
        'id_barang',
        'jumlah',
        'tanggal_keluar',
        'penerima',
        'keterangan',
    ];

    public function barang()
    {
        return $this->belongsTo(Barangs::class, 'id_barang');
    }
}
