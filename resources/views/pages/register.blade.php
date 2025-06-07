@extends('layout')
@section('content')
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
                .form-message {
                    font-size: 13px;
                    width: 100%;
                    text-align: start;
                    color: red;
                    margin-top: 5px; /* Add some space above the error message */
                }
            </style>


            <div class="form-group">
                <label class="control-label text-left">Họ và tên</label>
                <div>
                    <input type="text" name="name" class="form-control" id="name" required>
                    <span class="form-message"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label text-left">Email</label>
                <div>
                    <input type="email" name="email" class="form-control" id="email" required>
                    <div id="email-error" class="text-danger form-message"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label text-left">Mật khẩu</label>
                <div>
                    <input type="password" name="password" class="form-control" id="password" required>
                    <span class="form-message"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label text-left">Địa chỉ</label>
                <div>
                    <input type="text" name="address" class="form-control" id="address" required>
                    <span class="form-message"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label text-left">Điện thoại</label>
                <div>
                    <input type="text" name="phone" class="form-control" id="phone" required>
                    <span class="form-message"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label text-left">Ngày sinh</label>
                <div>
                    <input type="date" class="form-control" name="ngaysinh" id="ngaysinh" required />
                    <span class="form-message"></span>
                </div>
            </div>

            <button type="submit" value="Create" class="form-submit" name="register_submit">Đăng ký</button>

        </form>
    </div>
</div>
<script>
    let emailIsValid = true;

    // Function to show error message for a given input
    function showError(input, message) {
        const formGroup = input.closest('.form-group');
        const errorElement = formGroup.querySelector('.form-message');
        if (errorElement) {
            errorElement.textContent = message;
            input.classList.add('is-invalid'); // Add a class for styling invalid inputs
        }
    }

    // Function to hide error message for a given input
    function hideError(input) {
        const formGroup = input.closest('.form-group');
        const errorElement = formGroup.querySelector('.form-message');
        if (errorElement) {
            errorElement.textContent = '';
            input.classList.remove('is-invalid'); // Remove the invalid class
        }
    }

    // Validate on blur for all required fields
    document.querySelectorAll('#form-1 input[required]').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                showError(this, 'Vui lòng nhập trường này.');
            } else {
                hideError(this);
            }
        });

        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                hideError(this);
            }
        });
    });


    // Email validation (existing logic)
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

    // Form submission validation
    document.getElementById('form-1').addEventListener('submit', function(e) {
        let formIsValid = true;

        // Check all required fields
        document.querySelectorAll('#form-1 input[required]').forEach(input => {
            if (input.value.trim() === '') {
                showError(input, 'Vui lòng nhập trường này.');
                formIsValid = false;
            } else {
                hideError(input);
            }
        });

        // Check email validity
        if (!emailIsValid) {
            formIsValid = false;
            document.getElementById('email').focus(); // Focus on email if it's invalid
        }

        if (!formIsValid) {
            e.preventDefault(); // Prevent form submission if validation fails
            // Find the first invalid input and focus on it
            const firstInvalidInput = document.querySelector('.form-control.is-invalid');
            if (firstInvalidInput) {
                firstInvalidInput.focus();
            }
        }
    });
</script>
@endsection