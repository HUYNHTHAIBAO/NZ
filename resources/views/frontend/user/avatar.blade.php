@extends('frontend.layouts.frontend')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>



    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            @include('frontend.user.header')
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.user.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="dashboard__content-wrap">
                        <div class="dashboard__content-title">
                            <h4 class="title text-center">Ảnh</h4>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="itemOne-tab-pane" role="tabpanel"
                                         aria-labelledby="itemOne-tab" tabindex="0">
                                        <div class="instructor__profile-form-wrap">
                                            <form action="" class="instructor__profile-form" method="Post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3 col-6" style="margin: 0 auto">
                                                    <div class="row d-flex align-items-center justify-content-center" id="preview_img">
                                                        <img id="img_preview" src="{{asset('storage/uploads') . '/' . $user->avatar_file_path ?? ''}}" alt="" style="padding: 0px;display: block; max-width: 200px; height: 200px; object-fit: cover; border-radius: 50%;border: 1px solid #ccc">
                                                    </div>
                                                    <input type="file" class="form-control" name="avatar_file_id" id="avatar_file_id" aria-describedby="">
                                                    @if ($errors->has('avatar_file_id'))
                                                        <div class="custom_error">{{ $errors->first('avatar_file_id') }}</div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <div class="submit-btn mt-25">
                                                            <button type="submit" class="categories_button">
                                                                <span class="categories_link">Cập nhật</span>
                                                            </button>
                                                        </div>
                                                    </div>
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



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.getElementById('avatar_file_id').addEventListener('change', function(event) {
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
