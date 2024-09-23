@extends('frontend.layouts.frontend')

@section('content')

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
                            <h4 class="title text-center">Xem hồ sơ</h4>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-12">
                                <div class="profile__content-wrap">
                                    <ul class="list-wrap">
                                        <li class="text-black"><span >Họ tên</span> {{$user->fullname ?? ''}}</li>
                                        <li class="text-black"><span>Email</span> {{$user->email ?? ''}}</li>
                                        <li class="text-black"><span>Số điện thoại</span> {{$user->phone ?? ''}}</li>

                                        <li>
                                            <span class="text-black">Loại tài khoản</span>
                                            @if($user->account_type == 0)
                                                <span class="font-weight-bold text-black">Người dùng</span>
                                            @elseif($user->account_type == 1)
                                                <span class="font-weight-bold text-black">Đang chờ duyệt</span>
                                            @elseif($user->account_type == 2)
                                                <span class="font-weight-bold text-black">Chuyên gia</span>
                                            @else
                                                <span class="font-weight-bold text-black">Chưa xác định</span>
                                            @endif
                                        </li>

                                        <li class="text-black"><span>Ngày tham gia :</span> {{date_format($user->created_at, 'd/m/Y')}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- dashboard-area-end -->

@endsection
