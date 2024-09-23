@extends('frontend.layouts.frontend')

@section('content')
    <style>
        .video_tiktok > blockquote {
            width: 200px !important;
            height: 200px !important;
            object-fit: cover;
        }
    </style>

    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="dashboard__content-wrap">
                        <div class="pb-4">
                        <p class="bg-light p-1"><a class="text-black font_weight_bold" href="{{route('frontend.user.profile')}}"> Tài khoản </a> / Quản lý video ngắn</p>
                        </div>
                        <div class="row ">
                            <div class="col-12">
                                <div class="mb-4">
                                    <a href="{{route('frontend.shortVideoExpert.add')}}" class="btn_custom p-2">Đăng
                                        video </a>
                                </div>
                                <div class="dashboard__review-table mt-3">
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th>#</th>
{{--                                            <th>Tiêu đề</th>--}}
                                            <th>Video</th>
                                            <th>Loại video</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th class="text-end">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $key => $item)
{{--                                            // video ngắn youtube--}}
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
{{--                                            // video ngắn tiktok--}}
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

                                            <tr>
                                                <td>
                                                    {{$key+=1}}
                                                </td>
{{--                                                <td>--}}
{{--                                                    {{$item->title ?? ''}}--}}
{{--                                                </td>--}}
                                                @if($item->type == 1)
                                                    <td>
{{--                                                        <a href="{{$item->link ?? ''}}" target="_blank" class="video_wrap_play">--}}
{{--                                                            <img class="video_wrap_play_img" src="{{ asset('storage/uploads/' . $item->image_file_path) ?? '' }}" alt="" style="padding: 0px; display: block; max-width: 200px; height: 200px; object-fit: cover; border: 1px solid #ccc">--}}
{{--                                                            <span class="video-icon">--}}
{{--                                                            <i class="fa-solid fa-play"></i>--}}
{{--                                                        </span>--}}
{{--                                                        </a>--}}
{{--                                                        <div class="">--}}
                                                        <div style="width:350px; height: 400px; overflow: hidden; border-radius: 10px; position: relative;">
                                                            <iframe
                                                                src="{{ $embedUrlTiktok }}"
                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                                                                frameborder="0"
                                                                allowfullscreen>
                                                            </iframe>
                                                        </div>


                                                    </td>
                                                @elseif($item->type == 3)
                                                    <td>
                                                    <div style="width:350px; height: 400px; overflow: hidden; border-radius: 10px; position: relative;">
                                                        <iframe src="https://www.facebook.com/plugins/video.php?href={{$item->link ?? ''}}"
                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                                                                scrolling="no"
                                                                frameborder="0"
                                                                allowfullscreen="true"></iframe>

                                                    </div>
                                                    </td>
                                                @elseif($item->type == 4)
                                                    <td>
                                                        <div style="width:350px; height: 400px; overflow: hidden; border-radius: 10px; position: relative;">
                                                            {!! $item->link ?? '' !!}
                                                        </div>
                                                    </td>
                                                @else
{{--                                                    <td>--}}
                                                <td>
                                                    <div style="width:350px; height: 400px; overflow: hidden; border-radius: 10px; position: relative;">

                                                    <iframe width="100%" height="300" src="{{$embedUrl}}"
                                                            frameborder="0" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                    </div>
                                                </td>

{{--                                                        <a href="{{$item->link ?? ''}}" target="_blank" class="video_wrap_play">--}}
{{--                                                            <img class="video_wrap_play_img" src="{{ asset('storage/uploads/' . $item->image_file_path) ?? '' }}" alt="" style="padding: 0px; display: block; max-width: 200px; height: 200px; object-fit: cover; border: 1px solid #ccc">--}}
{{--                                                            <span class="video-icon">--}}
{{--                                                            <i class="fa-solid fa-play"></i>--}}
{{--                                                        </span>--}}
{{--                                                        </a>--}}
{{--                                                    </td>--}}

                                                @endif

                                                <td>
                                                    @if($item->type == 1)
                                                        <span class="font_weight_bold">TikTok</span>
                                                    @elseif($item->type == 2)
                                                        <span class="font_weight_bold">Youtube ngắn</span>
                                                    @elseif($item->type == 3)
                                                        <span class="font_weight_bold">Facebook</span>
                                                    @elseif($item->type == 4)
                                                        <span class="font_weight_bold">Instagram</span>

                                                    @else
                                                        Chưa xác định
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->status == 1)
                                                        <span class="dashboard__quiz-result hold">
                                                    Đang chờ duyệt
                                                </span>
                                                    @elseif($item->status == 2)
                                                        <span class="dashboard__quiz-result">
                                                        Đã duyệt
                                                </span>
                                                    @elseif($item->status == 3)
                                                        <span class="dashboard__quiz-result fail">
                                                        Đã Từ chối
                                                </span>
                                                    @else
                                                        <span class="dashboard__quiz-result">
                                                        Chưa xác định
                                                    </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{format_date_custom($item->created_at ?? '')}}
                                                </td>

                                                <td>
                                                    <div class="dashboard__review-action">
                                                        <a href="{{route('frontend.shortVideoExpert.edit',$item->id )}}"
                                                           title="Edit"><i class="skillgro-edit"></i></a>
                                                        <a href="{{route('frontend.shortVideoExpert.delete',$item->id )}}"
                                                           title="Delete"><i class="skillgro-bin"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty

                                        @endforelse
                                        </tbody>
                                    </table>


                                    <div class="mt-2 d-flex justify-content-end">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                {{$data->links()}}
                                            </ul>
                                        </nav>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script async src="https://www.tiktok.com/embed.js"></script>

@endsection
