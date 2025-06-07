@extends('layout')
@section('content')
<style>
    .product {
    position: relative; /* cần để vị trí tuyệt đối cho .box-icon-new-product */
}

.product .box-icon-new-product {
    position: absolute;
    top: 8px;
    right: 8px;
    width: auto;
    min-height: auto;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    z-index: 2; /* Ensure icons are above other elements */
}


.product .box-icon-new-product i {
    color: var(--color-text-1, #333);
    width: 40px;
    height: 40px;
    background-color: white;
    border-radius: 20px;
    text-align: center;
    line-height: 40px; /* để icon căn giữa dọc */
    margin: 0 5px;
    transition: all 0.7s ease;
    opacity: 0;
    cursor: pointer;
    pointer-events: auto; /* cho phép bấm icon */
}

.product .box-icon-new-product i:hover {
    background-color: var(--Hover-icon, #007bff);
    color: white;
}

.product .box-icon-new-product #cart-Product,
.product .box-icon-new-product #search-Product {
    transform: translateY(-20px);
}

.product .box-icon-new-product #heart-Product {
    transform: translateY(20px);
}

.product:hover .box-icon-new-product #cart-Product,
.product:hover .box-icon-new-product #search-Product,
.product:hover .box-icon-new-product #heart-Product {
    opacity: 1;
    transform: translateY(0);
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
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('viewAll', ['danhmuc_id' => 9]) }}" class="banner-top-2-child" style="background-color:rgb(171, 100, 91);">
                <div class="text-white">Gucci Collection</div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('viewAll', ['danhmuc_id' => 10]) }}" class="banner-top-2-child" style="background-color: #5C9CCA;">
                <div class="text-white" style="margin: 0 auto;">Christian Dior Elegance</div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('viewAll', ['danhmuc_id' => 11]) }}" class="banner-top-2-child" style="background-color: #C67B36;">
                <div class="text-white" style="margin: 0 auto;">Hermes Craftsmanship</div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('viewAll', ['danhmuc_id' => 12]) }}" class="banner-top-2-child" style="background-color:rgb(67, 61, 61);">
                <div class="text-white">Chanel Luxury</div>
            </a>
        </div>
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