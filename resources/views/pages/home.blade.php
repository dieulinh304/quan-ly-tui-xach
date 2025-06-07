@extends('layout')
@section('content')
<style>
    /* General product styling */
    .product {
        position: relative; /* Needed for absolute positioning of .box-icon-new-product */
        overflow: hidden; /* Hide overflowing parts of the zoomed image */
        border-radius: 8px; /* Slightly rounded corners for products */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); /* Subtle shadow for depth */
        transition: transform 0.3s ease; /* Smooth transition for product card itself */
    }

    .product:hover {
        transform: translateY(-5px); /* Lift effect on hover for the whole product card */
    }

    /* Icon box styling */
    .product .box-icon-new-product {
        position: absolute;
        top: 8px;
        right: 8px;
        width: auto;
        min-height: auto;
        display: flex;
        flex-direction: column; /* Stack icons vertically */
        justify-content: flex-end;
        gap: 8px;
        z-index: 2; /* Ensure icons are above other elements */
    }

    /* Individual icon styling */
    .product .box-icon-new-product i {
        color: var(--color-text-1, #333);
        width: 40px;
        height: 40px;
        background-color: white;
        border-radius: 50%; /* Make icons perfectly round */
        text-align: center;
        line-height: 40px; /* To center the icon vertically */
        transition: all 0.4s ease; /* Softer transition for icons */
        opacity: 0;
        cursor: pointer;
        pointer-events: auto; /* allow icon clicks */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for icons */
    }

    .product .box-icon-new-product i:hover {
        background-color: var(--Hover-icon, #007bff);
        color: white;
        transform: scale(1.1); /* Slightly enlarge icon on hover */
    }

    /* Icon initial positions (off-screen) */
    .product .box-icon-new-product #search-Product {
        transform: translateX(50px); /* Slide in from right */
    }

    .product .box-icon-new-product #cart-Product {
        transform: translateX(50px); /* Slide in from right */
    }

    /* Icon animation on product hover */
    .product:hover .box-icon-new-product #cart-Product,
    .product:hover .box-icon-new-product #search-Product,
    .product:hover .box-icon-new-product #heart-Product {
        opacity: 1;
        transform: translateX(0); /* Slide to original position */
    }

    .product:hover .box-icon-new-product #cart-Product {
        transition-delay: 0.1s; /* Stagger the animation */
    }

    .product:hover .box-icon-new-product #search-Product {
        transition-delay: 0.2s; /* Stagger the animation */
    }

    /* New styles for product image zoom and overlay */
    .product__img {
        position: relative;
        overflow: hidden; /* Ensures the zoomed part is clipped */
        border-radius: 8px 8px 0 0; /* Match parent border-radius */
    }

    .product__img img {
        display: block; /* Removes extra space below image */
        width: 100%;
        height: auto;
        transition: transform 0.5s ease, filter 0.5s ease; /* Smooth transition for zoom and blur */
    }

    .product__img::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0); /* Initial transparent overlay */
        transition: background-color 0.5s ease; /* Smooth transition for overlay */
        z-index: 1; /* Place overlay above image but below icons */
        pointer-events: none; /* Allows clicks to pass through the overlay to the image/link */
    }

    .product:hover .product__img img {
        transform: scale(1.05); /* Zoom in by 5% */
        filter: brightness(80%); /* Slightly dim the image */
    }

    .product:hover .product__img::before {
        background-color: rgba(0, 0, 0, 0.1); /* Slight dark overlay on hover */
    }

    /* Product content styling */
    .product__content {
        padding: 15px;
        text-align: center;
    }

    .product__brand {
        font-size: 0.9em;
        color: #777;
        margin-bottom: 5px;
    }

    .product__title {
        font-size: 1.1em;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .product__pride-oldPride {
        text-decoration: line-through;
        color: #999;
        font-size: 0.9em;
    }

    .product__pride-newPride {
        font-size: 1.1em;
        color: #e60023; /* A common color for sale prices */
        font-weight: bold;
    }

    .product__sale {
        position: absolute;
        top: 8px;
        left: 8px;
        background-color: #ff4d4d; /* Red background for sale tag */
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8em;
        font-weight: bold;
        z-index: 2;
    }

    /* Horizontal lines for section titles */
    .body__mainTitle {
        text-align: center;
        margin: 40px 0 30px;
        position: relative;
    }

    .body__mainTitle h2 {
        display: inline-block;
        background: #fff;
        padding: 0 20px;
        position: relative;
        z-index: 1;
        font-size: 2em;
        color: #333;
    }

    .body__mainTitle::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        border-top: 1px solid #eee;
        z-index: 0;
    }

    /* Banner top 2 styling (Brand Categories) */
    .banner-top-2 {
        display: flex; /* Use flexbox */
        justify-content: space-around; /* Distribute items evenly */
        align-items: center; /* Align items vertically */
        gap: 20px;
        margin-bottom: 40px;
        flex-wrap: nowrap; /* Prevent wrapping to new line */
    }

    .banner-top-2-child {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 150px; /* Fixed height for consistent look */
        border-radius: 8px;
        color: white;
        font-size: 1.5em;
        font-weight: bold;
        text-decoration: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
        padding: 15px;
        box-sizing: border-box;
        flex: 1; /* Allow items to grow and shrink */
        min-width: 200px; /* Ensure minimum width to prevent squishing on smaller screens */
    }

    .banner-top-2-child:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Adjust column widths for responsiveness (if using Bootstrap grid) */
    .col-lg-2_5 {
        flex: 0 0 20%;
        max-width: 20%;
    }

    @media (max-width: 991.98px) {
        .col-lg-2_5 {
            flex: 0 0 33.333%;
            max-width: 33.333%;
        }
    }

    @media (max-width: 767.98px) {
        .col-lg-2_5 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @media (max-width: 575.98px) {
        .col-lg-2_5 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Media query for very small screens to allow wrapping for brand categories if necessary */
    @media (max-width: 768px) {
        .banner-top-2 {
            flex-wrap: wrap; /* Allow wrapping on small screens */
            justify-content: center;
        }
        .banner-top-2-child {
            flex: 0 0 45%; /* Two items per row on small screens */
            max-width: 45%;
        }
    }

    @media (max-width: 480px) {
        .banner-top-2-child {
            flex: 0 0 90%; /* One item per row on very small screens */
            max-width: 90%;
        }
    }

</style>
<div class="post-slider">
    <i class="fa fa-chevron-left prev" aria-hidden="true"></i>
    <i class="fa fa-chevron-right next" aria-hidden="true"></i>

    <div class="post-wrapper">
        <div class="post">
            <img src="{{ asset('frontend/img/banner2.png')}}" alt="">
        </div>
        <div class="post">
            <img src="{{ asset('frontend/img/banner1.png')}}" alt="">
        </div>
    </div>
</div>

<div class="body">
    <div class="body__mainTitle">
        <h2>Sản phẩm nổi bật</h2>
    </div>

    <div class="post-slider2">
        <i class="fa fa-chevron-left prev2" aria-hidden="true"></i>
        <i class="fa fa-chevron-right next2" aria-hidden="true"></i>

        <div class="row">
            <div class="post-wrapper2">
                @foreach($alls->take(10) as $sanpham)
                <div class="col-lg-2_5 col-md-4 col-6 post2">
                    <a href="{{ route('detail', ['id' => $sanpham->id_sanpham]) }}">
                        <div class="product">
                            <div class="product__img">
                                <img src="{{ asset($sanpham->anhsp) }}" alt="{{ $sanpham->tensp }}" onerror="this.src='{{ asset('frontend/upload/placeholder.jpg') }}'">
                            </div>
                            <div class="box-icon-new-product">
                                <a href="{{ route('add_to_cart', $sanpham->id_sanpham) }}" title="Thêm vào giỏ hàng">
                                    <i style="font-size: 19px;" id="cart-Product" class="cart-product fa-solid fa-cart-shopping"></i>
                                </a>
                                {{-- <a href="{{ route('wishlist_add', $sanpham->id_sanpham) }}" title="Thêm vào yêu thích">
                                    <i style="font-size: 18px;" id="heart-Product" class="fa-solid fa-heart"></i>
                                </a> --}}
                                <a href="{{ route('detail', ['id' => $sanpham->id_sanpham]) }}" title="Xem chi tiết sản phẩm">
                                    <i style="font-size: 18px;" id="search-Product" class="fa-solid fa-magnifying-glass"></i>
                                </a>
                            </div>

                            <div class="product__sale">
                                <div>
                                    @if($sanpham->giamgia)
                                        -{{ $sanpham->giamgia }}%
                                    @else
                                        Mới
                                    @endif
                                </div>
                            </div>

                            <div class="product__content">
                                <div class="product__brand">
                                    {{ $sanpham->danhmuc->ten_danhmuc }}
                                </div>
                                <div class="product__title">
                                    {{ $sanpham->tensp }}
                                </div>
                                <div class="product__pride-oldPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format($sanpham->giasp, 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>
                                <div class="product__pride-newPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format($sanpham->giakhuyenmai, 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="banner">
    <div class="body__mainTitle">
        <h2>Danh mục thương hiệu</h2>
    </div>

    <div class="banner-top banner-top-2 row">
        <a href="{{ route('viewAll', ['danhmuc_id' => 9]) }}" class="banner-top-2-child" style="background-color:rgb(171, 100, 91);">
            <div class="text-white">Gucci Collection</div>
        </a>
        <a href="{{ route('viewAll', ['danhmuc_id' => 10]) }}" class="banner-top-2-child" style="background-color: #5C9CCA;">
            <div class="text-white" style="margin: 0 auto;">Christian Dior Elegance</div>
        </a>
        <a href="{{ route('viewAll', ['danhmuc_id' => 11]) }}" class="banner-top-2-child" style="background-color: #C67B36;">
            <div class="text-white" style="margin: 0 auto;">Hermes Craftsmanship</div>
        </a>
        <a href="{{ route('viewAll', ['danhmuc_id' => 12]) }}" class="banner-top-2-child" style="background-color:rgb(67, 61, 61);">
            <div class="text-white">Chanel Luxury</div>
        </a>
    </div>
</div>

<div class="body">
    <div class="body__mainTitle">
        <h2>Túi Gucci</h2>
    </div>
    <div class="row">
        @foreach($gucciProducts as $product)
        <div class="col-lg-2_5 col-md-4 col-6 post2">
            <a href="{{ route('detail', ['id' => $product->id_sanpham]) }}">
                <div class="product">
                    <div class="product__img">
                        <img src="{{ asset($product->anhsp) }}" alt="{{ $product->tensp }}" onerror="this.src='{{ asset('frontend/upload/placeholder.jpg') }}'">
                    </div>
                    <div class="box-icon-new-product">
                        <a href="{{ route('add_to_cart', $product->id_sanpham) }}" title="Thêm vào giỏ hàng">
                            <i style="font-size: 19px;" id="cart-Product" class="cart-product fa-solid fa-cart-shopping"></i>
                        </a>
                        {{-- <a href="{{ route('wishlist_add', $product->id_sanpham) }}" title="Thêm vào yêu thích">
                            <i style="font-size: 18px;" id="heart-Product" class="fa-solid fa-heart"></i>
                        </a> --}}
                        <a href="{{ route('detail', ['id' => $product->id_sanpham]) }}" title="Xem chi tiết sản phẩm">
                            <i style="font-size: 18px;" id="search-Product" class="fa-solid fa-magnifying-glass"></i>
                        </a>
                    </div>
                    <div class="product__sale">
                        <div>
                            @if($product->giamgia)
                                -{{ $product->giamgia }}%
                            @else
                                Mới
                            @endif
                        </div>
                    </div>
                    <div class="product__content">
                        <div class="product__title">
                            {{ $product->tensp }}
                        </div>
                        <div class="product__pride-oldPride">
                            <span class="Price">
                                <bdi>
                                    {{ number_format($product->giasp, 0, ',', '.') }}
                                    <span class="currencySymbol">₫</span>
                                </bdi>
                            </span>
                        </div>
                        <div class="product__pride-newPride">
                            <span class="Price">
                                <bdi>
                                    {{ number_format($product->giakhuyenmai, 0, ',', '.') }}
                                    <span class="currencySymbol">₫</span>
                                </bdi>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<div class="body">
    <div class="body__mainTitle">
        <h2>Túi Christian Dior</h2>
    </div>
    <div class="row">
        @foreach($diorProducts as $product)
        <div class="col-lg-2_5 col-md-4 col-6 post2">
            <a href="{{ route('detail', ['id' => $product->id_sanpham]) }}">
                <div class="product">
                    <div class="product__img">
                        <img src="{{ asset($product->anhsp) }}" alt="{{ $product->tensp }}" onerror="this.src='{{ asset('frontend/upload/placeholder.jpg') }}'">
                    </div>
                    <div class="box-icon-new-product">
                        <a href="{{ route('add_to_cart', $product->id_sanpham) }}" title="Thêm vào giỏ hàng">
                            <i style="font-size: 19px;" id="cart-Product" class="cart-product fa-solid fa-cart-shopping"></i>
                        </a>
                        {{-- <a href="{{ route('wishlist_add', $product->id_sanpham) }}" title="Thêm vào yêu thích">
                            <i style="font-size: 18px;" id="heart-Product" class="fa-solid fa-heart"></i>
                        </a> --}}
                        <a href="{{ route('detail', ['id' => $product->id_sanpham]) }}" title="Xem chi tiết sản phẩm">
                            <i style="font-size: 18px;" id="search-Product" class="fa-solid fa-magnifying-glass"></i>
                        </a>
                    </div>
                    <div class="product__sale">
                        <div>
                            @if($product->giamgia)
                                -{{ $product->giamgia }}%
                            @else
                                Mới
                            @endif
                        </div>
                    </div>
                    <div class="product__content">
                        <div class="product__title">
                            {{ $product->tensp }}
                        </div>
                        <div class="product__pride-oldPride">
                            <span class="Price">
                                <bdi>
                                    {{ number_format($product->giasp, 0, ',', '.') }}
                                    <span class="currencySymbol">₫</span>
                                </bdi>
                            </span>
                        </div>
                        <div class="product__pride-newPride">
                            <span class="Price">
                                <bdi>
                                    {{ number_format($product->giakhuyenmai, 0, ',', '.') }}
                                    <span class="currencySymbol">₫</span>
                                </bdi>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<div class="body">
    <div class="body__mainTitle">
        <h2>Túi Hermes</h2>
    </div>
    <div class="row">
        @foreach($hermesProducts as $product)
        <div class="col-lg-2_5 col-md-4 col-6 post2">
            <a href="{{ route('detail', ['id' => $product->id_sanpham]) }}">
                <div class="product">
                    <div class="product__img">
                        <img src="{{ asset($product->anhsp) }}" alt="{{ $product->tensp }}" onerror="this.src='{{ asset('frontend/upload/placeholder.jpg') }}'">
                    </div>
                    <div class="box-icon-new-product">
                        <a href="{{ route('add_to_cart', $product->id_sanpham) }}" title="Thêm vào giỏ hàng">
                            <i style="font-size: 19px;" id="cart-Product" class="cart-product fa-solid fa-cart-shopping"></i>
                        </a>
                        {{-- <a href="{{ route('wishlist_add', $product->id_sanpham) }}" title="Thêm vào yêu thích">
                            <i style="font-size: 18px;" id="heart-Product" class="fa-solid fa-heart"></i>
                        </a> --}}
                        <a href="{{ route('detail', ['id' => $product->id_sanpham]) }}" title="Xem chi tiết sản phẩm">
                            <i style="font-size: 18px;" id="search-Product" class="fa-solid fa-magnifying-glass"></i>
                        </a>
                    </div>
                    <div class="product__sale">
                        <div>
                            @if($product->giamgia)
                                -{{ $product->giamgia }}%
                            @else
                                Mới
                            @endif
                        </div>
                    </div>
                    <div class="product__content">
                        <div class="product__title">
                            {{ $product->tensp }}
                        </div>
                        <div class="product__pride-oldPride">
                            <span class="Price">
                                <bdi>
                                    {{ number_format($product->giasp, 0, ',', '.') }}
                                    <span class="currencySymbol">₫</span>
                                </bdi>
                            </span>
                        </div>
                        <div class="product__pride-newPride">
                            <span class="Price">
                                <bdi>
                                    {{ number_format($product->giakhuyenmai, 0, ',', '.') }}
                                    <span class="currencySymbol">₫</span>
                                </bdi>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<div class="body">
    <div class="body__mainTitle">
        <h2>Túi Chanel</h2>
    </div>
    <div class="row">
        @foreach($chanelProducts as $product)
        <div class="col-lg-2_5 col-md-4 col-6 post2">
            <a href="{{ route('detail', ['id' => $product->id_sanpham]) }}">
                <div class="product">
                    <div class="product__img">
                        <img src="{{ asset($product->anhsp) }}" alt="{{ $product->tensp }}" onerror="this.src='{{ asset('frontend/upload/placeholder.jpg') }}'">
                    </div>
                    <div class="box-icon-new-product">
                        <a href="{{ route('add_to_cart', $product->id_sanpham) }}" title="Thêm vào giỏ hàng">
                            <i style="font-size: 19px;" id="cart-Product" class="cart-product fa-solid fa-cart-shopping"></i>
                        </a>
                        {{-- <a href="{{ route('wishlist_add', $product->id_sanpham) }}" title="Thêm vào yêu thích">
                            <i style="font-size: 18px;" id="heart-Product" class="fa-solid fa-heart"></i>
                        </a> --}}
                        <a href="{{ route('detail', ['id' => $product->id_sanpham]) }}" title="Xem chi tiết sản phẩm">
                            <i style="font-size: 18px;" id="search-Product" class="fa-solid fa-magnifying-glass"></i>
                        </a>
                    </div>
                    <div class="product__sale">
                        <div>
                            @if($product->giamgia)
                                -{{ $product->giamgia }}%
                            @else
                                Mới
                            @endif
                        </div>
                    </div>
                    <div class="product__content">
                        <div class="product__title">
                            {{ $product->tensp }}
                        </div>
                        <div class="product__pride-oldPride">
                            <span class="Price">
                                <bdi>
                                    {{ number_format($product->giasp, 0, ',', '.') }}
                                    <span class="currencySymbol">₫</span>
                                </bdi>
                            </span>
                        </div>
                        <div class="product__pride-newPride">
                            <span class="Price">
                                <bdi>
                                    {{ number_format($product->giakhuyenmai, 0, ',', '.') }}
                                    <span class="currencySymbol">₫</span>
                                </bdi>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<div class="banner">
    <div class="banner-top">
        <img src="{{ asset('frontend/img/banner1.png')}}" />
    </div>
</div>
@endsection