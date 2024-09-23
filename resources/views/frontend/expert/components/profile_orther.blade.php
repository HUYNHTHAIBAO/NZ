@if(isset($expertProfileOrther) && $expertProfileOrther->count() >= 1)
    <div class="my-4 col-12">
        <p class="title d-flex align-items-center text-black"
           style="font-size: 24px; font-weight: 600">
            <img class="me-2"
                 src="https://cdn-icons-png.flaticon.com/128/318/318275.png" width="25px"
                 height="25px"
                 alt=""> Hồ sơ khác </p>
        <div class="row ">
            @forelse($expertProfileOrther as $item)
                <div class="col-xl-3 col-md-6">
                    <div class="blog__post-item shine__animate-item">
                        <div class="blog__post-thumb">
                            @if(isset($item->thumbnail))
                                @php
                                    $extension = pathinfo($item->thumbnail->file_src, PATHINFO_EXTENSION);
                                    $filename = pathinfo($item->thumbnail->file_src, PATHINFO_FILENAME);
                                @endphp

                                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{$item->thumbnail ? $item->thumbnail->file_src : 'https://cdn-icons-png.flaticon.com/128/696/696755.png'}}"
                                         alt="img">
                                @else
                                    <a href="{{$item->thumbnail->file_src}}"
                                       download="{{$item->slug . '.' . $extension}}"
                                       target="_blank">
                                        <img src="https://cdn-icons-png.flaticon.com/128/3073/3073439.png"
                                             alt="img" style="width: 100%; object-fit: contain">
                                    </a>
                                @endif
                            @else
                            <!-- Handle case when there is no thumbnail -->
                            @endif
                        </div>
                        <div class="blog__post-content">
                            <h4 class="title custom_line_2" style="height: 50px">
                                <a class="" title="{{$item->title ?? ''}}"
                                   href="#">{{$item->title ?? ''}}</a>
                            </h4>
                        </div>
                    </div>
                </div>

            @empty

            @endforelse
        </div>
    </div>
@else

@endif
