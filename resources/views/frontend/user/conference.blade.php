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
                            <h4 class="title text-center">Danh sách hội nghị</h4>
                        </div>
                        <div class="row justify-content-center">
                            <div class="row">
                                @foreach($data as $k=>$item)
                                    @if(!empty($item->alias))
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mt-5">
                                    <div class="shine__animate-item" style="background-color: #f6f6f6; border-radius: 10px; overflow: hidden;border: 1px solid #eee">
                                        <div class="courses__item-content p-2">
                                            <div class="courses__item-img">
                                                <h5>Phòng họp số : {{ $k+1 }}</h5>
                                                <h6>Mã cuộc họp: {{ $item->rom_code }}</h6>
                                                <h6>Ngày bắt đầu : {{ $item->date }}  {{ $item->time_start }}</h6>
{{--                                                <a href="https://quickom.com/j/{{ $item->alias }}" target="_blank">--}}
{{--                                                    <button class="categories_button text-white">Bắt đầu</button>--}}
{{--                                                </a>--}}

                                                <a href="{{ url('/tai-khoan/danh-sach-hoi-nghi.html?alias='.$item->alias.'') }}" target="_blank">
                                                    <button class="categories_button text-white" data-href="{{ url('/tai-khoan/danh-sach-hoi-nghi.html?alias='.$item->alias.'') }}" data-date="{{ $item->date }} " data-time="{{ $item->time_start }}" >Bắt đầu</button>
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- dashboard-area-end -->

@endsection
@section('script')
    <script>
        $(document).ready(function () {


            $('.categories_button').click(function () {
                event.preventDefault();
                var dateTimeString = $(this).data('date') + ' ' + $(this).data('time') ;
                var href = $(this).data('href');
                // Chuyển chuỗi thành đối tượng Date
                var itemDateTime = new Date(dateTimeString);

                // Lấy ngày giờ hiện tại của hệ thống
                var currentDateTime = new Date();

                // So sánh
                if (itemDateTime >= currentDateTime) {
                    console.log("Thời gian trong tương lai");
                    window.open(href, '_blank');
                } else {
                    Swal.fire({
                        title: "Thông báo.",
                        text: "Phòng họp đã quá thời hạn bắt đầu.",
                        icon: "warning"
                    });
                }
            });
        })
    </script>
@endsection
