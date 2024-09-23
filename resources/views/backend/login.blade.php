@extends('backend.layouts.main')

@section('title', 'Login')

@section('content')
    <section id="wrapper">
        <div class="login-register" style="background-image:url({{ asset('/storage/backend/assets/images/background/login-register.jpg')}});">
            <div class="login-box card">
                <div class="card-body">
                    <form class="form-horizontal form-material" id="loginform" action="" method="post">
                        <h3 class="box-title m-b-20 text-center">Đăng nhập</h3>
                        @csrf
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="email_or_phone" type="tel" required="" placeholder="Số điện thoại/Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="password" type="password" required="" placeholder="Mật khẩu">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 font-14">
                                <div class="checkbox checkbox-primary pull-left p-t-0">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> Ghi nhớ đăng nhập </label>
                                </div>
                            </div>
                        </div>

                        @if(Session::has('msg'))
                            <div class="alert alert-danger">{{ Session::get('msg')}}</div>
                        @endif

                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">
                                    Đăng nhập
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

@endsection
