@extends('layout')
@section('content')

<style>
.quantity-input {
    display: flex;
    align-items: center;
}

.quantity-btn {
    background-color: #ff4500;
    border: none;
    color: #fff;
    cursor: pointer;
    padding: 8px 15px;
    transition: background-color 0.3s ease, color 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    font-weight: bold;
    font-size: 14px;
}

.quantity-btn:hover {
    background-color: #ff5a1f;
}

.quantity-btn:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.quantity-field::-webkit-outer-spin-button,
.quantity-field::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.quantity-field:focus::-webkit-outer-spin-button,
.quantity-field:focus::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.quantity-field {
    width: 50px;
    text-align: center;
    padding: 8px 0px;
    outline: none;
    border: none;
    border-top: .px solid;
}
</style>

<div class="body">
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div> 
    @endif

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
                        <td><img src="{{ asset($details['anhsp']) }}" width="100" height="100" class="img-responsive"/></td>
                        <td>
                            <div>{{ $details['tensp'] }}</div>
                            <button class="btn btn-danger btn-sm cart_remove mt-2"><i class="fa fa-trash-o"></i> Xóa</button>
                        </td>  
                        <td data-th="Price">{{ $details['giasp'] }}</td>
                        <td data-th="Price">{{ $details['giamgia'] }}%</td>
                        <td data-th="Subtotal" class="text-center">{{ $details['giakhuyenmai'] }}đ</td>
                        <td data-th="Quantity" class="quantity-input">
                            <button class="quantity-btn decreaseValue">-</button>
                            <input class="quantity-field quantity cart_update" type="number" min="1" max="999" value="{{ $details['quantity'] }}">
                            <button class="quantity-btn increaseValue">+</button>
                        </td>
                        <td data-th="Total" class="text-center product-total">{{ $details['giakhuyenmai'] * $details['quantity'] }}đ</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="text-right">
                    <h3 class="d-flex justify-content-end align-items-center">
                        Tổng thanh toán <div id="cart-total" class="text-danger" style="font-size: 40px;">{{ number_format($total, 0, ',', '.') }}đ</div>
                    </h3>
                </td>
            </tr>
            <tr>
                <td colspan="7" class="text-right">
                    <a href="{{ url('/') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Tiếp tục mua sắm</a>
                    <button class="btn btn-success"><a class="text-white" href="{{ route('checkout') }}">Mua hàng</a></button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    // Hàm định dạng số tiền
    function formatPrice(price) {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + 'đ';
    }

    // Xử lý tăng số lượng
    document.querySelectorAll('.increaseValue').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var row = this.closest('tr');
            var quantityInput = row.querySelector('.quantity');
            var value = parseInt(quantityInput.value, 10);
            var max = parseInt(quantityInput.getAttribute('max'), 10);

            if (isNaN(value)) value = 1;
            if (value < max) {
                quantityInput.value = value + 1;
                updateCart(row, quantityInput.value, this);
            }
        });
    });

    // Xử lý giảm số lượng
    document.querySelectorAll('.decreaseValue').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var row = this.closest('tr');
            var quantityInput = row.querySelector('.quantity');
            var value = parseInt(quantityInput.value, 10);
            var min = parseInt(quantityInput.getAttribute('min'), 10);

            if (value > min) {
                quantityInput.value = value - 1;
                updateCart(row, quantityInput.value, this);
            }
        });
    });

    // Xử lý thay đổi số lượng trực tiếp
    document.querySelectorAll('.cart_update').forEach(function(input) {
        input.addEventListener('change', function(e) {
            e.preventDefault();
            var row = this.closest('tr');
            var value = parseInt(this.value, 10);
            var min = parseInt(this.getAttribute('min'), 10);
            var max = parseInt(this.getAttribute('max'), 10);

            if (isNaN(value) || value < min) {
                this.value = min;
                value = min;
            } else if (value > max) {
                this.value = max;
                value = max;
            }
            updateCart(row, value, this);
        });
    });

    // Xử lý xóa sản phẩm
    document.querySelectorAll('.cart_remove').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var row = this.closest('tr');
            var button = this;
            if (confirm("Bạn có thật sự muốn xóa?")) {
                button.disabled = true;
                $.ajax({
                    url: '{{ route('remove_from_cart') }}',
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: row.getAttribute('data-id')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            row.remove(); // Xóa hàng khỏi DOM
                            updateCartTotal(response.total); // Cập nhật tổng tiền
                        }
                    },
                    complete: function() {
                        button.disabled = false;
                    }
                });
            }
        });
    });

    // Hàm cập nhật giỏ hàng
    function updateCart(row, quantity, element) {
        var button = element && element.classList.contains('quantity-btn') ? element : null;
        if (button) {
            button.disabled = true; // Vô hiệu hóa nút trong khi xử lý
        }

        $.ajax({
            url: '{{ route('update_cart') }}',
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}',
                id: row.getAttribute('data-id'),
                quantity: quantity
            },
            success: function(response) {
                if (response.status === 'success') {
                    // Cập nhật tổng tiền của sản phẩm
                    var productTotal = row.querySelector('.product-total');
                    productTotal.textContent = formatPrice(response.product_total);

                    // Cập nhật tổng tiền giỏ hàng
                    updateCartTotal(response.total);
                } else {
                    // Khôi phục số lượng nếu có lỗi
                    var quantityInput = row.querySelector('.quantity');
                    quantityInput.value = response.quantity || quantityInput.value;
                }
            },
            complete: function() {
                if (button) {
                    button.disabled = false; // Bật lại nút
                }
            }
        });
    }

    // Hàm cập nhật tổng tiền giỏ hàng
    function updateCartTotal(total) {
        var cartTotalElement = document.getElementById('cart-total');
        if (cartTotalElement) {
            cartTotalElement.textContent = formatPrice(total);
        }
    }
});
</script>

@endsection