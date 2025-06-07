@extends('layout')
@section('content')
<!-- Main -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="body" style="padding-top: 50px;">
    <a class="buy_continute" href="{{ URL::to('/') }}">
        <i class="fa fa-arrow-circle-left"></i> Trở lại mua hàng
    </a>

    <div class="product_card mt-3">
        <div class="product__details-img mr-2">
            <div class="big-img">
                <img src="{{ asset($sanpham->anhsp) }}" alt="" id="zoom" style="visibility: visible;">
            </div>
        </div>

        <div class="product__details-info">
            <h3 style="margin-top: unset; line-height: unset;">{{ $sanpham->tensp }}</h3>

            <div class="short-des">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam sit aliquid debitis voluptates ducimus, quasi iusto nam quaerat eius quidem.
            </div>

            <hr />

            <div class="product__pride">
                <div class="product__pride-oldPride" style="font-size: 20px; text-align: start;">
                    <span class="Price">
                        <bdi>{{ number_format($sanpham->giasp, 0, ',', '.') }}<span class="currencySymbol">₫</span></bdi>
                    </span>
                </div>
                <div class="product__pride-newPride" style="font-size: 40px; text-align: start;">
                    <span class="Price">
                        <bdi>{{ number_format($sanpham->giakhuyenmai, 0, ',', '.') }}<span class="currencySymbol">₫</span></bdi>
                    </span>
                </div>
            </div>

            <form action="" method="POST">
                @if ($sanpham->soluong > 0)
                <div class="number">
                    <span>
                        Số lượng:
                        <span class="number__count">{{ $sanpham->soluong }}</span>
                    </span>
                </div>

                <div class="product__cart">
                    <a href="{{ route('add_to_cart', $sanpham->id_sanpham) }}" class="product__cart-add" name="add-to-cart">
                        Thêm vào giỏ hàng
                    </a>
                    <a href="{{ route('add_go_to_cart', $sanpham->id_sanpham) }}" class="product__cart-buy" name="buy-now">
                        Mua ngay
                    </a>
                </div>
                @else
                <div class="text-danger fw-bold" style="font-size: 16px; margin-top: 10px;">
                    Sản phẩm đã hết trong kho
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Mô tả sản phẩm -->
    <div class="body__mainTitle">
        <h2>MÔ TẢ SẢN PHẨM</h2>
    </div>
    <div class="product-description">
        <textarea class="form-control" id="mota" name="mota" rows="4" disabled style="font-size: 16px;background-color: transparent;border: none;color: #555;padding: 10px 0px;resize: none;overflow: hidden;">{{$sanpham->mota}}</textarea>
        <button id="toggleMotaBtn" style="margin-top: 5px; background: none; border: none; color: #1877f2; cursor: pointer; display: none;">Xem thêm</button>
    </div>
    <script>
        const btn = document.getElementById("toggleMotaBtn");
        const mota = document.getElementById("mota");

        const lineCount = mota.value.split('\n').length;

        if (lineCount > 4) {
            btn.style.display = "inline";
        }

        let expanded = false;
        btn.addEventListener("click", () => {
            expanded = !expanded;
            if (expanded) {
                mota.rows = lineCount + 1;
                btn.textContent = "Thu gọn";
            } else {
                mota.rows = 4;
                btn.textContent = "Xem thêm";
            }
        });
    </script>

    <hr />

    <!-- Bình luận sản phẩm -->
    <div class="comment-section">
        <h3>Bình luận</h3>

        @if(Auth::check())
        <form id="commentForm" style="margin-top: 20px;">
            @csrf
            <input type="hidden" name="sanpham_id" value="{{ $sanpham->id_sanpham }}">

            <div class="comment-box">
                <textarea name="content" placeholder="Viết bình luận..." rows="3" required></textarea>
                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" style="display:none"></div>
                <button type="submit" class="btn-submit">Gửi bình luận</button>
            </div>
        </form>
        @else
        <p>Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để bình luận.</p>
        @endif

        <div id="commentsList">
            @foreach($comments as $comment)
            <div class="comment-item" data-id="{{ $comment->id }}">
                <img src="{{ asset('frontend/img/user.jpg') }}" alt="Avatar" class="avatar" />
                <div class="comment-content">
                    <div class="comment-header">
                        <b class="username">{{ $comment->user->hoten }}</b>
                        <small class="time-text">
                            {{ \Carbon\Carbon::parse($comment->created_at)->format('H:i:s d/m/Y') }}
                        </small>
                    </div>
                    <p class="content-text">{{ $comment->content }}</p>

                    @if(Auth::id() == $comment->user_id)
                    <div class="comment-actions">
                        <button class="btn-edit">Sửa</button>
                        <button class="btn-delete">Xóa</button>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
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

            // Phát hiện khi danh sách bình luận được xem
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    hasViewedComments = true;
                    observer.disconnect(); // Ngừng quan sát sau khi đã xem
                }
            }, { threshold: 0.1 });
            observer.observe(commentsList);

            let commentTimes = []; // Lưu thời điểm gửi bình luận

            commentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!hasViewedComments) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cảnh báo',
                        text: 'Vui lòng xem phần bình luận trước khi gửi.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }

                const now = Date.now();
                commentTimes = commentTimes.filter(t => now - t < 2 * 60 * 1000);
                commentTimes.push(now);

                const content = this.content.value.trim();
                const sanpham_id = this.sanpham_id.value;
                if (!content) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Vui lòng nhập nội dung bình luận',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }

                let data = {
                    sanpham_id,
                    content
                };

                // Kiểm tra reCAPTCHA nếu vượt quá 5 lần
                if (commentTimes.length > 5) {
                    recaptchaDiv.style.display = 'block';
                    const recaptchaToken = grecaptcha.getResponse();
                    if (!recaptchaToken) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Vui lòng xác minh CAPTCHA',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }
                    data['g-recaptcha-response'] = recaptchaToken;
                } else {
                    recaptchaDiv.style.display = 'none';
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
                        grecaptcha.reset();
                        recaptchaDiv.style.display = 'none';
                        const comment = data.comment;
                        const html = `
                            <div class="comment-item" data-id="${comment.id}">
                                <img src="{{ asset('frontend/img/user.jpg') }}" alt="Avatar" class="avatar" />
                                <div class="comment-content">
                                    <b>${comment.user.hoten}</b>
                                    <p class="content-text">${comment.content}</p>
                                    <small class="time-text">vừa xong</small>
                                    <div class="comment-actions">
                                        <button class="btn-edit">Sửa</button>
                                        <button class="btn-delete">Xóa</button>
                                    </div>
                                </div>
                            </div>`;
                        commentsList.insertAdjacentHTML('afterbegin', html);
                        this.content.value = '';
                        if (commentTimes.length > 5) commentTimes = []; // Reset nếu đã xác thực captcha
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại',
                            text: `${data.message || 'Bình luận không thành công'}`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Đã có lỗi xảy ra, vui lòng thử lại',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            });

            commentsList.addEventListener('click', function(e) {
                const target = e.target;
                const commentItem = target.closest('.comment-item');
                if (!commentItem) return;
                const commentId = commentItem.getAttribute('data-id');

                if (target.classList.contains('btn-delete')) {
                    if (confirm('Bạn có chắc muốn xóa bình luận này?')) {
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
                                commentItem.remove();
                            } else {
                                alert(data.message || 'Xóa thất bại');
                            }
                        });
                    }
                }

                if (target.classList.contains('btn-edit')) {
                    const contentText = commentItem.querySelector('.content-text');
                    const oldContent = contentText.textContent;
                    const textarea = document.createElement('textarea');
                    textarea.value = oldContent;
                    textarea.rows = 3;
                    textarea.classList.add('edit-textarea');

                    contentText.replaceWith(textarea);
                    target.textContent = 'Lưu';
                    target.classList.remove('btn-edit');
                    target.classList.add('btn-save');

                    const cancelBtn = document.createElement('button');
                    cancelBtn.textContent = 'Hủy';
                    cancelBtn.classList.add('btn-cancel');
                    target.parentNode.insertBefore(cancelBtn, target.nextSibling);

                    cancelBtn.addEventListener('click', function() {
                        const p = document.createElement('p');
                        p.classList.add('content-text');
                        p.textContent = oldContent;
                        textarea.replaceWith(p);
                        target.textContent = 'Sửa';
                        target.classList.remove('btn-save');
                        target.classList.add('btn-edit');
                        cancelBtn.remove();
                    });

                    target.onclick = function() {
                        const newContent = textarea.value.trim();
                        if (!newContent) return alert('Nội dung không được để trống');

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
                                p.classList.add('content-text');
                                p.textContent = data.comment.content;

                                textarea.replaceWith(p);
                                target.textContent = 'Sửa';
                                target.classList.remove('btn-save');
                                target.classList.add('btn-edit');
                                cancelBtn.remove();
                            } else {
                                alert('Cập nhật thất bại');
                            }
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