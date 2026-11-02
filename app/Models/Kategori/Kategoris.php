<?php

namespace App\Models\Kategori;

use App\Models\Barang\Barangs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategoris extends Model
{
    use SoftDeletes;
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_kategori'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barang(): HasMany
    {
        return $this->hasMany(Barangs::class, 'id_kategori');
    }

    public function barangs(): HasMany
    {
        return $this->barang();
    }
}
