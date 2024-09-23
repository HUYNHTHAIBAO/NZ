@extends('frontend.layouts.frontend')

@section('content')
{{--    <!-- Meta tags for Facebook -->--}}
{{--    <meta property="og:title" content="{{ $post->title }}">--}}
{{--    <meta property="og:description" content="{{ $post->excerpt }}">--}}
{{--    <meta property="og:image" content="{{ $post->thumbnail->file_src }}">--}}
{{--    <meta property="og:url" content="{{ route('frontend.blogExpert.detail', $post->slug) }}">--}}
{{--    <meta property="og:type" content="article">--}}

{{--    <!-- Meta tags for Twitter -->--}}
{{--    <meta name="twitter:card" content="summary_large_image">--}}
{{--    <meta name="twitter:title" content="{{ $post->title }}">--}}
{{--    <meta name="twitter:description" content="{{ $post->excerpt }}">--}}
{{--    <meta name="twitter:image" content="{{ $post->thumbnail->file_src }}">--}}
{{--    <meta name="twitter:url" content="{{ route('frontend.blogExpert.detail', $post->slug) }}">--}}

{{--    <section class="breadcrumb__area breadcrumb__bg" data-background="{{ asset('/storage/frontendNew')}}/assets/img/bg/breadcrumb_bg.jpg">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="breadcrumb__content">--}}
{{--                        <nav class="breadcrumb">--}}
{{--                                <span property="itemListElement" typeof="ListItem">--}}
{{--                                    <a href="/">Trang chủ</a>--}}
{{--                                </span>--}}
{{--                            <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>--}}
{{--                            <span property="itemListElement" typeof="ListItem">--}}
{{--                                    <a href="/bai-viet-chuyen-gia">Bài viết chuyên gia</a>--}}
{{--                                </span>--}}
{{--                            <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>--}}
{{--                            <span property="itemListElement" typeof="ListItem">{{$post->name ?? ''}}</span>--}}
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
                                    <li><i class="flaticon-user-1"></i> by <span>{{$post->user->fullname ?? ''}}</span></li>
                                    <li><i class="flaticon-book"></i> <span class=""> <span>{{$post->expertCategory->name ?? ''}}</span></span></li>
                                </ul>
                            </div>
                            <h3 class="title">{{$post->name ?? ''}}</h3>
                            <p>{{$post->excerpt ?? ''}}</p>
                            <p>{!! $post->detail !!}</p>

                        </div>
                    </div>
                    <div class="blog__details-bottom">
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-md-7">
{{--                                <div class="tg-post-tag">--}}
{{--                                    <h5 class="tag-title">Tags :</h5>--}}
{{--                                    <ul class="list-wrap p-0 mb-0">--}}
{{--                                        <li><a href="#">Bath Cleaning</a></li>--}}
{{--                                        <li><a href="#">Cleaning</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
                                <div class="like-container">
                                    @if($post->isLikedByAuthUser())
                                        <form action="{{ route('frontend.blogExpert.unLike', $post->id) }}" method="POST" class="like-form">
                                            @csrf
                                            <button type="submit" class="like-button liked">
                                                <i class="fas fa-thumbs-up"></i> Unlike
                                            </button>
                                            <span class="like-count badge bg-light text-black" >{{$likeCount}}</span>
                                        </form>
                                    @else
                                        <form action="{{ route('frontend.blogExpert.like', $post->id) }}" method="POST" class="like-form">
                                            @csrf
                                            <button type="submit" class="like-button">
                                                <i class="fas fa-thumbs-up"></i> Like
                                            </button>
                                            <span class="like-count badge bg-light text-black">{{$likeCount}}</span>
                                        </form>
                                    @endif
                                </div>


                            </div>
                            <div class="col-xl-6 col-md-5">
                                <div class="tg-post-social justify-content-start justify-content-md-end">
                                    <h5 class="social-title">Chia sẽ :</h5>
                                    <ul class="list-wrap p-0 mb-0">
                                        <li><a href="#" onclick="shareOnFacebook('{{ route('frontend.blogExpert.detail', $post->slug) }}', '{{ $post->thumbnail->file_src }}')"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#" onclick="shareOnTwitter('{{ route('frontend.blogExpert.detail', $post->slug) }}', '{{ $post->thumbnail->file_src }}')"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#" onclick="shareOnLinkedIn('{{ route('frontend.blogExpert.detail', $post->slug) }}', '{{ $post->thumbnail->file_src }}')"><i class="fab fa-linkedin-in"></i></a></li>
                                        <li><a href="#" onclick="shareOnPinterest('{{ route('frontend.blogExpert.detail', $post->slug) }}', '{{ $post->thumbnail->file_src }}')"><i class="fab fa-pinterest-p"></i></a></li>
                                    </ul>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog-post-comment">
                        <div class="comment-wrap">
                            <div class="comment-wrap-title">
                                @if($commentCount == 0)

                                @else
                                <h4 class="title">{{$commentCount}} Bình luận</h4>

                                @endif
                            </div>
                            <div class="latest-comments">
                                <ul class="list-wrap">
                                    @forelse($post->comment as $item)
                                    <li>
                                        <div class="comments-box row" style="margin: 0px !important;">
                                            <div class="comments-avatar col-12 col-md-3">
{{--                                                <img src="{{ asset('/storage/frontendNew')}}/assets/img/blog/comment01.png" alt="img">--}}
                                                @if(!empty(Illuminate\Support\Facades\Auth::guard('web')->user()) && !empty(Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_file_path))
                                                    <img
                                                        src="{{asset('storage/uploads') . '/' . Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_file_path ?? ''}}"
                                                        style="padding: 0px; display: block; width: 50px; height: 50px; object-fit: cover; border-radius: 50%;border: 1px solid #ccc; cursor: pointer"
                                                        alt="img">
                                                @else
                                                    <div class="bg-black" style=" cursor: pointer; width: 50px; height: 50px; border-radius: 50%; border: 1px solid #eee; display: flex; align-items: center; justify-content: center;">
                                                        <span class="text-white font_weight_bold" style="">{{ Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_name ?? '' }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="comments-text col-12 col-md-9">
                                                <div class="avatar-name">
                                                    <h6 class="name">{{$item->user->fullname ?? ''}}</h6>
                                                    <span class="date">{{date_format($item->created_at, 'd/m/Y H:i:s')}}</span>
                                                </div>
                                                <p>{{$item->content ?? ''}} </p>
                                            </div>
                                        </div>
                                    </li>
                                    @empty

                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        <div class="comment-respond">
                            <h4 class="comment-reply-title">Bình luận</h4>
                            <form action="{{route('frontend.blogExpert.comment', $post->id)}}" class="comment-form" method="POST">
                                @csrf
                                <p class="comment-notes">
{{--                                    <span>Your email address will not be published. Required fields are marked *</span>--}}
                                </p>
                                <div class="comment-field">
                                    <textarea name="content" placeholder="Chia sẽ ý kiến của bạn...">{{old('content')}}</textarea>
                                    @if ($errors->has('content'))
                                        <div class="custom_error">{{ $errors->first('content') }}</div>
                                    @endif
                                </div>
                                <p class="form-submit"></p>



{{--                                    <button class="btn btn-two arrow-btn btn_custom">--}}
{{--                                        --}}
{{--                                        --}}
{{--                                    </button>--}}

                                <button class="categories_button">
{{--                                    <a href="{{route('frontend.news.main')}}" class=" font_weight_bold">--}}
{{--                                         </a>--}}
                                    <span class="categories_link">GỬI</span>
                                </button>



                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <aside class="blog-sidebar">
                        @include('frontend.blogExpert.sidebar')
                        <div class="blog-widget">
                            <h4 class="widget-title">Bài viết Liên quan</h4>
                            @forelse($relative_post as $item)
                            <div class="rc-post-item">
                                <div class="rc-post-thumb">
                                    <a href="{{route('frontend.blogExpert.detail', $item->slug)}}">
                                        <img src="{{$item->thumbnail ? $item->thumbnail->file_src : ''}}" alt="img">
                                    </a>
                                </div>
                                <div class="rc-post-content">
                                    <span class="date"><i class="flaticon-calendar"></i> {{format_date_custom($item->created_at)}} </span>
                                    <h4 class="title"><a href="{{route('frontend.blogExpert.detail' , $item->slug)}}">{{$item->name ?? ''}}</a></h4>
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

    <script>
        function shareOnFacebook(url, imageUrl) {
            const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&picture=${encodeURIComponent(imageUrl)}`;
            window.open(shareUrl, 'facebook-share-dialog', 'width=800,height=600');
        }

        function shareOnTwitter(url, imageUrl) {
            const text = 'Check out this article!';
            const shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
            window.open(shareUrl, 'twitter-share-dialog', 'width=800,height=600');
        }

        function shareOnLinkedIn(url, imageUrl) {
            const shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(url)}&source=${encodeURIComponent(imageUrl)}`;
            window.open(shareUrl, 'linkedin-share-dialog', 'width=800,height=600');
        }

        function shareOnPinterest(url, imageUrl) {
            const description = 'Check out this article!';
            const shareUrl = `https://pinterest.com/pin/create/button/?url=${encodeURIComponent(url)}&media=${encodeURIComponent(imageUrl)}&description=${encodeURIComponent(description)}`;
            window.open(shareUrl, 'pinterest-share-dialog', 'width=800,height=600');
        }

    </script>

@endsection
