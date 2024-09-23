<style>

   .video_youtube_custom > iframe .ytp-cued-thumbnail-overlay {
       width: 470px !important;

   }
</style>
@if(isset($videoYoutube) && $videoYoutube->count() >= 1)
    <div class="my-5 col-12">
        <p class="title d-flex align-items-center text-black" style="font-size: 24px; font-weight: 600">
            <img class="me-2"
                 src="https://cdn-icons-png.flaticon.com/128/318/318275.png" width="25px" height="25px"
                 alt=""> Video hàng đầu</p>
        <div class="video_youtube_slider">
            @forelse($videoYoutube as $item)
                <div class="video_youtube_custom ">
{{--                    <div class="card" style="">--}}
{{--                        <a href="{{$item->link ?? ''}}" target="_blank" class="">--}}
{{--                            <img src="{{ asset('storage/uploads/' . $item->image_file_path) ?? '' }}"--}}
{{--                                 class="card-img-top" alt="..." height="200"--}}
{{--                                 style="width: 100%;object-fit: cover">--}}
{{--                        </a>--}}
{{--                        <div class="card-body bg-light">--}}
{{--                            <h5 class="card-title custom_line_2"--}}
{{--                                style="height: 50px">{{$item->title ?? ''}}</h5>--}}
{{--                            <p class="card-text">{{format_date_custom($item->created_at ?? '')}}</p>--}}
{{--                        </div>--}}
{{--                        {!! $item->link ?? '' !!}--}}
                    {!! $item->link !!}
{{--                    </div>--}}
                </div>
            @empty

            @endif
        </div>
    </div>
@else

@endif
