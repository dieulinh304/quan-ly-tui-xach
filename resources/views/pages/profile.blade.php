@extends('layout')
@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center" style="color: var(--Hover-icon);">Thông tin cá nhân</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white text-dark">
                    <h5>Thông tin tài khoản</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        {{-- Họ tên --}}
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Họ tên:</label>
                    <div class="col-sm-9 d-flex align-items-center">
                        <span id="hoten-display" class="profile-value">{{ $user->hoten }}</span>
                        <input type="text" class="form-control profile-input d-none" id="hoten-input" name="hoten" value="{{ $user->hoten }}" required>
                        <button type="button" class="btn btn-sm btn-outline-secondary ml-auto edit-btn" data-target="hoten">Thay đổi</button>
                    </div>
                </div>
                {{-- Email --}}
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email:</label>
                    <div class="col-sm-9 d-flex align-items-center">
                        <span id="email-display" class="profile-value">{{ $user->email }}</span>
                        <input type="email" class="form-control profile-input d-none" id="email-input" name="email" value="{{ $user->email }}" required>
                        <button type="button" class="btn btn-sm btn-outline-secondary ml-auto edit-btn" data-target="email">Thay đổi</button>
                    </div>
                </div>
                {{-- Địa chỉ --}}
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Địa chỉ:</label>
                    <div class="col-sm-9 d-flex align-items-center">
                        <span id="diachi-display" class="profile-value">{{ $user->diachi }}</span>
                        <input type="text" class="form-control profile-input d-none" id="diachi-input" name="diachi" value="{{ $user->diachi }}">
                        <button type="button" class="btn btn-sm btn-outline-secondary ml-auto edit-btn" data-target="diachi">Thay đổi</button>
                    </div>
                </div>
                {{-- Số điện thoại --}}
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Số điện thoại:</label>
                    <div class="col-sm-9 d-flex align-items-center">
                        <span id="sdt-display" class="profile-value">{{ $user->sdt }}</span>
                        <input type="text" class="form-control profile-input d-none" id="sdt-input" name="sdt" value="{{ $user->sdt }}">
                        <button type="button" class="btn btn-sm btn-outline-secondary ml-auto edit-btn" data-target="sdt">Thay đổi</button>
                    </div>
                </div>
                        <div class="form-group row mb-0">
                            <div class="col-sm-9 offset-sm-3 text-right">
                                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Phần thay đổi mật khẩu --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white text-dark">
                    <h5>Thay đổi mật khẩu</h5>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-warning mb-3" id="show-password-form">Đổi mật khẩu</button>
                    <form action="{{ route('profile.updatePassword') }}" method="POST" id="password-form" class="d-none">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="current_password" class="col-sm-4 col-form-label">Mật khẩu hiện tại:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_password" class="col-sm-4 col-form-label">Mật khẩu mới:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_password_confirmation" class="col-sm-4 col-form-label">Xác nhận mật khẩu mới:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-sm-8 offset-sm-4 text-right">
                                <button type="submit" class="btn btn-warning">Xác nhận đổi mật khẩu</button>
                                <button type="button" class="btn btn-secondary" id="cancel-password-change">Hủy</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chức năng chỉnh sửa thông tin cá nhân
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const target = this.dataset.target;
                const displayElement = document.getElementById(target + '-display');
                const inputElement = document.getElementById(target + '-input');

                displayElement.classList.add('d-none');
                inputElement.classList.remove('d-none');
                inputElement.focus();
                this.classList.add('d-none'); // Ẩn nút "Thay đổi"
            });
        });

        document.querySelectorAll('.profile-input').forEach(input => {
            input.addEventListener('blur', function() {
                // Khi input mất focus, nếu người dùng không thay đổi giá trị, trở lại dạng label
                // hoặc bạn có thể thêm logic để tự động lưu hoặc có nút "Lưu" riêng cho từng trường
                const target = this.id.replace('-input', '');
                const displayElement = document.getElementById(target + '-display');
                const editButton = document.querySelector(`.edit-btn[data-target="${target}"]`);

                // Nếu giá trị input không thay đổi so với display ban đầu
                if (this.value === displayElement.textContent.trim()) {
                    displayElement.classList.remove('d-none');
                    this.classList.add('d-none');
                    editButton.classList.remove('d-none');
                }
            });
        });

        // Chức năng hiển thị form đổi mật khẩu
        const showPasswordFormButton = document.getElementById('show-password-form');
        const passwordForm = document.getElementById('password-form');
        const cancelPasswordChangeButton = document.getElementById('cancel-password-change');

        showPasswordFormButton.addEventListener('click', function() {
            passwordForm.classList.remove('d-none');
            this.classList.add('d-none'); // Ẩn nút "Đổi mật khẩu"
        });

        cancelPasswordChangeButton.addEventListener('click', function() {
            passwordForm.classList.add('d-none');
            showPasswordFormButton.classList.remove('d-none'); // Hiện lại nút "Đổi mật khẩu"
            passwordForm.reset(); // Xóa dữ liệu đã nhập trong form
            // Xóa các thông báo lỗi nếu có (tùy thuộc vào cách Laravel xử lý lỗi client-side)
            document.querySelectorAll('.text-danger').forEach(span => span.textContent = '');
        });
    });
</script>
@endsection