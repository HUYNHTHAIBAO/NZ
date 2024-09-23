@extends('frontend.layouts.frontend')

@section('content')
    <style>
        .category_images {
            position: relative;
            width: 200px;
            height: 240px;
            border-radius: 10px;
            overflow: hidden;

        }


        .category_images_close {
            filter: grayscale(1);
        }

        .active_category {
            filter: unset;
        }


        .active_category {
            /*width: 240px;*/
            /*height: 300px;*/
            /*box-shadow: 5px 5px 5px 5px #eee;*/
            /*padding-bottom: 10px;*/
            /*border-bottom: 5px solid #000;*/
            /*filter: unset;*/
            border: 5px solid #228585;
            /*padding: 5px;*/
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


        .form-check-input:checked + .form-check-label .tag-span {
            border: 5px solid #00aefd;
            background-color: #eee; /* Optional: add background color for better visibility */
        }

        .tag-span {
            cursor: pointer;
            transition: border 0.3s, background-color 0.3s;
            position: relative;
            padding-right: 30px; /* Ensure space for the icon */
        }

        .tag-span.active::after {
            content: '\f057'; /* Font Awesome Unicode for fa-circle-xmark */
            font-family: 'Font Awesome 5 Free'; /* Ensure Font Awesome is loaded */
            font-weight: 900; /* Solid icons weight */
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 20px;
        }
    </style>


    <section class="all-courses-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="categories">
                        @if(isset($expertCategory) && $expertCategory->count() >= 1)
                            <section class="categories-area" style="margin-top: 50px">
                                <div class="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="container-fluid border_radius  categories_wrap_slider">
                                                <div class="categories_slider_product">
                                                    @php
                                                        $activeCategoryId = request('category_id_expert'); // Lấy giá trị từ URL
                                                    @endphp
                                                    @php
                                                        $activeCategoryId = request('category_id_expert');

                                                        if ($activeCategoryId) {
                                                            // Lọc ra danh mục active
                                                            $activeItem = $expertCategory->firstWhere('id', $activeCategoryId);

                                                            // Loại bỏ danh mục active từ collection
                                                            $expertCategory = $expertCategory->filter(function($item) use ($activeCategoryId) {
                                                                return $item->id != $activeCategoryId;
                                                            });

                                                            // Đưa danh mục active lên đầu
                                                            if ($activeItem) {
                                                                $expertCategory->prepend($activeItem);
                                                            }
                                                        }
                                                    @endphp

                                                    @forelse($expertCategory as $key => $item)
                                                        <div
                                                            class="categories_item d-flex align-items-center justify-content-center flex-column">
                                                            <form action="{{ route('frontend.product.main') }}"
                                                                  method="get" class="category-form">
                                                                <input type="hidden" name="category_id_expert"
                                                                       value="{{ $item->id }}">
                                                                <button type="submit" class="category-button"
                                                                        style="border-radius: 5px; padding: 0px; background: #fff; border: none; color: #000;">
                                                                    <div
                                                                        class="category_images {{ $item->id == $activeCategoryId ? 'active_category' : '' }}">
                                                                        <img class="category_image category_image_front"
                                                                             src="{{ $item->file_src ?? '' }}" alt="">
                                                                        <img class="category_image category_image_back"
                                                                             src="{{ $item->file_src_after ?? '' }}"
                                                                             alt="">
                                                                        <div class="categories_item_content">
                                                                            <span class="text-center"
                                                                                  style="font-weight: 500">{{ $item->name ?? '' }}</span>
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
                                </div>
                            </section>
                        @else

                        @endif
                    </div>

                </div>
            </div>
        </div>
        <div class="mx-5">
            <div class="row">
                <div class="col-12">
                    <div class="section__title mb-10 d-flex align-items-center justify-content-between row">
                        <div class="col-6">
                            @if($activeCategoryName)
                                <p class="categories_title text-black" style="font-size: 30px; font-weight: bold">
                                    Các chuyên gia ở mục <span class="title_rgba">{{ $activeCategoryName }}</span>
                                </p>
                            @else
                                <p class="categories_title text-black" style="font-size: 30px; font-weight: bold">
                                    Tất cả chuyên gia của <span class="title_rgba">NeztWork</span>
                                </p>
                            @endif
                        </div>

                        <div class="col-4">
                            <form id="price-filter-form" action="{{ route('frontend.product.main') }}" method="get" class="d-flex align-items-center">
                                <select id="price-filter" name="price_filter" class="form-select" aria-label="Default select example" style="border-radius: 20px; cursor: pointer;">
                                    <option value="" disabled>-- Lọc giá --</option>
                                    <option value="all" {{ request('price_filter') == 'all' ? 'selected' : '' }}>Tất cả</option>
                                    <option value="desc" {{ request('price_filter') == 'desc' ? 'selected' : '' }}>Cao -> thấp</option>
                                    <option value="asc" {{ request('price_filter') == 'asc' ? 'selected' : '' }}>Thấp -> cao</option>
                                    <option value="below_2" {{ request('price_filter') == 'below_2' ? 'selected' : '' }}>Dưới 2 triệu</option>
                                    <option value="2_4" {{ request('price_filter') == '2_4' ? 'selected' : '' }}>Từ 2 - 4 triệu</option>
                                    <option value="4_7" {{ request('price_filter') == '4_7' ? 'selected' : '' }}>Từ 4 - 7 triệu</option>
                                    <option value="7_13" {{ request('price_filter') == '7_13' ? 'selected' : '' }}>Từ 7 - 13 triệu</option>
                                    <option value="above_15" {{ request('price_filter') == 'above_15' ? 'selected' : '' }}>Trên 15 triệu</option>
                                </select>
                                <div class="col-6">
                                    <button type="submit" class="categories_link categories_button ms-2 mt-">Xem kết quả</button>
                                </div>
                            </form>
                        </div>

                        <div class="category_tags d-flex">
                        @if($tags->isNotEmpty())
                            <form id="tags-form" action="{{ route('frontend.product.main') }}" method="get"
                                  class="d-flex flex-wrap">
                                <input type="hidden" name="category_id_expert" value="{{ $activeCategoryId }}">
                                <input type="hidden" id="price-filter-input" name="price_filter" value="">

                                @foreach($tags as $tag)
                                    <div class="form-check me-1 mb-2" style="padding-left: 2px;">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                               id="tag-{{ $tag->id }}"
                                               class="form-check-input visually-hidden"
                                               {{ request()->has('tags') && in_array($tag->id, request()->get('tags')) ? 'checked' : '' }} style=" border: 1px solid #6b6a6a !important;">
                                        <label for="tag-{{ $tag->id }}" class="form-check-label">
                        <span class="text-black rounded-pill border border-dark pe-4 ps-2 d-inline-block tag-span"
                              style="color: #6b6a6a !important; border: 1px solid #6b6a6a !important;">
                            {{ $tag->name }}
                        </span>
                                        </label>
                                    </div>
                                @endforeach
                            </form>
                        @endif
                    </div>

                </div>

            </div>


            <div class="row">
                @forelse($expert as $item)
                    <div class="col-12 col-md-6 col-lg-4 col-xl-2 mt-5">
                        <div class="shine__animate-item"
                             style="background-color: #f6f6f6; border-radius: 10px; overflow: hidden;border: 1px solid #eee">
                            <div class="courses__item-thumb m-0" style="border-radius: 10px;">
                                <a href="/chuyen-gia/{{ str_replace(' ', '', $item->fullname) }}.{{$item->id}}"
                                   class="shine__animate-link">
                                    @if($item->avatar_file_path)
                                        <img
                                            src="{{ asset('storage/uploads') . '/' . ($item->avatar_file_path ?? '') }}"
                                            alt="{{str_slug($item->fullname ?? '')}}"
                                            style="width: 100%; height: 200px; object-position: top;"
                                            class="category_expert_img">
                                    @else
                                        <div class="bg-black d-flex align-items-center justify-content-center"
                                             style="width: 100%; height: 200px">
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
                                           style="font-size: 16px; font-weight: 500">
                                            {{ $item->fullname ?? '' }}
                                        </a>
                                    </div>
                                </div>
                                <p class=" mb-1 ">
                                {{--                                    <button type="submit"--}}
                                {{--                                            class="register_btn d-flex align-items-center justify-content-center"--}}
                                {{--                                            style="padding: 2px 10px">--}}
                                {{--                                        <small--}}
                                {{--                                            class="custom_line_1">{{ $item->categoryExpert[0]['name'] ?? '' }}</small>--}}
                                {{--                                    </button>--}}

                                <form action="{{ route('frontend.product.main') }}" method="get" class="m-0">
                                    <input type="hidden" name="category_id_expert"
                                           value="{{$item->categoryExpert[0]['id'] ?? ''}}">
                                    <button type="submit"
                                            class="register_btn d-flex align-items-center justify-content-center"
                                            style="padding: 2px 10px">
                                        <small
                                            class="custom_line_1">{{ $item->categoryExpert[0]['name'] ?? '' }}</small>
                                    </button>
                                </form>

                                </p>
                                <div class="d-flex align-items-center">
                                    <img class="me-2" src="https://cdn-icons-png.flaticon.com/128/616/616489.png"
                                         style="width: 20px; height: 20px;" alt="rating">
                                    <small class="font_weight_bold"
                                           style="font-size: 16px; font-weight: 400; color: #000">5.0</small>
                                </div>
                                <div class="my-1">
                                    @if($item->bio)
                                        <p class="custom_line_2 m-0"
                                           style="font-size: 12px; color: #000; height: 40px">
                                            {{$item->bio}}
                                        </p>
                                    @else
                                        <p class="custom_line_2 m-0">

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
    </section>

    <script>
        document.querySelectorAll('#tags-form input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                document.getElementById('tags-form').submit();
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.form-check-input');

            checkboxes.forEach(checkbox => {
                const label = checkbox.nextElementSibling;
                const span = label.querySelector('.tag-span');

                // Apply active state based on the checkbox's checked attribute
                if (checkbox.checked) {
                    span.classList.add('active');
                } else {
                    span.classList.remove('active');
                }

                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        span.classList.add('active');
                    } else {
                        span.classList.remove('active');
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const categoryForms = document.querySelectorAll('.category-form');
            const activeCategoryId = localStorage.getItem('activeCategoryId'); // Lấy ID danh mục từ localStorage

            // Kiểm tra nếu có activeCategoryId trong localStorage thì gán lớp 'active_category' cho danh mục tương ứng
            if (activeCategoryId) {
                const activeImageDiv = document.querySelector(`input[value="${activeCategoryId}"]`).closest('.category_images');
                activeImageDiv.classList.add('active_category');
                activeImageDiv.classList.remove('category_images_close');
            }

            categoryForms.forEach(function (form) {
                form.addEventListener('click', function (event) {
                    event.preventDefault(); // Ngăn chặn form submit ngay lập tức

                    // Xóa lớp 'active_category' và thêm 'category_images_close' cho tất cả các hình
                    document.querySelectorAll('.category_images').forEach(function (imageDiv) {
                        imageDiv.classList.remove('active_category');
                        imageDiv.classList.add('category_images_close');
                    });

                    // Thêm lớp 'active_category' cho hình vừa được click và xóa 'category_images_close'
                    const clickedImageDiv = form.querySelector('.category_images');
                    clickedImageDiv.classList.add('active_category');
                    clickedImageDiv.classList.remove('category_images_close');

                    // Lưu ID của danh mục vừa click vào localStorage
                    const selectedCategoryId = form.querySelector('input[name="category_id_expert"]').value;
                    localStorage.setItem('activeCategoryId', selectedCategoryId);

                    // Submit form sau khi xử lý
                    form.submit();
                });
            });
        });

        document.getElementById('price-filter-form').addEventListener('submit', function (event) {
            // Lấy giá trị của bộ lọc giá
            var selectedPrice = document.getElementById('price-filter').value;

            // Cập nhật giá trị vào input ẩn
            var priceFilterInput = document.getElementById('price-filter-input');
            if (priceFilterInput) {
                priceFilterInput.value = selectedPrice;
            }
        });


    </script>


@endsection
