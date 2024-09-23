@extends('frontend.layouts.frontend')

@section('content')
    <style>
        .ai_image {
            position: relative;
        }

        .ai_content {
            position: absolute;
            top: 50%;
            left: 4%;
            transform: translate(4%, -50%);
            color: white;
            padding: 20px;
            border-radius: 20px;
        }

        .ai_content h4, .ai_content p {
            margin: 10px 0;
        }

        @media (max-width: 1199px) {
            .ai_image {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .ai_content {
                position: static;
                transform: none;
                background: rgba(255, 255, 255, 0.8); /* Optional: Background for better readability */
                color: black;
                margin-top: 20px;
            }

            .ai_content h4 {
                font-size: 24px; /* Smaller font size for smaller screens */
            }

            .ai_content p {
                color: black;
            }
        }

        .faq__wrap-two .accordion-item .accordion-button:not(.collapsed) {
            background-color: #000;
            color: #fff;
        }

        .faq__wrap-two .accordion-item .accordion-button:not(.collapsed)::after {
            color: #fff;
        }
    </style>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 ai_image">
                <img src="https://static-cse.canva.com/blob/1275370/feature_ai-photo-editor_hero_ENG2x.9c4b327f.jpg"
                     alt="" class="img-fluid" style="border-radius: 20px">
                <div class="col-12 col-md-12 col-lg-10 col-xl-5 ai_content">
                    <h4 style="font-weight: bold; font-size: 40px">Giúp bạn biến phức tạp thành đơn giản với Trợ Lý AI</h4>
                    <p style="color: #000">
                        Hãy để Trợ Lý AI của Neztwork lo liệu việc ghi chép và tóm tắt nội dung trong suốt buổi tư vấn của bạn, để bạn có thể tập trung hoàn toàn vào những gì quan trọng nhất. Với tính năng thông minh này, việc chuẩn bị cho những cuộc trò chuyện tiếp theo trở nên dễ dàng hơn bao giờ hết. Đặc biệt, tất cả thông tin và dữ liệu cá nhân đều được bảo mật tuyệt đối, đảm bảo bạn luôn giữ quyền kiểm soát thông tin của mình.
                    </p>
{{--                    <a href="#"--}}
{{--                       class="btn arrow-btn btn-four categories_button">Chỉnh sửa ảnh bằng AI--}}
{{--                    </a>--}}
                </div>
            </div>
        </div>

        {{--    //--}}
        <div class="row justify-content-center" style="margin-top: 100px">
            <div class="col-xl-6 col-lg-8">
                <div class="section__title text-center">
                    <p class="bold text-black" style="font-size: 30px">Nâng Cao Trải Nghiệm Tư Vấn Cùng Trợ Lý AI</p>
                </div>
            </div>
        </div>
        <div class="" style="margin-top: 50px">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10 ">
                    <div class="choose__img-three m-0">
                        <video
                            src="https://static-cse.canva.com/video/1032310/feature_ai-photo-editor_promo-showcase_01.mp4"
                            style="width: 100%; height: 100%; border-radius: 10px" controls></video>
                        {{--                        <img src="https://static-cse.canva.com/video/1032310/feature_ai-photo-editor_promo-showcase_01.mp4" alt="img" style="width: 100%; height: 400px; object-fit: cover; border-radius: 10px">--}}
                    </div>
                </div>
                <div class="col-lg-6 mt-2 mt-lg-0">
                    <div class="choose__content-three">
                        <div class="section__title mb-15 mt-1 text-center text-lg-start">
                            <h4 class="bold custom_line_2" style="font-size: 28px">Tóm Tắt Nội Dung Thông Minh</h4>
                        </div>
                        <p class="text-black mt-1 mb-1" style="font-size: 15px">Hãy để Trợ Lý AI của Neztwork lo liệu việc ghi chép cho bạn. Tính năng tóm tắt thông minh sẽ tự động ghi lại và hệ thống hóa các điểm chính từ cuộc trò chuyện, tạo ra bản ghi chú ngắn gọn và đầy đủ. Bạn không cần phải căng thẳng về việc ghi nhớ mọi chi tiết; Trợ Lý AI sẽ giúp bạn nắm bắt tất cả thông tin quan trọng và dễ dàng áp dụng những lời khuyên từ chuyên gia.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="" style="margin-top: 100px">
            <div class="row align-items-center justify-content-center">

                <div class="col-lg-6 mt-2 mt-lg-0">
                    <div class="choose__content-three">
                        <div class="section__title mb-15 mt-1 text-center text-lg-start">
                            <h4 class="bold custom_line_2" style="font-size: 28px">Tập Trung Vào Điều Quan Trọng</h4>
                        </div>
                        <p class="text-black mt-1 mb-1" style="font-size: 15px">Trải nghiệm sự tự do tối đa khi bạn không còn phải bận tâm về việc ghi chép. Trợ Lý AI giúp bạn hoàn toàn tập trung vào cuộc trò chuyện và tương tác sâu sắc với chuyên gia. Với Trợ Lý AI, bạn có thể yên tâm rằng mọi chi tiết quan trọng đều được ghi lại và không có thông tin nào bị bỏ lỡ, giúp bạn tận hưởng cuộc tư vấn một cách trọn vẹn nhất.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-10 ">
                    <div class="choose__img-three m-0">
                        <img
                            src="https://static-cse.canva.com/blob/1275364/feature_ai-photo-editor_promo-showcase_022x.bb02b8b9.jpg"
                            alt="img" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px">
                    </div>
                </div>
            </div>
        </div>
        <div class="" style="margin-top: 100px">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10 ">
                    <div class="choose__img-three m-0">
                        <video
                            src="https://static-cse.canva.com/video/1032313/feature_ai-photo-editor_promo-showcase_03.mp4"
                            style="width: 100%; height: 100%; border-radius: 10px" controls></video>
                    </div>
                </div>
                <div class="col-lg-6 mt-2 mt-lg-0">
                    <div class="choose__content-three">
                        <div class="section__title mb-15 mt-1 text-center text-lg-start">
                            <h4 class="bold custom_line_2" style="font-size: 28px">Ghi Chú và Chia Sẻ Ngay Lập Tức</h4>
                        </div>
                        <p class="text-black mt-1 mb-1" style="font-size: 15px">Ngừng lo lắng về việc tổ chức và chia sẻ thông tin sau buổi tư vấn. Trợ Lý AI sẽ ngay lập tức gửi bản ghi chú chi tiết đến bạn ngay sau khi cuộc trò chuyện kết thúc. Bạn có thể dễ dàng xem lại, chia sẻ với đồng đội, hoặc sử dụng để chuẩn bị cho các cuộc họp tiếp theo. Tất cả đều được thực hiện nhanh chóng và hiệu quả, giúp bạn tiết kiệm thời gian và công sức.</p>
                    </div>
                </div>

            </div>
        </div>


        <div class="" style="margin-top: 100px">
            <div class="row align-items-center justify-content-center">

                <div class="col-lg-6 mt-2 mt-lg-0">
                    <div class="choose__content-three">
                        <div class="section__title mb-15 mt-1 text-center text-lg-start">
                            <h4 class="bold custom_line_2" style="font-size: 28px">Bảo Mật Tuyệt Đối</h4>
                        </div>
                        <p class="text-black mt-1 mb-1" style="font-size: 15px">Chúng tôi hiểu rằng bảo mật thông tin cá nhân là ưu tiên hàng đầu. Trợ Lý AI của Neztwork sử dụng công nghệ bảo mật cao cấp để đảm bảo rằng mọi dữ liệu và thông tin cá nhân của bạn luôn được giữ an toàn và bảo mật. Bạn hoàn toàn có thể yên tâm về sự riêng tư của mình, trong khi Trợ Lý AI giúp bạn tối ưu hóa hiệu quả công việc và trải nghiệm tư vấn.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-10 ">
                    <div class="choose__img-three m-0">
                        <img
                            src="https://static-cse.canva.com/blob/1275368/feature_ai-photo-editor_promo-showcase_052xupdated.5e999437.jpg"
                            alt="img" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-light" style="margin-top: 100px">
        <div class="container" style="padding: 100px">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10 ">
                    <div class="choose__img-three m-0">
                        <img
                            src="https://static-cse.canva.com/blob/1275362/feature_photo_animation_how-to2x.d5ef8820.jpg"
                            alt="img" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px">
                    </div>
                </div>
                <div class="col-lg-6 mt-2 mt-lg-0">
                    <div class="choose__content-three">
                        <div class="section__title mb-15 mt-1 text-center text-lg-start">
                            <h4 class="bold custom_line_2" style="font-size: 28px">Làm Thế Nào Để Sử Dụng Trợ Lý AI của Neztwork? </h4>
                        </div>
                        <div class="my-4">
                            <p class="d-inline-flex gap-1 m-0">
                                <a class="collapse-toggle" data-bs-toggle="collapse" href="#collapseExample1"
                                   role="button" aria-expanded="false" aria-controls="collapseExample1"
                                   style="font-size: 20px; color: #000">
                                     1.	Bắt đầu buổi tư vấn của bạn
                                </a>
                            </p>
                            <div class="collapse" id="collapseExample1">
                                <div class="p-2">
                                    Chọn chuyên gia và bắt đầu tư vấn trực tuyến. Trợ Lý AI sẽ tự động ghi chú từ lúc này.
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <p class="d-inline-flex gap-1 m-0">
                                <a class="collapse-toggle" data-bs-toggle="collapse" href="#collapseExample2"
                                   role="button" aria-expanded="false" aria-controls="collapseExample2"
                                   style="font-size: 20px; color: #000">
                                    2.	Tập trung vào cuộc trò chuyện
                                </a>
                            </p>
                            <div class="collapse" id="collapseExample2">
                                <div class="p-2">
                                    Lo lắng về ghi chép? Để Trợ Lý AI làm việc đó, còn bạn tập trung vào trao đổi với chuyên gia.
                                </div>
                            </div>
                        </div>

                        <div class="my-4">
                            <p class="d-inline-flex gap-1 m-0">
                                <a class="collapse-toggle" data-bs-toggle="collapse" href="#collapseExample3"
                                   role="button" aria-expanded="false" aria-controls="collapseExample3"
                                   style="font-size: 20px; color: #000">
                                    3.	Nhận bản tóm tắt sau khi kết thúc
                                </a>
                            </p>
                            <div class="collapse" id="collapseExample3">
                                <div class="p-2">
                                    Khi tư vấn kết thúc, Trợ Lý AI gửi ngay bản tóm tắt chi tiết để bạn xem lại và chuẩn bị cho các bước tiếp theo.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    {{--    //--}}

    <div class="container">
        <div class="" style="margin-top: 100px">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-lg-4">
                    <div class="choose__img-three m-0 text-center text-lg-start">
                        <h4 class="bold custom_line_2" style="font-size: 28px">Câu hỏi thường gặp</h4>
                    </div>
                </div>
                <div class="col-12 col-lg-8 mt-2 mt-lg-0">
                    <div class="faq__wrap faq__wrap-two">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne">
                                        Trợ Lý AI của Neztwork hoạt động như thế nào?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse"
                                     data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        <p>Trợ Lý AI của Neztwork sử dụng công nghệ trí tuệ nhân tạo tiên tiến để lắng nghe và ghi lại các nội dung quan trọng trong suốt buổi tư vấn. Sau đó, nó sẽ tự động tóm tắt và tạo ra bản ghi chú chi tiết, giúp bạn tiết kiệm thời gian và nâng cao hiệu quả công việc.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                        Tôi có thể điều chỉnh Trợ Lý AI theo nhu cầu của mình không?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                     data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        <p>Có, bạn có thể tùy chỉnh Trợ Lý AI để tập trung vào những nội dung cụ thể mà bạn quan tâm. Bạn cũng có thể yêu cầu tóm tắt các phần khác nhau của cuộc trò chuyện theo cách mà bạn mong muốn.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                        Thông tin của tôi có an toàn không?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                     data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        <p>Tất cả các dữ liệu và thông tin được Trợ Lý AI xử lý đều được bảo mật ở mức độ cao nhất. Chúng tôi cam kết bảo vệ quyền riêng tư và dữ liệu cá nhân của bạn, đồng thời bạn luôn có quyền kiểm soát hoàn toàn các thông tin này.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="bg-light py-5" style="margin-top: 100px;">
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="section__title text-center">
                            <p class="bold text-black" style="font-size: 30px">Dành Cho Tất Cả Các Lĩnh Vực</p>
                            <p class="bold text-black" style="font-size: 20px">
                                Trợ Lý AI của Neztwork là công cụ lý tưởng cho mọi lĩnh vực, từ kinh doanh, giáo dục, đến tư vấn cá nhân. Hãy trải nghiệm sự hỗ trợ thông minh và tiện lợi từ AI, và thấy rõ sự khác biệt trong công việc hàng ngày của bạn.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="" style="margin-top: 100px">
                    <div class="text-center ">
                        <img src="https://static-cse.canva.com/_next/static/media/quotation_mark.file.9ed02a95.svg"
                             alt="" style="width: 20px; height: 20px; object-fit: contain">
                    </div>
            <div class="ai_slider">
                        <div class="col-6 row text-center justify-content-center pt-3 py-5">
                            <p style="font-size: 20px; color: #000">“Trợ Lý AI của Neztwork thực sự là một cứu tinh trong các cuộc họp của tôi. Tính năng tóm tắt nội dung thông minh giúp tôi không bỏ sót bất kỳ điểm quan trọng nào. Bản ghi chú chi tiết mà tôi nhận được ngay sau buổi tư vấn đã giúp tôi tổ chức công việc hiệu quả hơn và chuẩn bị cho các bước tiếp theo một cách dễ dàng. Tôi hoàn toàn yên tâm về bảo mật thông tin cá nhân, đây là điểm cộng lớn!”</p>
                            <p>Nguyễn Thị Lan - Giám đốc Dự án</p>
                        </div>
                <div class="col-6 row text-center justify-content-center pt-3 py-5">
                    <p style="font-size: 20px; color: #000">“Việc có Trợ Lý AI trong các buổi tư vấn là một sự bổ sung tuyệt vời cho trải nghiệm của tôi. Tính năng này giúp tôi tập trung hoàn toàn vào việc tương tác với khách hàng mà không phải lo lắng về việc ghi chép. Tôi rất ấn tượng với khả năng ghi chú và chia sẻ tức thì của Trợ Lý AI, giúp tôi và khách hàng dễ dàng theo dõi và áp dụng các chiến lược thảo luận. Thực sự đáng giá!”</p>
                    <p>Lê Văn Hùng - Chuyên gia Tư vấn</p>
                </div>
                <div class="col-6 row text-center justify-content-center pt-3 py-5">
                    <p style="font-size: 20px; color: #000">“Trợ Lý AI của Neztwork đã làm cho việc tham gia các buổi tư vấn học tập trở nên đơn giản hơn rất nhiều. Tôi không cần phải lo lắng về việc ghi chép thông tin trong suốt buổi học nữa, vì Trợ Lý AI đã lo tất cả. Điều này giúp tôi tập trung vào việc hiểu bài học và thảo luận với giảng viên. Bảo mật dữ liệu cũng rất được đảm bảo, tôi cảm thấy hoàn toàn yên tâm.”</p>
                    <p>Mai Phương - Sinh viên Cao học</p>
                </div>
                <div class="col-6 row text-center justify-content-center pt-3 py-5">
                    <p style="font-size: 20px; color: #000">“Tính năng Trợ Lý AI của Neztwork đã làm thay đổi cách tôi làm việc. Việc tự động tóm tắt nội dung và gửi bản ghi chú ngay sau buổi tư vấn giúp tôi tiết kiệm rất nhiều thời gian. Tôi đặc biệt đánh giá cao khả năng tùy chỉnh theo nhu cầu cụ thể của từng cuộc trò chuyện. Đây là một công cụ tuyệt vời để tối ưu hóa hiệu suất làm việc và duy trì sự tổ chức trong các dự án của tôi.”</p>
                    <p> Đỗ Minh Tú - Quản lý Kinh doanh</p>
                </div>


            </div>
        </div>

        <hr style="height: 2px; background-color: #ccc">
{{--        <div class="text-center">--}}
{{--            <a href="#"--}}
{{--               class="btn arrow-btn btn-four categories_button">Chỉnh sửa ảnh bằng AI--}}
{{--            </a>--}}
{{--        </div>--}}
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const collapseToggles = document.querySelectorAll('.collapse-toggle');

            collapseToggles.forEach(toggle => {
                toggle.addEventListener('click', function (event) {
                    const targetId = this.getAttribute('href');
                    collapseToggles.forEach(otherToggle => {
                        const otherTargetId = otherToggle.getAttribute('href');
                        if (otherTargetId !== targetId) {
                            const otherCollapse = document.querySelector(otherTargetId);
                            if (otherCollapse.classList.contains('show')) {
                                new bootstrap.Collapse(otherCollapse, {
                                    toggle: true
                                });
                            }
                        }
                    });
                });
            });
        });

    </script>
@endsection
