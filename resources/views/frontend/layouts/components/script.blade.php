<script src="{{ asset('/storage/frontendNew')}}/assets/js/vendor/jquery-3.6.0.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/bootstrap.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/imagesloaded.pkgd.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/jquery.magnific-popup.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/jquery.odometer.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/jquery.appear.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/tween-max.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/select2.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/swiper-bundle.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/jquery.marquee.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/tg-cursor.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/vivus.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/ajax-form.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/svg-inject.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/jquery.circleType.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/jquery.lettering.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/plyr.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/wow.min.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/aos.js"></script>
<script src="{{ asset('/storage/frontendNew')}}/assets/js/main.js"></script>
<script>
    SVGInject(document.querySelectorAll("img.injectable"));
</script>
<script
    type="module"
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
></script>
<script
    nomodule
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
></script>
<script
    type="text/javascript"
    src="https://code.jquery.com/jquery-1.11.0.min.js"
></script>
<script
    type="text/javascript"
    src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"
></script>
<script
    type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"
></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--// buff thông báo--}}
<script src="https://anocha.me/storage/frontend/js/socket.io.min.js" type="text/javascript"></script>
<script src="https://anocha.me/storage/backend/js/jquery.toast.js"></script>
<script src="{{ asset('/storage/backend')}}/assets/plugins/ckeditor/ckeditor.js?v=111"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    // Example: Hide loading screen when content is fully loaded
    window.addEventListener('load', function() {
        document.querySelector('.loading').style.display = 'none';
    });
</script>

<script>
    $(document).on('click','#userCancelBooking',function(e){
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Bạn có chắc muốn hủy không cuộc trò chuyện này không?',
            text: "Bạn có chắc",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Hủy!',
                    'Hủy thành công.',
                    'success'
                )
            }
        })


    });


    // todo : buff thông báo ( Tamk thời ẩn soccket đi )
    {{--$(document).ready(function () {--}}
    {{--    var socket = io.connect('wss://chat.thietke24h.vn', {transports: ["websocket"]});--}}
    {{--    socket.on("connect", function () {--}}
    {{--        console.log('Truy cập socket thành công.');--}}
    {{--    });--}}
    {{--    var api_key = 'BAO';--}}
    {{--    var user_id = `{{ \Illuminate\Support\Facades\Auth::guard('web')->id() }}`; // expert--}}
    {{--    var noti = '{{ route("frontend.user.bookingHistory") }}';--}}
    {{--    var user_fullname = `{{ \Illuminate\Support\Facades\Auth::guard('web')->user()->fullname ?? ''}}`; // expert--}}
    {{--    $("#hireBtn").click(function () {--}}
    {{--        var expert_id = $('#user_expert_id').val(); // Lấy giá trị user_expert_id từ input ẩn--}}
    {{--        var message_order = `Bạn có 1 đặt lịch mới từ <span style="color: #00aefd">${user_fullname}</span>, vui lòng kiểm tra <a href="${noti}">tại đây</a>`; // Nối route vào thông báo--}}
    {{--        var message_note = `Bạn có 1 đặt lịch mới từ ${user_fullname}`;--}}
    {{--        // Gửi thông báo qua socket--}}
    {{--        socket.emit("send_order", {--}}
    {{--            api_key: api_key,--}}
    {{--            type: 1,--}}
    {{--            status_order: 1,--}}
    {{--            expert_id: expert_id,--}}
    {{--            userId: '',--}}
    {{--            message_order: message_order--}}
    {{--        });--}}
    {{--        // Gửi yêu cầu AJAX để lưu thông báo--}}
    {{--        $.ajax({--}}
    {{--            url: '{{ route('frontend.ajax.notiExpert') }}',--}}
    {{--            type: 'POST',--}}
    {{--            data: {--}}
    {{--                user_id: user_id,--}}
    {{--                expert_id: expert_id,--}}
    {{--                note: message_note,--}}
    {{--                _token: '{{ csrf_token() }}'--}}
    {{--            },--}}
    {{--            success: function (response) {--}}
    {{--                // Chuyển đến trang thanh toán sau khi thông báo ẩn--}}
    {{--                //window.location.href = "{{ route('payment.create') }}";--}}
    {{--            },--}}
    {{--            error: function (xhr, status, error) {--}}
    {{--                // Xử lý lỗi nếu có--}}
    {{--                console.log(error);--}}
    {{--            }--}}
    {{--        });--}}
    {{--    });--}}

    {{--    socket.on("accept_order", function (data) {--}}
    {{--        if (data.api_key == api_key && data.status_order == 1 && data.expert_id == user_id) {--}}
    {{--            $.toast({--}}
    {{--                heading: 'Thông báo',--}}
    {{--                text: data.message_order,--}}
    {{--                showHideTransition: 'slide',--}}
    {{--                icon: 'success',--}}
    {{--                position: 'top-right',--}}
    {{--                hideAfter: false--}}
    {{--            });--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}

    // todo : end


    // like post expert
    document.addEventListener('DOMContentLoaded', (event) => {
        const likeForms = document.querySelectorAll('.like-form');

        likeForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the form from submitting immediately
                const button = this.querySelector('.like-button');
                const isLiked = button.classList.contains('liked');

                // Toggle the liked state
                button.classList.toggle('liked');

                // Animate the button
                if (isLiked) {
                    button.innerHTML = '<i class="fas fa-thumbs-up"></i> Like';
                } else {
                    button.innerHTML = '<i class="fas fa-thumbs-up"></i> Unlike';
                }

                // Submit the form after the animation
                setTimeout(() => {
                    this.submit();
                }, 300);
            });
        });
    });

    // todo : end


    //





    $('#subscribe-form').submit(function (e) {
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: '/ajax/subscribe-email.html',
            data: form.serialize(),
            dataType: 'json',
            success: function (data) {
                $.toast({
                    heading: 'Gửi thành công',
                    text: data.message,
                    showHideTransition: 'slide',
                    icon: 'success',
                    position: 'top-right',
                    hideAfter: 10000 // milliseconds
                })

                if (data.status)
                    $('#subscribe-form .email').val('');
            }
        });
        e.preventDefault();
    });
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('subscribe-form');
        const emailInput = document.getElementById('email-input');

        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Ngăn chặn form submit mặc định

            // Thực hiện các xử lý AJAX hoặc gửi form

            // Sau khi xử lý thành công, reset giá trị của input
            emailInput.value = ''; // Đặt giá trị của input về rỗng
        });
    });
    $(document).ready(function () {
        $(".banner").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: true,
            autoplaySpeed: 1000,
            fade: true,
            cssEase: 'linear',
            responsive: [
                {
                    breakpoint: 1079,
                    settings: {
                        arrows: false,
                        infinite: true,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });

        $(".categories_slider").slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: true,
            autoplaySpeed: 500,
            // speed: 2000,
            // cssEase: 'linear',
            responsive: [
                // {
                //     breakpoint: 1367,
                //     settings: {
                //         slidesToShow: 4,
                //     },
                // },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                    },
                },
                {
                    breakpoint: 1000,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });
        $(".categories_slider_product").slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: false,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                    },
                },
                {
                    breakpoint: 1000,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });
        $(".top_expert_slider").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: true,
            responsive: [
                // {
                //     breakpoint: 1367,
                //     settings: {
                //         slidesToShow: 4,
                //     },
                // },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                    },
                },

                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });
        $(".blog_slider").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: true,
            responsive: [
                // {
                //     breakpoint: 1367,
                //     settings: {
                //         slidesToShow: 4,
                //     },
                // },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                    },
                },

                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });
        $(".aboutNew_slider_feedback").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: true,
            autoplaySpeed: 1000,
            fade: true,
            cssEase: 'linear',
            responsive: [

            ],
        });
        // Khởi tạo Slick Slider cho slider đầu tiên
        $(".brand_slider").slick({
            slidesToShow: 7,
            slidesToScroll: 1,
            infinite: true,
            arrows: false,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: true,
            autoplaySpeed: 0,
            speed: 3000,
            cssEase: 'linear',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 5,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        arrows: false,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });

// Khởi tạo Slick Slider cho slider thứ hai với các tùy chọn đảo ngược
        $(".brand_slider_two").slick({
            slidesToShow: 7,
            slidesToScroll: 1,
            infinite: true,
            arrows: false,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: true,
            autoplaySpeed: 0, // Thời gian giữa các lần autoplay (0 để không có khoảng dừng)
            speed: 2000, // Tốc độ chạy slider (càng nhỏ càng nhanh)
            cssEase: 'linear', // Tăng độ mượt
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 5,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        arrows: false,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });



        $(".aboutNews_slider").slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: true,
            autoplaySpeed: 2000,
            // speed: 2000,
            // cssEase: 'linear',

            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                    },
                },

                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });
        $(".review").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: true,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [

                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });
        $(".ai_slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            arrows: false,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: true,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [

                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });


        $(".video_youtube_slider").slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: true,
            autoplaySpeed: 500,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                    },
                },

                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });

        $(".video_youtubeShort_slider").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: true,
            autoplaySpeed: 500,
            responsive: [
                // {
                //     breakpoint: 1367,
                //     settings: {
                //         slidesToShow: 4,
                //     },
                // },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                    },
                },

                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });

        $(".video_tiktok_slider").slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            draggable: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon class="icon_slider" name="arrow-back-outline"></ion-icon></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon class="icon_slider" name="arrow-forward-outline"></ion-icon></button>`,
            dots: false,
            autoplay: true,
            autoplaySpeed: 500,
            responsive: [
                // {
                //     breakpoint: 1367,
                //     settings: {
                //         slidesToShow: 4,
                //     },
                // },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                    },
                },

                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                        dots: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                        dots: false,
                    },
                },
            ],
        });


    });


    // select 2
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
        $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
    // datepicker
    jQuery(function ($) {
        $.datepicker.regional["vi-VN"] = {
            closeText: "Đóng",
            prevText: "Trước",
            nextText: "Sau",
            currentText: "Hôm nay",
            monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
            monthNamesShort: ["Một", "Hai", "Ba", "Bốn", "Năm", "Sáu", "Bảy", "Tám", "Chín", "Mười", "Mười một", "Mười hai"],
            dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
            dayNamesShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
            dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            weekHeader: "Tuần",
            dateFormat: "yy/mm/dd",
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ""
        };
        $.datepicker.setDefaults($.datepicker.regional["vi-VN"]);
    });




    // password eye
    function togglePasswordVisibilityAccount() {
        const passwordInputAccount = document.getElementById("passwordAccount");
        const eyeIconAccount = document.getElementById("eyeIconAccount");

        if (passwordInputAccount.type === "password") {
            passwordInputAccount.type = "text";
            eyeIconAccount.classList.remove("fa-eye");
            eyeIconAccount.classList.add("fa-eye-slash");
        } else {
            passwordInputAccount.type = "password";
            eyeIconAccount.classList.remove("fa-eye-slash");
            eyeIconAccount.classList.add("fa-eye");
        }
    }

    function toggleEyeIconVisibilityAccount() {
        const passwordInputAccount = document.getElementById("passwordAccount");
        const eyeIconContainerAccount = document.getElementById("eyeIconContainerAccount");

        // Hiển thị icon con mắt chỉ khi có nội dung trong trường nhập liệu
        if (passwordInputAccount.value.length > 0) {
            eyeIconContainerAccount.style.display = "inline";
        } else {
            eyeIconContainerAccount.style.display = "none";
        }
    }

    // Gọi hàm toggleEyeIconVisibilityAccount khi input mất focus để đảm bảo kiểm tra lại nội dung
    document.getElementById("passwordAccount").addEventListener("blur", function() {
        toggleEyeIconVisibilityAccount();
    });





    function togglePasswordVisibility(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }

    function toggleEyeIconVisibility(inputId, containerId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIconContainer = document.getElementById(containerId);

        // Hiển thị icon con mắt chỉ khi có nội dung trong trường nhập liệu
        if (passwordInput.value.length > 0) {
            eyeIconContainer.style.display = "inline";
        } else {
            eyeIconContainer.style.display = "none";
        }
    }

    // Đảm bảo kiểm tra lại nội dung khi mất focus cho mỗi trường nhập liệu
    document.getElementById("password_old").addEventListener("blur", function() {
        toggleEyeIconVisibility('password_old', 'eyeIconContainer_old');
    });

    document.getElementById("password").addEventListener("blur", function() {
        toggleEyeIconVisibility('password', 'eyeIconContainer');
    });

    document.getElementById("password_confirmation").addEventListener("blur", function() {
        toggleEyeIconVisibility('password_confirmation', 'eyeIconContainer_confirmation');
    });


    //


</script>
