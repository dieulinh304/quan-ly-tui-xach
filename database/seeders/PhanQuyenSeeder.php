<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhanQuyen;

class PhanQuyenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['id_phanquyen' => 1, 'tenquyen' => 'admin'],
            ['id_phanquyen' => 2, 'tenquyen' => 'user'],
            ['id_phanquyen' => 3, 'tenquyen' => 'staff'],
        ];

        foreach ($data as $item) {
            PhanQuyen::create($item);
        }
    }
}
