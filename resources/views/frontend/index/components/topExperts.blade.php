@if(isset($topExpert) && $topExpert->count() >= 1)
    <section class="courses-area p-0" style="margin-top: 50px">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-7">
                    <div class="section__title text-center mb-40">
                        <h2 class="categories_title"><span class="title_rgba">TOP CHUYÊN GIA</span> của NeztWork</h2>
                    </div>
                </div>
            </div>
            <div class="container-fluid top_expert_wrap_slider">
                <div class="top_expert_slider">
                    @forelse($topExpert as $item)
                        <div class="top_expert__items" style="width: 316px; height: 548px;">
                            <div class="shine__animate-item"
                                 style="border-radius: 10px; overflow: hidden">
                                <div class="courses__item-thumb m-0" style="border-radius: 10px;">
                                    <a href="/chuyen-gia/{{ str_replace(' ', '', $item->fullname) }}.{{$item->id}}"
                                       class="shine__animate-link">
                                        @if($item->avatar_file_path)
                                            <img
                                                src="{{ asset('storage/uploads') . '/' . ($item->avatar_file_path ?? '') }}"
                                                alt="{{str_slug($item->fullname)}}"
                                                style="width: 100%; height: 360px; object-position: top;" class="topExpert_img">
                                        @else
                                            <div class="bg-black d-flex align-items-center justify-content-center"
                                                 style="width: 100%; height: 360px">
                                                <span class="text-white font_weight_bold"
                                                      style="font-size: 40px; font-weight: bold">{{ $item->avatar_name ?? '' }}</span>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="courses__item-content p-2">
                                    <div class="d-flex align-items-center">
                                        <img class="me-2"
                                             src="https://cdn-icons-png.flaticon.com/128/10629/10629607.png"
                                             style="width: 25px; height: 25px;" alt="">
                                        <div class="author font_weight_bold m-0 d-flex align-items-center my-1">
                                            <a class="text-black"
                                               href="/chuyen-gia/{{ str_replace(' ', '', $item->fullname) }}.{{$item->id}}"
                                               style="font-size: 20px; font-weight: 600">
                                                {{ $item->fullname ?? '' }}
                                            </a>
                                        </div>
                                    </div>
                                    <p class="category_expert_img mb-1 ">
{{--                                        <button type="submit"--}}
{{--                                                class="register_btn d-flex align-items-center justify-content-center"--}}
{{--                                                style="padding: 2px 10px">--}}
{{--                                            <small class="custom_line_1">{{ $item->categoryExpert[0]['name'] ?? '' }}</small></button>--}}


                                    <form action="{{ route('frontend.product.main') }}" method="get" class="m-0">
                                        <input type="hidden" name="category_id_expert"
                                               value="{{$item->categoryExpert[0]['id'] ?? ''}}">
                                        <button type="submit"
                                                class="register_btn d-flex align-items-center justify-content-center"
                                                style="padding: 2px 10px">
                                            <small class="custom_line_1">{{ $item->categoryExpert[0]['name'] ?? '' }}</small></button>
                                    </form>

                                    </p>
                                    <div class="d-flex align-items-center">
                                        <img class="me-2" src="https://cdn-icons-png.flaticon.com/128/616/616489.png"
                                             style="width: 25px; height: 25px;" alt="">
                                        <small class="font_weight_bold"
                                               style="font-size: 16px; font-weight: 400; color: #000">5.0</small>
                                    </div>
                                    <div class="my-1">
                                        @if($item->bio)
                                            <p class="custom_line_2"
                                               style="font-size: 12px; color: #000; height: 40px">
                                                {{$item->bio}}
                                            </p>
                                        @else
                                            <p class="custom_line_2">

                                            </p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty

                    @endforelse
                </div>

            </div>

            <div class="row justify-content-center mt-3">
                <div class="col-xl-5 col-lg-7">
                    <div class="section__title text-center">
                            <a href="{{route('frontend.product.main')}}" class="categories_link font_weight_bold categories_button py-2" style="border: 1px solid #000">TẤT CẢ
                                CHUYÊN GIA </a>

                    </div>
                </div>
            </div>

        </div>
    </section>
@else

@endif
