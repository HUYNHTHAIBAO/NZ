@extends('backend.layouts.main')

@section('content')



    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">Danh sách video ngắn chuyên gia</h3>
        </div>
        <div class="col-md-7 align-self-center">
                        {{ Breadcrumbs::render('backend.shortVideoExpert.index') }}
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
{{--                                            <th>Tiêu đề</th>--}}
                                            <th>Video</th>
                                            <th>Loại</th>
                                            <th style="min-width: 100px">Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th class="text-right" style="min-width: 150px">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $key => $item)
    {{--                                        // video ngắn youtube--}}
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
    {{--                                        // video tiktok--}}
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
                                                <td>{{$key+=1}}</td>
                                                <td class="font-weight-bold">{{$item->userExpert->fullname ?? ''}}</td>
{{--                                                <td>{{$item->title ?? ''}}</td>--}}
                                                @if($item->type == 1)
                                                    <td>


                                                        <div style="width:350px; height: 400px; overflow: hidden; border-radius: 10px; position: relative;">
                                                            <iframe
                                                                src="{{ $embedUrlTiktok }}"
                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                                                                frameborder="0"
                                                                allowfullscreen>
                                                            </iframe>
                                                        </div>
                                                    </td>
                                                @else



                                                    <td>
                                                        <div style="width:350px; height: 400px; overflow: hidden; border-radius: 10px; position: relative;">

                                                        <iframe width="100%" height="300" src="{{$embedUrl}}"
                                                                frameborder="0"  style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen></iframe>
                                                        </div>
                                                    </td>

                                                @endif
                                                <td>
                                                    @if($item->type == 1)
                                                        <span class="font-weight-bold">TikTok</span>
                                                    @else
                                                        <span class="font-weight-bold">Youtube</span>
                                                    @endif
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
                                                            action="{{ route('backend.shortVideoExpert.approved', ['id' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="btn waves-effect waves-light btn-success btn-sm">
                                                                <i class="fa fa-pencil-square-o"></i> Duyệt
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('backend.shortVideoExpert.reject', ['id' => $item->id]) }}"
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
                                                            action="{{ route('backend.shortVideoExpert.approved', ['id' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="btn waves-effect waves-light btn-success btn-sm"
                                                                    disabled>
                                                                <i class="fa fa-pencil-square-o"></i> Duyệt
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('backend.shortVideoExpert.reject', ['id' => $item->id]) }}"
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
