@extends('layout')
@section('content')

<form class="body" action="{{route('dathang')}}" method="POST" id="checkout" enctype="multipart/form-data">
    @csrf
    @foreach ($showusers as $key => $showuser)
    @if ($key == 0)
    <div class="mb-3 bg-light p-3 my-3" style="border-radius: 20px;">
        <h4>Thông tin khách hàng</h4>
        <div class="d-flex">
            <div class="mr-4">
                <div style="font-size: 18px;"><strong>Khách hàng:</strong> <span id="display_hoten">{{$showuser->hoten}}</span></div>
                <div style="font-size: 18px;"><strong>Email:</strong> <span id="display_email">{{$showuser->email}}</span></div>
            </div>
            <div class="">
                <div style="font-size: 18px;"><strong>Số điện thoại:</strong> <span id="display_sdt">0{{$showuser->sdt}}</span></div>
                <div style="font-size: 18px;"><strong>Địa chỉ:</strong> <span id="display_diachigiaohang">{{$showuser->diachi}}</span></div>
            </div>

            <input type="hidden" name="id_nd" value="{{$showuser->id_nd}}">
            <input type="hidden" id="input_hoten" name="display_hoten" value="{{$showuser->hoten}}">
            <input type="hidden" id="input__email" name="display_email" value="{{$showuser->email}}">
            <input type="hidden" id="input_sdt" name="display_sdt" value="{{$showuser->sdt}}">
            <input type="hidden" id="input_diachigiaohang" name="display_diachigiaohang" value="{{$showuser->diachi}}">
            <input type="hidden" id="input_ngaydathang" name="ngaydathang" value="">
        </div>
        <button style="margin-top: 10px;" type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#updateInfoModal">
            <i class="fa fa-edit mr-1"></i> Cập nhật thông tin
        </button>
    </div>

    @endif
    @endforeach

    <table id="cart" class="table table-hover table-condensed">
        <thead>
            <tr>
                <th>Ảnh sp</th>
                <th>Tên sp</th>
                <th>Giá gốc</th>
                <th>Giảm giá</th>
                <th>Giá khuyến mại</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0 @endphp
            @if(session('cart'))
            @foreach(session('cart') as $id => $details)
            @php $total += $details['giakhuyenmai'] * $details['quantity'] @endphp

            <tr data-id="{{ $id }}">
                <td><img src="{{ asset($details['anhsp']) }}" width="100" height="100" class="img-responsive" /></td>
                <td>
                    <div>{{ $details['tensp'] }}</div>
                </td>
                <td data-th="Price">{{ $details['giasp'] }}</td>
                <td data-th="Price">{{ $details['giamgia'] }}%</td>
                <td data-th="Subtotal" class="text-center">{{ $details['giakhuyenmai']}}đ</td>

                <td data-th="Quantity" class="quantity-input">
                    {{$details['quantity']}}
                </td>

                <td data-th="" class="text-center">{{ $details['giakhuyenmai'] * $details['quantity'] }}đ</td>
            </tr>

            <input type="hidden" name="id_sanpham" value="{{$details['id_sanpham']}}">
            <input type="hidden" name="tensp" value="{{ $details['tensp'] }}">
            <input type="hidden" name="giatien" value="{{$details['giasp']}}">
            <input type="hidden" name="giamgia" value="{{$details['giamgia']}}">
            <input type="hidden" name="giakhuyenmai" value="{{$details['giakhuyenmai']}}">
            <input type="hidden" name="soluong" value="{{$details['quantity']}}">

            @endforeach
            @endif
        </tbody>

        <tfoot>

            <tr>
                <td colspan="7" class="bg-light">
                    <div class="d-flex justify-content-between">
                        <h4 class="pttt">Phương thức thanh toán</h4>
                        <div>
                            <div class="d-flex align-items-center p-2">
                                <input type="radio" id="cod" name="redirect" value="COD" checked>
                                <label for="cod" style="margin-bottom: 1px; margin-left: 5px; font-size: 20px;" class="paymentContent font-weight-bold text-xl p">
                                    Trả tiền khi nhận hàng (COD)
                                </label>
                            </div>

                            <div class="d-flex align-items-center p-2">
                                <input type="radio" id="vnpay" name="redirect" value="VNPAY">
                                <label for="vnpay" style="margin-bottom: 1px; margin-left: 5px; font-size: 20px;" class="paymentContent font-weight-bold text-xl p">
                                    Thanh toán online (VNPAY)
                                </label>
                            </div>
                        </div>
                    </div>

                </td>
            </tr>

            <tr>
                <td colspan="7" class="text-right">
                    <h3 class="d-flex justify-content-end align-items-center">
                        Tổng thanh toán &nbsp;<div class="text-danger" style="font-size: 40px;">{{ number_format($total, 0, ',', '.') }}đ</div>
                        <input type="hidden" name="tongtien" value="{{$total}}">
                    </h3>
                </td>
            </tr>

            <tr>
                <td colspan="7" class="text-right">
                    <a href="{{ url('/cart') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Quay lại giỏ hàng</a>
                    <button type="submit" class="btn btn-success text-white">Đặt hàng</button>
                </td>
            </tr>

        </tfoot>
    </table>
</form>
@csrf

@foreach ($showusers as $key => $showuser)
@if ($key == 0)
<div class="modal fade" id="updateInfoModal" tabindex="-1" aria-labelledby="updateInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="updateInfoForm" class="modal-content">
            @csrf
            <input type="hidden" name="id_nd" value="{{ $showuser->id_nd }}">
            <div class="modal-header">
                <h5 class="modal-title" id="updateInfoModalLabel">Cập nhật thông tin khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="hoten">Họ tên</label>
                    <input type="text" class="form-control" id="hoten" name="hoten" value="{{ $showuser->hoten }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $showuser->email }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="sdt">Số điện thoại</label>
                    <input type="text" class="form-control" id="sdt" name="sdt" pattern="^0\d{8,10}$"
                        required
                        minlength="10"
                        maxlength="10"
                        title="Số điện thoại phải bắt đầu bằng 0 và 10 chữ số" value="0{{ $showuser->sdt }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="diachi">Địa chỉ</label>
                    <input type="text" class="form-control" id="diachi" name="diachi" value="{{ $showuser->diachi }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            </div>
        </form>
    </div>
</div>
@endif
@endforeach
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Đặt hàng thất bại',
        text: "{{ session('error') }}",
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif
<script>
    $(document).ready(function() {
        $('#updateInfoForm').on('submit', function(e) {
            e.preventDefault();

            var hoten = $('#hoten').val();
            var email = $('#email').val();
            var sdt = $('#sdt').val();
            var diachi = $('#diachi').val();

            $('#display_hoten').text(hoten);
            $('#display_email').text(email);
            $('#display_sdt').text(sdt);
            $('#display_diachigiaohang').text(diachi);
            $('#input_hoten').val(hoten);
            $('#input_email').val(email);
            $('#input_sdt').val(sdt);
            $('#input_diachigiaohang').val(diachi);

            $('#updateInfoModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Thông tin đã được cập nhật!',
                timer: 2000,
                showConfirmButton: false
            });
            // alert('Thông tin đã được cập nhật!');
        });
    })
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
