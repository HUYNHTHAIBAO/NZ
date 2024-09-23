@if(isset($videoIntagram) && $videoIntagram->count() >= 1)
    <div class="my-4 col-12">
        <p class="title d-flex align-items-center text-black"
           style="font-size: 24px; font-weight: 600">
            <img class="me-2"
                 src="https://cdn-icons-png.flaticon.com/128/318/318275.png" width="25px"
                 height="25px"
                 alt=""> Video Intagram </p>
        <div class="video_youtubeShort_slider">
            @foreach($videoIntagram as $item)
                <div class=""
                     style="width:350px; height: 400px; overflow: hidden; border-radius: 10px; position: relative; margin: 0px 10px">
                    {!! $item->link !!}
                </div>
            @endforeach
        </div>
    </div>

@endif
