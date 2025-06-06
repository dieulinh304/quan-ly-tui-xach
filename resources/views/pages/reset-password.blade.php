@extends('layout')
@section('content')
<div class="login-form">
    <div class="height360">
        <div class="main">

            @if(Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <h3 class="heading">Đặt lại mật khẩu</h3>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu mới</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="form-submit">Đặt lại mật khẩu</button>
            </form>
        </div>
    </div>
</div>
@endsection
