<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\Sanpham;
use App\Models\Dathang;
use App\Models\ChitietDonhang;

class CartController extends Controller
{
    public function index()
    {
        $products = Sanpham::all();
        return view('products', compact('products'));
    }

    public function cart()
    {
        return view('pages.cart');
    }

    public function addToCart($id)
    {
        $product = Sanpham::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id_sanpham" => $product->id_sanpham,
                "tensp" => $product->tensp,
                "anhsp" => $product->anhsp,
                "giasp" => $product->giasp,
                "giamgia" => $product->giamgia,
                "giakhuyenmai" => $product->giakhuyenmai,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công!');
    }

    public function addGoToCart($id)
    {
        $product = Sanpham::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id_sanpham" => $product->id_sanpham,
                "tensp" => $product->tensp,
                "anhsp" => $product->anhsp,
                "giasp" => $product->giasp,
                "giamgia" => $product->giamgia,
                "giakhuyenmai" => $product->giakhuyenmai,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect('/cart');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity;
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Kiểm tra số lượng hợp lệ
            if ($quantity < 1 || $quantity > 999) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng không hợp lệ.',
                    'quantity' => $cart[$id]['quantity'] // Trả về số lượng hiện tại để khôi phục
                ], 400);
            }

            // Cập nhật số lượng
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);

            // Tính tổng tiền của sản phẩm
            $productTotal = $cart[$id]['giakhuyenmai'] * $quantity;

            // Tính tổng tiền giỏ hàng
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['giakhuyenmai'] * $item['quantity'];
            }

            return response()->json([
                'status' => 'success',
                'product_total' => $productTotal,
                'total' => $total,
                'message' => 'Cập nhật giỏ hàng thành công!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'
        ], 400);
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            // Tính tổng tiền giỏ hàng
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['giakhuyenmai'] * $item['quantity'];
            }

            return response()->json([
                'status' => 'success',
                'total' => $total,
                'message' => 'Xóa sản phẩm trong giỏ hàng thành công'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'
        ], 400);
    }

    public function checkout()
    {
        if (Auth::check()) {
            if (Auth::user()) {
                $showusers = DB::table('nguoidung')
                    ->select('nguoidung.*')
                    ->where('nguoidung.id_nd', Auth::user()->id_nd)
                    ->get();
                return view('pages.checkout', ['showusers' => $showusers]);
            }
        }
        return redirect('/login');
    }

    public function dathang(Request $request)
    {
        if (!session()->has('cart') || empty(session('cart'))) {
            return redirect()->back()->with('error', 'Không có đơn hàng để đặt!');
        }

        $validatedDataDatHang = $request->validate([]);

        $validatedDataDatHang['ngaygiaohang'] = Carbon::now()->addDay(4);
        $validatedDataDatHang['tongtien'] = $request->tongtien;
        $validatedDataDatHang['phuongthucthanhtoan'] = $request->redirect;
        $validatedDataDatHang['diachigiaohang'] = $request->display_diachigiaohang;
        $validatedDataDatHang['hoten'] = $request->display_hoten;
        $validatedDataDatHang['email'] = $request->display_email;
        $validatedDataDatHang['sdt'] = $request->display_sdt;
        $validatedDataDatHang['trangthai'] = "đang xử lý";
        $validatedDataDatHang['id_nd'] = Auth::user()->id_nd;

        $dathangCre = Dathang::create($validatedDataDatHang);


        $validatedDataCTDatHang = $request->validate([]);

        foreach (session('cart') as $item) {
            $sanpham = Sanpham::findOrFail($item['id_sanpham']);
            $soluongDaBan = DB::table('chitiet_donhang')
                ->where('id_sanpham', $item['id_sanpham'])
                ->sum('soluong');
            $soluongconlai = $sanpham->soluong - $soluongDaBan;

            if ($item['quantity'] > $soluongconlai) {
                return redirect()->back()->with('error', "Sản phẩm {$sanpham->tensp} không còn đủ số lượng trong kho!");
            }
        }

        foreach (session('cart') as $item) {
            $validatedDataCTDatHang['tensp'] = $item['tensp'];
            $validatedDataCTDatHang['soluong'] = $item['quantity'];
            $validatedDataCTDatHang['giamgia'] = $item['giamgia'];
            $validatedDataCTDatHang['giatien'] = $item['giasp'];
            $validatedDataCTDatHang['giakhuyenmai'] = $item['giakhuyenmai'];
            $validatedDataCTDatHang['id_sanpham'] = $item['id_sanpham'];
            $validatedDataCTDatHang['id_dathang'] = $dathangCre->id_dathang;
            $validatedDataCTDatHang['id_nd'] = Auth::user()->id_nd;

            ChitietDonhang::create($validatedDataCTDatHang);
        }

        $request->session()->forget('cart');

        return view('pages.thongbaodathang');
    }

    public function thongbaodathang(Request $request)
    {
        if ($request->has('vnp_ResponseCode') && $request->has('vnp_TransactionNo')) {
            $responseCode = $request->input('vnp_ResponseCode');

            if ($responseCode == '00') {
                return view('pages.thongbaodathang');
            } else {
                return redirect('/cart');
            }
        } else {
            return redirect('/cart');
        }
    }

    public function vnpay(Request $request)
    {
        $vnp_TmnCode = "GHHNT2HB"; // Mã website tại VNPAY
        $vnp_HashSecret = "BAGAOHAPRHKQZASKQZASVPRSAKPXNYXS"; // Chuỗi bí mật

        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/thongbaodathang";
        $vnp_TxnRef = date("YmdHis"); // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->tongtien * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }

        $this->dathang($request);

        return redirect($vnp_Url);
    }
    // public function capnhatThongTin(Request $request)
    // {
    //     $request->validate([
    //         'id_nd' => 'required|exists:nguoidung,id_nd',
    //         'diachi' => 'required|string|max:100',
    //         'hoten' => 'required|string|max:100',
    //         'email' => 'required|email|max:100',
    //         'sdt' => 'required|digits_between:9,11',
    //     ]);

    //     DB::table('nguoidung')
    //         ->where('id_nd', $request->id_nd)
    //         ->update([
    //             'diachi' => $request->diachi,
    //             'hoten'  => $request->hoten,
    //             'email'  => $request->email,
    //             'sdt'    => $request->sdt,
    //         ]);

    //     return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    // }
}
