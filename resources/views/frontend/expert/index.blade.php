@extends('frontend.layouts.frontend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .form-check-input.error {
            border-color: red; /* Màu đỏ cho viền checkbox */
            outline: none; /* Loại bỏ viền ngoài */
            box-shadow: 1px 1px 5px 5px rgba(140, 56, 56, 0.6);
        }
        .toast-warning {
            background-color: #ffa400; /* Màu vàng cho thông báo cảnh báo */
            color: #fff;
        }
        .toast-error {
            background-color: #d9534f; /* Màu đỏ cho thông báo lỗi */
            color: #fff;
        }
        .toast-success {
            background-color: #5bc0de; /* Màu xanh cho thông báo thành công */
            color: #fff;
        }
        .toast-info {
            background-color: #5bc0de; /* Màu xanh dương cho thông báo thông tin */
            color: #fff;
        }
    </style>

    <section class="courses__details-area custom_session">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 row expert_details">
                    <div class="courses__details-thumb mb-2 col-12 col-lg-12 col-xl-4">
                        <div class="p-2">
                            <a href="/" class="text-black">Neztwork</a> /
                            <a href="{{route('frontend.product.main')}}" class="text-black">Chuyên gia</a> /
                            <span>{{$expert->fullname ?? ''}}</span>
                        </div>
                        @if($expert->avatar_file_path)
                            <img
                                src="{{ asset('storage/uploads') . '/' . ($expert->avatar_file_path ?? '') }}"
                                alt="{{str_slug($expert->fullname ?? '')}}"
                                style="width: 100%; height: 400px; object-fit: cover">

                        @else
                            <div class="bg-black d-flex align-items-center justify-content-center"
                                 style="width: 100%; height: 400px;">
                                                <span class="text-white font_weight_bold"
                                                      style="font-size: 40px; font-weight: bold">{{ $expert->avatar_name ?? '' }}</span>
                            </div>
                        @endif
                        <p class="text-center p-2 text-black text-uppercase mt-2 mb-1"
                           style="font-size: 20px"> {{$expert->job ?? ''}}</p>
                        <div class="text-center">
                        @php
                            use App\Models\FollowExpert;
                            use Illuminate\Support\Facades\Auth;
                            $currentUserId = Auth::guard('web')->id();
                            $follow = FollowExpert::where('user_id', $currentUserId)
                                                  ->where('expert_id', $expert->id)
                                                  ->first();
                        @endphp
                        @if($currentUserId != $expert->id) <!-- Kiểm tra nếu người dùng đang xem không phải là chuyên gia -->
                            @if($follow)
                                <form action="{{ route('frontend.unfollowExpert', $expert->id) }}"
                                      method="post" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="m-0 btn_custom">Bỏ theo dõi</button>
                                </form>
                            @else
                                <form action="{{ route('frontend.followExpert', $expert->id) }}"
                                      method="post">
                                    @csrf
                                    <button type="submit" class="m-0 btn_custom">Theo dõi</button>
                                </form>
                            @endif
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-lg-12 col-xl-4 expert_detail_about"
                         style="">
                        <div class="courses__instructors-content mt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img class="me-2"
                                         src="https://cdn-icons-png.flaticon.com/128/10629/10629607.png"
                                         style="width: 25px; height: 25px;" alt="">
                                    <div class="author font_weight_bold m-0 d-flex align-items-center my-1">
                                        <p class=" m-0 text-black"
                                           style="font-size: 24px; font-weight: bold">{{ $expert->fullname ?? '' }}
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <ul class="courses__item-meta list-wrap d-flex align-items-center">
                                <li class="courses__item-tag">
                                    <form action="{{ route('frontend.product.main') }}" method="get" class="m-0">
                                        <input type="hidden" name="category_id_expert"
                                               value="{{$expert->categoryExpert[0]['id'] ?? ''}}">
                                        <button type="submit" class=""
                                                style="background-color: #000; border-radius: 20px; border: none; color: #fff; padding: 5px 10px">
                                            <span class="text-center text-white custom_line_1"
                                                  style="font-size: 14px">{{$expert->categoryExpert[0]['name'] ?? ''}}</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>


                            <p>
                            @if($rating >= 1)
                                <li class="avg-rating">
                                    <img class="" src="https://cdn-icons-png.flaticon.com/128/616/616489.png"
                                         style="width: 25px; height: 25px;" alt="">
                                    <span class="text-black" style="font-size: 16px">{{ $rating }} </span> <span>( 1000 )</span>
                                </li>

                            @else
                                <li class="avg-rating">
                                    <img class="" src="https://cdn-icons-png.flaticon.com/128/616/616489.png"
                                         style="width: 25px; height: 25px;" alt="">
                                    Chưa có đánh giá
                                </li>
                                @endif
                                </p>


                                <h6 class="m-0">About me</h6>
                                <div class="instructor__social py-3">
                                    <ul class="list-wrap justify-content-start">
                                        @if($expert->facebook_link != null)
                                            <li>
                                                <a href="{{$expert->facebook_link}}">
                                                    <img src="https://cdn-icons-png.flaticon.com/128/2175/2175193.png"
                                                         alt="">
                                                </a>
                                            </li>
                                        @endif

                                        @if($expert->x_link != null)
                                            <li>
                                                <a href="{{$expert->x_link}}">
                                                    <img src="https://cdn-icons-png.flaticon.com/128/5969/5969020.png"
                                                         alt="">
                                                </a>
                                            </li>
                                        @endif

                                        @if($expert->instagram_link != null)
                                            <li>
                                                <a href="{{$expert->instagram_link}}">
                                                    <img src="https://cdn-icons-png.flaticon.com/128/3670/3670274.png"
                                                         alt="">
                                                </a>
                                            </li>
                                        @endif

                                        @if($expert->tiktok_link != null)
                                            <li>
                                                <a href="{{$expert->tiktok_link}}">
                                                    <img src="https://cdn-icons-png.flaticon.com/128/4782/4782345.png"
                                                         alt="">
                                                </a>
                                            </li>
                                        @endif

                                        @if($expert->linkedin_link != null)
                                            <li>
                                                <a href="{{$expert->linkedin_link}}">
                                                    <img src="https://cdn-icons-png.flaticon.com/128/1384/1384014.png"
                                                         alt="">
                                                </a>
                                            </li>
                                        @endif


                                    </ul>
                                </div>
                                <div>
                                    <pre class="text-black"
                                         style="font-family: 'Kanit', sans-serif !important; white-space: pre-wrap;">{{$expert->bio ?? ''}}</pre>
                                </div>

                                <h6>Thing I can advice on</h6>
                                <div>
                                    <pre class="text-black"
                                         style="font-family: 'Kanit', sans-serif !important;white-space: pre-wrap;">{{$expert->advise ?? ''}}</pre>
                                </div>


                        </div>
                    </div>

                    <div class="col-12 col-lg-12 col-xl-4 expert_detail_package">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="">
                               <span class="px-4 py-2 arow_sidebar bg-secondary col-2 "
                                     style="display: none; cursor: pointer; padding: 10px; margin-bottom: 20px; border-radius: 10px">
                                   <i class="fa-solid fa-backward font_weight_bold d-flex align-items-center justify-content-center"
                                      style="color: #fff"></i>

                               </span>
                            </div>
                            <div class="">
                                <button type="button" class="bg-secondary info_sidebar" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop"
                                        style="border: none; display: none; cursor: pointer; padding: 10px;  margin-bottom: 20px; border-radius: 10px">
                                    <i class="fa-solid fa-circle-info" style="color: #fff"></i>
                                </button>
                                {{-- // modal--}}
                                @include('frontend.expert.modals.rule')

                            </div>
                        </div>
                        <div class="sidebar mt-2">
                            <div class="courses__details-sidebar mt-2" id="sidebar_expertCall"
                                 style="border-radius: 10px; background-color: #F1F2F3">
                                <div class="sidebar__header" id="sidebar_expertCall_text"
                                     style="border-radius: 10px 0px 10px 0px">
                                    <span>Đặt cuộc gọi video</span>
                                </div>
                                <div class="sidebar__content ">
                                    <p class="text-black " style="font-size: 20px; font-weight: bold">Tư vấn 1:1 với
                                        chuyên gia</p>
                                    <p>Đặt lịch tư vấn trực tiếp qua cuộc gọi video 1:1 cùng với chuyên gia và nhận lời
                                        khuyên cá nhân</p>
                                    <button class="categories_button w-100" id="btn_time"><span class="categories_link">XEM THỜI GIAN</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- Gói tháng //--}}
                        <div class="sidebarMonth">
                            @foreach($expertPlan as $item)
                                <form action="" method="post" class="">
                                    @csrf
                                    <div class="mt-4">
                                        <div class="courses__details-sidebar mt-2" id="sidebar_expertCallMonth"
                                             style="border-radius: 10px; background-color: #F1F2F3">
                                            <div class="sidebar__header" id="sidebar_expertCallMonth_text"
                                                 style="border-radius: 10px 0px 10px 0px ">
                                                <span>{{$item->title ?? ''}} / {{format_number_vnd($item->price ?? '')}} vnđ</span>
                                            </div>
                                            <div class="sidebar__content">
                                                <pre class="text-black"
                                                     style="font-family: 'Kanit', sans-serif !important; white-space: pre-wrap;">{!! $item->desc ?? '' !!}</pre>
                                                <button type="button"
                                                        class="categories_button w-100  {{ $item->option_plan == 1 ? 'btn_time_month' : 'btn_time_group' }}"

                                                        data-id="{{$item->id}}"
                                                        id="{{ $item->option_plan == 1 ? 'btn_time_month' : 'btn_time_group' }}"><span
                                                        class="categories_link">ĐẶT LỊCH</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        </div>


                        @if(isset($expert->questions))
                            <div class="question mt-2">
                                <div class="courses__details-sidebar mt-2"
                                     style="border-radius: 10px; background-color: #F1F2F3">
                                    <div class="sidebar__header"
                                         style="border-radius: 10px 0px 10px 0px">
                                        <span class="text-black text-center">Question to ask with me</span>
                                    </div>
                                    <div class="sidebar__content mt-2">
                                        <pre class="text-black"
                                             style="font-family: 'Kanit', sans-serif !important; white-space: pre-wrap;">{{ $expert->questions ?? '' }}</pre>
                                    </div>
                                </div>
                            </div>
                        @else


                        @endif

                        {{--                        // điều khoản--}}


                        {{-- // chọn thời gian--}}
                        @include('frontend.expert.components.select_time')
                    </div>

                    <!-- Checkbox điều khoản -->
                    <div class="vnpay_neztwork_terms my-3">
                        <div class="form-check" style="display: inline-block; float: right;">
                            <input class="form-check-input" type="checkbox" value="" id="vnpay_neztwork_terms" style="cursor: pointer">
                            <label class="form-check-label" for="vnpay_neztwork_terms">
                                Đã đọc, hiểu và đồng ý với
                                <a class="text-decoration-underline" href="https://neztwork.com/chinh-sach-gia-ca-va-khuyen-mai.html" target="_blank">
                                    Chính sách hoàn hủy của NZ
                                </a>
                            </label>

                        </div>
                    </div>


                </div>

                {{--  // video youtube--}}
                @include('frontend.expert.components.youtube')
                {{--  // video ngắn --}}
                @include('frontend.expert.components.video_short')



                {{--  // video tiktok--}}
                @include('frontend.expert.components.tiktok')
                @include('frontend.expert.components.video_facebook')
                @include('frontend.expert.components.video_intagram')



                {{--    // bài viết --}}
                @include('frontend.expert.components.post')
                {{--                // Hồ sơ khác--}}
                @include('frontend.expert.components.profile_orther')
                {{--   // đánh giá--}}
                @include('frontend.expert.components.review')
                {{--   // Chuyên gia tương tự --}}
                @include('frontend.expert.components.expert_related')
                {{--   // Câu hỏi --}}
                @include('frontend.expert.components.question')
            </div>
        </div>
    </section>
    @include('frontend.expert.modals.addUser')
    @endsection
    @section('style')
    @include('frontend.expert.components.style')
    </style>
@endsection


@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Cấu hình toastr (chỉ cần cấu hình một lần)
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Hàm xử lý sự kiện cho các nút
        function handleButtonClick(event) {
            var checkbox = document.getElementById('vnpay_neztwork_terms');
            if (!checkbox.checked) {
                // Hiển thị thông báo (toast)
                toastr.warning('Bạn cần chấp nhận điều khoản để tiếp tục.', 'Thông báo');
                // Tô đỏ ô checkbox
                checkbox.classList.add('error');
                // Ngăn không cho thực hiện hành động tiếp theo
                event.stopImmediatePropagation();
                event.preventDefault();
            } else {
                // Xóa lớp đỏ nếu checkbox đã được chọn
                checkbox.classList.remove('error');
            }
        }

        // Thêm sự kiện cho các nút
        document.getElementById('btn_time_group').addEventListener('click', handleButtonClick);
        document.getElementById('btn_time').addEventListener('click', handleButtonClick);
        document.getElementById('btn_time_month').addEventListener('click', handleButtonClick);



        var group_id = null;
        var arrayEmail = [];
        $(document).ready(function () {
            $('.btn_time_month').on('click', function () {
                var id = $(this).data('id');
                let data = {
                    id: id,
                    key: 2,
                    _token: "{{ csrf_token() }}"
                }

                $.ajax({
                    url: "{{ route('frontend.expert.booking.plan') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        //console.log(data.data.data.id)
                        window.location.href = '{{ url('/thong-tin-dat-lich') }}/' + data.data.data.id;
                    }
                });
            })

            $('.btn_time_group').on('click', function (event) {
                event.preventDefault();

                var id = $(this).data('id');
                window.location.href = `/chon-thoi-gian-dat-lich-goi-nhom/${id}`;
                // Gửi yêu cầu Ajax tới server để mã hóa id
                {{--$.ajax({--}}
                {{--    url: '/encrypt-id', // URL để server xử lý mã hóa--}}
                {{--    method: 'POST',--}}
                {{--    data: {--}}
                {{--        id: id,--}}
                {{--        _token: '{{ csrf_token() }}' // Đảm bảo thêm token CSRF cho bảo mật--}}
                {{--    },--}}
                {{--    success: function (response) {--}}
                {{--        // Khi thành công, chuyển hướng với id đã mã hóa--}}
                {{--        window.location.href = `/chon-thoi-gian-dat-lich-goi-nhom/${response.encryptedId}`;--}}
                {{--    }--}}
                {{--});--}}
            });


            $('.btn-order-group').on('click', function () {
                event.preventDefault();
                let data = {
                    id: group_id,
                    email: arrayEmail,
                    key: 3,
                    date: $('#min-date').val(),
                    time: $('#min-time').val(),
                    _token: "{{ csrf_token() }}"
                }
                $.ajax({
                    url: "{{ route('frontend.expert.booking.plan') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        console.log(data)
                        window.location.href = '{{ url('/thong-tin-dat-lich') }}/' + data.data.data.id;
                    }
                });

            })
        });


    </script>
@endsection
@include('frontend.expert.components.script')

