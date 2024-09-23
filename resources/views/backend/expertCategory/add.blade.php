@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.expertCategory.add') }}
        </div>
    </div>

    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">
                    <form class="form-horizontal" action="{{route('backend.expertCategory.add')}}" method="post"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 row" style="margin: auto">


                                <div class="form-group d-flex align-items-center flex-column col-6">
                                    <div class="">
                                        <label class="font-weight-bold">Hình trước
                                            <sup><span class="text-danger">Kích thước chuẩn: 128 x 128 </span></sup>
                                        </label>
                                    </div>


                                    <div class="">
                                        <div style="width: 200px; height: 300px" class="dropzone  col-md-12 "
                                             id="myDropzone"
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
                                        @if ($errors->has('image_id'))
                                            <div class="custom_error">{{ $errors->first('image_id') }}</div>
                                        @endif
                                    </div>


                                </div>

                                {{--                                    // Hình sau--}}
                                <div class="form-group d-flex align-items-center flex-column col-6">
                                    <div class="">
                                        <label class="font-weight-bold">Hình sau
                                            <sup><span class="text-danger">Kích thước chuẩn: 128 x 128 </span></sup>
                                        </label>
                                    </div>
                                    <div class="">
                                        <div style="width: 200px; height: 300px" class="dropzone col-md-12"
                                             id="myDropzone2" action="{{route('backend.ajax.uploadImage')}}">
                                            <div class="dz-message">
                                                <div class="col-xs-8">
                                                    <div class="message">
                                                        <h6>Kéo thả tập tin vào hoặc Click để tải lên</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="result">
                                                @if($image_file_after)
                                                    <div class="thumb-nail-view">
                                                        <img src="{{$image_file_after->file_src}}"
                                                             class="img-thumbnail_1">
                                                        <input name="image_id_after" value="{{$image_file_after->id}}"
                                                               type="hidden">
                                                        <a href="javascript:;" onclick="removeFile($(this))"
                                                           data-id="{{$image_file_after->id}}">Xóa</a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="fallback">
                                                <input type="file" name="file" multiple style="opacity: 0">
                                            </div>
                                        </div>
                                        @if ($errors->has('image_id_after'))
                                            <div class="custom_error">{{ $errors->first('image_id_after') }}</div>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group col-12">
                                    <label for="name" class="font-weight-bold">Tên danh mục <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name">
                                    @if ($errors->has('name'))
                                        <div class="custom_error">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>


                                <div class="form-group col-12">
                                    <label for="states" class="font-weight-bold">Tags<span
                                            class="text-danger">*</span></label>
                                    <select class="js-example-basic-multiple form-group col-12" name="tags_id[]" multiple="multiple">
                                        @foreach($dataTags as $key => $item)
                                            <option value="{{$item->id}}">{{$item->name ?? ''}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tags_id'))
                                        <div class="custom_error">{{ $errors->first('tags_id') }}</div>
                                    @endif
                                </div>


                                <div class="form-group col-12">
                                    <label class="control-label font-weight-bold">
                                        Trạng thái
                                    </label>
                                    <select class="form-control form-control-sm" name="status">
                                        <option value="1" {{old('status') == 1 ? "selected" : ''}}>Hoạt động
                                        </option>
                                        <option value="0" {{old('status') == 0 ? "selected" : ''}}>Không hoạt
                                            động
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <div class="col-sm-12 text-center">
                                        <button class="btn btn-info" type="submit">Thêm</button>
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

        .img-thumbnail {
            width: 200px;
            height: 200px;
            object-fit: contain;
        }

        .img-thumbnail_1 {
            width: 200px;
            height: 200px;
            object-fit: contain;
        }
    </style>
@stop
@section('script')
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

        Dropzone.options.myDropzone2 = {
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
                    $('#myDropzone2 .dz-preview').remove();
                    $('#myDropzone2').removeClass('dz-started');
                });
            },
            success: function (file, reponse) {
                $('#myDropzone2 .result').html('');
                $.each(reponse.r, function (i, item) {
                    appendImage(item.id, item.url, '#myDropzone2 .result', 'image_id_after');
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
                '        <img src="' + src + '" class="img-thumbnail img-thumbnail_1"/>\n' +
                '        <input name="' + input_name + '" value="' + id + '" type="hidden"/>\n' +
                '        <a href="javascript:;" onclick="removeFile($(this))" data-id="' + id + '">Xóa</a>\n' +
                '    </div>')
        }
    </script>
@stop
