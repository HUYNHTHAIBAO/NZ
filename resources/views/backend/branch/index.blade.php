@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.brands.index') }}
        </div>

        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">
                    @if(auth()->guard('backend')->user()->can('posts.add'))
                        <div class="row">
                            <div class="col-md-2 pull-right">
                                <a href="{{Route('backend.brands.create')}}"
                                   class="btn waves-effect waves-light btn-block btn-info">
                                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới
                                </a>
                            </div>
                        </div>
                    @endif
                    <br>
                    @include('backend.partials.msg')
                    @include('backend.partials.errors')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="col-12">
                                    <table id="table_id" class="table color-table muted-table table-striped">
                                        <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Giờ mở cửa</th>
                                            <th>Tên chi nhánh</th>
                                            <th>Đia chị</th>
                                            <th>Điện thoại</th>
                                            <th>Lat</th>
                                            <th>Long</th>
                                            <th class="text-right">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $key => $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>
                                                    {{$item->daily}}
                                                </td>
                                                <td>
                                                    {{$item->name}}
                                                </td>
                                                <td>
                                                    {{$item->address}}
                                                </td>
                                                <td>
                                                    {{$item->phone}}
                                                </td><td>
                                                    {{$item->o_lat}}
                                                </td>
                                                <td>
                                                    {{$item->o_long}}
                                                </td>

                                                <td class="text-right">
    {{--                                                @if(auth()->guard('backend')->user()->can('posts.edit'))--}}
                                                        <a href="{{Route('backend.brands.edit',[$item->id]). '?_ref=' .$current_url }}"
                                                           class="btn waves-effect waves-light btn-info btn-sm">
                                                            <i class="fa fa-pencil-square-o"></i> Sửa</a>
    {{--                                                @endif--}}

                                                    @if(auth()->guard('backend')->user()->can('posts.del'))
                                                        <a href="#"
                                                           class="btn waves-effect waves-light btn-danger btn-sm btnShowModal"
                                                           data-id="{{ $item->id }}">
                                                            <i class="fa fa-trash-o"></i> Xóa</a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10">-</td>
                                            </tr>
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
    @include('backend.branch.modal')
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            $(document).on('click','a.btnShowModal',function (e){
                let delete_id = $(this).data('id');
                $('#delete_id').val(delete_id);
                e.preventDefault();
                $('#deleteModal').modal('show');
            });

            $(document).on('click','button.btnDelete',function (e){
                let delete_id = $('#delete_id').val();
                let data = {
                    _token:'{{csrf_token()}}',
                    id:delete_id
                }
                $.ajax({
                    type:'POST',
                    url:'{{ Route('backend.brands.delete') }}',
                    dataType:'json',
                    data: data,
                    success: function (json){
                        window.location.reload();
                    }
                })
            });


        });
    </script>
@stop
