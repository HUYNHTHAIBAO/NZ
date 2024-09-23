@extends('frontend.layouts.frontend')

@section('content')
{{--    @include('frontend.parts.breadcrumbs')--}}

{{--    <!-- blog main wrapper start -->--}}
{{--    <div class="blog-area pt-20 pb-20">--}}
{{--        <div class="blog-main-wrapper section-padding">--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    @include('frontend.news.sidebar')--}}

{{--                    <div class="col-lg-9">--}}
{{--                        <div class="blog-details-wrapper">--}}
{{--                            <div class="blog-details-top">--}}
{{--                                <div class="blog-details-img">--}}
{{--                                    <img alt="" src="{{$post->thumbnail?$post->thumbnail->file_src:''}}">--}}
{{--                                </div>--}}
{{--                                <div class="blog-details-content">--}}
{{--                                    <div class="blog-meta-2">--}}
{{--                                        <ul>--}}
{{--                                            <li>{{$post->category->name}}</li>--}}
{{--                                            <li>{{$post->created_at}}</li>--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                    <h1>{{$post->name}}</h1>--}}
{{--                                    <p>{{$post->excerpt}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            {!! html_entity_decode($post->detail) !!}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- blog main wrapper end -->

{{--<section class="breadcrumb__area breadcrumb__bg" data-background="{{ asset('/storage/frontendNew')}}/assets/img/bg/breadcrumb_bg.jpg">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                <div class="breadcrumb__content">--}}
{{--                    <nav class="breadcrumb">--}}
{{--                                <span property="itemListElement" typeof="ListItem">--}}
{{--                                    <a href="/">Trang chủ</a>--}}
{{--                                </span>--}}
{{--                        <span class="breadcrumb-separator">--}}
{{--                            <i class="fas fa-angle-right"></i>--}}
{{--                        </span>--}}
{{--                        <span property="itemListElement" typeof="ListItem">--}}
{{--                                    <a href="{{route('frontend.news.main')}}">Tin tức & Bài viết của NeztWork</a>--}}
{{--                                </span>--}}
{{--                        <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>--}}
{{--                        <span property="itemListElement" typeof="ListItem">{{$post->name ?? ''}}</span>--}}
{{--                    </nav>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="breadcrumb__shape-wrap">--}}
{{--        <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape01.svg" alt="img" class="alltuchtopdown">--}}
{{--        <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape02.svg" alt="img" data-aos="fade-right" data-aos-delay="300" class="aos-init aos-animate">--}}
{{--        <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape03.svg" alt="img" data-aos="fade-up" data-aos-delay="400" class="aos-init aos-animate">--}}
{{--        <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape04.svg" alt="img" data-aos="fade-down-left" data-aos-delay="400" class="aos-init aos-animate">--}}
{{--        <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape05.svg" alt="img" data-aos="fade-left" data-aos-delay="400" class="aos-init aos-animate">--}}
{{--    </div>--}}
{{--</section>--}}


<section class="blog-details-area section-py-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="blog__details-wrapper">
                    <div class="blog__details-thumb">
                        <img
                            src="{{$post->thumbnail ? $post->thumbnail->file_src : ''}}"
                            alt="img">
                    </div>
                    <div class="blog__details-content">
                        <div class="blog__post-meta">
                            <ul class="list-wrap">
                                <li><i class="flaticon-calendar"></i>{{format_date_custom($post->created_at)}}</li>
                                <li><i class="flaticon-user-1"></i><span>Admin</span></li>
                            </ul>
                        </div>
                        <h3 class="title">{{$post->name ?? ''}}</h3>
                        <p>{{$post->excerpt ?? ''}}</p>
                        <p>{!! $post->detail !!}</p>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4">
                <aside class="blog-sidebar">
                    @include('frontend.news.sidebar')
                    <div class="blog-widget">
                        <h4 class="widget-title">Bài viết Liên quan</h4>
                        @forelse($relative_post as $item)
                            <div class="rc-post-item">
                                <div class="rc-post-thumb">
                                    <a href="{{$item->post_link()}}">
                                        <img src="{{$item->thumbnail ? $item->thumbnail->file_src : ''}}" alt="img">
                                    </a>
                                </div>
                                <div class="rc-post-content">
                                    <span class="date"><i class="flaticon-calendar"></i> {{format_date_custom($item->created_at)}} </span>
                                    <h4 class="title"><a href="{{$item->post_link()}}">{{$item->name ?? ''}}</a></h4>
                                </div>
                            </div>
                        @empty

                        @endforelse

                    </div>

                </aside>
            </div>
        </div>
    </div>
</section>

@endsection
