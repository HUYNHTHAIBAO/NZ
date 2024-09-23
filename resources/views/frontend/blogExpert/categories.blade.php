@extends('frontend.layouts.frontend')

@section('content')

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
{{--                            <span property="itemListElement" typeof="ListItem">Bài viết chuyên gia</span>--}}
                            <span property="itemListElement" typeof="ListItem">
                                <a href="{{route('frontend.blogExpert.main')}}">Bài viết chuyên gia</a>
                            </span>
                            <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>
                            <span property="itemListElement" typeof="ListItem">Danh mục</span>
                            <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>


                            @php
                                $firstPost = $data->first();
                            @endphp
                            @if($firstPost && $firstPost->expertCategory)
                                <span>{{ $firstPost->expertCategory->name  ?? ''}}</span>
                            @endif
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
                        @forelse($data as $item)
                            <div class="col-xl-4 col-md-6">
                                <div class="blog__post-item shine__animate-item">
                                    <div class="blog__post-thumb">
                                        <a href="{{route('frontend.blogExpert.detail', $item->slug)}}" class="shine__animate-link"><img
                                                src="{{$item->thumbnail ? $item->thumbnail->file_src : ''}}"
                                                alt="img"></a>
                                        <span class="post-tag">{{$item->expertCategory->name ?? ''}}</span>
                                    </div>
                                    <div class="blog__post-content">
                                        <div class="blog__post-meta">
                                            <ul class="list-wrap">
                                                <li><i class="flaticon-calendar"></i>{{(format_date_custom($item->created_at))}}</li>
                                                <li><i class="flaticon-user-1"></i>by
                                                    <span>{{$item->user->fullname ?? ''}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <h4 class="title custom_line_2">
                                            <a class="" title="{{$item->name ?? ''}}" href="{{route('frontend.blogExpert.detail', $item->slug)}}">{{$item->name ?? ''}}</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        @empty

                        @endforelse
                    </div>

                        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                            <ul class="pagination">
                                {{$data->links()}}
                            </ul>
                        </nav>

                </div>
                <div class="col-xl-3 col-lg-4">
                    <aside class="blog-sidebar">
                        @include('frontend.blogExpert.sidebar')
                    </aside>
                </div>
            </div>
        </div>
    </section>


@endsection
