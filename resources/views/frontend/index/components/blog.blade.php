@if(isset($news) && $news->count() >= 1)
<section class="px-4" style="padding: 50px 0px; margin: 50px 0px; background-color: #ffffff">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7">
                <div class="section__title text-center">
                    <h2 class="categories_title">
                        <span class="title_rgba">TIN TỨC VÀ BÀI VIẾT</span> <br> của NeztWork
                    </h2>

                        <a href="{{route('frontend.news.main')}}" class="categories_link font_weight_bold categories_button py-2" style="border: 1px solid #000">TẤT CẢ
                            TIN TỨC VÀ BÀI VIẾT </a>
                </div>
            </div>
        </div>

        <div class="row blog_slider" style="margin-top: 60px">
            @forelse($news as $item)
                <div class="col-xl-3 col-md-6 p-2 d-flex" style="width: 100%;">
                    <div class="shine__animate-item d-flex flex-column" style="width: 100%; background-color: #f6f6f6; border-radius: 10px; border: 1px solid #ccc">
                        <div class="blog__post-thumb mb-1">
                            <a href="{{$item->post_link()}}" class="d-block text-center">
                                <img src="{{$item->thumbnail ? $item->thumbnail->file_src : ''}}" class="blog_img" alt="{{str_slug($item->name ?? '')}}" style="width: 100%; height: 248px; border-radius: 10px 10px 0 0; object-position: top ">
                            </a>
                            <span class="post-tag">{{$item->category->name ?? ''}}</span>
                        </div>
                        <div class="blog__post-content mt-3 p-2 d-flex flex-column flex-grow-1">
                            <h4 class="custom_line_2" style="height: 55px; font-size: 20px; font-weight: bold;">
                                <a href="{{$item->post_link()}}">{{$item->name ?? ''}}</a>
                            </h4>
                            <p class="custom_line_2" style="font-size: 12px; color: #000; height: 40px">
                                {{ $item->excerpt ?? '' }}
                            </p>
                            <div class="blog__post-meta mt-auto">
                                <ul class="list-wrap">
                                    <li class="d-flex align-items-center"><img class="me-2" src="{{asset('storage/frontendNew')}}/assets/img/calendar.png"
                                             style="width: 25px; height: 25px;" alt="">{{format_date_custom($item->created_at)}}</li>
                                    <li class="d-flex align-items-center"><img class="me-2" src="{{asset('storage/frontendNew')}}/assets/img/user.png"
                                             style="width: 25px; height: 25px;" alt=""><span>Admin</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @empty

            @endforelse
        </div>

    </div>
</section>
@else

@endif
