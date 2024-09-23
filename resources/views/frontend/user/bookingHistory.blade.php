@extends('frontend.layouts.frontend')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard__content-wrap">
                        <div class="pb-4">
                            <p class="bg-light p-1"><a class="text-black font_weight_bold"
                                                       href="{{route('frontend.user.profile')}}"> Tài khoản </a> / Quản
                                lý đặt lịch</p>
                        </div>
                        <div class="row">
                            <?php $account_type = Illuminate\Support\Facades\Auth::guard('web')->user()->account_type; ?>
                            @foreach($data as $key => $item)
                                <div class="col-12 col-md-6 col-lg-4 col-xl-2 mt-5">
                                    <div class="shine__animate-item"
                                         style="background-color: #f6f6f6; border-radius: 10px; overflow: hidden;border: 1px solid #eee">
                                        <div class="courses__item-content p-2">
                                            <div class="courses__item-img">
                                                <ul>
                                                    <li>Mã đặt lịch: #{{$item->id ?? ''}}</li>
                                                    <li>Loại cuộc họp:
                                                        @if($item->key == 3)
                                                            Theo nhóm
                                                        @elseif($item->key == 2)
                                                            Theo tháng
                                                        @else
                                                            Theo ngày
                                                        @endif
                                                    </li>
                                                    <li>Thời gian:
                                                        @if(!empty($item->list_email))
                                                            {{$item->created_at->format('d-m-Y')}}
                                                        @elseif(empty($item->time))
                                                            {{$item->created_at->format('d-m-Y')}}
                                                        @else
                                                            {{$item->duration_id}} - {{$item->time}}
                                                            - {{format_date_custom($item->date)}}
                                                        @endif
                                                    </li>
                                                    <li>{{ $account_type == 2 ? 'Tên KH' : 'Tên CG' }}
                                                        : {{ $account_type == 2 ? $item->user->fullname ?? ''  : $item->userExpert->fullname ?? ''  }}</li>
                                                    <li>Ngày đặt lịch: {{format_date_custom($item->date ?? '')}}</li>
                                                    <li>Trạng thái: @if($item->type_request_user == 1)
                                                            <span class="badge bg-warning text-white">
                                                                   Chờ xác nhận
                                                            </span>
                                                        @elseif($item->type_request_user == 2)
                                                            <span class="badge bg-success text-white">
                                                                    Đã xác nhận
                                                            </span>
                                                        @elseif($item->type_request_user == 3)
                                                            <span class="badge bg-danger text-white">
                                                                    Đã hủy
                                                            </span>
                                                        @elseif($item->type_request_user == 4)
                                                            <span class="badge bg-success text-white">
                                                                  Đã hoàn thành
                                                            </span>
                                                        @elseif($item->type_request_user == 5)
                                                            <span class="badge bg-info text-white">
                                                                  Đã xác nhận thương lượng
                                                            </span>
                                                        @elseif($item->type_request_user == 6)
                                                            <span class="badge bg-info text-white">
                                                                 Đã từ chối thương lượng
                                                            </span>
                                                        @elseif($item->type_request_user == 7)
                                                            <span class="badge bg-danger text-white">
                                                                 Quá hạn
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning text-white">
                                                                    Chưa xác định
                                                                </span>
                                                        @endif
                                                    </li>

                                                        @if(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 2)
                                                            @if($item->type == 4)
                                                                @if($item->rating_type == 2)
                                                                    <div class="dashboard__review-action">
                                                                        <a href="{{route('frontend.rating.detail',$item->id )}}"
                                                                           title="" class="categories_button"
                                                                           style="background-color: #000; color: #fff"><span
                                                                                class="">Xem đánh giá</span></a>
                                                                    </div>
                                                                    <div class="dashboard__review-action">
                                                                        <a href="{{route('frontend.rating.detail',$item->id )}}"
                                                                           title="" class="badge bg-light text-black"
                                                                           style="background-color: #000; color: #fff"><span>Xem đánh giá</span></a>
                                                                    </div>
                                                                @else
                                                                    <span class="dashboard__quiz-result fail">
                                                                    Chưa có đánh giá
                                                                </span>
                                                                @endif
                                                            @endif
                                                        @else
                                                            @if($item->type == 4)
                                                                @if($item->rating_type == 1)
                                                                    <div class="">
                                                                        <a href="{{route('frontend.rating.add',$item->id )}}"
                                                                           title="" class=""><span>Viết đánh giá</span></a>
                                                                    </div>


                                                                @else
                                                                    <div class="dashboard__review-action">
                                                                        <a href="{{route('frontend.rating.detail',$item->id )}}"
                                                                           title="" class="badge bg-light text-black"
                                                                           style="background-color: #000; color: #fff"><span>Xem đánh giá</span></a>
                                                                    </div>
                                                                    @endif
                                                                    @endif
                                                                    @endif
                                                                    </td>


                                                                    @if(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 2)
                                                                        <td>
                                                                            <div class="dashboard__review-action">
                                                                                <a href="{{route('frontend.user.check',$item->id )}}"
                                                                                   title="Edit"><i
                                                                                        class="skillgro-edit"></i></a>
                                                                            </div>
                                                                        </td>
                                                                    @elseif($item->type == 5)
                                                                        <td>
                                                                            @if($item->type_request_user == 1)
                                                                                <div class="dashboard__review-action">
                                                                                    <form
                                                                                        action="{{ route('frontend.user.userApproveNegotiate', $item->id) }}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        <button type="submit"
                                                                                                title="Chấp nhận"
                                                                                                class="action-button approve"
                                                                                                style="background: #eee; border: none; cursor: pointer; padding: 2px 10px; color: green">
                                                                                            <i class="fa-solid fa-check"></i>
                                                                                        </button>
                                                                                    </form>
                                                                                    <form id="cancelForm"
                                                                                          action="{{ route('frontend.user.UserCancelNegotiate', $item->id) }}"
                                                                                          method="post">
                                                                                        @csrf
                                                                                        <!-- Thay đổi loại nút từ submit thành button -->
                                                                                        <button type="button"
                                                                                                title="Hủy"
                                                                                                class="action-button cancel"
                                                                                                onclick="confirmCancel(event)"
                                                                                                style="background: #eee; border: none; cursor: pointer; padding: 2px 10px; color: red">
                                                                                            <i class="fa-solid fa-x"></i>
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif($item->type_request_user == 2)

                                                                            @elseif($item->type_request_user == 3)

                                                                            @elseif($item->type_request_user == 4)

                                                                            @elseif($item->type_request_user == 5)

                                                                            @elseif($item->type_request_user == 7)
                                                                                <span>Quá hạn</span>
                                                                    @endif
                                                                    @elseif($item->type == 2)
                                                                        <td>
                                                                            @if($item->type_request_user == 1)
                                                                                <div class="dashboard__review-action">
                                                                                    <form
                                                                                        action="{{ route('frontend.user.userApprove', $item->id) }}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        <button type="submit"
                                                                                                title="Chấp nhận"
                                                                                                class="action-button approve"
                                                                                                style="background: #eee; border: none; cursor: pointer; padding: 2px 10px; color: green">
                                                                                            <i class="fa-solid fa-check"></i>
                                                                                        </button>
                                                                                    </form>
                                                                                    <form id="cancelForm"
                                                                                          action="{{ route('frontend.user.UserCancel', $item->id) }}"
                                                                                          method="post">
                                                                                        @csrf
                                                                                        <!-- Thay đổi loại nút từ submit thành button -->
                                                                                        <button type="button"
                                                                                                title="Hủy"
                                                                                                class="action-button cancel"
                                                                                                onclick="confirmCancel(event)"
                                                                                                style="background: #eee; border: none; cursor: pointer; padding: 2px 10px; color: red">
                                                                                            <i class="fa-solid fa-x"></i>
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif($item->type_request_user == 2)

                                                                            @elseif($item->type_request_user == 3)

                                                                            @elseif($item->type_request_user == 4)

                                                                            @elseif($item->type_request_user == 5)

                                                                            @elseif($item->type_request_user == 7)
                                                                                <span>Quá hạn</span>
                                                                    @endif
                                                                @endif


                                                </ul>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        // Kiểm tra nếu có thông báo success trong session
        {{--Swal.fire({--}}
        {{--    title: 'Thông báo',--}}
        {{--    text: "{{ session('success') }}",--}}
        {{--    icon: 'success',--}}
        {{--    timer: 10000, // Thời gian hiển thị (10 giây)--}}
        {{--    timerProgressBar: true,--}}
        {{--    showCloseButton: true,--}}
        {{--    showConfirmButton: false--}}
        {{--});--}}
        @if (session('successNoti'))
        Swal.fire({
            title: 'Hủy cuộc gọi thành công',
            html: `<strong>Neztwork Thông báo:</strong><br>{{ session('successNoti') }}<br><br><em>Chúng tôi chân thành cảm ơn bạn !</em>`,
            icon: "success"
        });
        @endif
        @if (session('successNotiUserApproveBefore'))
        Swal.fire({
            title: 'NeztWork Thông báo',
            html: `{{ session('successNotiUserApproveBefore') }}<br><br><em>Chúng tôi chân thành cảm ơn bạn !</em>`,
            icon: "question"
        });
        @endif

        @if (session('successNotiUserApproveAfter'))
        Swal.fire({
            title: 'Xác nhận cuộc gọi thành công',
            html: `<strong>Neztwork Thông báo:</strong><br>{{ session('successNotiUserApproveAfter') }}<br><br><em>Chúng tôi chân thành cảm ơn bạn !</em>`,
            icon: "success"
        });
        @endif
    </script>
    <script>
        function confirmCancel(event) {
            event.preventDefault(); // Ngăn không cho form gửi ngay lập tức

            console.log('Confirm Cancel Function Called'); // Xác nhận hàm được gọi

            Swal.fire({
                title: 'Bạn có chắc chắn muốn hủy cuộc gọi này?',
                text: "Bạn sẽ không thể quay lại trước đó nếu bấm hủy!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d', // Màu xám cho nút "Thoát"
                confirmButtonText: 'OK',
                cancelButtonText: 'Thoát'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('User confirmed'); // Xác nhận người dùng đã nhấn OK
                    // Nếu người dùng nhấn OK, gửi form
                    document.getElementById('cancelForm').submit();
                }
            });
        }

    </script>
@endsection
