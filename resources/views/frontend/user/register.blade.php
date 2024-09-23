@extends('frontend.layouts.frontend')

@section('content')

    <style>
        .input-focus-effect {
            position: relative;
            display: flex;
            flex-direction: column-reverse;

        }

        .input-focus-effect input {
            padding: 25px 10px 10px;
            border: 1px solid #ccc;
            display: block;
            width: 100%;
            border-radius: 8px;
            transition: border 0.25s linear;
            background-color: transparent;
            outline: none;
            color: black;
            font-size: 12px;
        }

        .input-focus-effect input:focus {
            border-color: #000;
        }

        .input-focus-effect input:focus + label,
        .input-focus-effect input:not(:placeholder-shown) + label {
            transform: translateY(-5px);
            top: 10px;
        }

        .input-focus-effect label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            pointer-events: none;
            color: #000;
            transition: 0.25s linear;
            font-size: 12px;
            padding: 10px 0px;
            font-weight: 400;
        }
    </style>

    <main class="main-area fix">
        <!-- singUp-area -->
        <section class="singUp-area custom_session">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-xl-6 col-lg-6">
                        <img src="{{asset('storage/frontendNew')}}/assets/img/register.png"
                             alt="">
                    </div>

                    <div class="col-12 col-xl-4 col-lg-4 py-5">
                        {{--   @include('frontend.parts.errors')--}}
                        <form action="#" class="" method="POST">
                            @csrf
                            <h2 class="text-center">Đăng ký và bắt đầu học</h2>
                            <div class="input-focus-effect">

                                <input type="text" name="fullname" placeholder=" " value="{{old('fullname')}}"/>
                                <label>Tên đầy đủ</label>
                            </div>
                            @if ($errors->has('fullname'))
                                <div class="custom_error">{{ $errors->first('fullname') }}</div>
                            @endif

                            <div class="input-focus-effect">

                                <input type="text" name="phone" placeholder=""  value="{{old('phone')}}"/>
                                <label>Số điện thoại</label>
                            </div>
                            @if ($errors->has('phone'))
                                <div class="custom_error">{{ $errors->first('phone') }}</div>
                            @endif

                            <div class="input-focus-effect">

                                <input type="text" name="email" placeholder=" " value="{{old('email')}}"/>
                                <label>Email </label>
                            </div>
                            @if ($errors->has('email'))
                                <div class="custom_error">{{ $errors->first('email') }}</div>
                            @endif

{{--                            <div class="input-focus-effect">--}}

{{--                                <input type="password" name="password" placeholder=" " value="{{old('password')}}"/>--}}
{{--                                <label>Mật khẩu </label>--}}
{{--                            </div>--}}


                            <div class="input-focus-effect">
                                <input type="password" id="passwordAccount" name="password" placeholder=" " oninput="toggleEyeIconVisibilityAccount()" />
                                <label>Mật khẩu</label>
                                <span class="toggle-password" onclick="togglePasswordVisibilityAccount()" id="eyeIconContainerAccount" style="display: none;">
                            <i class="fa-solid fa-eye" id="eyeIconAccount"></i>
                            </span>
                            </div>





                        @if ($errors->has('password'))
                                <div class="custom_error">{{ $errors->first('password') }}</div>
                            @endif


{{--                            <div class="input-focus-effect">--}}

{{--                                <input type="password" name="password" placeholder=" " value="{{old('password')}}"/>--}}
{{--                                <label>Nhập lại mật khẩu </label>--}}
{{--                            </div>--}}
{{--                            @if ($errors->has('password'))--}}
{{--                                <div class="custom_error">{{ $errors->first('password') }}</div>--}}
{{--                            @endif--}}




                            <button type="submit" class="btn_custom p-2 col-12 mt-4">Đăng ký</button>

                            <div class="text-center px-2 py-3">
                                <small class="">Khi nhấn đăng ký, bạn đã đồng ý với <a href="{{route('frontend.info.termOfUse')}}"
                                                                                       class="text-decoration-underline font_weight_bold">Điều
                                        khoản sử dụng</a> và <a href="{{route('frontend.info.informationPrivacy')}}" class="text-decoration-underline font_weight_bold">Chính sách về
                                        quyền riêng tư</a></small>
                            </div>

                            <div class="p-2 bg-light text-center">
                                <p class="text-black m-0">Bạn đã có tài khoản ? <a href="{{route('frontend.user.login')}}"
                                                                               class="text-decoration-underline font_weight_bold"> Đăng
                                        nhập</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- singUp-area-end -->

    </main>
@endsection
