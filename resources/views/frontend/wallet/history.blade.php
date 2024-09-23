@extends('frontend.layouts.frontend')

@section('content')

    <!-- dashboard-area -->
    <section class="dashboard__area custom_session">
        <div class="container">
            @include('frontend.user.header')
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.user.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="dashboard__content-wrap">
                        <div class="pb-4">
                            <p class="bg-light p-1"><a class="text-black font_weight_bold" href="{{route('frontend.user.profile')}}"> Tài khoản </a> /
                                <a class="text-black font_weight_bold" href="{{route('frontend.wallet.index')}}"> Quản lý Ví </a> / <span>Lịch sử rút tiền</span>
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard__review-table">
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ngân hàng</th>
                                            <th>STK</th>
                                            <th>Tên chủ tài khoản</th>
                                            <th>Số tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $key => $item)
                                            <tr>
                                                <td>
                                                    {{$key+=1}}
                                                </td>
                                                <td>
                                                    <p class="color-black">{{$item->bank_name ?? ''}}</p>
                                                </td>
                                                <td>
                                                    <p class="color-black">{{$item->bank_stk ?? ''}}</p>
                                                </td>
                                                <td>
                                                    <p class="color-black">{{$item->name ?? ''}}</p>
                                                </td>

                                                <td>
                                                    <p class="color-black">{{number_format($item->price ?? '', 0, ',', '.')}} vnđ</p>
                                                </td>

                                                <td>
                                                    @if($item->status == 1)
                                                        <span class="dashboard__quiz-result hold">
                                                        Đang chờ duyệt
                                                </span>
                                                    @elseif($item->status == 2)
                                                        <span class="dashboard__quiz-result">
                                                        Đã duyệt
                                                </span>
                                                    @else
                                                        <span class="dashboard__quiz-result">
                                                        Chưa xác định
                                                    </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <p class="color-black">{{format_date_custom($item->date ?? '')}}</p>
                                                </td>

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
