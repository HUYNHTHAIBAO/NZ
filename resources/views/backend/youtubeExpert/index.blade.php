@extends('backend.layouts.main')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">Danh sách video chuyên gia</h3>
        </div>
        <div class="col-md-7 align-self-center">
                        {{ Breadcrumbs::render('backend.youtubeExpert.index') }}
        </div>
    </div>

    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="col-12">
                                    <table id="table_id" class="table color-table muted-table table-striped">
                                        <thead class="bg-secondary">
                                        <tr>
                                            <th>#</th>
                                            <th>Họ tên</th>
                                            <th>Tiêu đề</th>
                                            <th>Video</th>
                                            <th style="min-width: 100px">Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th class="text-right" style="min-width: 150px">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $key => $item)
                                            <tr>
                                                <td>{{$key+=1}}</td>
                                                <td class="font-weight-bold">{{$item->userExpert->fullname ?? ''}}</td>
                                                <td>{{$item->title ?? ''}}</td>
                                                <td>
{{--                                                    <div class="video_youtube" style="">--}}
{{--                                                        {!! $item->link ?? '' !!}--}}
{{--                                                    </div>--}}
{{--                                                    <a href="{{$item->link ?? ''}}" target="_blank" class="video_wrap_play">--}}
{{--                                                        <img class="video_wrap_play_img" src="{{ asset('storage/uploads/' . $item->image_file_path) ?? '' }}" alt="" style="padding: 0px; display: block; max-width: 200px; height: 200px; object-fit: cover; border: 1px solid #ccc">--}}
{{--                                                        <span class="video-icon">--}}
{{--                                                            <i class="fa-solid fa-play"></i>--}}
{{--                                                        </span>--}}
{{--                                                    </a>--}}
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
                                                </td>
                                                <td>
                                                    @if($item->status == 1)
                                                        <span class="badge badge-warning text-white">Đang chờ duyệt</span>
                                                    @elseif($item->status == 2)
                                                        <span class="badge badge-success text-white">Đã duyệt</span>
                                                    @elseif($item->status == 3)
                                                        <span class="badge badge-danger text-white">Từ chối</span>
                                                    @else
                                                        <span class="badge badge-warning text-white">Chưa xác định</span>
                                                    @endif
                                                </td>
                                                <td>{{format_date_custom($item->created_at)}}</td>
                                                @if($item->status == 1)
                                                    <td class="d-flex align-items-center justify-content-end">

                                                        <form
                                                            action="{{ route('backend.youtubeExpert.approved', ['id' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="btn waves-effect waves-light btn-success btn-sm">
                                                                <i class="fa fa-pencil-square-o"></i> Duyệt
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('backend.youtubeExpert.reject', ['id' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <a href="{{Route('backend.postExpert.reject',[$item->id])}}"
                                                               class="btn waves-effect waves-light btn-danger btn-sm">
                                                                <i class="fa fa-pencil-square-o"></i> Từ chối</a>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td class="d-flex align-items-center justify-content-end">
                                                        <form
                                                            action="{{ route('backend.youtubeExpert.approved', ['id' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="btn waves-effect waves-light btn-success btn-sm"
                                                                    disabled>
                                                                <i class="fa fa-pencil-square-o"></i> Duyệt
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('backend.youtubeExpert.reject', ['id' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf

                                                            <button type="submit"
                                                                    class="btn waves-effect waves-light btn-success btn-sm"
                                                                    disabled>
                                                                <i class="fa fa-pencil-square-o"></i> Từ chối
                                                            </button>
                                                        </form>
                                                    </td>
                                                @endif

                                            </tr>
                                        @empty

                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
