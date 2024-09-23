@extends('frontend.layouts.frontend')
@section('content')
    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard__content-wrap">
                        <div class="pb-4">
                            <p class="bg-light p-1"><a class="text-black font_weight_bold"
                                                       href="{{route('frontend.user.profile')}}"> Tài khoản </a> / Danh
                                sách gói</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <a href="{{route('frontend.plan.add')}}"
                                       class="btn arrow-btn btn-four categories_button">
                                        Tạo gói mới
                                    </a>

                                    <div class="py-5">
                                        <div class="row">
                                            @foreach($data as $key => $item)
                                                <div class="col-12 col-md-6 col-lg-4 mt-2 mt-md-0">
                                                    <div class="card position-relative" style="">
                                                            <p class="position-absolute top-0 left-0 bg-light text-black p-2 m-2 rounded-2">Gói : {{$item->sort ?? ''}}</p>
                                                        <div class="card-body ">
                                                            <h5 class="card-title mt-5">{{$item->title ??' '}}</h5>
                                                            <p class="card-text">{{$item->desc ?? ''}}</p>
                                                            <p><span class="font-weight-bold">Giá</span> : {{format_number_vnd($item->price ?? '')}} vnđ</p>
                                                            <p><span class="font-weight-bold">Trạng thái :</span>
                                                                @if($item->status == 1)
                                                                    <span class="badge bg-info text-white"> Bật </span>
                                                                @else
                                                                    <span class="badge bg-warning text-white"> Tắt </span>
                                                                @endif
                                                            </p>

                                                            <div class="text-center mt-3 ">
                                                                <a href="{{route('frontend.plan.edit', $item->id)}}"
                                                                        class="btn arrow-btn btn-four categories_button  ">
                                                                    Cập nhật
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    {{--                                    <div class="mt-2 d-flex justify-content-end">--}}
                                    {{--                                        <nav aria-label="Page navigation example">--}}
                                    {{--                                            <ul class="pagination">--}}
                                    {{--                                                {{$data->links()}}--}}
                                    {{--                                            </ul>--}}
                                    {{--                                        </nav>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
