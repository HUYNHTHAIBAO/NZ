@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.review.index') }}
        </div>
    </div>


    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 pull-right">
                            <a href="{{Route('backend.review.add')}}"
                               class="btn waves-effect waves-light btn-block btn-info">
                                <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới
                            </a>
                        </div>
                    </div>
                    <br>
                    @include('backend.partials.msg')
                    @include('backend.partials.errors')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="col-12">
                                    <table id="table_id" class="table color-table muted-table table-striped">
                                        <thead class="bg-secondary">
                                        <tr>
                                            <th>#</th>
                                            <th>Hình</th>
                                            <th>Tiêu đề</th>
                                            <th>Ngày tạo</th>
                                            <th class="text-right">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($list_data as $key => $item)
                                            <tr>
                                                <td>{{$key+=1}}</td>
                                                <td>
                                                    <img src="{{url('storage/uploads/'.$item->image_path.'')}}"
                                                         height="80"
                                                         class="image-border image-popup-no-margins"
                                                         href="{{url('storage/uploads/'.$item->image_path.'')}}"/>
                                                </td>
                                                <td>
                                                    {{$item->title}}
                                                </td>
                                                <td>
                                                    {{format_date_custom($item->created_at)}}
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{Route('backend.review.edit',[$item->id]). '?_ref=' .$current_url }}"
                                                       class="btn waves-effect waves-light btn-info btn-sm">
                                                        <i class="fa fa-pencil-square-o"></i> Sửa</a>

                                                    <a href="{{Route('backend.review.del',[$item->id]) . '?_ref=' .$current_url }}"
                                                       class="btn waves-effect waves-light btn-danger btn-sm"
                                                       data-bb="confirm">
                                                        <i class="fa fa-trash-o"></i> Xóa</a>

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
