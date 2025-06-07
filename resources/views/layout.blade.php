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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>

    <link rel="stylesheet" href="/frontend/css/bsgrid.min.css" />
    <link rel="stylesheet" href="/frontend/css/style.min.css" />
    <!-- <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />

</head>
<style>
    /* Global variables */
    :root {
        --Hover-icon: #FF9B42; /* Main hover accent color */
    }

    /* Navbar Menu Styling */
    .navbar__menu-list li {
        display: inline-block;
        padding-right: 15px;
    }
    .navbar__menu-list li.active a {
        color: var(--Hover-icon) !important;
    }

    .navbar__menu-list li.active .hover-a::after {
        width: 100%;
        background-color: var(--Hover-icon);
    }

    .navbar__menu-list .padding-list-menu {
        padding: 0 15px;
    }

    .navbar__menu-list .fa-solid {
        font-size: 14px;
        margin-left: 5px;
        color: var(--color-text);
        transition: 0.4s;
    }

    .navbar__menu-list li a {
        text-decoration: none;
        font-size: 16px;
        color: rgb(33, 32, 32);
        font-weight: 500;
        padding: 0 0 5px 0;
        transition: 0.4s;
        position: relative;
    }

    /* Hover effect for menu links */
    .navbar__menu-list li .hover-a::after {
        position: absolute;
        content: "";
        width: 0px;
        height: 3px;
        background-color: var(--Hover-icon);
        left: 0;
        bottom: 0;
        transition: all 0.4s ease-in-out;
    }

    .navbar__menu-list li .hover-a:hover::after {
        width: 100%;
    }

    .navbar__menu-list li a:hover {
        color: var(--Hover-icon);
    }

    .navbar__menu-list li:hover .angle-down {
        color: var(--Hover-icon);
    }

    /* General hover effect for icons/images (e.g., login, cart) */
    .hover-effect {
        transition: color 0.3s ease, filter 0.3s ease;
        color: inherit; /* Inherit color by default */
    }

    .hover-effect i {
        transition: color 0.3s ease;
    }

    .hover-effect:hover,
    .hover-effect:hover i {
        color: var(--Hover-icon);
    }

    .hover-effect img {
        transition: filter 0.3s ease;
    }

    .hover-effect:hover img {
        /* This filter needs adjustment if your shopping-cart.svg is not green */
        filter: brightness(0) saturate(100%) invert(45%) sepia(83%) saturate(604%) hue-rotate(358deg) brightness(98%) contrast(102%);
    }

    /* Dropdown menu for categories */
    #dropdown-danhmuc {
        white-space: normal;
        width: 200px;
        padding: 10px 0;
    }

    #dropdown-danhmuc li {
        padding: 5px 15px;
    }

    #dropdown-danhmuc li a {
        white-space: normal;
        display: block;
        word-break: break-word;
    }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 999;
        opacity: 0;
        visibility: hidden;
        transition: opacity .3s ease, visibility .3s ease;
    }

    .modal-wrapper {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(.9);
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: opacity .3s ease, transform .3s ease, visibility .3s ease;
        max-width: 500px;
        width: 90%;
    }

    .modal.is-visible .modal-overlay,
    .modal.is-visible .modal-wrapper {
        opacity: 1;
        visibility: visible;
    }

    .modal.is-visible .modal-wrapper {
        transform: translate(-50%, -50%) scale(1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-heading {
        font-size: 1.8em;
        margin: 0;
        color: #333;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5em;
        cursor: pointer;
        color: #888;
        padding: 5px;
        transition: color 0.3s ease;
    }

    .modal-close:hover {
        color: #333;
    }

    /* Basic responsiveness for body content */
    @media (max-width: 992px) {
        .body {
            width: unset;
            margin: 0 auto;
        }
    }

    /* --- Footer Styles --- */
    footer {
        background-color: #2c3e50; /* Darker, professional background */
        color: #ecf0f1; /* Light text color */
        padding: 50px 20px 20px; /* Ample padding: top, sides, bottom */
        font-family: 'Inter', sans-serif; /* Consistent font */
        box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.2); /* Shadow for depth */
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .footer__info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive columns */
        gap: 40px; /* Space between columns */
        max-width: 1200px; /* Max width for content */
        margin: 0 auto 30px; /* Center and add space below */
        padding-bottom: 30px; /* Space above copyright */
        border-bottom: 1px solid rgba(255, 255, 255, 0.1); /* Subtle separator */
    }

    .footer__info-content {
        text-align: left; /* Align text within columns */
    }

    .footer__info-content h3 {
        font-size: 1.6em;
        color: #ffffff; /* White heading */
        margin-bottom: 20px;
        font-weight: bold;
        position: relative;
        padding-bottom: 10px; /* Space for underline effect */
    }

    .footer__info-content h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px; /* Short underline */
        height: 3px;
        background-color: var(--Hover-icon); /* Orange accent */
        border-radius: 2px;
    }

    .footer__info-content p {
        font-size: 0.95em;
        line-height: 1.6;
        margin-bottom: 10px;
        color: #bdc3c7; /* Lighter text color */
    }

    .footer__info-content a {
        color: #ecf0f1; /* Link color */
        text-decoration: none;
        transition: color 0.3s ease; /* Simple color transition */
        display: block; /* Make links block to take full width */
        margin-bottom: 8px;
    }

    .footer__info-content a:hover {
        color: var(--Hover-icon); /* Orange on hover */
    }

    .footer__info-content p i {
        margin-right: 10px;
        color: var(--Hover-icon); /* Icon color */
    }

    .footer__social {
        margin-top: 20px;
        display: flex; /* Arrange icons in a row */
        gap: 15px; /* Space between icons */
        justify-content: flex-start; /* Align social icons to the left */
    }

    .footer__social a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        background-color: rgba(255, 255, 255, 0.1); /* Semi-transparent background */
        border-radius: 50%; /* Circular icons */
        color: #ecf0f1;
        font-size: 1.2em;
        transition: background-color 0.3s ease, color 0.3s ease; /* Simple transitions */
    }

    .footer__social a:hover {
        background-color: var(--Hover-icon); /* Orange background on hover */
        color: #ffffff; /* White icon on hover */
    }

    .footer__copyright {
        text-align: center;
        font-size: 0.9em;
        color: #bdc3c7;
        padding-top: 20px; /* Space above copyright */
        border-top: 1px solid rgba(255, 255, 255, 0.05); /* Very subtle top border */
    }

    /* Responsive adjustments for footer */
    @media (max-width: 768px) {
        .footer__info {
            grid-template-columns: 1fr; /* Stack columns on smaller screens */
            text-align: center; /* Center text for stacked columns */
        }
        .footer__info-content h3::after {
            left: 50%;
            transform: translateX(-50%); /* Center underline */
        }
        .footer__social {
            justify-content: center; /* Center social icons */
        }
    }
</style>

<body style="margin: 0; min-height: 100vh; display: flex; flex-direction: column;">
    <div class="header">

        <div class="navbar">
            <div class="navbar__left">
                <a href="{{ URL::to('/')}}" class="navbar__logo">
                    <img src="{{ asset('frontend/img/LOGO.png') }}" alt="">
                </a>

                <ul class="navbar__menu-list">
                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ URL::to('/') }}" class="hover-a">Trang chủ</a>
                    </li>

                    <li class="dropdown {{ request()->is('viewAll*') ? 'active' : '' }}" id="sanpham-dropdown">
                        <a href="{{ URL::to('/viewAll') }}" class="hover-a">Sản phẩm </a>
                        <ul class="dropdown-menu" id="dropdown-danhmuc"></ul>
                    </li>

                    <li class="{{ request()->is('services') ? 'active' : '' }}">
                        <a href="{{ URL::to('/services') }}" class="hover-a">Dịch vụ</a>
                    </li>

                    <li class="{{ request()->is('donhang') ? 'active' : '' }}">
                        <a href="{{ URL::to('/donhang') }}" class="hover-a">Đơn hàng</a>
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
                        <button style="border: none; background: transparent; cursor: pointer;"
                                type="submit" id="logoutBtn" class="hover-effect">
                            <i class="fas fa-sign-out-alt text-primary" style="font-size: 20px;"></i>
                        </button>

                    </form>
                </div>

                @else
                <!-- Hiển thị nút login -->
                <div class="login">
                    <a href="{{ URL::to('login')}}" class="hover-effect">
                        <i class="fa fa-user"></i>
                    </a>
                </div>
                @endif

                <a href="{{ route('cart') }}" class="navbar__shoppingCart hover-effect">
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
                <p>Chúng tôi cam kết mang đến những sản phẩm và dịch vụ tốt nhất, luôn đặt trải nghiệm khách hàng lên hàng đầu với sự tận tâm và chuyên nghiệp.</p>
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
                    <a href="https://www.facebook.com/hocviennganhang1961" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/tuanphan_272" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Google"><i class="fab fa-google"></i></a>
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