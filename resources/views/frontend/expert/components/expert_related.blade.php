@if(isset($expertRelated) && $expertRelated->count() >= 1)
    <div class="my-4 col-12">
        <p class="title d-flex align-items-center text-black"
           style="font-size: 24px; font-weight: 600">
            <img class="me-2"
                 src="https://cdn-icons-png.flaticon.com/128/318/318275.png" width="25px"
                 height="25px"
                 alt="">Chuyên gia tương tự</p>
        <div class="top_expert_slider">
            @forelse($expertRelated as $item)
                <div class="top_expert__items" style="width: 316px; height: 548px;">
                    <div class="shine__animate-item"
                         style="background-color: #f6f6f6; border-radius: 10px; overflow: hidden;border: 1px solid #eee">
                        <div class="courses__item-thumb m-0" style="border-radius: 10px;">
                            <a href="/chuyen-gia/{{ str_replace(' ', '', $item->fullname) }}.{{$item->id}}"
                               class="shine__animate-link">
                                @if($item->avatar_file_path)
                                    <img
                                        src="{{ asset('storage/uploads') . '/' . ($item->avatar_file_path ?? '') }}"
                                        alt="img"
                                        style="width: 100%; height: 360px; object-position: top;">
                                @else
                                    <div
                                        class="bg-black d-flex align-items-center justify-content-center"
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
                                <div
                                    class="author font_weight_bold m-0 d-flex align-items-center my-1">
                                    <a class="text-black"
                                       href="/chuyen-gia/{{ str_replace(' ', '', $item->fullname) }}.{{$item->id}}"
                                       style="font-size: 20px; font-weight: 600">
                                        {{ $item->fullname ?? '' }}
                                    </a>
                                </div>
                            </div>
                            <p class="category_expert_img mb-1 ">
                                <button type="submit"
                                        class="register_btn d-flex align-items-center justify-content-center"
                                        style="padding: 2px 10px">
                                    <small
                                        class="custom_line_1">{{ $item->categoryExpert[0]['name'] ?? '' }}</small>
                                </button>
                            </p>
                            <div class="d-flex align-items-center">
                                <img class="me-2"
                                     src="https://cdn-icons-png.flaticon.com/128/616/616489.png"
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
@else

@endif
