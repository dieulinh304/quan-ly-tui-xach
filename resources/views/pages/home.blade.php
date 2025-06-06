@extends('layout')
@section('content')

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

<!-- Sản phẩm nổi bật -->
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

<!-- Danh mục thương hiệu -->
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

<!-- Sản phẩm theo thương hiệu -->
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

<!-- Tất cả sản phẩm -->
<!-- <div class="body">
    <div class="body__mainTitle">
        <h2>TẤT CẢ SẢN PHẨM</h2>
    </div>
    <div>
        <div class="row">
            @foreach($alls as $all)
            <div class="col-lg-2_5 col-md-4 col-6 post2">
                <a href="{{ route('detail', ['id' => $all->id_sanpham]) }}">
                    <div class="product">
                        <div class="product__img">
                            <img src="{{ asset($all->anhsp) }}" alt="{{ $all->tensp }}" onerror="this.src='{{ asset('frontend/upload/placeholder.jpg') }}'">
                        </div>
                        <div class="product__sale">
                            <div>
                                @if($all->giamgia)
                                    -{{ $all->giamgia }}%
                                @else
                                    Mới
                                @endif
                            </div>
                        </div>
                        <div class="product__content">
                            <div class="product__brand">
                                {{ $all->danhmuc->ten_danhmuc }}
                            </div>
                            <div class="product__title">
                                {{ $all->tensp }}
                            </div>
                            <div class="product__pride-oldPride">
                                <span class="Price">
                                    <bdi>
                                        {{ number_format($all->giasp, 0, ',', '.') }}
                                        <span class="currencySymbol">₫</span>
                                    </bdi>
                                </span>
                            </div>
                            <div class="product__pride-newPride">
                                <span class="Price">
                                    <bdi>
                                        {{ number_format($all->giakhuyenmai, 0, ',', '.') }}
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
        <center style="margin-top: 30px;">
            <a href="{{ route('viewAll') }}" class="btn text-white" style="background: #ff4500;">Xem thêm</a>
        </center>
    </div>
</div> -->

@endsection
