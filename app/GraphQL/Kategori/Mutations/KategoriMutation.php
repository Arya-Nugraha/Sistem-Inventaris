<?php

namespace App\GraphQL\Kategori\Mutations;

use App\Models\Kategori\Kategoris;

class KategoriMutation
{
    public function restore($_, array $args)
    {
        $Kategori = Kategoris::withTrashed()->findOrFail($args['id']);
        $Kategori->restore();
        return $Kategori;
    }

    public function forceDelete($_, array $args)
    {
        $Kategori = Kategoris::withTrashed()->findOrFail($args['id']);
        $Kategori->forceDelete();
        return $Kategori;
    }
}