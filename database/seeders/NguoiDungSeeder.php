<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NguoiDung;

class NguoiDungSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id_nd' => 1,
                'hoten' => 'teo',
                'email' => 'teo@gmail.com',
                'password' => '$2y$12$o42vmZrn2TzpqtP0NJ/VyOd0qgv2coPm76eyZ/ZNwUgBHNUUW6H2y',
                'diachi' => 'Đống Đa, Hà nội',
                'sdt' => 379487241,
                'id_phanquyen' => 2,
            ],
            [
                'id_nd' => 2,
                'hoten' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$/NpqKoSr.zwBa83nJfw8KuHTYjVmH51H/boJ.CxtIR8Sn/tTVg.NS',
                'diachi' => 'Đống Đa, Hà nội',
                'sdt' => 379487352,
                'id_phanquyen' => 1,
            ],
            [
                'id_nd' => 3,
                'hoten' => 'demotk',
                'email' => 'demotk@gmail.com',
                'password' => '$2y$12$z66Zyr0M/Ag7j6iQZvwjjuuqL4yQP/k68uo3Cmq0kxKghvuQFzjpK',
                'diachi' => 'demotk',
                'sdt' => 364877529,
                'id_phanquyen' => 2,
            ],
            [
                'id_nd' => 4,
                'hoten' => 'dieulinh',
                'email' => 'dlinh30042004@gmail.com',
                'password' => '$2y$12$/NpqKoSr.zwBa83nJfw8KuHTYjVmH51H/boJ.CxtIR8Sn/tTVg.NS',
                'diachi' => '102',
                'sdt' => 359723803,
                'id_phanquyen' => 1,
            ],
            [
                'id_nd' => 5,
                'hoten' => 'hoà nguyễn',
                'email' => 'hoacutehd2003@gmail.com',
                'password' => '$2y$12$ebsDSfsT/w/yLAyfHmqkr.m8TuEhy4CY4VhCqaibCspDj742B4sx2',
                'diachi' => 'Chùa Bộc',
                'sdt' => 364273858,
                'id_phanquyen' => 2,
            ],
            [
                'id_nd' => 6,
                'hoten' => 'Lê Thị Kim Oanh',
                'email' => 'oanhcute6c@gmail.com',
                'password' => '$2y$12$LMbc0gU1wFNgqYkiEnEsquUSfKQ/ZFwa5W9Mrvl9qbESU9AnTu/EW',
                'diachi' => 'Nghệ An',
                'sdt' => 943377126,
                'id_phanquyen' => 2,
            ],
            [
                'id_nd' => 7,
                'hoten' => 'Phan Tuan',
                'email' => 'anhtuana1k99@gmail.com',
                'password' => '$2y$12$xx3yBmp4PilqSha2Ydf1V.ZnjnDOCulSGZB3hMucaDwsw0q58q8Ay',
                'diachi' => 'hanoi',
                'sdt' => 943377126,
                'id_phanquyen' => 2,
            ],
        ];

        foreach ($data as $item) {
            NguoiDung::create($item);
        }
    }
}
