@if(isset($videoFacebook) && $videoFacebook->count() >= 1)
    <div class="my-4 col-12">
        <p class="title d-flex align-items-center text-black"
           style="font-size: 24px; font-weight: 600">
            <img class="me-2"
                 src="https://cdn-icons-png.flaticon.com/128/318/318275.png" width="25px"
                 height="25px"
                 alt=""> Video Facebook </p>
        <div class="video_youtubeShort_slider">
            @foreach($videoFacebook as $item)
                <div class=""
                     style="width:350px; height: 400px; overflow: hidden; border-radius: 10px; position: relative; margin: 0px 10px">
                    <iframe
                        src="https://www.facebook.com/plugins/video.php?href={{$item->link ?? ''}}"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>
                </div>
            @endforeach
        </div>
    </div>

@endif
