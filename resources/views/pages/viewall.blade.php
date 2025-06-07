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
<!-- Tất cả sản phẩm -->
<div class="body">
    <div class="body__mainTitle">
        <h2>
            @php
            $ten = 'TẤT CẢ SẢN PHẨM';
            if(request('danhmuc_id')) {
            $dm = $danhmucs->firstWhere('id_danhmuc', request('danhmuc_id'));
            if ($dm) {
            $ten = 'SẢN PHẨM: ' . strtoupper($dm->ten_danhmuc);
            }
            }
            @endphp
            {{ $ten }}
        </h2>

        <div>
            <div class="row">
                @foreach($sanphams as $sanpham)
                <div class="col-lg-2_5 col-md-4 col-6 post2">
                    <a href="{{ route('detail', ['id' => $sanpham->id_sanpham]) }}">
                        <div class="product">
                            <div class="product__img">
                                <img src="{{$sanpham->anhsp}}" alt="">
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
                                    -{{$sanpham->giamgia}}%
                                    @else Mới
                                    @endif
                                </div>
                            </div>

                            <div class="product__content">
                                <div class="product__title">
                                    {{$sanpham->tensp}}
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
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item @if($sanphams->currentPage() === 1) disabled @endif">
                        <a class="page-link" href="{{ $sanphams->appends(request()->query())->previousPageUrl() }}">
                            &laquo; {{-- hoặc dùng << --}}
                        </a>
                    </li>
                    @for ($i = 1; $i <= $sanphams->lastPage(); $i++)
                        <li class="page-item @if($sanphams->currentPage() === $i) active @endif">
                            <a class="page-link" href="{{ $sanphams->appends(request()->query())->url($i) }}">{{ $i }}</a>
                        </li>
                        @endfor
                        <li class="page-item @if($sanphams->currentPage() === $sanphams->lastPage()) disabled @endif">
                            <a class="page-link" href="{{ $sanphams->appends(request()->query())->nextPageUrl() }}">
                                &raquo; {{-- hoặc dùng >> --}}
                            </a>
                        </li>
                </ul>
            </nav>
        </div>

    </div>
</div>
@endsection
