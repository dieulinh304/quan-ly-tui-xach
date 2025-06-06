@extends('layout')
@section('content')
<!--Main-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="login-form">
    <div class="height360">
        <div class="main">
            <form action="{{route('login')}}" method="POST" class="form" id="form-2">
                @csrf
                <h3 class="heading">Đăng nhập</h3>


                <div class="form-group">
                    <label for="Fullname" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control">
                    <span class="form-message"></span>
                </div>

                <div class="form-group" style="position: relative;">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" id="password">
                    <span class="form-message"></span>

                    <span id="togglePassword" style="position: absolute; right: 10px; top: 50px; cursor: pointer;">
                        <i class="fa-solid fa-eye" id="eyeIcon" style="cursor: pointer;"></i>
                    </span>
                </div>


                <button type="submit" class="form-submit" value="Login" name="login_submit">Đăng nhập</button>

                <div class="dont-have-account">
                    Bạn chưa có tài khoản? <a class="account-register" href="{{ URL::to('register')}}">Đăng ký ngay</a>
                </div>
                <div class="dont-have-account">
                    Quên mật khẩu? <a class="account-register" href="{{ route('password.forgot') }}">Lấy lại mật khẩu</a>
                </div>
            </form>
        </div>
    </div>
</div>
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Đăng nhập thất bại',
        text: "{{ session('error') }}",
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    });
</script>
@endsection
