@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5">
            <h3 class="text-black font-weight-bold">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7">
                        {{ Breadcrumbs::render('backend.review.add') }}
        </div>
    </div>

    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">
                    <form class="form-horizontal" action="{{route('backend.review.add')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                @include('backend.partials.msg')
                                @include('backend.partials.errors')
                                @csrf
                                <div class="form-group">
                                    <label class="col-md-12 font_weight_bold">Tiêu đề <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="title"
                                               value="{{old('title')}}">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-12 font_weight_bold">Nội dung <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="desc" id="" cols="" rows="3">{{old('desc')}}</textarea>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-md-12 font_weight_bold">Họ tên <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="name"
                                               value="{{old('name')}}">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-12 font_weight_bold">Công việc </label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="job"
                                               value="{{old('job')}}">
                                    </div>
                                </div>

                                <br>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="font_weight_bold">Hình
                                            <sup><span class="text-danger">Kích thước chuẩn: 128 x 128</span></sup>
                                        </label>
                                        <div class="dropzone  col-md-12 " id="myDropzone"
                                             action="{{route('backend.ajax.uploadImage')}}">
                                            <div class="dz-message">
                                                <div>
                                                    <div class="message">
                                                        <h6>Kéo thả tập tin vào hoặc Click để tải lên</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="result">
                                                @if($image_file)
                                                    <div class="thumb-nail-view">
                                                        <img src="{{$image_file->file_src}}" class="img-thumbnail">
                                                        <input name="image_id" value="{{$image_file->id}}"
                                                               type="hidden">
                                                        <a href="javascript:;" onclick="removeFile($(this))"
                                                           data-id="{{$image_file->id}}">Xóa</a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="fallback">
                                                <input type="file" name="file" multiple style="opacity: 0">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-info" type="submit">Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_top')
    <script src="{{ asset('/storage/backend')}}/assets/plugins/ckeditor/ckeditor.js?v=111"></script>
@stop

@section('style')
    <link href="{{ asset('/storage/backend')}}/assets/plugins/codemirror/lib/codemirror.css" rel="stylesheet">
    <link href="{{ asset('/storage/backend')}}/assets/plugins/codemirror/theme/monokai.css" rel="stylesheet">

    <style>
        #form-add label {
            font-size: 13px;
        }

        .result {
            display: inline-block;
        }

        .thumb-nail-view {
            /*width: 32%;*/
            /*height: 100px;*/
            margin: auto;
            padding: 5px;
            float: left;
        }

        .thumb-nail-view a {
            text-align: center;
            font-size: 10px;
            cursor: pointer !important;
            display: inline-block;
            width: 100%;
            color: red;
            font-weight: bold;
        }

        .dropzone .dz-message {
            padding: 0;
        }

        .dropzone .dz-preview .dz-image {
            border-radius: 5px;
            overflow: hidden;
            width: 70px;
            height: 70px;
        }

        .dropzone .dz-preview .dz-image img {
            width: 100%;
        }

        .dropzone .dz-preview .dz-progress {
            width: 60px;
            margin-left: -30px;
        }

        .dropzone .dz-preview .dz-details .dz-size {
            display: none;
        }

        .dropzone {
            min-height: 100px;
        }
    </style>
@stop

@section('script')
    <script src="{{ asset('/storage/backend/assets/plugins')}}/codemirror/lib/codemirror.js"></script>
    <script
        src="{{ asset('/storage/backend/assets/plugins')}}/codemirror/addon/selection/selection-pointer.js"></script>
    <script src="{{ asset('/storage/backend/assets/plugins')}}/codemirror/mode/css/css.js"></script>
    <script src="{{ asset('/storage/backend/assets/plugins')}}/codemirror/addon/edit/matchbrackets.js"></script>
    <script src="{{ asset('/storage/backend/assets/plugins')}}/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script>
        Dropzone.options.myDropzone = {
            uploadMultiple: true,
            parallelUploads: 1,
            maxFilesize: 16,
            addRemoveLinks: false,
            dictFileTooBig: 'Dung lượng hình lớn hơn 16MB',
            timeout: 10000,
            params: {
                _token: $('[name="_token"]').val(),
            },
            init: function () {
                this.on("complete", function (file, reponse) {
                    $('#myDropzone .dz-preview').remove();
                    $('#myDropzone').removeClass('dz-started');
                });
            },
            success: function (file, reponse) {
                $('#myDropzone .result').html('');
                $.each(reponse.r, function (i, item) {
                    appendImage(item.id, item.url, '#myDropzone .result', 'image_id');
                });
            }
        }



        function removeFile(d) {
            var file_id = d.data('id');
            $.post({
                url: '{{route('backend.ajax.removeImage')}}',
                data: {id: file_id, _token: $('[name="_token"]').val()},
                dataType: 'json',
                success: function (data) {
                    d.parent().remove();
                }
            });
        }

        function appendImage(id, src, parent_div, input_name) {
            $(parent_div).append('<div class="thumb-nail-view">\n' +
                '        <img src="' + src + '" class="img-thumbnail"/>\n' +
                '        <input name="' + input_name + '" value="' + id + '" type="hidden"/>\n' +
                '        <a href="javascript:;" onclick="removeFile($(this))" data-id="' + id + '">Xóa</a>\n' +
                '    </div>')
        }


    </script>
@stop
