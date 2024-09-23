@extends('frontend.layouts.frontend')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>



    <!-- breadcrumb-area-end -->

    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="dashboard__content-wrap">
                        <div class="pb-4">
                            <p class="bg-light p-1"><a class="text-black font_weight_bold" href="{{route('frontend.user.profile')}}"> Tài khoản </a> /
                                <a class="text-black font_weight_bold" href="{{route('frontend.youtubeExpert.index')}}">Quản lý video</a> / Đăng video</p>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tab-content" id="myTabContent">
                                    <button type="button" class="btn_custom my-4" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop">
                                        Xem hướng dẫn
                                    </button>
                                    <div class="tab-pane fade active show" id="itemTwo-tab-pane" role="tabpanel"
                                         aria-labelledby="itemTwo-tab" tabindex="0">
                                        <div class="instructor__profile-form-wrap">
                                            <form action="{{route('frontend.youtubeExpert.add')}}"
                                                  class="instructor__profile-form" method="POST" enctype="multipart/form-data">
                                                @csrf
{{--                                                <div class="form-grp">--}}
{{--                                                    <div class="row d-flex align-items-center justify-content-center" id="preview_img">--}}
{{--                                                        <img id="img_preview" src="" style="padding: 0px;display: block; max-width: 200px; height: 200px; object-fit: cover; border: 1px solid #ccc">--}}
{{--                                                    </div>--}}
{{--                                                    <input type="file" class="form-control" name="image_file_id" id="image_file_id" aria-describedby="">--}}
{{--                                                    @if ($errors->has('image_file_id'))--}}
{{--                                                        <div class="custom_error">{{ $errors->first('image_file_id') }}</div>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                                <div class="form-grp">--}}
{{--                                                    <label for="title">Tiêu đề <span class="text-danger">*</span></label>--}}
{{--                                                    <textarea id="title" name="title">{{old('title')}}</textarea>--}}
{{--                                                    @if ($errors->has('title'))--}}
{{--                                                        <div class="custom_error">{{ $errors->first('title') }}</div>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
                                                <div class="form-grp">
                                                    <label for="link">Link video <span class="text-danger">*</span></label>
                                                    <textarea id="link" name="link">{{old('link')}}</textarea>
                                                    @if ($errors->has('link'))
                                                        <div class="custom_error">{{ $errors->first('link') }}</div>
                                                    @endif
                                                </div>
                                                <div class="submit-btn mt-25 text-center">
                                                    <button type="submit" class="categories_button"><span class="categories_link">Đăng</span></button>
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



    {{--// modal --}}
    @include('frontend.youtubeExpert.modal.index')



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.getElementById('image_file_id').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
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

