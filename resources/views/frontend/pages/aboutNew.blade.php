@extends('frontend.layouts.frontend')

@section('content')

    <style>
        .testimonial__item:before {
            display: none !important;
        }

        .testimonial__nav button.testimonial-button-prev {
            left: 0%;
        }

        .testimonial__nav button {
            right: 0%;
        }

        .image-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .commitments_btn_text {
            color: #000;
        }

        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 20px;
        }

        .commitments_one_content {
            position: absolute;
            top: 30%; /* Canh giữa theo chiều dọc */
            left: 10%; /* Canh giữa theo chiều ngang */
            color: #fff;
            width: 40%;
        }

        .commitments_one_content p,
        .commitments_one_content h3 {
            margin: 0;
            padding: 5px 0;
            color: #fff;
        }

        .commitments_btn {
            padding: 10px;
            border-radius: 10px;
            background-color: #eee;
            color: #000;
            margin-top: 10px;
            display: inline-block;
            text-decoration: none;
        }

        .commitments_two_content {
            position: absolute;
            top: 40%; /* Canh giữa theo chiều dọc */
            left: 50%; /* Canh giữa theo chiều ngang */
            color: #fff;
            width: 50%;
            text-align: center;
            transform: translate(-50%, -50%);
        }

        .commitments_two_content p,
        .commitments_two_content h3 {
            margin: 0;
            padding: 5px 0;
            color: #fff;
        }


        /*//*/
        .newsroom_wrap {
            display: block;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            text-align: center;
        }

        .newsroom_wrap:hover .image-container .image {
            transform: scale(1.1);
            filter: brightness(50%);
        }

        .newsroom_wrap:hover .overlay-button {
            opacity: 1;
        }

        .newsroom_wrap:hover .title_trust {
            color: blue; /* Change text color to blue */
        }

        .image-container {
            position: relative;
            display: inline-block;
            overflow: hidden;
            border-radius: 20px;
        }

        .image-container .image {
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
        /*//*/

        /*//*/

        @media (max-width: 1023px) {
            .image-container {
                display: block;
            }

            .commitments_one_content {
                position: static;
                transform: none;
                padding: 20px;
                text-align: center;
                color: #000;
                width: 100%;

            }

            .commitments_one_content p,
            .commitments_one_content h3 {
                margin: 0;
                padding: 5px 0;
                color: #000;
            }

            .commitments_btn {
                padding: 10px;
                border-radius: 10px;
                background-color: #fff;
                color: #000;
                margin-top: 10px;
                display: inline-block;
                text-decoration: none;
                width: 100%;
                border: 1px solid #eee;
            }

            .commitments_btn:hover {
                background-color: #eee;
                transition: all 0.2s linear;
            }


            .commitments_two_content {
                position: static;
                transform: none;
                padding: 20px;
                text-align: center;
                color: #000;
                width: 100%;

            }

            .commitments_two_content p,
            .commitments_two_content h3 {
                margin: 0;
                padding: 5px 0;
                color: #000;
            }
        }
        @media (max-width: 767px) {
            .image-gap {
                margin-top: 100px;
            }
        }
    </style>

    <section class="p-5"
             style="background: linear-gradient(to right bottom, #eee, #fff)">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-12">
                    <img class="ms-5 p-3 img-fluid"
                         src="{{asset('storage/frontendNew')}}/assets/img/about/1.png" alt="Image 1"
                         style="width: 100%; height: 250px; object-fit: contain">
                    <img class="p-3 img-fluid" src="{{asset('storage/frontendNew')}}/assets/img/about/2.png"
                         alt="Image 2" style="width: 100%; height: 150px; object-fit: contain">
                    <img class="p-3 img-fluid" src="{{asset('storage/frontendNew')}}/assets/img/about/3.png"
                         alt="Image 3">
                </div>
                <div class="col-lg-4 col-12 text-center d-flex align-items-center">
                    <h2 style="font-size: 50px;">Kết nối Creators <span class="title_rgba" style=""> hiện thực hóa ước mơ</span></h2>
                </div>
                <div class="col-lg-4 col-12">
                    <img class="p-3 img-fluid" src="{{asset('storage/frontendNew')}}/assets/img/about/4.png"
                         alt="Image 1">
                    <img class="p-3 img-fluid" src="{{asset('storage/frontendNew')}}/assets/img/about/5.png"
                         alt="Image 2" style="width: 100%; height: 150px; object-fit: contain">
                    <img class="p-3 img-fluid"
                         src="{{asset('storage/frontendNew')}}/assets/img/about/6.png" alt="Image 3"
                         style="width: 100%; height: 200px; object-fit: contain">
                </div>
            </div>
        </div>
    </section>
{{--    <div class="brand-area-three">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-2 col-md-12 d-flex justify-content-start align-items-center">--}}
{{--                    <span class="text-black font_weight_bold">TRUSTED BY</span>--}}
{{--                </div>--}}
{{--                <div class="col-lg-2 col-md-4 text-center text-lg-start">--}}
{{--                    <img src="https://static-cse.canva.com/blob/1492173/image.png" alt=""--}}
{{--                         style="width: 100px; height: 100px; object-fit: contain">--}}
{{--                </div>--}}
{{--                <div class="col-lg-2 col-md-4 text-center text-lg-start">--}}
{{--                    <img src="https://static-cse.canva.com/blob/1492169/bloomingdales.png" alt=""--}}
{{--                         style="width: 100px; height: 100px; object-fit: contain">--}}
{{--                </div>--}}
{{--                <div class="col-lg-2 col-md-4 text-center text-lg-start">--}}
{{--                    <img src="https://static-cse.canva.com/blob/1492151/danone.png" alt=""--}}
{{--                         style="width: 100px; height: 100px; object-fit: contain">--}}
{{--                </div>--}}
{{--                <div class="col-lg-2 col-md-4 text-center text-lg-start">--}}
{{--                    <img src="https://static-cse.canva.com/blob/1492166/sony.png" alt=""--}}
{{--                         style="width: 100px; height: 100px; object-fit: contain">--}}
{{--                </div>--}}
{{--                <div class="col-lg-2 col-md-4 text-center text-lg-start">--}}
{{--                    <img src="https://static-cse.canva.com/blob/1492177/salesforce.png" alt=""--}}
{{--                         style="width: 100px; height: 100px; object-fit: contain">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <section class="features__area-five features__bg p-5" style="background-color: #000; margin: 50px 0px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section__title text-center white-title mb-60">
                        <p class="text-white" style="font-size: 20px">
                            Chào mừng đến với Neztwork, nơi chúng tôi không chỉ dừng lại ở việc cung cấp những cuộc gọi video chia sẻ, tư vấn chuyên nghiệp. Sứ mệnh của chúng tôi là kết nối con người, tôn vinh giá trị của mỗi cuộc giao tiếp, chia sẻ; phá vỡ những rào cản thường gặp (như địa điểm, thời gian, giá cả không minh bạch, và sự chênh lệch về địa vị xã hội). Tại Neztwork, chúng tôi tin rằng những kết nối chân thành sẽ tiếp sức và nâng cao hành trình của mỗi người, giúp họ tiến xa hơn trên con đường phát triển.</p>
                    </div>
                </div>
            </div>
{{--            <div class="row justify-content-center">--}}
{{--                <div class="col-xl-10">--}}
{{--                    <div class="row justify-content-center">--}}
{{--                        <div class="col-lg-3 col-md-6">--}}
{{--                            <div class="features__item-four">--}}
{{--                                <div class="features__content-four">--}}
{{--                                    <h3 class="title m-0" style="font-size: 30px">130M+</h3>--}}
{{--                                    <p>MAUs</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-3 col-md-6">--}}
{{--                            <div class="features__item-four">--}}
{{--                                <div class="features__content-four">--}}
{{--                                    <h3 class="title m-0" style="font-size: 30px">15B+</h3>--}}
{{--                                    <p>Designs created</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-3 col-md-6">--}}
{{--                            <div class="features__item-four">--}}
{{--                                <div class="features__content-four">--}}
{{--                                    <h3 class="title m-0" style="font-size: 30px">190</h3>--}}
{{--                                    <p>Countries</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-3 col-md-6">--}}
{{--                            <div class="features__item-four">--}}
{{--                                <div class="features__content-four">--}}
{{--                                    <h3 class="title m-0" style="font-size: 30px">100+</h3>--}}
{{--                                    <p>Languages</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </section>
    <section class="features__area-three" style="margin: 100px 0px; background-color: #fff">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-8">
                    <div class="section__title text-center mb-40">
                        <h2 class="title">Giá Trị Cốt Lõi Của Chúng Tôi</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="testimonial__item-wrap">
                        <div
                            class="swiper-container testimonial-swiper-active swiper-initialized swiper-horizontal swiper-backface-hidden">
                            <div class="swiper-wrapper" id="swiper-wrapper-32a39510f8c821e4b" aria-live="polite"
                                 style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px); transition-delay: 0ms;">
                                <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 6"
                                     data-swiper-slide-index="0" style="width: 450px; margin-right: 30px;">
                                    <div
                                        class="testimonial__item d-flex align-items-center justify-content-center flex-column"
                                        style="width: 100%; height: 450px">
                                        <div class="testimonial__item-top">
                                            <div class="testimonial__author">
                                                <div class="">
                                                    <img
                                                        src="https://static-cse.canva.com/blob/1492175/1-forceforgood.93f52abb.avif"
                                                        alt="img"
                                                        style="width: 100%; height: 250px; object-fit: contain">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="testimonial__author-content">
                                            <h2 class="title">Đơn Giản và Hiệu Quả
                                            </h2>
                                        </div>
                                        <div class="testimonial__content text-center">
                                            <p>Chúng tôi luôn ưu tiên các giải pháp đơn giản, thực tế và hiệu quả, giúp người dùng dễ dàng kết nối với các Creators và nhận được sự hỗ trợ cần thiết.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide swiper-slide-next" role="group" aria-label="2 / 6"
                                     data-swiper-slide-index="1" style="width: 450px; margin-right: 30px;">
                                    <div
                                        class="testimonial__item d-flex align-items-center justify-content-center flex-column"
                                        style="width: 100%; height: 450px">
                                        <div class="testimonial__item-top">
                                            <div class="testimonial__author">
                                                <div class="">
                                                    <img
                                                        src="https://static-cse.canva.com/blob/1492174/2-goodhuman.c9eb7f06.avif"
                                                        alt="img"
                                                        style="width: 100%; height: 250px; object-fit: contain">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="testimonial__author-content">
                                            <h2 class="title">Cam Kết Chất Lượng</h2>
                                        </div>
                                        <div class="testimonial__content text-center">
                                            <p>Chúng tôi đặt ra những tiêu chuẩn cao nhất và không ngừng nỗ lực để đạt được sự xuất sắc trong mọi việc mình làm. Cam kết về chất lượng của chúng tôi được thể hiện rõ qua nền tảng và các tương tác với cộng đồng.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide" role="group" aria-label="3 / 6" data-swiper-slide-index="2"
                                     style="width: 450px; margin-right: 30px;">
                                    <div
                                        class="testimonial__item d-flex align-items-center justify-content-center flex-column"
                                        style="width: 100%; height: 450px">
                                        <div class="testimonial__item-top">
                                            <div class="testimonial__author">
                                                <div class="">
                                                    <img
                                                        src="https://static-cse.canva.com/blob/1492162/3-empowerothers.0280916a.avif"
                                                        alt="img"
                                                        style="width: 100%; height: 250px; object-fit: contain">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="testimonial__author-content">
                                            <h2 class="title">Mục Tiêu Tham Vọng và Truyền Cảm Hứng</h2>
                                        </div>
                                        <div class="testimonial__content text-center">
                                            <p>Chúng tôi đặt ra những mục tiêu tham vọng và làm việc không ngừng để đạt được chúng. Chúng tôi tin vào sức mạnh của ước mơ và luôn sẵn sàng giúp người dùng hiện thực hóa ước mơ của họ.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide" role="group" aria-label="4 / 6" data-swiper-slide-index="3"
                                     style="width: 450px; margin-right: 30px;">
                                    <div
                                        class="testimonial__item d-flex align-items-center justify-content-center flex-column"
                                        style="width: 100%; height: 450px">
                                        <div class="testimonial__item-top">
                                            <div class="testimonial__author">
                                                <div class="">
                                                    <img
                                                        src="https://static-cse.canva.com/blob/1492157/4-complexthingssimple.7ae0a02d.avif"
                                                        alt="img"
                                                        style="width: 100%; height: 250px; object-fit: contain">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="testimonial__author-content">
                                            <h2 class="title">Tôn Vinh Kết Nối Con Người</h2>
                                        </div>
                                        <div class="testimonial__content text-center">
                                            <p>Chúng tôi tin vào giá trị kỳ diệu của sự tương tác giữa con người và tác động sâu sắc mà chúng mang lại cho cuộc sống. Chúng tôi nỗ lực tạo ra một nền tảng nuôi dưỡng những kết nối chân thật, trân trọng nét đẹp riêng của mỗi cá nhân.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide" role="group" aria-label="5 / 6" data-swiper-slide-index="4"
                                     style="width: 450px; margin-right: 30px;">
                                    <div
                                        class="testimonial__item d-flex align-items-center justify-content-center flex-column"
                                        style="width: 100%; height: 450px">
                                        <div class="testimonial__item-top">
                                            <div class="testimonial__author">
                                                <div class="">
                                                    <img
                                                        src="https://static-cse.canva.com/blob/1492176/5-pursueexcellence.b89f1e6a.avif"
                                                        alt="img"
                                                        style="width: 100%; height: 250px; object-fit: contain">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="testimonial__author-content">
                                            <h2 class="title">
                                                Đón Nhận Sự Chân Thật
                                            </h2>
                                        </div>
                                        <div class="testimonial__content text-center">
                                            <p>
                                                Chúng tôi tôn vinh sự chân thật dưới mọi hình thức. Chúng tôi khuyến khích người dùng luôn là chính mình, tôn trọng cả điểm mạnh lẫn thử thách trên hành trình của họ.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide" role="group" aria-label="6 / 6" data-swiper-slide-index="5"
                                     style="width: 450px; margin-right: 30px;">
                                    <div
                                        class="testimonial__item d-flex align-items-center justify-content-center flex-column"
                                        style="width: 100%; height: 450px">
                                        <div class="testimonial__item-top">
                                            <div class="testimonial__author">
                                                <div class="">
                                                    <img
                                                        src="https://static-cse.canva.com/blob/1492158/6-crazybiggoals.61ff33ae.avif"
                                                        alt="img"
                                                        style="width: 100%; height: 250px; object-fit: contain">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="testimonial__author-content">
                                            <h2 class="title">Tiếp Sức Cho Mọi Hành Trình</h2>
                                        </div>
                                        <div class="testimonial__content text-center">
                                            <p>
                                                Mỗi hành trình đều mang giá trị và sự độc đáo riêng. Chúng tôi cam kết hỗ trợ người dùng bằng cách cung cấp những nguồn lực và hỗ trợ phù hợp để họ đạt được mục tiêu của mình.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        </div>
                        <div class="testimonial__nav">
                            <button class="testimonial-button-prev" tabindex="0" aria-label="Previous slide"
                                    aria-controls="swiper-wrapper-32a39510f8c821e4b" style="background-color: #fff">
                                <i class="flaticon-arrow-right" style="color: #000"></i>
                            </button>
                            <button class="testimonial-button-next" tabindex="0" aria-label="Next slide"
                                    aria-controls="swiper-wrapper-32a39510f8c821e4b" style="background-color: #fff">
                                <i class="flaticon-arrow-right" style="color: #000"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="features__area-five features__bg" style="margin: 100px 0px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-8">
                    <div class="section__title text-center mb-40">
                        <h2 class="title">Cam Kết Của Chúng Tôi</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="commitments_one row">
                        <div class="image-container col-lg-12 col-12">
                            <img src="{{asset('storage/frontendNew')}}/assets/img/about/7.png"
                                 alt="" style="border-radius: 20px;">
                            <div class="commitments_one_content">
                                <p>Neztwork Vì Cộng Đồng</p>
                                <h3>Chúng tôi luôn nỗ lực tạo ra những tác động tích cực thông qua các sáng kiến của Neztwork. Vì Cộng Đồng, tập trung vào sự hòa nhập, đa dạng và hỗ trợ cộng đồng.</h3>
{{--                                <a href="#" class="commitments_btn"><span class="commitments_btn_text">Learn more</span></a>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3 row">
                    <div class="col-lg-6 col-12">
                        <div class="commitments_one row">
                            <div class="image-container col-lg-12 col-12">
                                <img src="{{asset('storage/frontendNew')}}/assets/img/about/8.png" alt=""
                                     style="border-radius: 20px;">
                                <div class="commitments_two_content">
                                    <p>Phát Triển Bền Vững Tại Neztwork</p>
                                    <h3>Chúng tôi ý thức rõ trách nhiệm bảo vệ môi trường và cam kết thực hiện các hoạt động bền vững trong mọi khía cạnh vận hành của mình.</h3>
{{--                                    <a href="#" class="commitments_btn"><span--}}
{{--                                            class="commitments_btn_text">Learn more</span></a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="commitments_one row">
                            <div class="image-container col-lg-12 col-12">
                                <img src="{{asset('storage/frontendNew')}}/assets/img/about/9.png" alt=""
                                     style="border-radius: 20px;">
                                <div class="commitments_two_content">
                                    <p>Nền tảng tin cậy</p>
                                    <h3>Chúng tôi đặt ưu tiên vào việc xây dựng một nền tảng an toàn, bảo mật và đáng tin cậy, nơi người dùng có thể tự tin tìm kiếm và cung cấp những lời khuyên chuyên môn.</h3>
{{--                                    <a href="#" class="commitments_btn"><span--}}
{{--                                            class="commitments_btn_text">Learn more</span></a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{{--    <div class="brand-area-three" style="margin: 100px 0px">--}}
{{--        <div class="container">--}}
{{--            <div class="row justify-content-center">--}}
{{--                <div class="col-xl-5 col-lg-8">--}}
{{--                    <div class="section__title text-center mb-40">--}}
{{--                        <h2 class="title"></h2>--}}
{{--                        <p class="text-black font_weight_bold" style="font-size: 20px">Awards and recognition</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row d-flex align-items-center justify-content-between">--}}
{{--                <div class="col-lg-2 col-md-4 col-12 mt-4 mt-lg-0">--}}
{{--                    <div class="d-flex align-items-center justify-content-center">--}}
{{--                        <img src="https://static-cse.canva.com/blob/1492161/logo.png" alt=""--}}
{{--                             style="filter: grayscale(1)">--}}
{{--                    </div>--}}
{{--                    <div class="text-center mt-4">--}}
{{--                        <p class="text-black font_weight_bold m-0">Accessibility Award</p>--}}
{{--                        <span>2022 Winner, Smartling</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-2 col-md-4 col-12 mt-4 mt-lg-0">--}}
{{--                    <div class="d-flex align-items-center justify-content-center">--}}
{{--                        <img src="https://static-cse.canva.com/blob/1492155/apple.png" alt=""--}}
{{--                             style="filter: grayscale(1)">--}}
{{--                    </div>--}}
{{--                    <div class="text-center mt-4">--}}
{{--                        <p class="text-black font_weight_bold m-0">Apple App Awards</p>--}}
{{--                        <span>2021 Winner, ‘Connection’</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-2 col-md-4 col-12 mt-4 mt-lg-0">--}}
{{--                    <div class="d-flex align-items-center justify-content-center">--}}
{{--                        <img src="https://static-cse.canva.com/blob/1492164/cnbc-disruptor2.png" alt=""--}}
{{--                             style="filter: grayscale(1)">--}}
{{--                    </div>--}}
{{--                    <div class="text-center mt-2 mt-lg-0">--}}
{{--                        <p class="text-black font_weight_bold m-0">Disruptor 50 list</p>--}}
{{--                        <span>22022, CNBC Disruptor 50</span>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--                <div class="col-lg-2 col-md-4 col-12 mt-4 mt-lg-0">--}}
{{--                    <div class="d-flex align-items-center justify-content-center">--}}
{{--                        <img src="https://static-cse.canva.com/blob/1492165/good_design.png" alt=""--}}
{{--                             style="filter: grayscale(1)">--}}
{{--                    </div>--}}
{{--                    <div class="text-center mt-4">--}}
{{--                        <p class="text-black font_weight_bold m-0">Good Design Award</p>--}}
{{--                        <span>2020 Winner, Canva Video</span>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--                <div class="col-lg-2 col-md-4 col-12 mt-4 mt-lg-0">--}}
{{--                    <div class="d-flex align-items-center justify-content-center">--}}
{{--                        <img src="https://static-cse.canva.com/blob/1492171/fast.png" alt=""--}}
{{--                             style="filter: grayscale(1)">--}}
{{--                    </div>--}}
{{--                    <div class="text-center mt-4">--}}
{{--                        <p class="text-black font_weight_bold m-0">Most Innovative Companies</p>--}}
{{--                        <span>2022, Fast Company</span>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <section class="features__area-five features__bg" style="margin: 100px 0px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-8">
                    <div class="section__title text-center mb-40">
                        <h2 class="title">Cảm Nhận Từ Cộng Đồng Neztwork</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center aboutNew_slider_feedback">
                <div class="col-12 d-flex align-items-center flex-wrap">
                    <div class="col-lg-6 col-12 ">
                        <img class="margin-top" src="https://static-cse.canva.com/blob/1492170/zoom-img.c3b7dfe2.avif" alt="" style="width: 100%; max-height: 500px; object-fit: contain; padding: 20px;">
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="">
                            <p class="text-black" style="font-size: 20px;">
                                "Là một doanh nhân, Neztwork đã trở thành nguồn lực quan trọng giúp tôi vượt qua những thách thức trong việc mở rộng quy mô kinh doanh. Sự tư vấn từ các chuyên gia và sự hỗ trợ từ cộng đồng đã tạo ra sự khác biệt lớn trong hành trình của tôi."
                            </p>
                            <div class="">
                                <p class="m-0 font_weight_bold text-black">Nguyễn Ngọc Nhật Minh</p>
{{--                                <p>Global Creative Manager, Zoom</p>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex align-items-center flex-wrap">
                    <div class="col-lg-6 col-12">
                        <img class="margin-top" src="https://static-cse.canva.com/blob/1492172/amnesy.png" alt="" style="width: 100%; max-height: 500px; object-fit: contain;padding: 20px;">
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="">
                            <p class="text-black" style="font-size: 20px;">
                                "Là một cá nhân thuộc cộng đồng LGBTQ+, Neztwork đã mang đến cho tôi cơ hội khám phá và hiểu rõ hơn về bản thân, thúc đẩy sự phát triển cá nhân. Cộng đồng ủng hộ và hướng dẫn từ các chuyên gia thực sự đã truyền sức mạnh và thay đổi cuộc sống của tôi."
                            </p>
                            <div class="">
                                <p class="m-0 font_weight_bold text-black">Alex

                                </p>
{{--                                <p>Social Media Specialist, Amnesty International Australia</p>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex align-items-center flex-wrap">
                    <div class="col-lg-6 col-12">
                        <img class="margin-top" src="https://static-cse.canva.com/blob/1492178/GeorgeLee.png" alt="" style="width: 100%; max-height: 500px; object-fit: contain;padding: 20px;">
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="">
                            <p class="text-black" style="font-size: 20px;">
                                "Neztwork đã thay đổi cách chúng tôi tiếp cận phát triển chuyên môn. Đây không chỉ là một nền tảng mà là một cộng đồng coi trọng kết nối con người và tiếp thêm động lực cho đội ngũ của chúng tôi."
                            </p>
                            <div class="">
                                <p class="m-0 font_weight_bold text-black">Nguyễn Kiều Hảo, Phó Giám Đốc Boston Pharma, Việt Nam

                                </p>
{{--                                <p>CAST Academy Coordinator, Balboa High School</p>--}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex align-items-center flex-wrap">
                    <div class="col-lg-6 col-12">
                        <img class="margin-top" src="https://static-cse.canva.com/blob/1492156/up.png" alt="" style="width: 100%; max-height: 500px; object-fit: contain;padding: 20px;">
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="">
                            <p class="text-black" style="font-size: 20px;">
                                "Thông qua Neztwork, tôi đã kết nối được với những chuyên gia đã dẫn dắt tôi qua các quyết định sự nghiệp quan trọng. Sự hỗ trợ cá nhân hóa và những kết nối chân thật là vô giá đối với tôi."
                            </p>
                            <div class="">
                                <p class="m-0 font_weight_bold text-black">Đào Thu Thảo

                                </p>
{{--                                <p>Upworthy writer</p>--}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="features__area-five features__bg" style="margin: 100px 0px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-8">
                    <div class="section__title text-center mb-40">
                        <h2 class="title">
                            Cùng Đồng Hành Với Chúng Tôi
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="commitments_one row">
                        <div class="image-container col-lg-12 col-12">
                            <img src="https://static-cse.canva.com/blob/1492181/Careers.8f8e8940.avif"
                                 alt="" style="border-radius: 20px;">
                            <div class="commitments_one_content">
                                <p>CƠ HỘI NGHỀ NGHIỆP</p>
                                <h3>Bạn có đam mê tạo ra những thay đổi tích cực? Hãy đồng hành cùng chúng tôi trong sứ mệnh gắn kết con người và xây dựng những kết nối ý nghĩa. Xem cơ hội nghề nghiệp tại đây.
                                </h3>
{{--                                <a href="#" class="commitments_btn"><span--}}
{{--                                        class="commitments_btn_text">See careers</span></a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


{{--    <section class="features__area-five features__bg" style="margin: 100px 0px">--}}
{{--        <div class="container">--}}
{{--            <div class="row justify-content-center">--}}
{{--                <div class="col-xl-5 col-lg-8">--}}
{{--                    <div class="section__title text-center mb-40">--}}
{{--                        <h2 class="title">Newsroom</h2>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row justify-content-center">--}}
{{--                <div class="col-12 row">--}}
{{--                    <a href="#" class="newsroom_wrap col-12 col-lg-4 col-md-6 my-3 text-center text-lg-start">--}}
{{--                        <div class="image-container">--}}
{{--                            <img class="image"--}}
{{--                                 src="https://static-cse.canva.com/blob/1551829/CC2024NewsroomArticle1-HeroThumbnail1920x1080.jpg"--}}
{{--                                 alt="" style="height: 250px; object-fit: contain">--}}
{{--                            <span class="overlay-button">See more</span>--}}
{{--                        </div>--}}
{{--                        <div class="">--}}
{{--                            <small class="m-0 text-secondary">OUR PRODUCT</small>--}}
{{--                            <p class="custom_line_2 title_trust font_weight_bold text-black">Canva Create 2024:--}}
{{--                                Introducing a whole new Canva</p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <a href="#" class="newsroom_wrap col-12 col-lg-4 col-md-6 my-3 text-center text-lg-start">--}}
{{--                        <div class="image-container">--}}
{{--                            <img class="image"--}}
{{--                                 src="https://static-cse.canva.com/blob/1589645/CanvaCreateCaseStudyPanel.jpg" alt=""--}}
{{--                                 style="height: 250px; object-fit: contain">--}}
{{--                            <span class="overlay-button">See more</span>--}}
{{--                        </div>--}}
{{--                        <div class="">--}}
{{--                            <small class="m-0 text-secondary">B2B</small>--}}
{{--                            <p class="custom_line_2 title_trust font_weight_bold text-black">5 Ways global organizations--}}
{{--                                are supercharging growth with Canva</p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <a href="#" class="newsroom_wrap col-12 col-lg-4 col-md-6 my-3 text-center text-lg-start">--}}
{{--                        <div class="image-container">--}}
{{--                            <img--}}
{{--                                class="image"--}}
{{--                                src="https://static-cse.canva.com/blob/1551704/CanvaVEReport2024NewsroomTumb_1920x1080.png"--}}
{{--                                alt="" style="height: 250px; object-fit: contain">--}}
{{--                            <span class="overlay-button">See more</span>--}}
{{--                        </div>--}}
{{--                        <div class="">--}}
{{--                            <small class="m-0 text-secondary">Security</small>--}}
{{--                            <p class="custom_line_2 title_trust font_weight_bold text-black">Canva report: AI and visual--}}
{{--                                communication are booming</p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}




    <section class="fact__area-two " style="margin: 100px 0px">
        <div class="container" style="background-color: #ebf3fe; border-radius: 20px">
            <div class="row p-3 justify-content-center align-items-center">
                <div class="col-lg-3 col-12 text-center p-2">
                    <img src="https://static-cse.canva.com/blob/1492163/KangarooPaws.png" alt="" style="height: 300px">
                </div>
                <div class="col-lg-6 col-12">
                    <div class="text-center">
                        <h5 style="font-size: 25px; font-weight: bold">Tâm Huyết Từ Neztwork</h5>
                        <p>Tại Neztwork, chúng tôi luôn tự hào về bản sắc dân tộc của mình Việt Nam – mảnh đất giàu truyền thống và sức mạnh bền bỉ, sự kiên trì và đoàn kết, là nơi câu chuyện của chúng tôi bắt đầu. Hàng ngày, chúng tôi được truyền cảm hứng từ sự ấm áp, lòng hiếu khách và tinh thần kiên cường của người dân Việt. Chúng tôi tin vào sức mạnh của những ước mơ và biết rằng, những ai nuôi dưỡng niềm tin sẽ không bao giờ phải bước đi một mình. Với sự tôn trọng sâu sắc dành cho quê hương, biển cả và con người Việt Nam, chúng tôi trân trọng hành trình chung này và nỗ lực xây dựng một tương lai nơi những kết nối giữa con người được tôn vinh và gìn giữ.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-12 text-center p-2">
                    <img src="https://static-cse.canva.com/blob/1492167/Waratah.png" alt="" style="height: 300px">
                </div>
            </div>
        </div>
    </section>





@endsection
