<style>
    .sidebar_user {
        margin: 0 !important;
        padding: 0 !important;
        list-style-type: none; /* Xóa dấu chấm đầu dòng của danh sách */
    }

    .sidebar_user a {
        display: block; /* Đảm bảo toàn bộ khu vực liên kết có thể nhấp được */
        padding: 5px; /* Tạo khoảng cách bên trong cho liên kết */
        color: #000; /* Màu chữ mặc định */
        font-weight: bold; /* Chữ in đậm */
        text-decoration: none; /* Xóa gạch chân mặc định của liên kết */
        transition: background-color 0.2s linear, color 0.2s linear; /* Chuyển tiếp mượt mà khi hover */
    }

    .sidebar_user a:hover,
    .sidebar_user a.active {
        background-color: #282626; /* Màu nền khi hover hoặc active */
        color: #fff !important; /* Màu chữ khi hover hoặc active */
    }
</style>


<div class="" style="border: 1px solid #ccc; padding: 20px">
    <nav class="dashboard__sidebar-menu">
        <div class="d-flex align-items-center justify-content-center">
            @if(!empty(Illuminate\Support\Facades\Auth::guard('web')->user()) && !empty(Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_file_path))
                <img
                    src="{{asset('storage/uploads') . '/' . Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_file_path ?? ''}}"
                    style="padding: 0px; display: block; width: 100px; height: 100px; object-fit: cover; border-radius: 50%;border: 1px solid #ccc"
                    alt="img">
            @else
                <div class="bg-black"
                     style="width: 100px; height: 100px; border-radius: 50%; border: 1px solid #eee; display: flex; align-items: center; justify-content: center;">
                    <span class="text-white font_weight_bold"
                          style="font-size: 30px">{{ Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_name ?? '' }}</span>
                </div>
            @endif
        </div>
        <div class="text-center">
            <p class="title font_weight_bold text-black">{{Illuminate\Support\Facades\Auth::guard('web')->user()->fullname ?? ''}}</p>
        </div>
    </nav>
    <nav class="dashboard__sidebar-menu">
        <ul class="list-wrap">
            <li class="sidebar_user">
                <a href="{{ route('frontend.user.profile') }}"
                   class="{{ request()->routeIs('frontend.user.profile') ? 'active' : '' }} text-black">
                    {{-- <i class="skillgro-avatar"></i> --}}
                    Xem hồ sơ
                </a>
            </li>

            <li class="sidebar_user">
                <a href="{{route('frontend.user.account')}}"
                   class="{{ request()->routeIs('frontend.user.account') ? 'active' : '' }} text-black">
                    {{--                    <i class="skillgro-settings"></i>--}}
                    Cập nhật Hồ sơ
                </a>
            </li>
            <li class="sidebar_user">
                <a href="{{route('frontend.user.avatar')}}"
                   class="{{ request()->routeIs('frontend.user.avatar') ? 'active' : '' }} text-black">
                    {{--                    <i class="skillgro-settings"></i>--}}
                    Ảnh
                </a>
            </li>
            <li class="sidebar_user">
                <a href="{{route('frontend.user.changePassword')}}"
                   class="{{ request()->routeIs('frontend.user.changePassword') ? 'active' : '' }} text-black">
                    Đổi mật khẩu
                </a>
            </li>

            @if( Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 0 && ( Illuminate\Support\Facades\Auth::guard('web')->user()->approved == 2 || Illuminate\Support\Facades\Auth::guard('web')->user()->approved == 5 ) )

            @else
                <li class="sidebar_user">
                    <a href="{{route('frontend.user.registerExpert')}}"
                       class="{{ request()->routeIs('frontend.user.registerExpert') ? 'active' : '' }} text-black">
                        Đăng ký chuyên gia
                    </a>
                </li>
            @endif

            @if( Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 0 )
                <li class="sidebar_user">
                    <a href="{{route('frontend.user.bookingHistory')}}"
                       class="{{ request()->routeIs('frontend.user.bookingHistory') ? 'active' : '' }} text-black">
                        {{--                        <i class="fa-regular fa-calendar"></i>--}}
                        Quản lý đặt lịch
                    </a>
                </li>
            @else

            @endif

            @if( Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 2 )
                <li class="sidebar_user">
                    <a href="{{route('frontend.user.setting.time')}}"
                       class="{{ request()->routeIs('frontend.user.setting.time') ? 'active' : '' }} text-black">
                        Lên lịch
                    </a>
                </li>
                <li class="sidebar_user">
                    <a href="{{route('frontend.plan.index')}}"
                       class="{{ request()->routeIs('frontend.plan.index') ? 'active' : '' }} text-black">
                        Tạo gói
                    </a>
                </li>

                {{--                <li>--}}
                {{--                    <a href="{{route('frontend.rating.index')}}">--}}
                {{--                        <i class="fa-regular fa-star"></i>--}}
                {{--                           Quản lý đánh giá--}}
                {{--                    </a>--}}
                {{--                </li>--}}

                {{--                <li>--}}
                {{--                    <a href="{{route('frontend.user.notification')}}">--}}
                {{--                        <i class="fa-regular fa-bell"></i>--}}
                {{--                        Lịch sử thông báo--}}
                {{--                    </a>--}}
                {{--                </li>--}}

                <li class="sidebar_user">
                    <a href="{{route('frontend.user.bookingHistory')}}"
                       class="{{ request()->routeIs('frontend.user.bookingHistory') ? 'active' : '' }} text-black">
                        Quản lý đặt lịch
                    </a>
                </li>
                <li class="sidebar_user">
                    <a href="{{route('frontend.user.conference')}}"
                       class="{{ request()->routeIs('frontend.user.conference') ? 'active' : '' }} text-black">
                        Danh sách hội nghị
                    </a>
                </li>



                <li class="sidebar_user">
                    <a href="{{route('frontend.blogExpert.index')}}"
                       class="{{ request()->routeIs('frontend.blogExpert.index') ? 'active' : '' }} text-black">
                        Bài viết
                    </a>
                </li>

                <li class="sidebar_user">
                    <a href="{{route('frontend.profileOrther.index')}}"
                       class="{{ request()->routeIs('frontend.profileOrther.index') ? 'active' : '' }} text-black">
                        Hồ sơ khác
                    </a>
                </li>



                <li class="sidebar_user">
                    <a href="{{route('frontend.youtubeExpert.index')}}"
                       class="{{ request()->routeIs('frontend.youtubeExpert.index') ? 'active' : '' }} text-black">
                        Youtube
                    </a>
                </li>


                <li class="sidebar_user">
                    <a href="{{route('frontend.shortVideoExpert.index')}}"
                       class="{{ request()->routeIs('frontend.shortVideoExpert.index') ? 'active' : '' }} text-black">
                        Video ngắn
                    </a>
                </li>

                <li class="sidebar_user">
                    <a href="{{route('frontend.questionExpert.index')}}"
                       class="{{ request()->routeIs('frontend.questionExpert.index') ? 'active' : '' }} text-black">
                        Câu hỏi Thường gặp
                    </a>
                </li>

                <li class="sidebar_user">
                    <a href="{{route('frontend.wallet.index')}}"
                       class="{{ request()->routeIs('frontend.wallet.index') ? 'active' : '' }} text-black">
                        Ví
                    </a>
                </li>
            @else

            @endif

            <li class="sidebar_user">
                <a href="{{route('frontend.user.logout')}}"
                   class="{{ request()->routeIs('frontend.user.logout') ? 'active' : '' }} text-black">
                    Đăng xuất
                </a>
            </li>
        </ul>
    </nav>
</div>
