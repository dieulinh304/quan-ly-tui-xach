@extends('layout')
@section('content')
<div class="body">
    <h1 class="h3 mb-3 bg-light p-3"><strong>Đơn hàng đã đặt</strong></h1>

    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
    @endif

    <div class="mb-3 bg-light p-3 my-3" style="border-radius: 20px;">
        <h4>Thông tin khách hàng</h4>
        <div class="d-flex">
            <div class="mr-4">
                <div style="font-size: 18px;"><strong>Khách hàng:</strong> <span id="display_hoten">{{$order->hoten}}</span></div>
                <div style="font-size: 18px;"><strong>Email:</strong> <span id="display_email">{{$order->email}}</span></div>
            </div>
            <div class="">
                <div style="font-size: 18px;"><strong>Số điện thoại:</strong> <span id="display_sdt">0{{$order->sdt}}</span></div>
                <div style="font-size: 18px;"><strong>Địa chỉ:</strong> <span id="display_diachigiaohang">{{$order->diachigiaohang}}</span></div>
            </div>
        </div>
        <button style="margin-top: 10px;" type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#updateInfoModal">
            <i class="fa fa-edit mr-1"></i>Thay đổi thông tin
        </button>
    </div>

    <div class="mb-3">
        <table class="table table-hover my-0">
            <tbody>
                <tr>
                    <th>Ngày đặt</th>
                    <td>{{ date('d-m-Y H:i:s', strtotime($order->ngaydathang)) }}</td>
                </tr>
                <tr>
                    <th>Ngày giao</th>
                    <td>
                        {{ date('d-m-Y', strtotime($order->ngaygiaohang)) }}
                    </td>
                </tr>
                <tr>
                    <th>Phương thức thanh toán</th>
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
                </tr>
                <tr>
                    <th>Địa chỉ giao hàng</th>
                    <td>{{$order->diachigiaohang}}</td>
                </tr>
                <tr>
                    <th>Trạng thái</th>
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
                </tr>
            </tbody>
        </table>
    </div>


    <div class="mb-3">
        <table class="table table-hover my-0">
            <thead>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá gốc</th>
                <th>Giảm giá</th>
                <th>Giá khuyến mại</th>
                <th>tổng tiền</th>
            </thead>
            <tbody>
                @php
                $totalPrice = 0; // Khởi tạo biến tổng tiền
                @endphp
                @foreach ($orderdetails as $orderdetail)
                <tr>
                    <td>{{$orderdetail->tensp}}</td>
                    <td>{{$orderdetail->soluong}}</td>
                    <td>{{$orderdetail->giatien}}</td>
                    <td>{{$orderdetail->giamgia}}%</td>
                    <td>{{$orderdetail->giakhuyenmai}}</td>
                    <td>{{$orderdetail->giakhuyenmai * $orderdetail->soluong}}</td>
                </tr>

                @php
                $totalPrice += $orderdetail->giakhuyenmai * $orderdetail->soluong; // Cộng giá trị tổng tiền
                @endphp

                @endforeach

            </tbody>
        </table>
    </div>

    <h3 class="d-flex justify-content-end align-items-center">
        Tổng thanh toán &nbsp;<div class="text-danger" style="font-size: 40px;">{{ number_format($totalPrice, 0, ',', '.') }}đ</div>
    </h3>

    &nbsp;<a class="btn btn-secondary" href="{{URL::to('/donhang')}}">Quay lại</a>
</div>
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: 'Thay đổi thông tin khách hàng thành công.',
            timer: 2000,
            showConfirmButton: false
        });
    });
</script>
@endif
<div class="modal fade" id="updateInfoModal" tabindex="-1" aria-labelledby="updateInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('donhang.update') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="id_dathang" value="{{ $order->id_dathang }}">
            <div class="modal-header">
                <h5 class="modal-title" id="updateInfoModalLabel">Cập nhật thông tin khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="hoten">Họ tên</label>
                    <input type="text" class="form-control" id="hoten" name="hoten" value="{{ $order->hoten }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $order->email }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="sdt">Số điện thoại</label>
                    <input type="text" class="form-control" id="sdt" name="sdt" pattern="^0\d{8,10}$"
                        required
                        minlength="10"
                        maxlength="10"
                        title="Số điện thoại phải bắt đầu bằng 0 và 10 chữ số" value="0{{ $order->sdt }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="diachi">Địa chỉ</label>
                    <input type="text" class="form-control" id="diachi" name="diachi" value="{{ $order->diachigiaohang }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            </div>
        </form>
    </div>
</div>

<script>
    //cod
    $('#cod').click(function() {
        // $('#cod').attr('value', 'COD');
        $('#checkout').attr('action', "{{route('dathang')}}");
    });

    //chuyen khoan vnpay
    $('#vnpay').click(function() {
        // $('#vnpay').attr('value', 'VNPAY');
        $('#checkout').attr('action', "{{route('vnpay')}}");

    });
</script>
@endsection
