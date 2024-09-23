@extends('frontend.layouts.frontend')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
                            <h4 class="title text-center">Đổi mật khẩu</h4>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="itemTwo-tab-pane" role="tabpanel" aria-labelledby="itemTwo-tab" tabindex="0">
                                        <div class="instructor__profile-form-wrap">
                                            <form action="" class="instructor__profile-form" method="Post">
                                                @csrf
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-8 col-12">
                                                        <div class="input-focus-effect">
                                                            <input class="input_user" id="password_old" name="password_old" type="password" placeholder="Mật khẩu cũ ..." value="{{ old('password_old') }}" oninput="toggleEyeIconVisibility('password_old', 'eyeIconContainer_old')">
                                                            <span class="toggle-password" onclick="togglePasswordVisibility('password_old', 'eyeIcon_old')" id="eyeIconContainer_old" style="display: none;">
                                                            <i class="fa-solid fa-eye" id="eyeIcon_old"></i>
                                                            </span>
                                                        </div>
                                                        @if ($errors->has('password_old'))
                                                            <div class="custom_error">{{ $errors->first('password_old') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-lg-8 col-12">
                                                        <div class="input-focus-effect">
                                                            <input class="input_user" id="password" type="password" name="password" placeholder="Mật khẩu mới ..." value="{{ old('password') }}" oninput="toggleEyeIconVisibility('password', 'eyeIconContainer')">
                                                            <span class="toggle-password" onclick="togglePasswordVisibility('password', 'eyeIcon')" id="eyeIconContainer" style="display: none;">
                                                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                                        </span>
                                                        </div>
                                                        @if ($errors->has('password'))
                                                            <div class="custom_error">{{ $errors->first('password') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-lg-8 col-12">
                                                        <div class="input-focus-effect">
                                                            <input class="input_user" id="password_confirmation" name="password_confirmation" type="password" placeholder="Xác nhận lại mật khẩu mới ..." value="{{ old('password_confirmation') }}" oninput="toggleEyeIconVisibility('password_confirmation', 'eyeIconContainer_confirmation')">
                                                            <span class="toggle-password" onclick="togglePasswordVisibility('password_confirmation', 'eyeIcon_confirmation')" id="eyeIconContainer_confirmation" style="display: none;">
                                                            <i class="fa-solid fa-eye" id="eyeIcon_confirmation"></i>
                                                        </span>
                                                        </div>
                                                        @if ($errors->has('password_confirmation'))
                                                            <div class="custom_error">{{ $errors->first('password_confirmation') }}</div>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="submit-btn mt-25 text-center">
                                                    <button type="submit" class="categories_button"><span class="categories_link">Cập nhật</span></button>
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



@endsection

