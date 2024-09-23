@extends('frontend.layouts.frontend')

@section('content')

    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard__content-wrap">
                        <div class="pb-4">
                            <p class="bg-light p-1"><a class="text-black font_weight_bold" href="{{route('frontend.user.profile')}}"> Tài khoản </a> / Quản lý video</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <a href="{{route('frontend.youtubeExpert.add')}}" class="btn_custom p-2">Đăng
                                        video </a>
{{--                                    <a href="{{route('frontend.youtubeExpert.add')}}" class="btn_custom p-2"> </a>--}}

                                </div>
                                <div class="dashboard__review-table">
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tiêu đề</th>
                                            <th>Video</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th class="text-end">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $key => $item)
                                            <tr>
                                                <td>
                                                    {{$key+=1}}
                                                </td>
                                                <td>
                                                    {{$item->title ?? ''}}
{{--                                                    <div class="video_youtube">--}}
{{--                                                        {!! $item->link ?? '' !!}--}}
{{--                                                    </div>--}}
                                                </td>
                                                <td>
{{--                                                    <a href="{{$item->link ?? ''}}" target="_blank" class="video_wrap_play">--}}
{{--                                                        <img class="video_wrap_play_img" src="{{ asset('storage/uploads/' . $item->image_file_path) ?? '' }}" alt="" style="padding: 0px; display: block; max-width: 200px; height: 200px; object-fit: cover; border: 1px solid #ccc">--}}
{{--                                                        <span class="video-icon">--}}
{{--                                                            <i class="fa-solid fa-play"></i>--}}
{{--                                                        </span>--}}
{{--                                                    </a>--}}
                                                    <div class="video_youtube_custom ">
                                                        {!! $item->link !!}
                                                    </div>
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
                                                        <a href="{{route('frontend.youtubeExpert.edit',$item->id )}}"
                                                           title="Edit"><i class="skillgro-edit"></i></a>
                                                        <a href="{{route('frontend.youtubeExpert.delete',$item->id )}}"
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


@endsection
