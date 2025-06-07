@extends('layout')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* General & Reset */
    body {
        font-family: 'Inter', sans-serif; /* A more modern, clean font */
        background-color: #f0f2f5; /* Light grey background */
        color: #333;
        line-height: 1.6;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Montserrat', sans-serif; /* A strong, modern heading font */
        color: #2c3e50; /* Darker tone for headings */
    }

    a {
        text-decoration: none;
        color: #3498db; /* A vibrant blue for links */
        transition: color 0.3s ease;
    }

    a:hover {
        color: #2980b9;
    }

    hr {
        border: 0;
        height: 1px;
        background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0));
        margin: 40px 0;
    }

    /* Layout Container */
    .body-container {
        padding-top: 80px; /* More space from top */
        max-width: 1280px; /* Slightly wider container */
        margin: 0 auto;
        padding-left: 20px;
        padding-right: 20px;
    }

    /* Back to Shopping Button */
    .buy_continute {
        display: inline-flex;
        align-items: center;
        margin-bottom: 35px;
        color: #555;
        font-weight: 500;
        font-size: 1.05rem;
        padding: 8px 15px;
        border-radius: 8px;
        background-color: #e9ecef;
        transition: all 0.3s ease;
    }

    .buy_continute:hover {
        background-color: #dde2e6;
        color: #333;
        transform: translateX(-5px);
    }

    .buy_continute i {
        margin-right: 10px;
        font-size: 1.1rem;
    }

    /* Product Card */
    .product-detail-card {
        display: flex;
        flex-wrap: wrap;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 40px;
        align-items: flex-start;
        margin-bottom: 50px;
    }

    .product-image-area {
        flex: 1;
        min-width: 350px;
        max-width: 550px;
        margin-right: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fdfdfd;
        border-radius: 12px;
        padding: 25px;
        box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.03);
        overflow: hidden; /* Ensure image zoom stays within bounds */
    }

    .product-image-area img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        transition: transform 0.4s ease-in-out, opacity 0.4s ease-in-out; /* Add opacity transition */
    }

    .product-image-area img:hover {
        transform: scale(1.15); /* More noticeable zoom effect on hover (from 1.05 to 1.15) */
        opacity: 0.8; /* Slightly dim the image on hover */
    }

    .product-info-area {
        flex: 2;
        min-width: 400px;
    }

    .product-info-area h3 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .product-short-description {
        font-size: 1.05rem;
        color: #7f8c8d; /* Muted grey */
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .product-price-display {
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .old-price {
        font-size: 1.3rem;
        color: #95a5a6; /* Lighter grey for old price */
        text-decoration: line-through;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .current-price {
        font-size: 3.2rem; /* Much larger for impact */
        color: #e74c3c; /* Striking red for current price */
        font-weight: 800;
        display: block;
    }

    .currency-symbol {
        font-size: 0.7em;
        vertical-align: super;
    }

    .product-quantity-available {
        margin-bottom: 25px;
        font-size: 1.1rem;
        color: #555;
    }

    .quantity-count {
        font-weight: 700;
        color: #27ae60; /* Green for available stock */
    }

    .product-action-buttons {
        display: flex;
        gap: 20px; /* More space between buttons */
        margin-top: 30px;
    }

    .add-to-cart-btn,
    .buy-now-btn {
        padding: 16px 35px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
        flex: 1;
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Subtle shadow for buttons */
        /* Make text contrast for better readability on hover */
        color: #fff; /* Default text color */
    }

    .add-to-cart-btn {
        background-color: #3498db; /* Blue for add to cart */
        border: 2px solid #3498db;
    }

    .add-to-cart-btn:hover {
        background-color: #2980b9;
        border-color: #2980b9;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(52, 152, 219, 0.4);
        color: #fff; /* Ensure text remains white for contrast */
    }

    .buy-now-btn {
        background-color: #2ecc71; /* Green for buy now */
        border: 2px solid #2ecc71;
    }

    .buy-now-btn:hover {
        background-color: #27ae60;
        border-color: #27ae60;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(46, 204, 113, 0.4);
        color: #fff; /* Ensure text remains white for contrast */
    }

    .out-of-stock-message {
        color: #e74c3c !important; /* Red for out of stock */
        font-size: 1.2rem !important;
        margin-top: 20px;
        font-weight: 600;
        text-align: center;
        padding: 10px;
        background-color: #fbe0e0;
        border-radius: 8px;
    }

    /* Section Title */
    .section-heading {
        text-align: center;
        margin: 60px 0 40px;
        font-size: 2.4rem;
        color: #2c3e50;
        position: relative;
        padding-bottom: 15px;
    }

    .section-heading::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 80px;
        height: 5px;
        background-color: #3498db; /* Blue underline */
        border-radius: 3px;
    }

    /* Product Description */
    .product-description-panel {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        padding: 30px;
        margin-bottom: 50px;
    }

    .description-textarea {
        width: 100%;
        border: none;
        background-color: transparent;
        color: #555;
        padding: 0;
        resize: none;
        overflow: hidden;
        font-size: 1.05rem;
        line-height: 1.8;
        transition: all 0.3s ease;
    }

    .description-textarea:focus {
        outline: none;
    }

    .toggle-description-btn {
        background: none;
        border: none;
        color: #3498db;
        cursor: pointer;
        font-weight: 600;
        padding: 10px 0;
        font-size: 1rem;
        transition: color 0.3s ease, text-decoration 0.3s ease;
        display: block; /* Ensure it takes full width for margin auto to work */
        margin-top: 15px; /* Add some space above the button */
        margin-left: auto; /* Center button */
        margin-right: auto; /* Center button */
        width: fit-content; /* Make button only as wide as its content for centering */
    }

    .toggle-description-btn:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    /* Comment Section */
    .comment-area {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        padding: 30px;
        margin-top: 50px;
    }

    .comment-area h3 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 30px;
        border-bottom: 2px solid #f0f2f5;
        padding-bottom: 20px;
    }

    .comment-form-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 40px;
    }

    .comment-input-textarea {
        width: 100%;
        padding: 18px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        font-size: 1.05rem;
        line-height: 1.6;
        min-height: 100px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .comment-input-textarea:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.3rem rgba(52, 152, 219, 0.2);
        outline: none;
    }

    .submit-comment-btn {
        background-color: #3498db;
        color: #fff;
        padding: 14px 30px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 1.1rem;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        align-self: flex-end;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }

    .submit-comment-btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    }

    .login-prompt {
        font-size: 1.1rem;
        color: #555;
        text-align: center;
        padding: 20px;
        background-color: #f7f7f7;
        border-radius: 10px;
        border: 1px dashed #e0e0e0;
    }

    .login-prompt a {
        font-weight: 700;
        color: #e74c3c;
    }

    .comment-list-area {
        margin-top: 30px;
    }

    .comment-entry {
        display: flex;
        align-items: flex-start;
        margin-bottom: 30px;
        padding: 25px;
        background-color: #fdfdfd;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    .comment-entry:hover {
        transform: translateY(-5px); /* More noticeable lift on hover */
    }

    .comment-avatar {
        width: 60px; /* Larger avatar */
        height: 60px;
        border-radius: 50%;
        margin-right: 20px;
        object-fit: cover;
        border: 3px solid #ecf0f1; /* Light border */
        flex-shrink: 0;
    }

    .comment-content-wrapper {
        flex: 1;
    }

    .comment-header {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        gap: 12px; /* Space between username and time */
    }

    .comment-username {
        font-weight: 700;
        color: #333;
        font-size: 1.2rem;
    }

    .comment-time {
        font-size: 0.9rem;
        color: #999;
    }

    .comment-text-body {
        font-size: 1.05rem;
        color: #495057;
        line-height: 1.7;
        margin-bottom: 15px;
        word-wrap: break-word; /* Ensure long words break */
    }

    .comment-action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 10px;
    }

    .comment-action-buttons button {
        background: none;
        border: none;
        color: #3498db;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 600;
        padding: 5px 0;
        transition: color 0.3s ease, text-decoration 0.3s ease;
    }
    .comment-action-buttons button.btn-delete {
        color: #e74c3c; /* Red for delete button */
    }
    .comment-action-buttons button.btn-delete:hover {
        color: #c0392b;
    }

    .comment-action-buttons button:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    .edit-comment-textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        font-size: 1rem;
        min-height: 80px;
        margin-bottom: 15px;
        transition: border-color 0.3s ease;
    }

    .edit-comment-textarea:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .no-comments-message {
        text-align: center;
        font-style: italic;
        color: #7f8c8d;
        padding: 20px;
        border: 1px dashed #e0e0e0;
        border-radius: 10px;
        background-color: #fcfcfc;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .product-detail-card {
            flex-direction: column;
            padding: 30px;
        }

        .product-image-area {
            margin-right: 0;
            margin-bottom: 30px;
            max-width: 100%;
            min-width: unset;
            padding: 20px;
        }

        .product-info-area {
            min-width: unset;
            width: 100%;
        }

        .product-info-area h3 {
            font-size: 2.2rem;
        }

        .current-price {
            font-size: 2.8rem;
        }

        .product-action-buttons {
            flex-direction: column;
            gap: 15px;
        }
    }

    @media (max-width: 768px) {
        .body-container {
            padding-top: 60px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .product-detail-card,
        .product-description-panel,
        .comment-area {
            padding: 25px;
            border-radius: 10px;
        }

        .product-info-area h3 {
            font-size: 2rem;
        }

        .current-price {
            font-size: 2.4rem;
        }

        .section-heading {
            font-size: 2rem;
            margin: 50px 0 35px;
        }

        .comment-area h3 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            padding-bottom: 15px;
        }

        .comment-entry {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .comment-avatar {
            margin-right: 0;
            margin-bottom: 15px;
        }

        .comment-header {
            flex-direction: column;
            gap: 5px;
        }

        .comment-username {
            margin-right: 0;
        }

        .comment-action-buttons {
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .product-detail-card {
            padding: 20px;
        }

        .product-info-area h3 {
            font-size: 1.8rem;
        }

        .current-price {
            font-size: 2rem;
        }

        .add-to-cart-btn, .buy-now-btn {
            font-size: 1rem;
            padding: 12px 20px;
        }

        .section-heading {
            font-size: 1.8rem;
            margin: 40px 0 30px;
        }

        .comment-input-textarea {
            padding: 15px;
        }

        .submit-comment-btn {
            padding: 12px 25px;
            font-size: 1rem;
        }

        .comment-avatar {
            width: 50px;
            height: 50px;
        }

        .comment-username {
            font-size: 1.1rem;
        }

        .comment-text-body {
            font-size: 0.95rem;
        }
    }
</style>

<div class="body-container">
    <a class="buy_continute" href="{{ URL::to('/') }}">
        <i class="fa fa-arrow-circle-left"></i> Trở lại mua hàng
    </a>

    <div class="product-detail-card mt-3">
        <div class="product-image-area mr-2">
            <div class="big-img">
                <img src="{{ asset($sanpham->anhsp) }}" alt="{{ $sanpham->tensp }}" id="zoom">
            </div>
        </div>

        <div class="product-info-area">
            <h3>{{ $sanpham->tensp }}</h3>

            <div class="product-short-description">
                Chúng tôi mang đến những sản phẩm chất lượng, thiết kế ấn tượng và công năng vượt trội, giúp bạn thể hiện phong cách riêng và tận hưởng cuộc sống trọn vẹn hơn mỗi ngày.
            </div>

            <hr />

            <div class="product-price-display">
                @if ($sanpham->giakhuyenmai < $sanpham->giasp && $sanpham->giakhuyenmai > 0)
                <div class="old-price">
                    <span class="Price">
                        <bdi>{{ number_format($sanpham->giasp, 0, ',', '.') }}<span class="currency-symbol">₫</span></bdi>
                    </span>
                </div>
                <div class="current-price">
                    <span class="Price">
                        <bdi>{{ number_format($sanpham->giakhuyenmai, 0, ',', '.') }}<span class="currency-symbol">₫</span></bdi>
                    </span>
                </div>
                @else
                <div class="current-price" style="font-size: 3.2rem;">
                    <span class="Price">
                        <bdi>{{ number_format($sanpham->giasp, 0, ',', '.') }}<span class="currency-symbol">₫</span></bdi>
                    </span>
                </div>
                @endif
            </div>

            <form action="" method="POST">
                @if ($sanpham->soluong > 0)
                <div class="product-quantity-available">
                    <span>
                        Số lượng trong kho:
                        <span class="quantity-count">{{ $sanpham->soluong }}</span>
                    </span>
                </div>

                <div class="product-action-buttons">
                    <a href="{{ route('add_to_cart', $sanpham->id_sanpham) }}" class="add-to-cart-btn"
                        name="add-to-cart">
                        Thêm vào giỏ hàng
                    </a>
                    <a href="{{ route('add_go_to_cart', $sanpham->id_sanpham) }}" class="buy-now-btn"
                        name="buy-now">
                        Mua ngay
                    </a>
                </div>
                @else
                <div class="out-of-stock-message fw-bold">
                    Sản phẩm đã hết trong kho
                </div>
                @endif
            </form>
        </div>
    </div>

    <div class="section-heading">
        <h2>MÔ TẢ SẢN PHẨM</h2>
    </div>
    <div class="product-description-panel">
        <textarea class="description-textarea" id="mota" name="mota" rows="4" disabled>{{ $sanpham->mota }}</textarea>
        <button id="toggleMotaBtn" class="toggle-description-btn">Xem thêm</button>
    </div>

    <hr />

    <div class="comment-area">
        <h3>Bình luận về sản phẩm</h3>

        @if(Auth::check())
        <form id="commentForm" class="comment-form-container">
            @csrf
            <input type="hidden" name="sanpham_id" value="{{ $sanpham->id_sanpham }}">

            <div class="comment-box">
                <textarea name="content" placeholder="Viết bình luận của bạn tại đây..." rows="3" required class="comment-input-textarea"></textarea>
                {{-- reCAPTCHA div will be displayed by JS if needed --}}
                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" style="display:none;"></div>
                <button type="submit" class="submit-comment-btn">Gửi bình luận</button>
            </div>
        </form>
        @else
        <p class="login-prompt">Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để bình luận về sản phẩm này.</p>
        @endif

        <div id="commentsList" class="comment-list-area">
            @foreach($comments as $comment)
            <div class="comment-entry" data-id="{{ $comment->id }}">
                <img src="{{ asset('frontend/img/user.jpg') }}" alt="Avatar" class="comment-avatar" />
                <div class="comment-content-wrapper">
                    <div class="comment-header">
                        <b class="comment-username">{{ $comment->user->hoten }}</b>
                        <small class="comment-time">
                            {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                        </small>
                    </div>
                    <p class="comment-text-body">{{ $comment->content }}</p>

                    @if(Auth::id() == $comment->user_id)
                    <div class="comment-action-buttons">
                        <button class="btn-edit">Sửa</button>
                        <button class="btn-delete">Xóa</button>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            @if ($comments->isEmpty())
            <p class="no-comments-message">Chưa có bình luận nào cho sản phẩm này. Hãy là người đầu tiên bình luận!</p>
            @endif
        </div>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentForm = document.getElementById('commentForm');
            const commentsList = document.getElementById('commentsList');
            const csrfToken = document.querySelector('input[name="_token"]').value;
            const recaptchaDiv = document.querySelector('.g-recaptcha');
            let hasViewedComments = false;

            // --- Description "Xem thêm" button logic ---
            const motaTextarea = document.getElementById("mota");
            const toggleMotaBtn = document.getElementById("toggleMotaBtn");
            let expandedDescription = false; // Add this variable back

            function adjustMotaTextarea() {
                motaTextarea.style.height = 'auto'; // Reset height
                const lineHeight = parseFloat(getComputedStyle(motaTextarea).lineHeight);
                const naturalHeight = motaTextarea.scrollHeight;

                // Set a max height for initial display (e.g., 4 lines)
                const initialMaxHeight = lineHeight * 4;

                if (naturalHeight > initialMaxHeight) {
                    toggleMotaBtn.style.display = "block"; /* Changed to block for centering with margin auto */
                    toggleMotaBtn.style.width = "fit-content"; /* Allow button to shrink to content width */
                    motaTextarea.style.height = initialMaxHeight + 'px'; // Collapse to 4 lines
                    motaTextarea.style.overflowY = 'hidden';
                    toggleMotaBtn.textContent = "Xem thêm";
                    expandedDescription = false;
                } else {
                    toggleMotaBtn.style.display = "none";
                    motaTextarea.style.height = naturalHeight + 'px'; // Adjust to fit content
                    motaTextarea.style.overflowY = 'hidden';
                }
            }

            adjustMotaTextarea(); // Initial adjustment on load

            toggleMotaBtn.addEventListener("click", () => {
                expandedDescription = !expandedDescription;
                if (expandedDescription) {
                    motaTextarea.style.height = motaTextarea.scrollHeight + 'px'; // Expand to full content
                    motaTextarea.style.overflowY = 'auto'; // Allow scrolling if content is very long
                    toggleMotaBtn.textContent = "Thu gọn";
                } else {
                    const lineHeight = parseFloat(getComputedStyle(motaTextarea).lineHeight);
                    motaTextarea.style.height = (lineHeight * 4) + 'px'; // Collapse to 4 lines
                    motaTextarea.style.overflowY = 'hidden';
                    toggleMotaBtn.textContent = "Xem thêm";
                }
            });

            // --- Comment Section Logic ---
            // Observe when the comments section comes into view
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    hasViewedComments = true;
                    observer.disconnect(); // Stop observing once viewed
                }
            }, { threshold: 0.1 });
            observer.observe(commentsList);

            let commentTimes = []; // Store timestamps of comments sent

            if (commentForm) {
                commentForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!hasViewedComments) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Cảnh báo',
                            text: 'Vui lòng xem phần bình luận trước khi gửi.',
                            timer: 2500,
                            showConfirmButton: false
                        });
                        return;
                    }

                    const now = Date.now();
                    // Filter out comments older than 2 minutes
                    commentTimes = commentTimes.filter(t => now - t < 2 * 60 * 1000);
                    commentTimes.push(now);

                    const content = this.content.value.trim();
                    const sanpham_id = this.sanpham_id.value;

                    if (!content) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Vui lòng nhập nội dung bình luận.',
                            timer: 2500,
                            showConfirmButton: false
                        });
                        return;
                    }

                    let data = {
                        sanpham_id,
                        content
                    };

                    // Check reCAPTCHA if more than 3 comments are sent within 2 minutes
                    if (commentTimes.length > 3) {
                        recaptchaDiv.style.display = 'block';
                        const recaptchaToken = grecaptcha.getResponse();
                        if (!recaptchaToken) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Vui lòng xác minh CAPTCHA.',
                                timer: 2500,
                                showConfirmButton: false
                            });
                            return;
                        }
                        data['g-recaptcha-response'] = recaptchaToken;
                    } else {
                        recaptchaDiv.style.display = 'none'; // Hide if not needed
                    }

                    fetch("{{ route('comment.post') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                grecaptcha.reset(); // Reset reCAPTCHA after successful submission
                                recaptchaDiv.style.display = 'none';
                                const comment = data.comment;

                                // Remove "No comments" message if present
                                const noCommentsMessage = document.querySelector('.no-comments-message');
                                if (noCommentsMessage) {
                                    noCommentsMessage.remove();
                                }

                                const html = `
                                <div class="comment-entry" data-id="${comment.id}">
                                    <img src="{{ asset('frontend/img/user.jpg') }}" alt="Avatar" class="comment-avatar" />
                                    <div class="comment-content-wrapper">
                                        <div class="comment-header">
                                            <b class="comment-username">${comment.user.hoten}</b>
                                            <small class="comment-time">vừa xong</small>
                                        </div>
                                        <p class="comment-text-body">${comment.content}</p>
                                        <div class="comment-action-buttons">
                                            <button class="btn-edit">Sửa</button>
                                            <button class="btn-delete">Xóa</button>
                                        </div>
                                    </div>
                                </div>`;
                                commentsList.insertAdjacentHTML('afterbegin', html);
                                this.content.value = '';
                                if (commentTimes.length > 3) commentTimes = [];
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: 'Bình luận của bạn đã được gửi!',
                                    timer: 2500,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Thất bại',
                                    text: `${data.message || 'Bình luận không thành công.'}`,
                                    timer: 2500,
                                    showConfirmButton: false
                                });
                                if (commentTimes.length > 3) grecaptcha.reset();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Đã có lỗi xảy ra, vui lòng thử lại.',
                                timer: 2500,
                                showConfirmButton: false
                            });
                            if (commentTimes.length > 3) grecaptcha.reset();
                        });
                });
            }


            commentsList.addEventListener('click', function(e) {
                const target = e.target;
                const commentEntry = target.closest('.comment-entry');
                if (!commentEntry) return;
                const commentId = commentEntry.getAttribute('data-id');

                // Delete comment
                if (target.classList.contains('btn-delete')) {
                    Swal.fire({
                        title: 'Bạn có chắc chắn?',
                        text: "Bình luận này sẽ bị xóa vĩnh viễn!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e74c3c',
                        cancelButtonColor: '#95a5a6',
                        confirmButtonText: 'Đồng ý xóa',
                        cancelButtonText: 'Hủy bỏ'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/comments/${commentId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        commentEntry.remove();
                                        Swal.fire(
                                            'Đã xóa!',
                                            'Bình luận đã được xóa thành công.',
                                            'success'
                                        )
                                        // If no comments left, show the message
                                        if (commentsList.children.length === 0) {
                                            commentsList.innerHTML = `<p class="no-comments-message">Chưa có bình luận nào cho sản phẩm này. Hãy là người đầu tiên bình luận!</p>`;
                                        }
                                    } else {
                                        Swal.fire(
                                            'Thất bại!',
                                            data.message || 'Không thể xóa bình luận.',
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire(
                                        'Lỗi!',
                                        'Đã có lỗi xảy ra khi xóa bình luận.',
                                        'error'
                                    );
                                });
                        }
                    });
                }

                // Edit comment
                if (target.classList.contains('btn-edit')) {
                    const contentText = commentEntry.querySelector('.comment-text-body');
                    const oldContent = contentText.textContent;
                    const textarea = document.createElement('textarea');
                    textarea.value = oldContent;
                    textarea.rows = 3;
                    textarea.classList.add('edit-comment-textarea');

                    // Check if edit/save buttons are already present
                    const existingSaveBtn = commentEntry.querySelector('.btn-save');
                    const existingCancelBtn = commentEntry.querySelector('.btn-cancel');

                    if (existingSaveBtn || existingCancelBtn) {
                        // If already in edit mode, do nothing or prevent multiple clicks
                        return;
                    }

                    contentText.replaceWith(textarea);
                    target.textContent = 'Lưu';
                    target.classList.remove('btn-edit');
                    target.classList.add('btn-save');

                    const cancelBtn = document.createElement('button');
                    cancelBtn.textContent = 'Hủy';
                    cancelBtn.classList.add('btn-cancel');
                    target.parentNode.insertBefore(cancelBtn, target.nextSibling);

                    // Store original click handler to restore later if needed
                    const originalTargetOnClick = target.onclick;

                    cancelBtn.addEventListener('click', function() {
                        const p = document.createElement('p');
                        p.classList.add('comment-text-body');
                        p.textContent = oldContent;
                        textarea.replaceWith(p);
                        target.textContent = 'Sửa';
                        target.classList.remove('btn-save');
                        target.classList.add('btn-edit');
                        cancelBtn.remove();
                        target.onclick = originalTargetOnClick; // Restore original handler
                    });

                    // Set the new click handler for 'Save'
                    target.onclick = function() {
                        const newContent = textarea.value.trim();
                        if (!newContent) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Nội dung bình luận không được để trống.',
                                timer: 2500,
                                showConfirmButton: false
                            });
                            return;
                        }

                        fetch(`/comments/${commentId}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    content: newContent
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    const p = document.createElement('p');
                                    p.classList.add('comment-text-body');
                                    p.textContent = data.comment.content;

                                    textarea.replaceWith(p);
                                    target.textContent = 'Sửa';
                                    target.classList.remove('btn-save');
                                    target.classList.add('btn-edit');
                                    cancelBtn.remove();
                                    target.onclick = originalTargetOnClick; // Restore original handler
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thành công',
                                        text: 'Bình luận đã được cập nhật.',
                                        timer: 2500,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Thất bại',
                                        text: data.message || 'Cập nhật bình luận không thành công.',
                                        timer: 2500,
                                        showConfirmButton: false
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi',
                                    text: 'Đã có lỗi xảy ra khi cập nhật bình luận.',
                                    timer: 2500,
                                    showConfirmButton: false
                                });
                            });
                    }
                }
            });
        });
    </script>
</div>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Thành công',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif
@endsection