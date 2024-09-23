@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.postExpert.index') }}
        </div>
    </div>

    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 pull-right">
                            <a href="{{Route('backend.postExpert.add')}}"
                               class="btn waves-effect waves-light btn-block btn-info">
                                <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới
                            </a>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="col-12">
                                    <table id="table_id" class="table color-table muted-table table-striped">
                                        <thead class="bg-secondary">
                                        <tr>
                                            <th>#</th>
                                            <th>Người tạo</th>
                                            <th style="min-width: 100px">Hình</th>
                                            <th style="min-width: 100px">Tên bài viết</th>
                                            <th style="min-width: 200px">Danh mục</th>
                                            <th>Thứ tự</th>
                                            <th style="min-width: 110px">Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th class="text-right" style="min-width: 150px">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($list_data as $key => $item)
                                            <tr>
                                                <td>{{$key+=1}}</td>
                                                <td><span class="font-weight-bold">{{$item->user->fullname ?? ''}}</span></td>
                                                <td>
                                                    @if($item->thumbnail)
                                                        <img src="{{$item->thumbnail->file_src}}" height="40"
                                                             class="image-border image-popup-no-margins"
                                                             href="{{$item->thumbnail->file_src}}"/>
                                                    @endif
                                                </td>
                                                <td> <span  style="width: 200px" class="custom_line_2" title="{{$item->name ?? ''}}">{{$item->name ?? ''}}</span></td>

                                                <td>
                                                <span
                                                    class="font_weight_bold">{{$item->expertCategory->name ?? ''}}</span>
                                                </td>

                                                <td>
                                                <span
                                                    class="badge text-white font-weight-bold bg-danger">{{$item->sort ?? ''}}</span>
                                                </td>

                                                <td>
                                                    @if($item->status == 0)
                                                        <span
                                                            class="badge badge-warning text-white">Đang chờ duyệt</span>
                                                    @elseif($item->status == 1)
                                                        <span class="badge badge-success text-white">Đã duyệt</span>
                                                    @elseif($item->status == 2)
                                                        <span class="badge badge-danger text-white">Từ chối</span>
                                                    @else
                                                        <span class="badge badge-warning text-white">Từ chối</span>
                                                    @endif
                                                </td>
                                                <td>{{format_date_custom($item->created_at)}}</td>


                                                <td class="text-right d-flex align-items-center">
                                                    <a href="{{Route('backend.postExpert.edit',[$item->id])}}"
                                                       class="btn waves-effect waves-light btn-info btn-sm">
                                                        <i class="fa fa-pencil-square-o"></i> Sửa</a>

                                                    <a href="{{Route('backend.postExpert.del',[$item->id])}}"
                                                       class="btn waves-effect waves-light btn-danger btn-sm"
                                                       data-bb="confirm" id="">
                                                        <i class="fa fa-trash-o"></i> Xóa</a>

                                                    @if($item->status == 0)
                                                        <form
                                                            action="{{ route('backend.postExpert.approve', ['id' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="btn waves-effect waves-light btn-primary btn-sm">
                                                                <i class="fa fa-pencil-square-o"></i> Duyệt
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('backend.postExpert.reject', ['id' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <a href="{{Route('backend.postExpert.reject',[$item->id])}}"
                                                               class="btn waves-effect waves-light btn-warning btn-sm">
                                                                <i class="fa fa-pencil-square-o"></i> Từ chối</a>
                                                        </form>
                                                    @else

                                                    @endif

                                                </td>
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
