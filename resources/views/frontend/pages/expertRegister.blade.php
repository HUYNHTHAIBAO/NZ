@extends('frontend.layouts.frontend')

@section('content')
    <section class="banner-area banner-bg tg-motion-effects"
             data-background="{{asset('storage/frontendNew')}}/assets/img/banner/banner_bg.png">
        <div class="container">
            <div class="row justify-content-between align-items-start">
                <div class="col-xl-5 col-lg-6">
                    <div class="banner__content">
                        <h2 class="title tg-svg aos-init aos-animate" data-aos="fade-right" data-aos-delay="400"
                            style="font-weight: bold">
                            Trở thành Creator cùng Neztwork
                        </h2>
                        <p data-aos="fade-right" data-aos-delay="600" class="aos-init aos-animate">Hãy để Neztwork cùng bạn tạo nên sự khác biệt — Kết nối tri thức, chia sẻ giá trị, phát triển cộng đồng.</p>
                        <div class="banner__btn-wrap aos-init aos-animate" data-aos="fade-right" data-aos-delay="800">
                            <a href="#" class="btn btn_custom">Bắt đầu <img
                                    src="{{asset('storage/frontendNew')}}/assets/img/icons/right_arrow.svg" alt="img"
                                    class="injectable icon_btn_custom"></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="banner__images">
                        <img src="{{asset('storage/frontendNew')}}/assets/img/expertRegister/1.png" alt="img"
                             class="main-img">
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--//--}}
    <section class="categories-area-three fix categories__bg"
             data-background="{{asset('storage/frontendNew')}}/assets/assets/img/bg/categories_bg.jpg" style="margin-top: 100px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="section__title text-center mb-50">
                        <h2 class="title bold">Rất Nhiều Lý Do Để Bắt Đầu</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="categories__item-three">
                        <a href="#">
                            <div class="">
                                <img src="https://cdn-icons-png.flaticon.com/128/7855/7855626.png" alt="">
                            </div>
                            <span class="name">Toàn quyền quản lý và thiết kế </span>
                            <span class="courses">Neztwork cho phép creator toàn quyền quản lý, thiết kế danh mục sản phẩm và mọi khía cạnh khác để có thể tăng tương tác, thu hút người dùng (như cuộc gọi video 1:1, cuộc gọi nhóm, webinar, sản phẩm số,...)</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="categories__item-three">
                        <a href="#">
                            <div class="">
                                <img src="https://cdn-icons-png.flaticon.com/128/2967/2967768.png" alt="">
                            </div>
                            <span class="name">Truyền Cảm Hứng và Tạo Sự Ảnh Hưởng</span>
                            <span class="courses">Chia sẻ kiến thức của bạn để giúp người dùng khám phá những khả năng mới, học hỏi các kỹ năng mới và đạt được mục tiêu. Sự hướng dẫn của bạn có thể mở ra những bước tiến lớn và thúc đẩy sự phát triển cá nhân mạnh mẽ.</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="categories__item-three">
                        <a href="#">
                            <div class="">
                                <img src="https://cdn-icons-png.flaticon.com/128/2429/2429296.png" alt="">
                            </div>
                            <span class="name">Gặt Hái Phần Thưởng</span>
                            <span class="courses">Xây dựng thương hiệu, nâng cao chuyên môn, tăng thu nhập và tiếp cận thị trường rộng lớn hơn. Neztwork là cầu nối giúp Creators chia sẻ giá trị và kiến thức, góp phần phát triển cộng đồng và tạo ra tác động tích cực.</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <section class="fact__area">
            <div class="">
                <div class="fact__inner-wrap" style="border-radius: 0px">
                    <div class="row d-flex align-items-center justify-content-center">
                        <div class="col-lg-2 col-6">
                            <div class="fact__item">
                                <h2 class="text-white">Hàng ngàn</h2>
                                <p>Cuộc gọi video dự kiến</p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-6">
                            <div class="fact__item">
                                <h2 class="text-white">5+</h2>
                                <p>Ngôn ngữ được sử dụng</p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-6">
                            <div class="fact__item">
                                <h2 class="text-white">Hàng ngàn</h2>
                                <p>Tương tác</p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-6">
                            <div class="fact__item">
                                <h2 class="text-white">5+</h2>
                                <p>Quốc gia phục vụ</p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-6">
                            <div class="fact__item">
                                <h2 class="text-white">100+</h2>
                                <p>Đối tác doanh nghiệp</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>


    {{--    //--}}

    {{--    //--}}

    <section class="categories-area-three fix categories__bg"
             data-background="{{asset('storage/frontendNew')}}/assets/assets/img/bg/categories_bg.jpg" style="margin-top: 100px">
        <div class="container">
            <div class="dashboard__content-wrap">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="section__title text-center mb-50">
                            <h2 class="title bold">Làm sao để bắt đầu</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="dashboard__nav-wrap">
                            <ul class="nav nav-tabs d-flex align-items-center justify-content-center" id="myTab"
                                role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="itemOne-tab" data-bs-toggle="tab"
                                            data-bs-target="#itemOne-tab-pane" type="button" role="tab"
                                            aria-controls="itemOne-tab-pane" aria-selected="false" tabindex="-1">Thể Hiện Sự Xuất Sắc Của Bạn
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " id="itemTwo-tab" data-bs-toggle="tab"
                                            data-bs-target="#itemTwo-tab-pane" type="button" role="tab"
                                            aria-controls="itemTwo-tab-pane" aria-selected="true">Định Hình Sức Ảnh Hưởng Của Bạn
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="itemThree-tab" data-bs-toggle="tab"
                                            data-bs-target="#itemThree-tab-pane" type="button" role="tab"
                                            aria-controls="itemThree-tab-pane" aria-selected="false" tabindex="-1">Kết Nối và Biến Đổi Cuộc Sống
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="itemOne-tab-pane" role="tabpanel"
                                 aria-labelledby="itemOne-tab" tabindex="0">
                                <div class="row d-flex align-items-center justify-content-center">
                                    <div class="col-lg-4 col-12">
                                        <p class="text-black">
                                            Tạo hồ sơ nổi bật trên Neztwork phản ánh chính xác kỹ năng và chuyên môn đặc biệt của bạn. Làm nổi bật các thành tựu và giá trị riêng biệt mà bạn mang lại, giúp khách hàng tiềm năng dễ dàng nhận thấy vì sao bạn là Creator mà họ cần.
                                        </p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <img src="https://s.udemycdn.com/teaching/plan-your-curriculum-v3.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade " id="itemTwo-tab-pane" role="tabpanel"
                                 aria-labelledby="itemTwo-tab" tabindex="0">
                                <div class="row d-flex align-items-center justify-content-center">
                                    <div class="col-lg-4 col-12">
                                        <p class="text-black">
                                            Quản lý, thiết kế danh mục sản phẩm và mọi khía cạnh khác để có thể tăng tương tác, thu hút người dùng (như cuộc gọi video 1:1, cuộc gọi nhóm, webinar, sản phẩm số,...) bằng cách tự thiết lập thời gian, mức giá và lĩnh vực chuyên môn. Neztwork mang đến cho bạn sự tự do tùy chỉnh dịch vụ theo đam mê và phong cách sống, cho phép bạn cung cấp những đề tài chia sẻ mang tính cá nhân hóa và đầy tác động theo cách riêng của mình.
                                        </p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <img src="https://s.udemycdn.com/teaching/record-your-video-v3.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="itemThree-tab-pane" role="tabpanel"
                                 aria-labelledby="itemThree-tab" tabindex="0">
                                <div class="row d-flex align-items-center justify-content-center">
                                    <div class="col-lg-4 col-12">
                                        <p class="text-black">
                                            Bắt đầu hành trình thương mại hóa kiến thức và xây dựng thương hiệu cá nhân cùng Neztwork, tạo ra một không gian kết nối nơi kiến thức chuyên sâu và kỹ năng thực tiễn được chia sẻ, góp phần phát triển cộng đồng và mang lại giá trị thực sự cho xã hội.
                                        </p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <img src="https://s.udemycdn.com/teaching/launch-your-course-v3.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{{--    //--}}
    <div class="" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="section__title text-center mb-50">
                    <h2 class="title bold">Chia sẻ từ Creator của Neztwork</h2>
                </div>
            </div>
        </div>
        <div class="text-center ">
            <img src="https://static-cse.canva.com/_next/static/media/quotation_mark.file.9ed02a95.svg"
                 alt="" style="width: 20px; height: 20px; object-fit: contain">
        </div>
        <div class="container">
        <div class="ai_slider">
            <div class="col-6 row text-center justify-content-center pt-3 py-5">
                <p style="font-size: 20px; color: #000">"Tham gia Neztwork đã là một hành trình tuyệt vời. Giờ đây, tôi đang tiếp cận với nhóm người dùng những quốc gia khác nhau và tạo ra sự khác biệt thực sự. Sự hỗ trợ từ nền tảng đã đóng vai trò quan trọng cho thành công của tôi."</p>
                <p>Tiến sĩ Elena Ramirez, Chuyên gia tư vấn chiến lược kinh doanh</p>
            </div>
            <div class="col-6 row text-center justify-content-center pt-3 py-5">
                <p style="font-size: 20px; color: #000">"Neztwork đã thay đổi cách tôi kết nối với khách hàng. Sự linh hoạt của nền tảng và cộng đồng hỗ trợ đã giúp tôi tạo ra sự khác biệt lớn trên con đường theo đuổi đam mê của mình."</p>
                <p>Alex Nguyễn, Cố vấn công nghệ</p>>
            </div>
            <div class="col-6 row text-center justify-content-center pt-3 py-5">
                <p style="font-size: 20px; color: #000">"Tham gia Neztwork giúp tôi xây dựng thương hiệu cá nhân và tạo ra tầm ảnh hưởng. Sự tập trung vào kết nối chân thật và hỗ trợ tuyệt vời đã là yếu tố quan trọng trong hành trình chia sẻ của tôi!"</p>
                <p>Priya Patel, Tư vấn phát triển sự nghiệp</p>
            </div>
        </div>
        </div>
    </div>


    <section class="categories-area-three fix  categories__bg"
             data-background="{{asset('storage/frontendNew')}}/assets/assets/img/bg/categories_bg.jpg" style="margin-top: 100px">

        <div class="row d-flex align-items-center text-center">
            <div class="col-lg-3 col-12">
                <img src="https://s.udemycdn.com/teaching/plan-your-curriculum-v3.jpg" alt="">
            </div>
            <div class="col-lg-6 col-12">
                <h2>Hãy tỏa sáng cùng Neztwork</h2>
                <p>
                    Đội ngũ thân thiện của Neztwork luôn sẵn sàng hỗ trợ bạn từng bước trên hành trình chia sẻ, thương mại hóa kiến thuwsc. Với nguồn tài nguyên phong phú và cộng đồng Creators năng động, bạn sẽ không bao giờ đơn độc trong hành trình của mình.
                </p>
                {{--                <a href="#">Bạn cần biết thêm chi tiết trước khi bắt đầu? Hãy tìm hiểu thêm.</a>--}}
            </div>
            <div class="col-lg-3 col-12">
                <img src="https://s.udemycdn.com/teaching/plan-your-curriculum-v3.jpg" alt="">
            </div>
        </div>
    </section>



    <section class="features__area" style="background: #eeeeee">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="section__title white-title text-center mb-50">
                        <h2 class="title text-black">Trở thành Creator của Neztwork ngay hôm nay</h2>
                        <p class="text-black">Hãy trở một phần của cộng đồng Neztwork, nơi tạo ra các kết nối có sức ảnh hưởng và sự phát triển cá nhân. Cùng chúng tôi tạo ra một không gian kết nối, nơi kiến thức chuyên sâu và kỹ năng thực tiễn được chia sẻ, góp phần phát triển cộng đồng và mang lại giá trị thực sự cho xã hội.</p>
{{--                        <a href="{{route('frontend.user.login')}}" class="btn btn_custom my-2">Bắt đầu</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
