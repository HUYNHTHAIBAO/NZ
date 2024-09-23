@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">{{$title}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('Profile') }}
        </div>
    </div>

    <div class="row page-titles">
    <div class="col-md-12">
        <div class="card card-outline-info">
            <div class="card-body">

                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-6" style="margin: auto">
                            @include('backend.partials.msg')
                            @include('backend.partials.errors')

                            {{ csrf_field() }}

                            <div class="form-group">
                                <div class="col-md-3 offset-md-5">
                                    <input type="file" id="input-file-now-custom-1"
                                           name="file_avatar"
                                           class="dropify"
                                           data-default-file="{{ Auth()->guard('backend')->user()->avatar }}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12 font-weight-bold">Họ tên <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="text"
                                           class="form-control form-control-line"
                                           name="fullname"
                                           value="{{Auth()->guard('backend')->user()->fullname}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-emai font-weight-boldl" class="col-md-12">Email</label>
                                <div class="col-md-12">
                                    <input type="email"
                                           class="form-control form-control-line"
                                           name="email"
                                           value="{{Auth()->guard('backend')->user()->email}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 font-weight-bold">Điện thoại</label>
                                <div class="col-md-12">
                                    <input type="text" disabled="disabled"
                                           class="form-control form-control-line"
                                           value="{{Auth()->guard('backend')->user()->phone}}"
                                           name="phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 font-weight-bold">Mật khẩu cũ</label>
                                <div class="col-md-12">
                                    <input type="password"
                                           class="form-control form-control-line"
                                           name="oldpassword">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 font-weight-bold">Mật khẩu mới</label>
                                <div class="col-md-12">
                                    <input type="password"
                                           class="form-control form-control-line"
                                           name="newpassword">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-info" type="submit">Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('style')
    <link rel="stylesheet" href="{{ asset('/storage/backend/assets/plugins/dropify/dist/css/dropify.min.css')}}">
@stop

@section('script')
    <!-- jQuery file upload -->
    <script src="{{ asset('/storage/backend/assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            // Basic
            $('.dropify').dropify();

            // Translated
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'Désolé, le fichier trop volumineux'
                }
            });

            // Used events
            var drEvent = $('#input-file-events').dropify();

            drEvent.on('dropify.beforeClear', function (event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function (event, element) {
                alert('File deleted');
            });

            drEvent.on('dropify.errors', function (event, element) {
                console.log('Has Errors');
            });

            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function (e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });
    </script>
@stop
