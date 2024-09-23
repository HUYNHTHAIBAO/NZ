<section class="choose__area-three" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-7">
            <div class="section__title text-center mb-40">
                <h2 class="categories_title">
                    <span class="title_rgba">BẢNG TIN</span> của chuyên gia NeztWork
                </h2>
                    <a href="{{route('frontend.blogExpert.main')}}" class="categories_link font_weight_bold categories_button py-2" style="border: 1px solid #000">TẤT CẢ
                        BẢNG TIN </a>
            </div>
        </div>
    </div>

    @if(isset($postExpertOne) && $postExpertOne->count() >= 1)
        <div class="container" >
            @forelse($postExpertOne->take(1) as $item)
                <div class="row align-items-center justify-content-center mt-5">
                    <div class="col-lg-6 col-md-10 ">
                        <div class="choose__img-three m-0">
                            <img src="{{$item->thumbnail ? $item->thumbnail->file_src : ''}}" alt="img" style="width: 100%; height: 400px; object-fit: cover; border-radius: 20px">
                        </div>
                    </div>
                    <div class="col-lg-6 mt-2 mt-lg-0">
                        <div class="choose__content-three">
                            <div class="section__title mb-15 mt-1 text-center text-lg-start">
                                <h4 class=" custom_line_2" style="font-size: 22px; font-weight: 550">{{$item->name ?? ''}}</h4>
                            </div>
                            <p class="text-black mt-1 mb-1" style="font-size: 18px">{{$item->excerpt ?? ''}}</p>
                            <div class="text-center text-lg-start mt-3">
                            <a href="{{route('frontend.blogExpert.detail', $item->slug)}}"
                               class="btn arrow-btn btn-four categories_button">XEM NGAY
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty

            @endforelse
        </div>
    @else

    @endif


    @if(isset($postExpertTwo) && $postExpertTwo->count() >= 1)

        <section class="choose__area-four tg-motion-effects mt-5">
            <div class="container">
                @forelse($postExpertTwo->take(1) as $item)
                    <div class="row align-items-center justify-content-center flex-row-reverse">
                        <div class="col-lg-6 col-md-10">
                            <div class="choose__img-four m-0">
                                <div class="">
                                    <img src="{{$item->thumbnail ? $item->thumbnail->file_src : ''}}" alt="img"
                                         data-aos="fade-down" data-aos-delay="200" class="aos-init aos-animate" style="width: 100%; height: 400px; object-fit: cover; border-radius: 20px">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2 mt-lg-0">
                            <div class="choose__content-four">
                                <div class="section__title mb-15 mt-1 text-center text-lg-start">
                                    <h4 class="bold custom_line_2" style="font-size: 22px; font-weight: 550">{{$item->name ?? ''}}</h4>
                                </div>
                                <p class="text-black mt-1 mb-1" style="font-size: 18px">{{$item->excerpt ?? ''}}</p>
                                <div class="text-center text-lg-start mt-3">
                                    <a href="{{route('frontend.blogExpert.detail', $item->slug)}}"
                                       class="btn arrow-btn btn-four categories_button  ">XEM NGAY
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse
            </div>
        </section>
    @else

    @endif


    @if(isset($postExpertThree) && $postExpertThree->count() >= 1)
        <section class="choose__area-four tg-motion-effects mt-5">
            <div class="container">
                @forelse($postExpertThree->take(1) as $item)
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-6 col-md-10">
                            <div class="choose__img-four m-0">
                                <div class="">
                                    <img src="{{$item->thumbnail ? $item->thumbnail->file_src : ''}}" alt="img"
                                         data-aos="fade-down" data-aos-delay="200" class="aos-init aos-animate" style="width: 100%; height: 400px; object-fit: cover; border-radius: 20px">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2 mt-lg-0">
                            <div class="choose__content-four">
                                <div class="section__title mb-15 mt-1 text-center text-lg-start">
                                    <h4 class="bold custom_line_2" style="font-size: 28px; font-weight: 550">{{$item->name ?? ''}}</h4>
                                </div>
                                <p class="text-black mt-1 mb-1" style="font-size: 18px">{{$item->excerpt ?? ''}}</p>
                                <div class="text-center text-lg-start mt-3">
                                    <a href="{{route('frontend.blogExpert.detail', $item->slug)}}"
                                       class="btn arrow-btn btn-four categories_button  ">XEM NGAY
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse
            </div>
        </section>
    @else

    @endif


</section>
