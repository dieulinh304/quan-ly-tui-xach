@extends('layout')
@section('content')
<style>
    /* General product styling (kept for consistency if other elements on the page use it) */
    .product {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .product:hover {
        transform: translateY(-5px);
    }

    .product .box-icon-new-product {
        position: absolute;
        top: 8px;
        right: 8px;
        width: auto;
        min-height: auto;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        gap: 8px;
        z-index: 2;
    }

    .product .box-icon-new-product i {
        color: var(--color-text-1, #333);
        width: 40px;
        height: 40px;
        background-color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 40px;
        transition: all 0.4s ease;
        opacity: 0;
        cursor: pointer;
        pointer-events: auto;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .product .box-icon-new-product i:hover {
        background-color: var(--Hover-icon, #007bff);
        color: white;
        transform: scale(1.1);
    }

    .product .box-icon-new-product #search-Product {
        transform: translateX(50px);
    }

    .product .box-icon-new-product #cart-Product {
        transform: translateX(50px);
    }

    .product:hover .box-icon-new-product #cart-Product,
    .product:hover .box-icon-new-product #search-Product,
    .product:hover .box-icon-new-product #heart-Product {
        opacity: 1;
        transform: translateX(0);
    }

    .product:hover .box-icon-new-product #cart-Product {
        transition-delay: 0.1s;
    }

    .product:hover .box-icon-new-product #search-Product {
        transition-delay: 0.2s;
    }

    .product__img {
        position: relative;
        overflow: hidden;
        border-radius: 8px 8px 0 0;
    }

    .product__img img {
        display: block;
        width: 100%;
        height: auto;
        transition: transform 0.5s ease, filter 0.5s ease;
    }

    .product__img::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0);
        transition: background-color 0.5s ease;
        z-index: 1;
        pointer-events: none;
    }

    .product:hover .product__img img {
        transform: scale(1.05);
        filter: brightness(80%);
    }

    .product:hover .product__img::before {
        background-color: rgba(0, 0, 0, 0.1);
    }

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
        color: #e60023;
        font-weight: bold;
    }

    .product__sale {
        position: absolute;
        top: 8px;
        left: 8px;
        background-color: #ff4d4d;
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

    /* Styles for the new feature items (Image & Text side-by-side) */
    .feature-section-container {
        display: flex;
        flex-direction: column; /* Stack items vertically */
        gap: 60px; /* Space between large items */
        padding: 40px 20px; /* Add some padding around the section */
        max-width: 1200px; /* Constrain width for better readability */
        margin: 0 auto; /* Center the container */
    }

    .feature-item {
        display: flex;
        align-items: center; /* Center items vertically */
        background-color: #fcfcfc; /* Light background for the whole item */
        border-radius: 15px; /* More pronounced rounded corners */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); /* Stronger, softer shadow */
        overflow: hidden;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        padding: 20px; /* Add padding to the item itself */
    }

    .feature-item:hover {
        transform: translateY(-12px); /* Significant lift effect */
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25); /* Even stronger shadow on hover */
    }

    .feature-item__img-wrapper {
        flex: 1; /* Take up half width */
        min-width: 50%;
        overflow: hidden;
        border-radius: 12px; /* Apply border-radius to the wrapper if needed for visual */
        position: relative; /* For image hover effect */
    }

    /* Image on the left (default) */
    .feature-item__img-wrapper {
        margin-right: 30px; /* Space between image and content */
    }

    /* Image on the right (reversed) */
    .feature-item--reversed .feature-item__img-wrapper {
        order: 2; /* Image to the right */
        margin-left: 30px; /* Space between content and image */
        margin-right: 0;
    }

    .feature-item__img-wrapper img {
        display: block;
        width: 100%;
        height: 400px; /* Fixed height for consistency, adjust as needed */
        object-fit: cover;
        transition: transform 0.6s ease, filter 0.6s ease;
        border-radius: 12px; /* Rounded corners for the image itself */
    }

    .feature-item__img-wrapper:hover img {
        transform: scale(1.05); /* Zoom in */
        filter: brightness(0.8) blur(2px); /* Dim and blur on hover */
    }

    .feature-item__content {
        flex: 1;
        padding: 20px; /* Padding inside the content area */
        text-align: left; /* Align text to left for better readability */
        color: #333; /* Darker text for readability on light background */
    }

    .feature-item__content h3 {
        font-size: 2.5em; /* Larger title */
        margin-bottom: 20px;
        font-weight: bold;
        color: #2c3e50; /* Stronger heading color */
    }

    .feature-item__content p {
        font-size: 1.1em;
        line-height: 1.8;
        margin-bottom: 30px;
        color: #555;
    }

    .btn-feature-action {
        display: inline-block;
        background: linear-gradient(45deg, #007bff, #0056b3); /* Gradient button */
        color: white;
        padding: 15px 35px; /* Larger button */
        border-radius: 50px; /* More rounded */
        text-decoration: none;
        font-weight: bold;
        font-size: 1.1em;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-feature-action:hover {
        background: linear-gradient(45deg, #0056b3, #007bff);
        transform: translateY(-3px) scale(1.02); /* Slight lift and scale */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    /* Responsive adjustments for new feature items */
    @media (max-width: 991.98px) {
        .feature-item {
            flex-direction: column; /* Stack image and text vertically */
            padding: 15px; /* Adjust padding */
        }
        .feature-item__img-wrapper,
        .feature-item--reversed .feature-item__img-wrapper {
            min-width: 100%;
            margin-right: 0;
            margin-left: 0;
            margin-bottom: 20px; /* Space below image */
            border-radius: 12px 12px 0 0; /* Rounded top corners for stacked layout */
        }
        .feature-item--reversed .feature-item__img-wrapper {
            order: 1; /* Image always on top when stacked */
        }
        .feature-item__content {
            padding: 15px;
            text-align: center; /* Center text on smaller screens */
        }
        .feature-item__content h3 {
            font-size: 1.8em;
        }
        .feature-item__content p {
            font-size: 1em;
        }
        .feature-item__img-wrapper img {
            height: 300px; /* Adjust height for smaller screens */
        }
    }

    /* Existing media query from original for .body width */
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

    <div class="body__mainTitle">
        <h2>Những Điều Khiến SACHA Khác Biệt</h2>
    </div>

    <div class="feature-section-container">
        <!-- Feature Item 1 (Image Left, Text Right) -->
        <div class="feature-item">
            <div class="feature-item__img-wrapper">
                <img src="{{ asset('frontend/img/luxurybag.jpg')}}" alt="Luxury Bag" onerror="this.src='https://placehold.co/800x600/2885BA/FFFFFF?text=Luxury+Bag'">
            </div>
            <div class="feature-item__content">
                <h3>1. SACHA - ĐỈNH CAO THỜI TRANG TÚI HIỆU!</h3>
                <p>
                    SACHA cung cấp các bộ sưu tập túi hiệu từ những thương hiệu danh tiếng, giúp bạn tỏa sáng trong mọi dịp, từ công việc đến các sự kiện sang trọng, khẳng định gu thẩm mỹ cá nhân.
                </p>
                <a href="{{ url('/viewAll') }}" class="btn-feature-action">Tìm hiểu thêm</a>
            </div>
        </div>

        <!-- Feature Item 2 (Text Left, Image Right) -->
        <div class="feature-item feature-item--reversed">
            <div class="feature-item__img-wrapper">
                <img src="{{ asset('frontend/img/communitybag.jpg')}}" alt="Quality Bag" onerror="this.src='https://placehold.co/800x600/B56256/FFFFFF?text=Quality+Bag'">
            </div>
            <div class="feature-item__content">
                <h3>2. CHẤT LƯỢNG VÀ SỰ TIN CẬY HÀNG ĐẦU!</h3>
                <p>
                    Mỗi sản phẩm tại SACHA đều được chọn lọc kỹ lưỡng, đảm bảo chất lượng cao cấp và thiết kế độc đáo. Chúng tôi cam kết mang lại sự hài lòng tối đa cho khách hàng bằng sản phẩm chính hãng 100%.
                </p>
                <a href="{{ url('/viewAll') }}" class="btn-feature-action">Xem thêm</a>
            </div>
        </div>

        <!-- Feature Item 3 (Image Left, Text Right) -->
        <div class="feature-item">
            <div class="feature-item__img-wrapper">
                <img src="{{ asset('frontend/img/qualitybag.jpg')}}" alt="Community" onerror="this.src='https://placehold.co/800x600/5C9CCA/FFFFFF?text=Community'">
            </div>
            <div class="feature-item__content">
                <h3>3. NƠI HỘI TỤ NHỮNG TÍN ĐỒ ĐAM MÊ TÚI HIỆU!</h3>
                <p>
                    SACHA không chỉ là nơi mua sắm, mà còn là cộng đồng để những người yêu túi hiệu chia sẻ đam mê, phong cách và cảm hứng thời trang, cùng nhau tạo nên một không gian đẳng cấp.
                </p>
                <a href="{{ url('/viewAll') }}" class="btn-feature-action">Tham gia cộng đồng</a>
            </div>
        </div>
    </div>
</div>
@endsection