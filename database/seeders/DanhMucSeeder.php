<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Danhmuc;

class DanhMucSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['id_danhmuc' => 9, 'ten_danhmuc' => 'Gucci'],
            ['id_danhmuc' => 10, 'ten_danhmuc' => 'Christian Dior'],
            ['id_danhmuc' => 11, 'ten_danhmuc' => 'Hermes'],
            ['id_danhmuc' => 12, 'ten_danhmuc' => 'Chanel'],
        ];

        foreach ($data as $item) {
            Danhmuc::create($item);
        }
    }
}
