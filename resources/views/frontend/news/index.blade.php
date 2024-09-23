@extends('frontend.layouts.frontend')

@section('content')
{{--    @include('frontend.parts.breadcrumbs')--}}

{{--    <div class="blog-area pt-20 pb-20">--}}
{{--        <div class="container">--}}
{{--            <div class="row flex-row-reverse">--}}
{{--                <div class="col-lg-9">--}}
{{--                    <div class="row">--}}
{{--                        @forelse($items as $item)--}}

{{--                            <div class="col-lg-6 col-md-6 col-12 col-sm-6">--}}
{{--                                <div class="blog-wrap mb-40">--}}
{{--                                    <div class="blog-img mb-20">--}}
{{--                                        <a href="{{$item->post_link()}}" title="{{$item->name}}">--}}
{{--                                            <img src="{{$item->thumbnail ? $item->thumbnail->file_src : ''}}" alt="{{$item->name}}">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    <div class="blog-content">--}}
{{--                                        <div class="blog-meta">--}}
{{--                                            <ul>--}}
{{--                                                <li><a href="#">{{$item->category->name}}</a></li>--}}
{{--                                                <li>{{$item->created_at}}</li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                        <h1><a href="{{$item->post_link()}}" title="{{$item->name}}">{{$item->name}}</a></h1>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @empty--}}
{{--                            <p>Nội dung đang được cập nhật.</p>--}}
{{--                        @endforelse--}}
{{--                    </div>--}}
{{--                    @include('frontend.parts.pagination', ['paginator' => $items])--}}

{{--                </div>--}}
{{--                @include('frontend.news.sidebar')--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


<section class="breadcrumb__area breadcrumb__bg"
         data-background="{{ asset('/storage/frontendNew')}}/assets/img/bg/breadcrumb_bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb__content">
                    <nav class="breadcrumb">
                                <span property="itemListElement" typeof="ListItem">
                                    <a href="/">Trang chủ</a>
                                </span>
                        <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>
                        <span property="itemListElement" typeof="ListItem">Tin tức & Bài viết của NeztWork</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb__shape-wrap">
        <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape01.svg" alt="img"
             class="alltuchtopdown">
        <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape02.svg" alt="img"
             data-aos="fade-right" data-aos-delay="300" class="aos-init aos-animate">
        <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape03.svg" alt="img"
             data-aos="fade-up" data-aos-delay="400" class="aos-init aos-animate">
        <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape04.svg" alt="img"
             data-aos="fade-down-left" data-aos-delay="400" class="aos-init aos-animate">
        <img src="{{ asset('/storage/frontendNew')}}/assets/img/others/breadcrumb_shape05.svg" alt="img"
             data-aos="fade-left" data-aos-delay="400" class="aos-init aos-animate">
    </div>
</section>


<section class="blog-area section-py-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="row gutter-20">
                    @forelse($items as $item)
                        <div class="col-xl-4 col-md-6">
                            <div class="blog__post-item shine__animate-item">
                                <div class="blog__post-thumb">
                                    <a href="{{$item->post_link()}}" class="shine__animate-link"><img
                                            src="{{$item->thumbnail ? $item->thumbnail->file_src : ''}}"
                                            alt="img"></a>
                                    <span class="post-tag">{{$item->category->name ?? ''}}</span>
                                </div>
                                <div class="blog__post-content">
                                    <div class="blog__post-meta">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-calendar"></i>{{(format_date_custom($item->created_at))}}</li>
                                            <li><i class="flaticon-user-1"></i> <span> Admin</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <h4 class="title custom_line_2">
                                        <a class="" title="{{$item->name ?? ''}}" href="{{$item->post_link()}}">{{$item->name ?? ''}}</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    @empty

                    @endforelse
                </div>
                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                    <ul class="pagination">
                        {{$items->links()}}
                    </ul>
                </nav>
            </div>
            <div class="col-xl-3 col-lg-4">
                <aside class="blog-sidebar">
                    @include('frontend.news.sidebar')
                </aside>
            </div>
        </div>
    </div>
</section>

@endsection
