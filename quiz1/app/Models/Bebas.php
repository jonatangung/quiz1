<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Bebas
{
    public function tambah(string $table, array $data): int
    {
        return DB::table($table)->insertGetId($data);
    }

    public function tarik(string $table, array $conditions): ?object
    {
        $query = DB::table($table);

        if ($table === 'user' && !Schema::hasColumn('user', 'id_user')) {
            $query->addSelect('id as id_user');
        }

        return $query->where($conditions)->first();
    }
}
