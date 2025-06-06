<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dathang extends Model
{
    protected $table = 'dathang';
    protected $primaryKey = 'id_dathang';
    public $timestamps = false;

    protected $fillable = [
        'ngaydathang',
        'ngaygiaohang',
        'tongtien',
        'phuongthucthanhtoan',
        'diachigiaohang',
        'hoten',
        'email',
        'sdt',
        'trangthai',
        'id_nd'
    ];

    protected $casts = [
        'id_dathang' => 'int',
        'ngaydathang' => 'datetime',
        'ngaygiaohang' => 'datetime',
        'tongtien' => 'int',
        'phuongthucthanhtoan' => 'string',
        'diachigiaohang' => 'string',
        'hoten' => 'string',
        'email' => 'string',
        'sdt' => 'int',
        'trangthai' => 'string',
        'id_nd' => 'int',
    ];

    protected $dates = [
        'ngaydathang',
        'ngaygiaohang',
    ];
}
