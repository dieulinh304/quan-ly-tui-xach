<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý cửa hàng túi xách</title>
    <link rel="shortcut icon" type="image/png" href="/frontend/img/icon.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="/frontend/css/bsgrid.min.css" />
    <link rel="stylesheet" href="/frontend/css/style.min.css" />
    <!-- <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />

</head>

<body style="margin: 0; min-height: 100vh; display: flex; flex-direction: column;">
    <div class="header">

        <div class="navbar">
            <div class="navbar__left">
                <a href="{{ URL::to('/')}}" class="navbar__logo">
                    <img src="{{ asset('frontend/img/LOGO.png') }}" alt="">
                </a>

                <ul class="navbar__menu-list">
                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ URL::to('/') }}">Trang chủ</a>
                    </li>

                    <li class="dropdown {{ request()->is('viewAll*') ? 'active' : '' }}" id="sanpham-dropdown">
                        <a href="{{ URL::to('/viewAll') }}">Sản phẩm </a>
                        <ul class="dropdown-menu" id="dropdown-danhmuc"></ul>
                    </li>

                    <li class="{{ request()->is('services') ? 'active' : '' }}">
                        <a href="{{ URL::to('/services') }}">Dịch vụ</a>
                    </li>

                    <li class="{{ request()->is('donhang') ? 'active' : '' }}">
                        <a href="{{ URL::to('/donhang') }}">Đơn hàng</a>
                    </li>
                </ul>

            </div>

            <div class="navbar__center">
                <form action="{{route('search')}}" method="GET" class="navbar__search">
                    <input type="text" value="" placeholder="Nhập để tìm kiếm..." name="tukhoa" class="search" required>
                    <i class="fa fa-search" id="searchBtn"></i>
                </form>
            </div>

            <div class="navbar__right">

                @if (Auth::check())
                <!-- Hiển thị nút logout -->

                <span class="mr-2">{{Auth::user()->hoten}}</span>

                <div class="logout">
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button style="border: none; background: transparent; cursor: pointer;" type="submit" id="logoutBtn">
                            <i class="fas fa-sign-out-alt text-primary" style="font-size: 20px;"></i>
                        </button>
                    </form>
                </div>

                @else
                <!-- Hiển thị nút login -->
                <div class="login">
                    <a href="{{ URL::to('login')}}"><i class="fa fa-user"></i> </a>
                </div>
                @endif

                <a href="{{ route('cart') }}" class="navbar__shoppingCart">
                    <img src="{{ asset('frontend/img/shopping-cart.svg')}}" style="width: 24px;" alt="">

                    @if (session('cart'))
                    <span>{{ count((array) session('cart')) }}</span>
                    @else
                    <span>0</span>

                    @endif
                </a>
            </div>
        </div>

    </div>

    <!-- Content -->
    <div style="flex:1">
        @yield('content')
    </div>

    <div class="go-to-top"><i class="fas fa-chevron-up"></i></div>


    <div class="go-to-top"><i class="fas fa-chevron-up"></i></div>

    <footer>

        <div class="footer__info">
            <div class="footer__info-content">
                <h3>Về SACHA</h3>
                <p>Chúng tôi cam kết mang đến những sản phẩm và dịch vụ tốt nhất.</p>
            </div>

            <div class="footer__info-content">
                <h3>Thương hiệu</h3>
                <p><a href="{{ route('viewAll', ['danhmuc_id' => 12]) }}">CHANEL</a></p>
                <p><a href="{{ route('viewAll', ['danhmuc_id' => 10]) }}">CHRISTIAN DIOR</a></p>
                <p><a href="{{ route('viewAll', ['danhmuc_id' => 11]) }}">HERMES</a></p>
                <p><a href="{{ route('viewAll', ['danhmuc_id' => 9]) }}">GUCCI</a></p>
            </div>

            <div class="footer__info-content">
                <h3>Liên hệ</h3>
                <p><i class="fas fa-home"></i> Địa chỉ: Số 12, Chùa Bộc, Đống Đa, Hà Nội</p>
                <p><i class="fas fa-envelope"></i> Email: sacha@gmail.com</p>
                <p><i class="fas fa-phone"></i> Sđt: 1900 1596</p>
                <div class="footer__social">
                    <a href="https://facebook.com/trieuetam" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/tai_khoan_cua_ban" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-google"></i></a>
                </div>
            </div>
        </div>

        <div class="footer__copyright">
            <center>© 2025 Sacha Shop. All rights reserved.</center>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
        let danhMucLoaded = false;

        document.getElementById('sanpham-dropdown').addEventListener('mouseenter', function() {
            if (danhMucLoaded) return;

            fetch('/api/danhmuc')
                .then(response => response.json())
                .then(data => {
                    const ul = document.getElementById('dropdown-danhmuc');
                    data.forEach(dm => {
                        const li = document.createElement('li');
                        const a = document.createElement('a');
                        a.href = `/viewAll?danhmuc_id=${dm.id_danhmuc}`;
                        a.textContent = dm.ten_danhmuc;
                        li.appendChild(a);
                        ul.appendChild(li);
                    });
                    danhMucLoaded = true;
                })
                .catch(error => console.error('Lỗi khi tải danh mục:', error));
        });
    </script>
    <script>
        document.getElementById('logoutForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Đăng xuất?',
                text: "Bạn có chắc chắn muốn đăng xuất không?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đăng xuất',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        });
    </script>
    <script>
        //Slider using Slick
        $(document).ready(function() {
            $('.post-wrapper').slick({
                slidesToScroll: 1,
                autoplay: true,
                arrow: true,
                dots: true,
                autoplaySpeed: 5000,
                prevArrow: $('.prev'),
                nextArrow: $('.next'),
                appendDots: $(".dot"),
            });
        });

        // Slick mutiple carousel
        $('.post-wrapper2').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            prevArrow: $('.prev2'),
            nextArrow: $('.next2'),
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 3,
                        infinite: true,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    </script>

    <script src="/frontend/script/script.js"></script>

</body>

</html>
