<style>
    .category_images {
        position: relative;
        width: 200px;
        height: 240px;
        border-radius: 10px;
        overflow: hidden;
    }


    .categories_item_content {
        width: calc(100% - 20px);
        padding: 5px 10px;
        background-color: #fff;
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 5px;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

</style>
@if(isset($expertCategory) && $expertCategory->count() >= 1)
    <section class="categories-area" style="margin-top: 100px">
        <div class="">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-7">
                    <div class="section__title text-center mb-10">
                        {{--                        <span class="sub-title">Danh mục</span>--}}
                        <h3 class="categories_title" style="">Bạn muốn <span class="title_rgba">TÌM KIẾM</span> gì?
                        </h3>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="container-fluid border_radius  categories_wrap_slider">
                        <div class="categories_slider">
                            @forelse($expertCategory as $key => $item)
                                <div class="categories_item d-flex align-items-center justify-content-center flex-column">
                                    <form action="{{ route('frontend.product.main') }}" method="get">
                                        <input type="hidden" name="category_id_expert" value="{{ $item->id }}">
                                        <button type="submit" style="border-radius: 5px; padding: 0px; background: #fff; border: none; color: #000;">
                                            <div class="category_images">
                                                <img class="category_image category_image_front" src="{{ $item->file_src ?? '' }}" alt="">
                                                <img class="category_image category_image_back" src="{{ $item->file_src_after ?? '' }}" alt="">
                                                <div class="categories_item_content">
                                                    <span class="text-center" style="font-weight: 500">{{ $item->name ?? '' }}</span>
                                                </div>
                                            </div>
                                        </button>
                                    </form>

                                </div>


                            @empty

                            @endforelse

                        </div>

                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-7">
                    <div class="section__title text-center mb-10">
                        <a href="{{route('frontend.product.main')}}" class="categories_link font_weight_bold categories_button py-2" style="border: 1px solid #000">TẤT CẢ DANH MỤC</a>
                    </div>
                </div>
            </div>

        </div>
    </section>
@else

@endif
