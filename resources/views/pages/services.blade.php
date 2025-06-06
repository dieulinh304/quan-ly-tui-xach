@extends('layout')
@section('content')

<style>
    @media (max-width: 992px) {
    .body {
        width: unset;
        margin: 0 auto;
    }
}
</style>

<div class="post-slider">
    <div class="post-wrapper">
        <div class="post">

            <img src="{{ asset('frontend/img/banner2.png')}}" alt="Sacha Luxury Bags">
        </div>
    </div>
</div>

<div class="modal">
    <div class="modal-overlay modal-toggle"></div>
    <div class="modal-wrapper modal-transition">

        <div class="modal-header">
            <button class="modal-close modal-toggle btn fa fa-times" style="outline: none;"></button>
            <h2 class="modal-heading">Tìm hiểu thêm</h2>
        </div>

        <style>
            .form-horizontal .control-label {
                text-align: unset !important;
            }
        </style>

    </div>
</div>

<div class="body">
    <div class="container-fluid" style="padding: 0!important;">
        <div style="background-image: url('frontend/img/bg_sacha.jpg')" class="service-banner">
            <div class="boxservice">
                <h3 class="h1-title">
                    SACHA - NƠI TÔN VINH PHONG CÁCH VÀ ĐẲNG CẤP!
                </h3>
                <p>Với sứ mệnh mang đến những chiếc túi hiệu thời thượng, Sacha là điểm đến lý tưởng cho những ai yêu thích sự tinh tế và đẳng cấp trong từng thiết kế.</p>

                <button class="btn btn-danger mt-5" onclick="window.location.href='{{ url('/') }}'">Khám phá ngay!</button>            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4" style="padding: 15px!important;">
            <div style="background-color: #2885BA" class="service-list__content-box">
                <img src="{{ asset('frontend/img/sacha_bag1.jpg')}}" alt="Luxury Bag">
                <h3 class="h1-title">
                    1. SACHA - ĐỈNH CAO THỜI TRANG TÚI HIỆU!
                </h3>
                <p>
                    Sacha cung cấp các bộ sưu tập túi hiệu từ những thương hiệu danh tiếng, giúp bạn tỏa sáng trong mọi dịp, từ công việc đến các sự kiện sang trọng.
                </p>
            </div>
        </div>
        <div class="col-lg-4" style="padding: 15px!important;">
            <div style="background-color: #B56256" class="service-list__content-box">
                <img src="{{ asset('frontend/img/sacha_bag2.jpg')}}" alt="Quality Bag">
                <h3 class="h1-title">
                    2. CHẤT LƯỢNG VÀ SỰ TIN CẬY HÀNG ĐẦU!
                </h3>
                <p>
                    Mỗi sản phẩm tại Sacha đều được chọn lọc kỹ lưỡng, đảm bảo chất lượng cao cấp và thiết kế độc đáo, mang lại sự hài lòng tối đa cho khách hàng.
                </p>
            </div>
        </div>
        <div class="col-lg-4" style="padding: 15px!important;">
            <div style="background-color: #5C9CCA" class="service-list__content-box">
                <img src="{{ asset('frontend/img/sacha_bag3.jpg')}}" alt="Community">
                <h3 class="h1-title">
                    3. CỘNG ĐỒNG YÊU TÚI HIỆU!
                </h3>
                <p>
                    Sacha không chỉ là nơi mua sắm, mà còn là cộng đồng để những người yêu túi hiệu chia sẻ đam mê, phong cách và cảm hứng thời trang.
                </p>
            </div>
        </div>
    </div>

    <div class="service-text mb30">
        <div class="service-text__content">
            <h2 class="h2-title">
                Tinh tế, đẳng cấp và đam mê thời trang là những giá trị cốt lõi mà Sacha mang đến cho từng khách hàng!
            </h2>
        </div>

        <div class="d-flex justify-content-center align-items-center">
            <img class="banner-service" src="{{ asset('frontend/img/sacha_banner.jpg')}}" alt="Sacha Brand">
        </div>
    </div>
</div>
@endsection