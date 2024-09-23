@extends('frontend.layouts.frontend')

@section('content')
    <style>
        .policies {
            display: block;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            text-align: center;
        }

        .policies:hover .image-container img {
            transform: scale(1.1);
            filter: brightness(50%);
        }

        .policies:hover .overlay-button {
            opacity: 1;
        }

        .policies:hover .title_trust {
            color: blue; /* Change text color to blue */
        }

        .image-container {
            position: relative;
            display: inline-block;
            overflow: hidden;
            border-radius: 20px;
        }

        .image-container img {
            border-radius: 20px;
            display: block;
            width: 100%;
            height: auto;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .overlay-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 10px;
            border-radius: 10px;
            background-color: rgba(238, 238, 238, 0.8);
            color: #000;
            text-decoration: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .font_weight_bold {
            font-weight: bold;
        }

        .m-0 {
            margin: 0;
        }

        .my-3 {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .text-center {
            text-align: center;
        }

        .text-lg-start {
            text-align: left;
        }

        .custom_line_2 {
            line-height: 1.5;
        }
    </style>
    <section class="banner-area banner-bg-six tg-motion-effects p-5" style="background-color: #f7faf9">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 col-md-9 col-sm-10 order-0 order-lg-2">
                    <div class="banner__images-six">
                        <div class="main-img tg-svg">
                            <img
                                src="https://images.unsplash.com/photo-1527689368864-3a821dbccc34?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                alt="img">
                        </div>

                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="banner__content-six">
                        <h2 class="title ">Niềm Tin
                        </h2>
                        <p class="">Chúng tôi cam kết xây dựng nền tảng đáng tin cậyi, đặt sự tin tưởng của bạn là trọng tâm trong mọi hoạt động. Các sản phẩm, chính sách, quy trình và hệ thống của chúng tôi đều được thiết kế để bảo vệ bạn, quyền lợi và dữ liệu của bạn, mang đến không gian an toàn để bạn sáng tạo và chia sẻ những kiến thức và kinh nghiệm của mình.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="custom_session">
        <div class="container">
            <h2 class="text-center text-lg-start">Chính Sách Bảo Mật</h2>
            <div class="row">

                <a href="#" class="policies col-12 col-lg-4 col-md-6 my-3 text-center text-lg-start">

                    <div class="image-container">
                        <img src="https://static-cse.canva.com/blob/1158597/security.e9ac5481.avif" alt="">
                        {{--                        <span class="overlay-button">See more</span>--}}
                    </div>
                    {{--                    <p class="font_weight_bold title_trust m-0 ">Security</p>--}}
                    <p class="custom_line_2">Tìm hiểu cách chúng tôi lưu trữ dữ liệu và bảo đảm an toàn cho Neztwork.</p>
                </a>
                <a href="#" class="policies col-12 col-lg-4 col-md-6 my-3 text-center text-lg-start">

                    <div class="image-container">
                        <img src="https://static-cse.canva.com/blob/1158593/privacy.4e82a065.avif" alt="">
{{--                        <span class="overlay-button">See more</span>--}}
                    </div>
{{--                    <p class="font_weight_bold title_trust m-0 ">Security</p>--}}
                    <p class="custom_line_2">Cách Neztwork bảo vệ quyền riêng tư và tuân thủ luật pháp toàn cầu.</p>
                </a>
                <a href="#" class="policies col-12 col-lg-4 col-md-6 my-3 text-center text-lg-start">

                    <div class="image-container">
                        <img
                            src="https://static-cse.canva.com/blob/1355745/trustsafetycenter_home_illustration_safety.63ad1c55.avif"
                            alt="">
{{--                        <span class="overlay-button">See more</span>--}}
                    </div>
{{--                    <p class="font_weight_bold title_trust m-0 ">Security</p>--}}
                    <p class="custom_line_2">Các biện pháp giúp giữ an toàn cho người dùng của chúng tôi.</p>
                </a>
                <a href="#" class="policies col-12 col-lg-4 col-md-6 my-3 text-center text-lg-start">
                        <div class="image-container">
                            <img src="https://static-cse.canva.com/blob/1158595/legal.c6252bb6.avif" alt="">
{{--                            <span class="overlay-button">See more</span>--}}
                        </div>
{{--                        <p class="font_weight_bold title_trust m-0">Security</p>--}}
                        <p class="custom_line_2">Điều khoản pháp lý và chính sách của Neztwork.</p>
                </a>
                <a href="#" class="policies col-12 col-lg-4 col-md-6 my-3 text-center text-lg-start">

                    <div class="image-container">
                        <img src="https://static-cse.canva.com/blob/1158596/compliance.a87111dc.avif" alt="">
{{--                        <span class="overlay-button">See more</span>--}}
                    </div>
{{--                    <p class="font_weight_bold title_trust m-0">Security</p>--}}
                    <p class="custom_line_2">Thông tin về việc tuân thủ các quy định toàn cầu.</p>
                </a>
                <a href="#" class="policies col-12 col-lg-4 col-md-6 my-3 text-center text-lg-start">

                    <div class="image-container">
                        <img src="https://static-cse.canva.com/blob/1158592/procurement.cd8d8cee.avif" alt="">
{{--                        <span class="overlay-button">See more</span>--}}
                    </div>
{{--                    <p class="font_weight_bold title_trust m-0">Security</p>--}}
                    <p class="custom_line_2">Cam kết bảo vệ dữ liệu Creator và khách hàng minh bạch, rõ ràng, và tuyệt đối. </p>
                </a>
{{--                <a href="#" class="policies col-12 col-lg-4 col-md-6 my-3 text-center text-lg-start">--}}

{{--                    <div class="image-container">--}}
{{--                        <img src="https://static-cse.canva.com/blob/1158598/education.a194f11c.avif" alt="">--}}
{{--                        <span class="overlay-button">See more</span>--}}
{{--                    </div>--}}
{{--                    <p class="font_weight_bold title_trust m-0">Security</p>--}}
{{--                    <p class="custom_line_2">We're dedicated to protecting student data and keeping Canva for Education--}}
{{--                        safe. Learn more here.</p>--}}
{{--                </a>--}}


            </div>
        </div>
    </section>
@endsection
