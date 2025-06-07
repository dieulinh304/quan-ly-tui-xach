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
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="boxservice" style="text-align: justify;">
                    <h3 class="h1-title text-center" style="font-family: Georgia, serif; font-weight: bold; font-size: 1.8rem;">
                        HÀNH TRÌNH KHẲNG ĐỊNH THƯƠNG HIỆU SACHA
                    </h3>
                    <p>
                        SACHA được thành lập với mục tiêu trở thành cầu nối đáng tin cậy giữa khách hàng và các thương hiệu túi xách xa xỉ hàng đầu thế giới như Gucci, Chanel, Dior, Louis Vuitton... Chúng tôi chuyên cung cấp các dòng sản phẩm chính hãng 100%, được tuyển chọn kỹ lưỡng từ những nhà phân phối uy tín toàn cầu.
                    </p>
                    <p>
                        Từ những ngày đầu hoạt động, SACHA đã không ngừng nỗ lực xây dựng uy tín thông qua chất lượng dịch vụ, độ minh bạch về sản phẩm và trải nghiệm mua sắm đẳng cấp. Khách hàng đến với SACHA không chỉ để sở hữu một chiếc túi thời trang, mà còn để khẳng định phong cách sống thời thượng và gu thẩm mỹ cá nhân.
                    </p>
                    <p>
                        Với phương châm “Chất lượng tạo nên đẳng cấp”, SACHA cam kết mang đến cho bạn những bộ sưu tập mới nhất, hot nhất từ các sàn diễn thời trang quốc tế – cùng chính sách bảo hành, hậu mãi và hỗ trợ tận tâm. SACHA tin rằng, mỗi chiếc túi là một phần trong câu chuyện phong cách của riêng bạn.
                    </p>
                    <div class="text-center">
                        <a href="{{ url('/viewAll') }}">
                            <button class="btn btn-danger mt-3 px-4 py-2" style="font-size: 1.1rem; border-radius: 30px;">
                                Khám phá ngay!
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4" style="padding: 15px!important;">
            <div style="background-color: #2885BA" class="service-list__content-box">
                <img src="{{ asset('frontend/img/luxurybag.jpg')}}" alt="Luxury Bag">
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
                <img src="{{ asset('frontend/img/communitybag.jpg')}}" alt="Quality Bag">
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
                <img src="{{ asset('frontend/img/qualitybag.jpg')}}" alt="Community">
                <h3 class="h1-title">
                    3. NƠI HỘI TỤ NHỮNG TÍN ĐỒ ĐAM MÊ TÚI HIỆU!
                </h3>
                <p>
                    Sacha không chỉ là nơi mua sắm, mà còn là cộng đồng để những người yêu túi hiệu chia sẻ đam mê, phong cách và cảm hứng thời trang.
                </p>
            </div>
        </div>
    </div>


</div>
@endsection