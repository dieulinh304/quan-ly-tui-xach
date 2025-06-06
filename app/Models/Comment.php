<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments'; // tên bảng

    protected $fillable = [
        'user_id',
        'sanpham_id',
        'content',
    ];

    // Liên kết tới khách hàng (user)
    public function user()
    {
        return $this->belongsTo(NguoiDung::class, 'user_id', 'id_nd');
    }

    // Liên kết tới sản phẩm
    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'sanpham_id', 'id_sanpham');
    }
}
