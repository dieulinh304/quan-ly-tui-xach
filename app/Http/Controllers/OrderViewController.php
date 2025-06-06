<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\IOrderRepository;
use DB;

use Illuminate\Support\Facades\Auth;

class OrderViewController extends Controller
{

    private $OrderRepository;

    public function __construct(IOrderRepository $OrderRepository)
    {
        $this->OrderRepository = $OrderRepository;
    }

    public function donhang()
    {

        $user = Auth::user();
        if ($user) {
            $orders = $this->OrderRepository->orderView($user->id_nd);
            // print_r($orders);
            return view('pages.donhang', ['orders' => $orders]);
        } else {
            return redirect('/');
        }
    }

    public function edit($id)
    {
        $order = $this->OrderRepository->findOrder($id);
        $orderdetails = $this->OrderRepository->findDetailProduct($id);
        $showusers = $this->OrderRepository->findUser($id);
        return view('pages.donhangdetail', ['order' => $order, 'orderdetails' => $orderdetails, 'showusers' => $showusers]);
    }

    public function capnhatThongTin(Request $request)
    {
        $request->validate([
            'id_dathang' => 'required|exists:dathang,id_dathang',
            'diachi' => 'required|string|max:100',
            'hoten' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'sdt' => 'required|digits_between:9,11',
        ]);

        DB::table('dathang')
            ->where('id_dathang', $request->id_dathang)
            ->update([
                'diachigiaohang' => $request->diachi,
                'hoten'  => $request->hoten,
                'email'  => $request->email,
                'sdt'    => $request->sdt,
            ]);
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
