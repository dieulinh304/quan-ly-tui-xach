@extends('layout')
@section('content')
<!--Main-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="login-form" style="height: unset !important; margin-top: -105px!important;">
    <div class="main" style="padding-top: 180px; padding-bottom: 15px; margin-bottom: 0;">

        @if(session()->has('thongbao'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Đăng ký tài khoản thành công!',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        @endif

        <form action="{{route('register')}}" method="POST" class="form" style="width: 400px;" id="form-1">
            @csrf

            <h3 class="heading">Đăng ký tài khoản</h3>
            <div class="dont-have-account">
                Bạn đã có tài khoản? <a class="account-register" href="{{ URL::to('login')}}">Đăng nhập</a>
            </div>

            <div class="spacer"></div>

            <style>
                .form-group {
                    margin-bottom: 0;
                }
            </style>


            <div class="form-group">
                <label class="control-label text-left">Họ và tên</label>
                <div>
                    <input type="text" name="name" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label text-left">Email</label>
                <div>
                    <input type="email" name="email" class="form-control" id="email">
                    <div id="email-error"  class="text-danger" style="font-size: 13px; width: 100%; text-align: start; "></div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label text-left">Mật khẩu</label>
                <div>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label text-left">Địa chỉ</label>
                <div>
                    <input type="text" name="address" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label text-left">Điện thoại</label>
                <div>
                    <input type="text" name="phone" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label text-left">Ngày sinh</label>
                <div>
                    <input type="date" class="form-control" name="ngaysinh" id="ngaysinh" required />
                </div>
            </div>

            <button type="submit" value="Create" class="form-submit" name="register_submit">Đăng ký</button>

        </form>
    </div>
</div>
<script>
    let emailIsValid = true;

    document.getElementById('email').addEventListener('blur', function() {
        const emailInput = this;
        const errorSpan = document.getElementById('email-error');
        const email = emailInput.value;

        if (!email) {
            errorSpan.textContent = '';
            emailInput.removeAttribute('title');
            emailIsValid = true;
            return;
        }

        fetch('{{ route("kiemtra.email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    email: email
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    errorSpan.textContent = 'Email này đã được sử dụng. Vui lòng chọn email khác.';
                    emailIsValid = false;
                } else {
                    errorSpan.textContent = '';
                    emailIsValid = true;
                }
            })
            .catch(() => {
                errorSpan.textContent = 'Không thể kiểm tra email.';
                emailIsValid = false;
            });
    });

    document.getElementById('form-1').addEventListener('submit', function(e) {
        if (!emailIsValid) {
            e.preventDefault();
            document.getElementById('email').focus();
        }
    });
</script>
@endsection
