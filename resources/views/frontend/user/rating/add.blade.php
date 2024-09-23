@extends('frontend.layouts.frontend')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

    <style>

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }
        .rating {
            --star-size: clamp(2rem, 5vw, 6rem);
            --star-clr-inactive: rgba(128, 128, 128, 0.7);
            --star-clr-active: rgb(245, 158, 11);
            --star-clr-hover: rgba(236, 201, 136, 0.2);
            --star-clip-path: polygon(
                50% 0%,
                61% 35%,
                98% 35%,
                68% 57%,
                79% 91%,
                50% 70%,
                21% 91%,
                32% 57%,
                2% 35%,
                39% 35%
            );
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        label {
            position: relative;
            cursor: pointer;
            width: var(--star-size);
            height: var(--star-size);
        }
        label::before {
            content: "";
            position: absolute;
            inset: 50%;
            border-radius: 50%;
            background-color: var(--star-clr-hover);
            transition: rotate 450ms ease-in-out, inset 300ms ease-in-out;
            clip-path: var(--star-clip-path);
        }
        label:hover::before {
            inset: -1rem;
            rotate: 45deg;
        }
        label::after {
            content: "";
            position: absolute;
            inset: 0;
            background-color: var(--star-clr-inactive);
            clip-path: var(--star-clip-path);
            transition: 300ms ease-in-out;
            scale: 0.75;
        }
        label:has(~ label:hover)::after,
        label:has(~ label > :checked)::after,
        label:has(:checked)::after,
        label:hover::after {
            background-color: var(--star-clr-active);
            scale: 1;
        }

        label:hover ~ label::after {
            scale: 0.75;
        }
        label:active::before {
            inset: -2rem;
        }


    </style>


    <!-- breadcrumb-area -->
{{--    <div class="breadcrumb__area breadcrumb__bg breadcrumb__bg-three  mb-5"--}}
{{--         data-background="{{asset('storage/backend')}}/assets/img/bg/breadcrumb_bg.jpg" style="">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="breadcrumb__content">--}}
{{--                        --}}{{-- <h3 class="title">Đăng nhập</h3>--}}
{{--                        <nav class="breadcrumb">--}}
{{--                                <span property="itemListElement" typeof="ListItem">--}}
{{--                                    <a href="/">Trang chủ</a>--}}
{{--                                </span>--}}
{{--                            <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>--}}
{{--                            <span property="itemListElement" typeof="ListItem">Đánh giá</span>--}}
{{--                        </nav>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="breadcrumb__shape-wrap">--}}
{{--            <img src="{{asset('storage/frontendNew')}}/assets/img/others/breadcrumb_shape01.svg" alt="img"--}}
{{--                 class="alltuchtopdown">--}}
{{--            <img src="{{asset('storage/frontendNew')}}/assets/img/others/breadcrumb_shape02.svg" alt="img"--}}
{{--                 data-aos="fade-right" data-aos-delay="300" class="aos-init aos-animate">--}}
{{--            <img src="{{asset('storage/frontendNew')}}/assets/img/others/breadcrumb_shape03.svg" alt="img"--}}
{{--                 data-aos="fade-up" data-aos-delay="400" class="aos-init aos-animate">--}}
{{--            <img src="{{asset('storage/frontendNew')}}/assets/img/others/breadcrumb_shape04.svg" alt="img"--}}
{{--                 data-aos="fade-down-left" data-aos-delay="400" class="aos-init aos-animate">--}}
{{--            <img src="{{asset('storage/frontendNew')}}/assets/img/others/breadcrumb_shape05.svg" alt="img"--}}
{{--                 data-aos="fade-left" data-aos-delay="400" class="aos-init aos-animate">--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- breadcrumb-area-end -->

    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            @include('frontend.user.header')
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.user.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="dashboard__content-wrap">
                        <div class="dashboard__content-title">
                            <h4 class="title">Đánh giá</h4>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="itemTwo-tab-pane" role="tabpanel"
                                         aria-labelledby="itemTwo-tab" tabindex="0">
                                        <div class="instructor__profile-form-wrap">
                                            <form action="{{route('frontend.rating.add', $rating->id)}}" class="instructor__profile-form" method="Post">
                                                @csrf
                                                <div class="rating p-5 d-flex justify-content-center">
                                                    <label for="radio-1" aria-label="Rating 1"><input type="radio" name="rating" id="radio-1" class="sr-only" value="1"></label>
                                                    <label for="radio-2" aria-label="Rating 2"> <input type="radio" name="rating" id="radio-2" class="sr-only" value="2"></label>
                                                    <label for="radio-3" aria-label="Rating 3"><input type="radio" name="rating" id="radio-3" class="sr-only" value="3"></label>
                                                    <label for="radio-4" aria-label="Rating 4"><input type="radio" name="rating" id="radio-4" class="sr-only" value="4"></label>
                                                    <label for="radio-5" aria-label="Rating 5"><input type="radio" name="rating" id="radio-5" class="sr-only" checked value="5"></label>
                                                </div>
                                                <div class="form-grp">
                                                    <label for="comment"> Nội dung <span
                                                            class="text-danger">*</span></label>
                                                    <textarea id="comment" name="comment"></textarea>
                                                    @if ($errors->has('comment'))
                                                        <div class="custom_error">{{ $errors->first('comment') }}</div>
                                                    @endif
                                                </div>

                                                <div class="submit-btn mt-25">
                                                    <button type="submit" class="btn btn_custom">Gửi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>

    </script>
@endsection

