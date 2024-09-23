@extends('frontend.layouts.frontend')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>



    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="dashboard__content-wrap">
                        <div class="pb-4">
                            <p class="bg-light p-1"><a class="text-black font_weight_bold" href="{{route('frontend.user.profile')}}"> Tài khoản </a>
                                <a class="text-black font_weight_bold" href="{{route('frontend.profileOrther.index')}}"> / Hồ sơ khác </a> / Cập nhật</p>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="itemTwo-tab-pane" role="tabpanel"
                                         aria-labelledby="itemTwo-tab" tabindex="0">
                                        <div class="instructor__profile-form-wrap">
                                            <form action="{{route('frontend.profileOrther.edit', $data->id)}}"
                                                  class="instructor__profile-form" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3 col-6" style="margin: 0 auto">
                                                    <label for="thumbnail_id"
                                                           class="form-label font-weight-bold d-flex align-content-center justify-content-center font_weight_bold">Hình
                                                        bài viết
                                                    </label>
                                                    <div class="row d-flex align-items-center justify-content-center" id="preview_img">
                                                        @if(isset($data->thumbnail))
                                                            @php
                                                                $extension = pathinfo($data->thumbnail->file_src, PATHINFO_EXTENSION);
                                                                $filename = pathinfo($data->thumbnail->file_src, PATHINFO_FILENAME);
                                                            @endphp

                                                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                <img id="img_preview" src="{{ $data->thumbnail->file_src }}" alt=""
                                                                     style="padding: 0px; display: block; width: 100%; height: 200px; object-fit: contain">
                                                            @else
                                                                <div class="text-center">
                                                                    <a href="{{ $data->thumbnail->file_src }}" target="_blank">Download file</a>
                                                                    <br>
                                                                    <span>{{ $filename . '.' . $extension }}</span>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="text-center">
                                                                No file available
                                                            </div>
                                                        @endif
                                                    </div>






                                                    <input type="file" class="form-control" name="image_file_id"
                                                           id="image_file_id" aria-describedby="">
                                                    @if ($errors->has('image_file_id'))
                                                        <div
                                                            class="custom_error">{{ $errors->first('image_file_id') }}</div>
                                                    @endif
                                                </div>
                                                <div class="form-grp">
                                                    <div class="form-grp">
                                                        <label for="title">Tên bài viết <span
                                                                class="text-danger">*</span></label>
                                                        <input id="title" name="title" type="text" value="{{$data->title ?? ''}}">
                                                        @if ($errors->has('title'))
                                                            <div class="custom_error">{{ $errors->first('title') }}</div>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="submit-btn mt-25 text-center">
                                                    <button type="submit" class="categories_button">
                                                        <span class="categories_link">Cập nhật</span>
                                                    </button>
                                                </div>


                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <script src="{{ asset('/storage/backend')}}/assets/plugins/ckeditor/ckeditor.js?v=111"></script>

    <script>
        CKEDITOR.replace('detail');
    </script>


    <script>
        document.getElementById('image_file_id').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.getElementById('img_preview');
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                const img = document.getElementById('img_preview');
                img.src = '#';
                img.style.display = 'none';
            }
        });
    </script>
@endsection

