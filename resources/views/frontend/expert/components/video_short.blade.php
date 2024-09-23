

@if(isset($videoShort) && $videoShort->count() >= 1)
    <div class="my-4 col-12">
        <p class="title d-flex align-items-center text-black"
           style="font-size: 24px; font-weight: 600">
            <img class="me-2"
                 src="https://cdn-icons-png.flaticon.com/128/318/318275.png" width="25px"
                 height="25px"
                 alt=""> Video ngắn</p>
        <div class="video_youtubeShort_slider">
            @forelse($videoShort as $item)
                @php
                    // Lấy URL gốc từ $item->link
                                             $url = $item->link ?? '';
                                             // Khởi tạo URL nhúng rỗng
                                             $embedUrl = '';
                                             // Kiểm tra nếu URL chứa "youtube.com/shorts/"
                                             if (strpos($url, 'youtube.com/shorts/') !== false) {
                                                 // Trích xuất video ID từ URL
                                                 $urlParts = explode('/', $url);
                                                 $videoId = end($urlParts);
                                                 $videoId = explode('?', $videoId)[0]; // Loại bỏ các tham số query string nếu có
                                                 $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                             } else {
                                                 // Nếu không phải YouTube Shorts, sử dụng URL ban đầu
                                                 $embedUrl = $url;
                                             }
                @endphp
                @if($item->type == 2)
                    <div class="" style="width:350px; height: 400px; overflow: hidden; border-radius: 10px; position: relative; margin: 0px 10px">
                        <iframe
                            src="{{ $embedUrl }}"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                            frameborder="0"
                            allowfullscreen>
                        </iframe>
                    </div>
                @endif
            @empty
            @endif
        </div>
    </div>
@else
@endif
