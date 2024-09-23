@if(isset($videoTiktok) && $videoTiktok->count() >= 1)
    <div class="my-4 col-12">
        <p class="title d-flex align-items-center text-black"
           style="font-size: 24px; font-weight: 600">
            <img class="me-2"
                 src="https://cdn-icons-png.flaticon.com/128/318/318275.png" width="25px"
                 height="25px"
                 alt=""> Video TikTok</p>
        <div class="video_tiktok_slider">
            @forelse($videoTiktok as $item)
                @php
                    // Lấy URL gốc từ $item->link
                    $urlTiktok = $item->link ?? '';
                    // Khởi tạo URL nhúng rỗng
                    $embedUrlTiktok = '';

                    // Kiểm tra nếu URL chứa "tiktok.com/@"
                    if (strpos($urlTiktok, 'tiktok.com/@') !== false) {
                        // Trích xuất video ID từ URL
                        $urlPartsTiktok = explode('/', $urlTiktok);
                        $videoIdTiktok = end($urlPartsTiktok);
                        $videoIdTiktok = explode('?', $videoIdTiktok)[0]; // Loại bỏ các tham số query string nếu có
                        $embedUrlTiktok = 'https://www.tiktok.com/embed/' . $videoIdTiktok;
                    } else {
                        // Nếu không phải URL TikTok, sử dụng URL ban đầu
                        $embedUrlTiktok = $urlTiktok;
                    }
                @endphp
{{--                <div class="video_youtube_custom">--}}

{{--                    {!! $urlTiktok ?? '' !!}--}}

{{--                </div>--}}
                <div style="width:350px; height: 400px; overflow: hidden; border-radius: 10px; position: relative;">
                    <iframe
                        src="{{ $embedUrlTiktok }}"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>
                </div>
            @empty

            @endforelse
        </div>


    </div>
@else

@endif
