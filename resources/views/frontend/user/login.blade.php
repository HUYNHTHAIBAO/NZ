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

        .custom_line {
            width: 100%;
            height: 2px;
            background: #ccc;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom_line_text {
            background-color: #fff; /* Màu nền của văn bản */
            padding: 0 10px; /* Khoảng cách giữa văn bản và đường kẻ */
        }

        .icon_login {
            width: 40px;
            height: 40px;
        }

        .google_login:hover {
            background: #eee;
            border: 1px solid #ccc;
            transition: all 0.2s linear;
        }


        .facebook_login:hover {
            background: #eee;
            border: 1px solid #ccc;
            transition: all 0.2s linear;
        }
        /*//*/


    </style>
    <!-- singUp-area -->
    <section class="singUp-area custom_session">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-6 col-lg-6">
                    <img src="{{asset('storage/frontendNew')}}/assets/img/login.png"
                         alt="">
                </div>
                <div class="col-12 col-xl-4 col-lg-4 pt-5 py-3">
                    <form action="#" class="" method="POST">
                        @csrf
                        <h2 class="text-center">Đăng nhập để tiếp tục hành trình học tập của bạn</h2>
                        <div class="input-focus-effect">

                            <input type="text" name="phone_or_email" placeholder=" "/>
                            <label>Số điện thoại or Email</label>
                        </div>
                        @if ($errors->has('phone_or_email'))
                            <div class="custom_error">{{ $errors->first('phone_or_email') }}</div>
                        @endif


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

                        <button type="submit" class="btn_custom p-2 col-12 mt-4">Đăng nhập</button>


{{--                        <div class="mt-5 mb-3">--}}
{{--                            <div class="text-center custom_line">--}}
{{--                                <span class="custom_line_text">--}}
{{--                                    Các tùy chọn đăng nhập khác--}}
{{--                                </span>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="d-flex align-items-center justify-content-center my-3">--}}
{{--                            <a href="">--}}
{{--                                <div class="p-2 m-2 border border-1 google_login">--}}
{{--                                    <img src="https://cdn-icons-png.flaticon.com/128/300/300221.png" alt=""--}}
{{--                                         class="icon_login">--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a href="">--}}
{{--                                <div class="p-2 m-2 border border-1 facebook_login">--}}
{{--                                    <img src="https://cdn-icons-png.flaticon.com/128/733/733547.png" alt=""--}}
{{--                                         class="icon_login">--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}

                        <div class="p-2 bg-light text-center mt-3">
                            <p class="text-black m-0">Bạn không có tài khoản ? <a href="{{route('frontend.user.register')}}" class="text-decoration-underline font_weight_bold"> Đăng ký</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- singUp-area-end -->


@endsection
