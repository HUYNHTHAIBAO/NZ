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
                            <h4 class="title text-center">Cập nhật thông tin tài khoản</h4>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="itemOne-tab-pane" role="tabpanel"
                                         aria-labelledby="itemOne-tab" tabindex="0">
                                        <div class="instructor__profile-form-wrap">
                                            <form action="" class="instructor__profile-form" method="Post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row justify-content-center">
                                                    <div class="col-md-8">
                                                    <label for="fullname" class="font_weight_bold">Thông tin cơ bản : </label>
                                                    </div>
                                                    <div class="col-md-8 col-12 mt-3">
                                                        <div class="">
                                                            <input id="fullname" type="text" name="fullname"
                                                                   value="{{old('fullname', auth('web')->user()->fullname)}}"
                                                                   placeholder="Họ tên" class="input_user">
                                                            @if ($errors->has('fullname'))
                                                                <div
                                                                    class="custom_error">{{ $errors->first('fullname') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-12 mt-3">
                                                        <div class="">
                                                            <input id="phone" type="text" name="phone"
                                                                   value="{{old('phone', auth('web')->user()->phone)}}"
                                                                   placeholder="Số điện thoại" class="input_user">
                                                            @if ($errors->has('phone'))
                                                                <div
                                                                    class="custom_error">{{ $errors->first('phone') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-12 mt-3">
                                                        <div class="">
                                                            <input id="skill" type="text" name="email"
                                                                   value="{{old('email', auth('web')->user()->email)}}"
                                                                   placeholder="Email" class="input_user">
                                                            @if ($errors->has('email'))
                                                                <div
                                                                    class="custom_error">{{ $errors->first('email') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
{{--                                                    <div class="col-md-8">--}}
{{--                                                        <div class="form-grp">--}}
{{--                                                            <label for="birthday">Ngày sinh</label>--}}
{{--                                                            <input autocomplete="off" id="birthday" type="text"--}}
{{--                                                                   name="birthday"--}}
{{--                                                                   value="{{old('birthday', auth('web')->user()->birthday)}}">--}}

{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-8 d-flex align-items-center">--}}
{{--                                                        <div class="form-grp">--}}
{{--                                                            <label for="gender">Giới tính</label>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="ms-5">--}}
{{--                                                            <div class="form-check">--}}
{{--                                                                <input class="form-check-input" type="radio"--}}
{{--                                                                       name="gender"--}}
{{--                                                                       id="flexRadioDefault1"--}}
{{--                                                                       value="1" {{ auth('web')->user()->gender == 1 ? 'checked' : '' }}>--}}
{{--                                                                <label class="form-check-label" for="flexRadioDefault1">--}}
{{--                                                                    Nam--}}
{{--                                                                </label>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="form-check">--}}
{{--                                                                <input class="form-check-input" type="radio"--}}
{{--                                                                       name="gender"--}}
{{--                                                                       id="flexRadioDefault2"--}}
{{--                                                                       value="2" {{ auth('web')->user()->gender == 2 ? 'checked' : '' }}>--}}
{{--                                                                <label class="form-check-label" for="flexRadioDefault2">--}}
{{--                                                                    Nữ--}}
{{--                                                                </label>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="form-check">--}}
{{--                                                                <input class="form-check-input" type="radio"--}}
{{--                                                                       name="gender"--}}
{{--                                                                       id="flexRadioDefault3"--}}
{{--                                                                       value="0" {{ auth('web')->user()->gender == 0 ? 'checked' : '' }}>--}}
{{--                                                                <label class="form-check-label" for="flexRadioDefault3">--}}
{{--                                                                    Khác--}}
{{--                                                                </label>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-6">--}}
{{--                                                        <div class="form-grp">--}}
{{--                                                            <label for="address">Địa chỉ</label>--}}
{{--                                                            <input id="address" type="text" name="address"--}}
{{--                                                                   value="{{old('address', auth('web')->user()->address)}}"--}}
{{--                                                                   placeholder="Nhập địa chỉ ...">--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
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


    {{--    // avatar --}}



@endsection



@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function () {
            $("#birthday").datepicker({
                dateFormat: "yy/mm/dd",
            });
        });
    </script>
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
@stop
