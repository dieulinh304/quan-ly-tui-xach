@extends('layout')
@section('content')

<div class="body">
    <h1 class="h3 mb-3"><strong>Danh sách đơn hàng</strong></h1>

    <div class="">
        @if(session()->has('success'))
        <div class="alert alert-success mb-3">
            {{session('success')}}
        </div>
        @endif
    </div>

    <div class="card flex-fill">

        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Thanh toán</th>
                    <th>Ngày đặt</th>
                    <th>Ngày giao dự kiến</th>
                    <th>Trạng thái</th>
                    <th>Địa chỉ giao hàng</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($orders) && count($orders) > 0)
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @if ($order->phuongthucthanhtoan == "COD")
                            <td class="d-none d-xl-table-cell">
                                <div class="badge bg-secondary text-white">{{$order->phuongthucthanhtoan}}</div>
                            </td>
                            @elseif ($order->phuongthucthanhtoan == "VNPAY")
                            <td class="d-none d-xl-table-cell">
                                <div class="badge bg-primary text-white">{{$order->phuongthucthanhtoan}}</div>
                            </td>
                            @else
                            <td class="d-none d-xl-table-cell">{{$order->phuongthucthanhtoan}}</td>
                            @endif

                            <td class="d-none d-xl-table-cell">{{ date('d-m-Y H:i:s', strtotime($order->ngaydathang)) }}</td>
                            @if ($order->ngaygiaohang)
                            <td class="d-none d-xl-table-cell">{{ date('d-m-Y', strtotime($order->ngaygiaohang)) }}</td>
                            @else
                            <td></td>
                            @endif

                            <td>
                                @if($order->trangthai == 'đang xử lý')
                                <span class="badge bg-primary text-white">{{$order->trangthai}}</span>
                                @elseif ($order->trangthai == 'chờ lấy hàng')
                                <span class="badge bg-warning text-white">{{$order->trangthai}}</span>
                                @elseif ($order->trangthai == 'đang giao hàng')
                                <span class="badge bg-success text-white">{{$order->trangthai}}</span>
                                @elseif ($order->trangthai == 'giao thành công')
                                <span class="badge bg-success text-white">{{$order->trangthai}}</span>
                                @else
                                <span class="badge bg-danger text-white">{{$order->trangthai}}</span>
                                @endif
                            </td>

                            <td class="d-none d-md-table-cell">{{$order->diachigiaohang}}</td>
                            <td class="d-none d-md-table-cell">
                                <a href="{{ route('donhang.edit', ['id' => $order->id_dathang]) }}" class="btn btn-primary">Xem đơn hàng</a>
                            </td>
                        </tr>
                    @endforeach
                @elseif (isset($needLogin) && $needLogin)
                    <tr>
                        <td colspan="8" class="text-center text-muted">Vui lòng đăng nhập để xem đơn hàng</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="8" class="text-center text-muted">Không có dữ liệu đơn hàng đã đặt</td>
                    </tr>
                @endif
            </tbody>

        </table>

    </div>
</div>
@if (isset($needLogin) && $needLogin)
    <!-- Modal nhỏ -->
    <div id="loginModal" style="
        position: fixed;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px 30px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        z-index: 1000;
        text-align: center;
    ">
        <p style="font-size: 16px; margin-bottom: 20px;">Bạn cần đăng nhập để xem đơn hàng.</p>
        <div>
            <a href="/login" class="btn btn-primary" style="margin-right: 10px;">Chuyển đến đăng nhập</a>
            <button onclick="document.getElementById('loginModal').style.display='none'" class="btn btn-secondary">Hủy</button>
        </div>
    </div>

    <!-- Overlay nền mờ -->
    <div id="overlay" style="
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    "></div>
@endif

@endsection
