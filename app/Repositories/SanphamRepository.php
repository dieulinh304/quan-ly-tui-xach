<?php

namespace App\Repositories;

use App\Repositories\ISanphamRepository;
use App\Models\Sanpham;
use App\Models\Danhmuc;
use Illuminate\Http\Request;

class SanphamRepository implements ISanphamRepository
{
    public function allProduct()
    {
        return Sanpham::with('danhmuc')
            ->orderBy('id_sanpham', 'desc')
            ->take(20)
            ->get();
    }

    public function featuredProducts()
    {
        return Sanpham::with('danhmuc')
            ->orderBy('giasp', 'desc') // Sắp xếp theo giá giảm dần
            ->take(5)
            ->get();
    }

    public function relatedProduct()
    {
        return Sanpham::with('danhmuc')
            ->orderBy('id_sanpham', 'desc')
            ->take(10)
            ->get();
    }

    public function randomProduct()
    {
        return Sanpham::with('danhmuc')
            ->inRandomOrder()
            ->take(10)
            ->get();
    }

    public function searchProduct(Request $request)
    {
        $searchKeyword = $request->input('tukhoa');
        $danhmuc_id = $request->input('danhmuc_id');

        $query = Sanpham::with('danhmuc');

        if ($searchKeyword) {
            $query->where('tensp', 'like', '%' . $searchKeyword . '%');
        }

        if ($danhmuc_id) {
            $query->where('id_danhmuc', $danhmuc_id);
        }

        return $query->paginate(5);
    }
/* Lấy danh sách sản phẩm với phân trang */
    public function viewAllWithPagi()
    {
        return Sanpham::with('danhmuc')
            ->paginate(10);
    }
/* Lấy danh sách sản phẩm theo danh mục */
    public function getAllByDanhMuc($request)
    {
        $query = Sanpham::query();
        if ($request->has('danhmuc_id')) {
            $query->where('id_danhmuc', $request->danhmuc_id);
        }
        return $query->paginate(10);
    }
    public function getProductsByCategory($categoryId)
    {
        return Sanpham::with('danhmuc')
            ->where('id_danhmuc', $categoryId)
            ->take(5)
            ->get();
    }
}