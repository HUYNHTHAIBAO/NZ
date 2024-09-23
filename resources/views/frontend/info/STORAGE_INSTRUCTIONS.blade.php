


@extends('frontend.layouts.frontend')

@section('content')
{{--    <section class="breadcrumb__area breadcrumb__bg">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="breadcrumb__content">--}}
{{--                        <nav class="breadcrumb">--}}
{{--                                <span property="itemListElement" typeof="ListItem">--}}
{{--                                    <a href="/">Trang chủ</a>--}}
{{--                                </span>--}}
{{--                            <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>--}}
{{--                            <span property="itemListElement" typeof="ListItem">Chính sách thanh toán</span>--}}
{{--                        </nav>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="breadcrumb__shape-wrap">--}}
{{--            <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape01.svg" alt="img" class="alltuchtopdown">--}}
{{--            <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape02.svg" alt="img" data-aos="fade-right" data-aos-delay="300" class="aos-init aos-animate">--}}
{{--            <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape03.svg" alt="img" data-aos="fade-up" data-aos-delay="400" class="aos-init aos-animate">--}}
{{--            <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape04.svg" alt="img" data-aos="fade-down-left" data-aos-delay="400" class="aos-init aos-animate">--}}
{{--            <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape05.svg" alt="img" data-aos="fade-left" data-aos-delay="400" class="aos-init aos-animate">--}}
{{--        </div>--}}
{{--    </section>--}}
    <section class="about-area-three section-py-120">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                {!! html_entity_decode($STORAGE_INSTRUCTIONS) !!}
            </div>
        </div>
    </section>
@endsection
