
@if(isset($banners) && $banners->count() >= 1)
<div class="container-fluid" style="margin-top: 35px">
    <div class="banner" >
        @forelse($banners as $key => $item)
            <div class="banner_item">
                <section class="">
                    <a href="{{$item->url ?? ''}}">
                        <div class="banner_image_bg">
                            <img
                                src="{{$item->file_src ?? ''}}"
                                alt="" style="border-radius: 10px">
                            <div class="container banner_content">
                                <div class="row justify-content-between align-items-start ">
                                    <div class="col-xl-5 col-lg-6 bg-white  m-2 m-lg-5 rounded shadow-lg banner_size"
                                         style="">
                                        {{--                                        @if(isset($item->title ))--}}
                                        {{--                                        <div class="banner__content ">--}}
                                        {{--                                            <h3 class="title tg-svg aos-init aos-animate font-weight-bold banner_title custom_line_1"--}}
                                        {{--                                                data-aos="fade-right" data-aos-delay="400">--}}
                                        {{--                                               {{$item->title ?? ''}}--}}
                                        {{--                                            </h3>--}}
                                        {{--                                            <p data-aos="fade-right" data-aos-delay="600"--}}
                                        {{--                                               class="aos-init aos-animate banner_desc custom_line_2"> {{$item->description ?? ''}} </p>--}}
                                        {{--                                            <div class="banner__btn-wrap aos-init aos-animate banner_btn"--}}
                                        {{--                                                 data-aos="fade-right" data-aos-delay="800">--}}
                                        {{--                                                <a href="{{$item->url ?? ''}}" class="btn arrow-btn banner_link">Xem thêm <img--}}
                                        {{--                                                        src="{{ asset('/storage/frontendNew')}}/assets/img/icons/right_arrow.svg"--}}
                                        {{--                                                        alt="img" class="injectable icon_banner_link"></a>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        @endif--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </section>
            </div>
        @empty

        @endforelse
    </div>
</div>
@else

@endif


