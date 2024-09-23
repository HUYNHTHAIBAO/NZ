<header class="topbar" style="background: linear-gradient(45deg, black, transparent);}">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header" style="background: linear-gradient(45deg, black, transparent);}">
            <a class="navbar-brand" href="{{Route('backend.dashboard')}}">
                <!-- Logo icon -->
                <b class="text-white">
                    <!-- Dark Logo icon -->
                    {{--                    <img src="{{ asset('/storage/backend/assets') }}/images/logo.png" height="45" alt="homepage"--}}
                    {{--                         class="dark-logo logo-img"/>--}}
                    Admin
                    <!-- Light Logo icon -->
                </b>
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
{{--        <div class="navbar-collapse col-12">--}}
{{--            <!-- ============================================================== -->--}}
{{--            <!-- toggle and nav items -->--}}
{{--            <!-- ============================================================== -->--}}
{{--            <ul class="navbar-nav mr-auto mt-md-0">--}}
{{--                <!-- This is  -->--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link  nav-toggler hidden-md-up text-muted waves-effect waves-dark"--}}
{{--                       href="javascript:void(0)"><i class="mdi mdi-menu"></i></a>--}}
{{--                </li>--}}
{{--                <li class="nav-item m-l-10">--}}
{{--                    <a class="nav-link  sidebartoggler hidden-sm-down text-muted waves-effect waves-dark"--}}
{{--                       href="javascript:void(0)"><i class="ti-menu"></i></a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--            <ul class="navbar-nav my-lg-0">--}}
{{--                <!-- Profile -->--}}
{{--                <!-- ============================================================== -->--}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark"--}}
{{--                       href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                        --}}{{--<img src="{{ asset('storage/uploads/backend/' . Auth()->guard('backend')->user()->avatar) }}" alt="user" class="profile-pic"/></a>--}}
{{--                        <img src="{{ asset('/storage/backend/assets/images/users/5.jpg') }}" alt="user"--}}
{{--                             class="profile-pic"/></a>--}}
{{--                    <div class="dropdown-menu dropdown-menu-right scale-up">--}}
{{--                        <ul class="dropdown-user">--}}
{{--                            <li>--}}
{{--                                <div class="dw-user-box">--}}
{{--                                    <div class="u-img">--}}
{{--                                        --}}{{--<img src="{{ asset('storage/uploads/backend/' . Auth()->guard('backend')->user()->avatar) }}" alt="user">--}}
{{--                                        <img src="{{ asset('/storage/backend/assets/images/users/5.jpg') }}" alt="user">--}}
{{--                                    </div>--}}
{{--                                    <div class="u-text">--}}

{{--                                        <h4>{{Auth()->guard('backend')->user()->name}}</h4>--}}
{{--                                        <p class="text-muted">{{Auth()->guard('backend')->user()->email}}</p>--}}

{{--                                        <a href="{{route('backend.users.profile')}}"--}}
{{--                                           class="btn btn-rounded btn-danger btn-sm">Thông tin tài khoản</a></div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li role="separator" class="divider"></li>--}}
{{--                            <li><a href="{{route('backend.logout')}}"><i class="fa fa-power-off"></i> Thoát</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div>--}}
    </nav>
</header>

<aside class="left-sidebar col-3">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <div class="user-profile">
            <div class="profile-text">
                <h4 class="font-weight-bold p-2">KHU VỰC QUẢN TRỊ</h4>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav" style="height: 600px; overflow-y: auto">
            <ul id="sidebarnav">
                @if(auth()->guard('backend')->user()->can('index'))
                    <li class="">
                        <a href="{{route('backend.dashboard')}}" aria-expanded="false" class="">
                            <i class="mdi mdi-gauge"></i><span class="hide-menu font-weight-bold">Bảng điều khiển</span>
                        </a>
                    </li>
                @endif
                {{--                    @if(auth()->guard('backend')->user()->can('staff.index.blade.php'))--}}
                {{--                        <li>--}}
                {{--                            <a class="waves-effect" href="{{Route('backend.staff.index.blade.php')}}">--}}
                {{--                                <i class="mdi mdi-lock"></i><span class="hide-menu font-weight-bold">Quản trị viên</span>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                    @endif--}}
                @if(auth()->guard('backend')->user()->can('users.index'))
                    <li class="">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-account-multiple"></i> <span class="hide-menu font-weight-bold">QL Khách hàng</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li class=""><a class="font-weight-bold" href="{{Route('backend.users.index')}}"> <i
                                        class="mdi mdi-subdirectory-arrow-right"></i> Danh sách </a></li>
                        </ul>

                    </li>
                @endif


                @if(auth()->guard('backend')->user()->can('users.index'))
                    <li class="">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-account-check"></i> <span
                                class="hide-menu font-weight-bold">QL Chuyên gia</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li class=""><a class="font-weight-bold" href="{{Route('backend.expert.index')}}"> <i
                                        class="mdi mdi-subdirectory-arrow-right"></i> Danh sách </a></li>
                            <li class=""><a class="font-weight-bold" href="{{Route('backend.expert.expertApplication')}}"> <i
                                        class="mdi mdi-subdirectory-arrow-right"></i> HS đăng ký
                                    @php
                                        $registerExpert = \App\Models\CoreUsers::where('approved', 1)->count();
                                    @endphp
                                    <span class="badge bg-warning text-white">{{$registerExpert}}</span>
                                </a>
                            </li>
                            <li class=""><a class="font-weight-bold" href="{{Route('backend.expert.expertApplicationUpdate')}}">
                                    <i class="mdi mdi-subdirectory-arrow-right"></i> HS cập nhật
                                    @php
                                        $registerExpertUpdate = \App\Models\CoreUsers::where('approved', 4)->count();
                                    @endphp
                                    <span class="badge bg-warning text-white">{{$registerExpertUpdate}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif


                @if(auth()->guard('backend')->user()->can('setting.index'))
                    <li class="">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-settings"></i>
                            <span class="hide-menu font-weight-bold">Cài đặt</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li class=""><a class="" href="{{Route('backend.setting.index')}}"> <i
                                        class="mdi mdi-subdirectory-arrow-right"></i> Chung </a></li>
                            {{--                            <li><a class="f" href="{{Route('backend.menu.index.blade.php')}}"> <i class="mdi mdi-subdirectory-arrow-right"></i> Menu website </a></li>--}}
                            {{--                            <li><a class="" href="{{Route('backend.setting.coupon')}}"> <i class="mdi mdi-subdirectory-arrow-right"></i> Mã giảm giá</a></li>--}}
                            <li class="">
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <i class="fa-solid fa-house"></i> <span
                                        class="hide-menu font-weight-bold">QL Trang chủ</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li class=""><a class="" href="{{Route('backend.HomeGroup.edit', 2)}}"> <i
                                                class="mdi mdi-subdirectory-arrow-right"></i> Đội nhóm </a></li>
                                    <li class=""><a class="" href="{{Route('backend.HomeAi.edit', 1)}}"> <i
                                                class="mdi mdi-subdirectory-arrow-right"></i> Trợ lý AI </a></li>
                                </ul>
                            </li>

                            <li class="">
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <i class="mdi mdi-folder-multiple-image"></i> <span
                                        class="hide-menu font-weight-bold">QL Banner</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li class=""><a class="" href="{{Route('backend.banner.index')}}"> <i
                                                class="mdi mdi-subdirectory-arrow-right"></i> Danh sách </a></li>
                                    <li class=""><a class="" href="{{Route('backend.banner.add')}}"> <i
                                                class="mdi mdi-subdirectory-arrow-right"></i> Thêm mới </a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <i class="mdi mdi-folder-image"></i> <span class="hide-menu font-weight-bold">QL Đối tác</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li class=""><a class="" href="{{Route('backend.partner.index')}}"> <i
                                                class="mdi mdi-subdirectory-arrow-right"></i> Danh sách </a></li>
                                    <li class=""><a class="" href="{{Route('backend.partner.add')}}"> <i
                                                class="mdi mdi-subdirectory-arrow-right"></i> Thêm mới </a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <i class="mdi mdi-laptop"></i> <span
                                        class="hide-menu font-weight-bold">QL Quy trình</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li class=""><a class="" href="{{Route('backend.booking.index')}}"> <i
                                                class="mdi mdi-subdirectory-arrow-right"></i> Danh sách </a></li>
                                    <li class=""><a class="" href="{{Route('backend.booking.add')}}"> <i
                                                class="mdi mdi-subdirectory-arrow-right"></i> Thêm mới </a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <i class="mdi mdi-comment-text-outline"></i> <span
                                        class="hide-menu font-weight-bold">QL Review</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li class=""><a class="" href="{{Route('backend.review.index')}}"> <i
                                                class="mdi mdi-subdirectory-arrow-right"></i> DS Review </a></li>
                                    <li><a class="" href="{{Route('backend.review.add')}}"> <i
                                                class="mdi mdi-subdirectory-arrow-right"></i> Thêm mới </a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
                {{--                @if(auth()->guard('backend')->user()->can('products.index.blade.php'))--}}

                {{--                    <li>--}}
                {{--                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i--}}
                {{--                                class="mdi mdi-briefcase-check"></i><span class="hide-menu">Sản phẩm</span></a>--}}
                {{--                        <ul aria-expanded="false" class="collapse">--}}

                {{--                            @if(auth()->guard('backend')->user()->can('products.index.blade.php'))--}}
                {{--                                <li><a href="{{Route('backend.products.index.blade.php')}}">Tất cả</a></li>--}}
                {{--                            @endif--}}


                {{--                            @if(auth()->guard('backend')->user()->can('products.add'))--}}
                {{--                                <li><a href="{{Route('backend.products.add',1)}}">Thêm mới sản phẩm</a></li>--}}
                {{--                            @endif--}}

                {{--                            @if(auth()->guard('backend')->user()->can('products.add'))--}}
                {{--                                <li><a href="{{Route('backend.products.add',2)}}">Thêm mới đồ ăn vặt</a></li>--}}
                {{--                            @endif--}}

                {{--                                @if(auth()->guard('backend')->user()->can('products.type.index.blade.php'))--}}
                {{--                                <li><a href="{{Route('backend.products.type.index.blade.php')}}">Danh mục sản--}}
                {{--                                        phẩm</a></li>--}}
                {{--                            @endif--}}

                {{--                        </ul>--}}
                {{--                    </li>--}}
                {{--                @endif--}}

                {{--                @if(auth()->guard('backend')->user()->can('orders.index.blade.php'))--}}
                {{--                    <li>--}}
                {{--                        <a class="waves-effect waves-dark" href="{{Route('backend.orders.index.blade.php')}}"--}}
                {{--                           aria-expanded="false">--}}
                {{--                            <i class="mdi mdi-cart"></i>--}}
                {{--                            <span class="hide-menu">Đơn hàng</span>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}
                {{--                @endif--}}

                {{--                @if(auth()->guard('backend')->user()->can('discount.index.blade.php')||auth()->guard('backend')->user()->can('discount.add'))--}}
                {{--                    <li>--}}
                {{--                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">--}}
                {{--                            <i class="mdi mdi-tag"></i>--}}
                {{--                            <span class="hide-menu">Mã giảm giá</span>--}}
                {{--                        </a>--}}
                {{--                        <ul aria-expanded="false" class="collapse">--}}
                {{--                            @if(auth()->guard('backend')->user()->can('discount.index.blade.php'))--}}
                {{--                                <li><a href="{{Route('backend.discount.index.blade.php')}}">Danh sách</a></li>--}}
                {{--                            @endif--}}

                {{--                            @if(auth()->guard('backend')->user()->can('discount.add'))--}}
                {{--                                <li><a href="{{Route('backend.discount.add')}}">Thêm mới</a></li>--}}
                {{--                            @endif--}}
                {{--                        </ul>--}}
                {{--                    </li>--}}
                {{--                @endif--}}
                @if(auth()->guard('backend')->user()->can('posts.index'))
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-file-document"></i>
                            <span class="hide-menu font-weight-bold">Bài viết Admin</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            @if(auth()->guard('backend')->user()->can('posts.index'))
                                <li><a class="" href="{{Route('backend.posts.index')}}"> <i
                                            class="mdi mdi-subdirectory-arrow-right"></i> Danh sách</a></li>
                            @endif
                            @if(auth()->guard('backend')->user()->can('posts.index'))
                                <li><a class="" href="{{Route('backend.posts.add')}}"> <i
                                            class="mdi mdi-subdirectory-arrow-right"></i> Thêm mới</a></li>
                            @endif
                            @if(auth()->guard('backend')->user()->can('posts.category.index'))
                                <li><a class="" href="{{Route('backend.posts.category.index')}}"> <i
                                            class="mdi mdi-subdirectory-arrow-right"></i> Danh mục bài viết</a></li>
                            @endif
                        </ul>
                    </li>
                @endif


                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa-solid fa-gear"></i>
                        <span class="hide-menu font-weight-bold">Chuyên gia</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="fa-regular fa-newspaper"></i>
                                <span class="hide-menu font-weight-bold">Bài viết</span>
                                @php
                                    $postExpert = \App\Models\PostExpert::where('status', 0)->count();
                                @endphp
                                <span class="badge bg-warning text-white">{{$postExpert}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a class="" href="{{Route('backend.postExpert.index')}}"> <i
                                            class="mdi mdi-subdirectory-arrow-right"></i> Danh sách</a></li>
                                <li><a class="" href="{{Route('backend.postExpert.add')}}"> <i
                                            class="mdi mdi-subdirectory-arrow-right"></i> Thêm mới</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="fa-brands fa-youtube"></i>
                                <span class="hide-menu font-weight-bold">Video </span>
                                @php
                                    $video = \App\Models\YoutubeExpert::where('status', 1)->count();
                                @endphp
                                <span class="badge bg-warning text-white">{{$video}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a class="" href="{{Route('backend.youtubeExpert.index')}}"> <i
                                            class="mdi mdi-subdirectory-arrow-right"></i> Danh sách</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="fa-solid fa-folder"></i>
                                <span class="hide-menu font-weight-bold">Hồ sơ khác </span>
                                @php
                                    $expertProfileOrther = \App\Models\ExpertProfileOrther::where('status', 0)->count();
                                @endphp
                                <span class="badge bg-warning text-white">{{$expertProfileOrther}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a class="" href="{{Route('backend.ExpertProfileOrther.index')}}"> <i
                                            class="mdi mdi-subdirectory-arrow-right"></i> Danh sách</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="fa-solid fa-play"></i>
                                <span class="hide-menu font-weight-bold">Video ngắn</span>
                                @php
                                    $videoShort = \App\Models\ShortVideoExpert::where('status', 1)->count();
                                @endphp
                                <span class="badge bg-warning text-white">{{$videoShort}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a class="" href="{{Route('backend.shortVideoExpert.index')}}"> <i
                                            class="mdi mdi-subdirectory-arrow-right"></i> Danh sách</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="fa-regular fa-circle-question"></i>
                                <span class="hide-menu font-weight-bold">Câu hỏi</span>
                                @php
                                    $questionExpert = \App\Models\QuestionExpert::where('status', 1)->count();
                                @endphp
                                <span class="badge bg-warning text-white">{{$questionExpert}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a class="" href="{{Route('backend.questionExpert.index')}}"> <i
                                            class="mdi mdi-subdirectory-arrow-right"></i> Danh sách</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>


                {{--                @if(auth()->guard('backend')->user()->can('email.index.blade.php'))--}}
                {{--                    <li>--}}
                {{--                        <a class="waves-effect waves-dark" href="{{Route('backend.subscribers.index.blade.php')}}"--}}
                {{--                           aria-expanded="false">--}}
                {{--                            <i class="mdi mdi-email"></i>--}}
                {{--                            <span class="hide-menu">Email nhận tin</span>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}
                {{--                @endif--}}

                {{--                @if(auth()->guard('backend')->user()->can('banner.index.blade.php'))--}}
                {{--                    <li>--}}
                {{--                        <a class="waves-effect" href="{{Route('backend.banner.index.blade.php')}}">--}}
                {{--                            <i class="mdi mdi-file-image"></i><span class="hide-menu">Banner</span>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}
                {{--                @endif--}}



                {{--                @if(auth()->guard('backend')->user()->can('notification.index.blade.php'))--}}
                {{--                    <li>--}}
                {{--                        <a class="waves-effect" href="{{Route('backend.notification.index.blade.php')}}">--}}
                {{--                            <i class="mdi mdi-bell"></i><span class="hide-menu">Thông báo</span>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}
                {{--                @endif--}}




                {{--                    @if(auth()->guard('backend')->user()->can('users.index.blade.php'))--}}

                <li>
                    <a class="" href="{{route('backend.subscribers.index')}}" aria-expanded="false">
                        <i class="mdi mdi-email-outline"></i> <span
                            class="hide-menu font-weight-bold">Subscribers</span>
                    </a>
                </li>


                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="mdi mdi-content-duplicate"></i> <span
                            class="hide-menu font-weight-bold">QL Danh mục</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a class="font-weight-bold" href="{{Route('backend.expertCategory.index')}}"> <i
                                    class="mdi mdi-subdirectory-arrow-right"></i> Danh sách </a></li>
                        <li><a class="font-weight-bold" href="{{Route('backend.expertCategoryTags.index')}}"> <i
                                    class="mdi mdi-subdirectory-arrow-right"></i> Tags </a></li>
                    </ul>
                </li>


                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa-regular fa-calendar-days"></i> <span
                            class="hide-menu font-weight-bold">QL Đặt lịch</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a class="font-weight-bold" href="{{Route('backend.requestExpert.index')}}"> <i
                                    class="mdi mdi-subdirectory-arrow-right"></i> Danh sách </a></li>
                    </ul>
                </li>


                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa-solid fa-wallet"></i> <span class="hide-menu font-weight-bold">QL Rút tiền</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a class="font-weight-bold" href="{{Route('backend.walletExpert.index')}}"> <i
                                    class="mdi mdi-subdirectory-arrow-right"></i> Danh sách </a></li>
                    </ul>
                </li>


                {{--                    <li>--}}
                {{--                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">--}}
                {{--                            <i class="mdi mdi-content-duplicate"></i> <span class="hide-menu font-weight-bold">QL Đặt lịch</span>--}}
                {{--                        </a>--}}
                {{--                        <ul aria-expanded="false" class="collapse">--}}
                {{--                            <li><a class="font-weight-bold" href="{{Route('backend.expertCategory.index.blade.php')}}"> <i class="mdi mdi-subdirectory-arrow-right"></i> DS Đặt lịch </a></li>--}}
                {{--                        </ul>--}}
                {{--                    </li>--}}


                {{--                    <li>--}}
                {{--                        <a class="" href="{{route('backend.calendarExpert.index.blade.php')}}" aria-expanded="false">--}}
                {{--                            <i class="mdi mdi-content-duplicate"></i> <span class="hide-menu font-weight-bold">QL Lịch Chuyên gia</span>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}


                {{--                    <li>--}}
                {{--                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">--}}
                {{--                            <i class="mdi mdi-content-duplicate"></i> <span class="hide-menu font-weight-bold">QL Đặt chỗ</span>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}


                {{--                    <li>--}}
                {{--                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">--}}
                {{--                            <i class="mdi mdi-content-duplicate"></i> <span class="hide-menu font-weight-bold">QL Thanh toán</span>--}}
                {{--                        </a>--}}
                {{--                        <ul aria-expanded="false" class="collapse">--}}
                {{--                            <li><a class="font-weight-bold" href="{{Route('backend.expertCategory.index.blade.php')}}"> <i class="mdi mdi-subdirectory-arrow-right"></i> DS Danh mục </a></li>--}}
                {{--                        </ul>--}}
                {{--                    </li>--}}



                {{--                    <li>--}}
                {{--                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">--}}
                {{--                            <i class="mdi mdi-content-duplicate"></i> <span class="hide-menu font-weight-bold">QL Bài viết</span>--}}
                {{--                        </a>--}}
                {{--                        <ul aria-expanded="false" class="collapse">--}}
                {{--                            <li><a class="font-weight-bold" href="{{Route('backend.expertCategory.index.blade.php')}}"> <i class="mdi mdi-subdirectory-arrow-right"></i> DS Danh mục </a></li>--}}
                {{--                        </ul>--}}
                {{--                    </li>--}}


                {{--                    @endif--}}

                {{--Ca -07-12-22 khu vuc--}}
                {{--                    <li>--}}
                {{--                        <a class="waves-effect" href="{{Route('backend.brands.index.blade.php')}}">--}}
                {{--                            <i class="mdi mdi-file-image"></i><span class="hide-menu">Đại lý</span>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}
                {{--Ca -07-12-22 khu vuc--}}


                {{--                    @if(auth()->guard('backend')->user()->can('debt.index.blade.php'))--}}
                {{--                    <li>--}}
                {{--                        <a class="waves-effect" href="{{Route('backend.debt.index.blade.php')}}">--}}
                {{--                            <i class="mdi mdi-trending-up"></i><span class="hide-menu">Công nợ</span>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}

                {{--                    @endif--}}


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
