@extends('backend.layouts.main')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"></h3>
        </div>
        <div class="col-md-7 align-self-center">
        </div>
    </div>
    <div class="col-md-12">
        <div class="card card-outline-info">
            <div class="card-body">
                <button type="button" class="btn btn-primary add_time" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">
                    Thêm
                </button>

                @include('backend.partials.msg')
                @include('backend.partials.errors')

                <table class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k=>$item)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <a href="{{ route('backend.setting.time.rates.delete', $item->id) }}">Xóa</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thêm khung thời gian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> X</button>
                    </div>
                    <form method="post">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="form-control" name="name">

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('style')

@stop

@section('script')
    <script>
        $(".add_time").click(function () {
            $('#staticBackdrop').modal('toggle');
        });
    </script>
@stop
