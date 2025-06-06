@extends('layout')
@section('content')
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
