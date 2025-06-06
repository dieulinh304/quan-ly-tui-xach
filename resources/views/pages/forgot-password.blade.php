@extends('layout')
@section('content')
<div class="login-form">
    <div class="height360">
        <div class="main">

            @if(Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            <form action="{{ route('forgot.send') }}" method="POST" class="form">
                @csrf
                <h3 class="heading">Quên mật khẩu</h3>

                <div class="form-group">
                    <label class="form-label">Email đã đăng ký</label>
                    <input type="email" name="email" class="form-control" required>
                    <span class="form-message"></span>
                </div>

                <button type="submit" class="form-submit">Gửi link đặt lại mật khẩu</button>
                <div class="dont-have-account">
                    <a class="account-register" href="{{ route('login') }}">Quay lại đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
