<?php

namespace App\Models\Supplier;

use App\Models\BarangMasuk\BarangMasuks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Suppliers extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_supplier',
        'alamat',
        'telepon',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barangMasuk(): HasMany
    {
        return $this->hasMany(BarangMasuks::class, 'id_supplier');
    }
}
