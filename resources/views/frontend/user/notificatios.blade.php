@extends('frontend.layouts.frontend')

@section('content')

    <!-- breadcrumb-area -->
    <div class="breadcrumb__area breadcrumb__bg breadcrumb__bg-three  mb-5"
         data-background="{{asset('storage/backend')}}/assets/img/bg/breadcrumb_bg.jpg" style="">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content">
                        {{-- <h3 class="title">Đăng nhập</h3>--}}
                        <nav class="breadcrumb">
                                <span property="itemListElement" typeof="ListItem">
                                    <a href="/">Trang chủ</a>
                                </span>
                            <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>
                            <span property="itemListElement" typeof="ListItem">Lịch sử thông báo</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb__shape-wrap">
            <img src="{{asset('storage/frontendNew')}}/assets/img/others/breadcrumb_shape01.svg" alt="img"
                 class="alltuchtopdown">
            <img src="{{asset('storage/frontendNew')}}/assets/img/others/breadcrumb_shape02.svg" alt="img"
                 data-aos="fade-right" data-aos-delay="300" class="aos-init aos-animate">
            <img src="{{asset('storage/frontendNew')}}/assets/img/others/breadcrumb_shape03.svg" alt="img"
                 data-aos="fade-up" data-aos-delay="400" class="aos-init aos-animate">
            <img src="{{asset('storage/frontendNew')}}/assets/img/others/breadcrumb_shape04.svg" alt="img"
                 data-aos="fade-down-left" data-aos-delay="400" class="aos-init aos-animate">
            <img src="{{asset('storage/frontendNew')}}/assets/img/others/breadcrumb_shape05.svg" alt="img"
                 data-aos="fade-left" data-aos-delay="400" class="aos-init aos-animate">
        </div>
    </div>
    <!-- breadcrumb-area-end -->

    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120">
        <div class="container">
            @include('frontend.user.header')
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.user.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="dashboard__content-wrap">
                        <div class="dashboard__content-title">
                            <h4 class="title">Lịch sử đặt lịch</h4>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard__review-table">
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="">Tên khách hàng</th>
                                            <th style="width: 200px">Tin nhắn</th>
                                            <th style="">Ngày</th>
                                            @if(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 2)
                                            <th class="d-flex justify-content-end">Trạng thái</th>
                                            @else

                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $key => $item)
                                            <tr>
                                                <td>
                                                    {{$key+=1}}
                                                </td>
                                                <td>
                                                    <p class="color-black">{{$item->user->fullname ?? ''}}</p>
                                                </td>

                                                <td>
                                                <span class="color-black">
                                                    {{$item->note ?? ''}}
                                                </span>
                                                </td>
                                                <td>
                                                    <p class="color-black">{{format_date_custom($item->date ?? '')}}</p>
                                                </td>


                                                @if(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 2)
                                                    <td class="">
                                                        <div class="dashboard__review-action">
                                                            <a href="{{route('frontend.user.check',$item->id )}}"
                                                               title="Edit"><i class="skillgro-edit"></i></a>
                                                        </div>
                                                    </td>
                                                @else

                                                @endif
                                            </tr>
                                        @empty

                                        @endforelse
                                        </tbody>
                                    </table>


                                    <div class="mt-2 d-flex justify-content-end">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                {{$data->links()}}
                                            </ul>
                                        </nav>
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
