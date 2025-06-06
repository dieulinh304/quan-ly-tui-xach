<?php

namespace App\Repositories;

use App\Repositories\IOrderRepository;
use App\Models\Dathang;

use Illuminate\Support\Facades\DB;

class OrderRepository implements IOrderRepository
{

    public function allOrder()
    {
        return Dathang::orderBy('id_dathang', 'desc')->paginate(2);
    }
    public function findOrder($id)
    {
        return Dathang::where('id_dathang', $id)->first();
    }
    public function findDetailProduct($id)
    {
        return DB::table('chitiet_donhang')
            ->join('dathang', 'chitiet_donhang.id_dathang', '=', 'dathang.id_dathang')
            ->select('chitiet_donhang.*')
            ->where('dathang.id_dathang', $id)
            ->get();
    }
    public function findUser($id)
    {
        return DB::table('nguoidung')
            ->join('dathang', 'nguoidung.id_nd', '=', 'dathang.id_nd')
            ->select('nguoidung.*')
            ->where('dathang.id_dathang', $id)
            ->get();
    }
    public function updateOrder($data, $id)
    {
        $this->findOrder($id)->update($data);
    }

    public function orderView($id)
    {
        return Dathang::where('id_nd', $id)
            ->orderBy('ngaydathang', 'desc')
            ->get();
    }
}
