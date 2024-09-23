<style>
    .topic_title {
        font-size: 24px;
        font-weight: 600;
        color: #000;
    }
    .topic_text {
        font-size: 20px;
        font-weight: bold;
        color: #2568EF;
        text-decoration: underline;
    }
    .topic_desc {
        font-size: 18px;
        font-weight: 400;
        color: #000;
    }
</style>


<div class="" style="margin-top: 100px; background-color: #F1F2F3">
    <div class="container-fluid py-4">
    <h2 class="bold custom_line_2 text-center" style="font-size: 30px"><span class="title_rgba">CHỦ ĐỀ NỔI BẬT </span> theo thể loại</h2>
    <div class="row" style="padding: 30px 100px">


    @foreach($expertCategoryTopic as $item)
        <div class="col-12 col-md-6 col-lg-3">
            <span class="topic_title" style="font-size: 18px">{{$item->name ?? ''}}</span>
            @foreach($item->tags->take(4) as $tag)
                <form action="{{ route('frontend.product.main') }}" method="get">
                    <div class="my-3">
                        <a href="{{route('frontend.product.main')}}" name="tags[]" class="m-0 topic_text" style="font-size: 15px">{{$tag->name ?? ''}}</a>
                    </div>
                </form>

            @endforeach
        </div>
        @endforeach
{{--        <div class="col-12 col-md-6 col-lg-3">--}}
{{--            <span class="topic_title">BUSINESS</span>--}}
{{--            <div class="my-3">--}}
{{--                <p class="m-0 topic_text">Financial Analysis</p>--}}
{{--            </div>--}}
{{--            <div class="my-3">--}}
{{--                <p class="m-0 topic_text">SQL</p>--}}
{{--            </div>--}}
{{--            <div class="my-3">--}}
{{--                <p class="m-0 topic_text">PMP</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-12 col-md-6 col-lg-3">--}}
{{--            <span class="topic_title">IT and Software</span>--}}
{{--            <div class="my-3">--}}
{{--                <p class="m-0 topic_text">Amazon AWS</p>--}}
{{--            </div>--}}
{{--            <div class="my-3">--}}
{{--                <p class="m-0 topic_text">Ethical Hacking</p>--}}
{{--            </div>--}}
{{--            <div class="my-3">--}}
{{--                <p class="m-0 topic_text">Cyber Security</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-12 col-md-6 col-lg-3">--}}
{{--            <span class="topic_title">Design</span>--}}
{{--            <div class="my-3">--}}
{{--                <p class="m-0 topic_text">UI UX Design</p>--}}
{{--            </div>--}}
{{--            <div class="my-3">--}}
{{--                <p class="m-0 topic_text">Graphic Design</p>--}}
{{--            </div>--}}
{{--            <div class="my-3">--}}
{{--                <p class="m-0 topic_text">Digital Painting</p>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7">
                <div class="section__title text-center mb-10">
                    <a href="{{route('frontend.product.main')}}" class="categories_link font_weight_bold categories_button py-2" style="border: 1px solid #000">TẤT CẢ CHỦ ĐỀ</a>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="p-4">
    <div class="container">
        <div class="row align-items-center justify-content-center" style="margin-top: 100px">
            <div class="col-12 col-lg-6 col-md-6 ">
                <div class="choose__img-three m-0" style="width: 100%; height: 100%">
                    <img
                        src="{{$groupNeztWork->file_src ?? ''}}"
                        alt="img" style="width: 100%; height: 100%; border-radius: 20px; object-fit: contain">
                </div>
            </div>
            <div class="col-12 col-lg-6 col-md-6 mt-2 mt-lg-0">
                <div class="choose__content-three " style="margin-left: 30px">
                    <div class="section__title mb-15 mt-1 text-center text-lg-start">
                        <h2 class="bold custom_line_2" style="font-size: 30px"><span
                                class="title_rgba">{{$groupNeztWork->title_color ?? ''}}</span> {{$groupNeztWork->title ?? ''}}</h2>
                    </div>
                    <p class="text-black mt-1 mb-1" style="font-size: 18px">{{$groupNeztWork->desc ?? ''}}</p>
                    <div class="text-center text-lg-start mt-3">
                        <a href="{{route('frontend.page.neztwork_team')}}"
                           class="btn arrow-btn btn-four categories_button">XEM NGAY
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{--        //--}}
        <div class="row align-items-center justify-content-center flex-row-reverse" style="margin-top: 100px">
            <div class="col-12 col-lg-6 col-md-6 ">
                <div class="choose__img-three m-0" style="width: 100%; height: 100%">
                    <img
                        src="{{$aiNeztWork->file_src ?? ''}}"
                        alt="img" style="width: 100%; height: 100%; border-radius: 20px; object-fit: contain">
                </div>
            </div>
            <div class="col-12 col-lg-6 col-md-6 mt-2 mt-lg-0">
                <div class="choose__content-three">
                    <div class="section__title mb-15 mt-1 text-center text-lg-start">
                        <h2 class="bold custom_line_2" style="font-size: 30px"><span
                                class="title_rgba">{{$aiNeztWork->title_color ?? ''}}</span> {{$aiNeztWork->title ?? ''}}</h2>
                    </div>
                    <p class="text-black mt-1 mb-1" style="font-size: 18px">{{$aiNeztWork->desc ?? ''}}</p>
                    <div class="text-center text-lg-start mt-3">
                        <a href="{{route('frontend.page.ai')}}"
                           class="btn arrow-btn btn-four categories_button">XEM NGAY
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
