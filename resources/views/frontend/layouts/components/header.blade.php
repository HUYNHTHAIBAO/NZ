
<header>
    <div id="header-fixed-height"></div>
    <div id="sticky-header" class="tg-header__area tg-header__style-five header_shadow">
        <div class="">
            <div class="row">
                <div class="col-12">
                    <div class="tgmenu__wrap px-4">
                        <nav class="tgmenu__nav d-flex justify-content-between">
                            <div class="logo">
                                <a href="/">
                                    <img src="{{url('/storage/uploads').'/'.$LOGO}}" alt="Logo" width="100" height=""></a>
                            </div>
                            {{--                            <div class="tgmenu__categories select-grp-two d-none d-md-block">--}}
                            {{--                                <div class="dropdown" style="">--}}
                            {{--                                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"--}}
                            {{--                                            aria-expanded="false" style="font-weight: bold">--}}
                            {{--                                        Danh mục--}}
                            {{--                                    </button>--}}
                            {{--                                    <ul class="dropdown-menu" style="height: 200px; overflow-y: auto;">--}}
                            {{--                                        @php--}}
                            {{--                                            $expertCategory = \App\Models\ExpertCategory::where('status', 1)->orderBy('id', 'desc')->get();--}}
                            {{--                                        @endphp--}}

                            {{--                                                                    @foreach($expertCategory as $key => $item)--}}
                            {{--                                                                        <form action="{{ route('frontend.product.main') }}" method="get">--}}
                            {{--                                                                            <input type="hidden" name="category_id" value="{{ $item->id }}">--}}
                            {{--                                                                                                                            <li>--}}
                            {{--                                                                                                                                <a class="dropdown-item" href="/"--}}
                            {{--                                                                                                                                   style="font-weight: bold">{{$item->name ?? ''}}</a>--}}
                            {{--                                                                                                                            </li>--}}
                            {{--                                                                            <button type="submit"--}}
                            {{--                                                                                    style="border: none;width: 100%; color: #000; padding: 5px; background: #ebebeb17">--}}
                            {{--                                                                                <span class="text-center font_weight_bold custom_line_1">{{ $item->name ?? '' }}</span>--}}
                            {{--                                                                            </button>--}}
                            {{--                                                                        </form>--}}
                            {{--                                                                    @endforeach--}}
                            {{--                                    </ul>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-xl-flex">
                                <ul class="navigation">
                                    <li class=""><a href="{{route('frontend.product.main')}}" class="text-black" style="font-weight: bold">Danh mục</a>
                                        <ul class="sub-menu" style="height: 600px;width: 350px; overflow: auto;">
                                            @php
                                                $expertCategory = \App\Models\ExpertCategory::where('status', 1)->orderBy('id', 'desc')->get();
                                            @endphp
                                            @foreach($expertCategory as $key => $item)
                                                <form action="{{ route('frontend.product.main') }}" method="get">
                                                    <input type="hidden" name="category_id_expert" value="{{ $item->id }}">
                                                    <button type="submit"
                                                            style="border: none;width: 100%; color: #000; padding: 5px; background: #ebebeb17; text-align: left" class="d-flex align-items-center justify-content-start">
                                                          <span class="custom_line_1 d-flex header_category" style="padding: 0px 20px"> {{ $item->name ?? '' }}</span>
                                                    </button>
                                                </form>
                                            @endforeach
                                        </ul>
                                        <div class="dropdown-btn"><span class="plus-line"></span></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tgmenu__action tgmenu__action-five ml_1 d-none d-xl-flex">
                                <ul class="list-wrap">
                                    <li>
                                        <div class="tgmenu__search tgmenu__search-two  d-none d-md-block">
                                            <form action="{{route('frontend.product.main')}}"
                                                  class="tgmenu__search-form tgmenu__search-form-two m-0" method="get"
                                                  style="border: 1px solid #000">
                                                <div class="input-grp">
                                                    <input class="m-0" type="text" name="key"
                                                           value="{{ request()->get('key', '') }}"
                                                           placeholder="Tìm chuyên gia bạn muốn. . .">
                                                    <button type="submit"><i class="flaticon-search"
                                                                             style="color: #ccc"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-xl-flex">
                                <ul class="navigation" style="margin: 0 auto">
                                    <li class="">
                                        <a href="{{route('frontend.page.registerExpert')}}" class="text-black"
                                           style="font-weight: bold">Chuyên gia</a>
                                    </li>
                                    <li class="">
                                        <a href="#" class="text-black" style="font-weight: bold">Business</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tgmenu__action tgmenu__action-five ml_1">
                                <ul class="list-wrap">
                                    {{--                                    <li class="header-user">--}}
                                    {{--                                        <a href="instructor-dashboard.html"><img src="{{ asset('/storage/frontendNew')}}/assets/img/icons/user.svg" alt="" class="injectable"></a>--}}
                                    {{--                                    </li>--}}
                                    {{--                                    <li class="mini-cart-icon">--}}
                                    {{--                                        <a href="/" class="cart-count">--}}
                                    {{--                                            <img src="{{ asset('/storage/frontendNew')}}/assets/img/icons/cart.svg"--}}
                                    {{--                                                 class="injectable" alt="img">--}}
                                    {{--                                            <span class="mini-cart-count">0</span>--}}
                                    {{--                                        </a>--}}
                                    {{--                                    </li>--}}
                                    @if(Illuminate\Support\Facades\Auth::guard('web')->user()->fullname ?? '')
                                        <div class="dropdown-center nav-item">
                                            <li class="header-user d-flex align-items-center dropdown-toggle"
                                                aria-expanded="false" data-bs-toggle="dropdown">
{{--                                                <a href="#"><img--}}
{{--                                                        src="{{ asset('/storage/frontendNew/assets/img/icons/user.svg') }}"--}}
{{--                                                        alt="" class="injectable"></a>--}}
{{--                                                --}}

                                                @if(!empty(Illuminate\Support\Facades\Auth::guard('web')->user()) && !empty(Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_file_path))
                                                    <img
                                                        src="{{asset('storage/uploads') . '/' . Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_file_path ?? ''}}"
                                                        style="padding: 0px; display: block; width: 50px; height: 50px; object-fit: cover; border-radius: 50%;border: 1px solid #ccc; cursor: pointer"
                                                        alt="img">
                                                @else
                                                    <div class="bg-black" style=" cursor: pointer; width: 50px; height: 50px; border-radius: 50%; border: 1px solid #eee; display: flex; align-items: center; justify-content: center;">
                                                        <span class="text-white font_weight_bold" style="">{{ Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_name ?? '' }}</span>
                                                    </div>
                                                @endif


                                            </li>
                                            <ul class="dropdown-menu" style="width: 200px; ">
                                                <div class="p-3">
                                                    <p class="m-0">Xin chào !</p>
                                                    <span
                                                        class="badge bg-secondary">{{ \Illuminate\Support\Str::limit(Illuminate\Support\Facades\Auth::guard('web')->user()->fullname, 20, '...') }}</span>
                                                </div>

{{--                                                // switch account--}}
                                                @if(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 2)
                                                    <li class="p-0 m-1">
                                                        <form action="{{ route('frontend.switchAccount.switchToStudent') }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item categories_button p-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chuyển sang chế độ của học viên ngay tại đây">
                                                                <small class="categories_link" style="cursor: pointer">Chuyển sang Người dùng</small>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @elseif(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 0)
                                                    @if(Illuminate\Support\Facades\Auth::guard('web')->user()->approved == 2 || Illuminate\Support\Facades\Auth::guard('web')->user()->approved == 4 || Illuminate\Support\Facades\Auth::guard('web')->user()->approved == 5 || Illuminate\Support\Facades\Auth::guard('web')->user()->approved == 6)
                                                    <li class="p-0 m-1">
                                                        <form action="{{ route('frontend.switchAccount.switchToExpert') }}" method="POST">
                                                            @csrf

                                                            <button type="submit" class="dropdown-item categories_button p-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chuyển sang chế độ của chuyên gia ngay tại đây">
                                                                <small class="categories_link" style="cursor: pointer">Chuyển sang Chuyên gia</small>
                                                            </button>
                                                        </form>
                                                    </li>
                                                    @else

                                                    @endif

                                                @endif



                                            @if(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 2)
                                                    <li><a class="dropdown-item"
                                                           href="/chuyen-gia/{{ str_replace(' ', '', \Illuminate\Support\Facades\Auth::guard('web')->user()->fullname) }}.{{Illuminate\Support\Facades\Auth::guard('web')->user()->id}}">Trang
                                                            cá nhân</a></li>

                                                @else

                                                @endif


                                                <li><a class="dropdown-item"
                                                       href="{{ route('frontend.user.profile') }}">Cài đặt tài khoản</a></li>

                                                <li class="d-flex"><a class="dropdown-item"
                                                                      href="{{ route('frontend.user.logout') }}">Đăng
                                                        xuất</a></li>
                                            </ul>
                                        </div>
                                    @else
                                        <li class="nav-item">

                                                <a href="{{ route('frontend.user.login') }}" class="login_btn" style="font-weight: bold">  <span>Đăng
                                                    nhập </span></a>

                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('frontend.user.register') }}" class="register_btn" style="font-weight: bold">  <span>Đăng
                                                    ký </span></a>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                            <div class="mobile-login-btn">
                                {{--                                <a href="/"><img--}}
                                {{--                                        src="{{ asset('/storage/frontendNew')}}/assets/img/icons/user.svg" alt=""--}}
                                {{--                                        class="injectable"></a>--}}
                            </div>
                            <div class="mobile-nav-toggler"><i class="tg-flaticon-menu-1 text-black"></i></div>
                        </nav>
                    </div>


                    <!-- Mobile Menu  -->
                    <div class="tgmobile__menu">
                        <nav class="tgmobile__menu-box">
                            <div class="close-btn"><i class="tg-flaticon-close-1 text-black"></i></div>
                            <div class="nav-logo">
                                <a href="/"><img
                                        src="{{url('/storage/uploads').'/'.$LOGO}}"
                                        alt="Logo" width="100" height="100"></a>
                            </div>
                            <div class="tgmobile__search">
                                <form action="#">
                                    <input type="text" placeholder="Tìm chuyên gia ...">
                                    <button><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                            <div class="px-5 py-2">
                                <p>  <a href="{{route('frontend.product.main')}}" class="menu_mobile_title">Danh mục</a></p>
                                <p> <a href="{{route('frontend.page.registerExpert')}}" class="menu_mobile_title">Chuyên gia</a></p>
                                <p> <a href="#" class="menu_mobile_title">Bussiness</a></p>
                            </div>
{{--                            <div class="tgmobile__menu-outer">--}}
{{--                                <span class="text-black" style="padding: 10px 60px 10px 25px">dnakjshdasdasdasd</span>--}}
{{--                                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->--}}
{{--                            </div>--}}
                            <div class="">

                                <div class="tgmenu__action tgmenu__action-five ml_1">
                                    <ul class="list-wrap">
                                        {{--                                    <li class="header-user">--}}
                                        {{--                                        <a href="instructor-dashboard.html"><img src="{{ asset('/storage/frontendNew')}}/assets/img/icons/user.svg" alt="" class="injectable"></a>--}}
                                        {{--                                    </li>--}}
                                        {{--                                    <li class="mini-cart-icon">--}}
                                        {{--                                        <a href="/" class="cart-count">--}}
                                        {{--                                            <img src="{{ asset('/storage/frontendNew')}}/assets/img/icons/cart.svg"--}}
                                        {{--                                                 class="injectable" alt="img">--}}
                                        {{--                                            <span class="mini-cart-count">0</span>--}}
                                        {{--                                        </a>--}}
                                        {{--                                    </li>--}}
                                        @if(Illuminate\Support\Facades\Auth::guard('web')->user()->fullname ?? '')
                                            <div class="dropdown-center nav-item">
                                                <li class="header-user d-flex align-items-center dropdown-toggle"
                                                    aria-expanded="false" data-bs-toggle="dropdown">
                                                    {{--                                                <a href="#"><img--}}
                                                    {{--                                                        src="{{ asset('/storage/frontendNew/assets/img/icons/user.svg') }}"--}}
                                                    {{--                                                        alt="" class="injectable"></a>--}}
                                                    {{--                                                --}}

                                                    @if(!empty(Illuminate\Support\Facades\Auth::guard('web')->user()) && !empty(Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_file_path))
                                                        <img
                                                            src="{{asset('storage/uploads') . '/' . Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_file_path ?? ''}}"
                                                            style="padding: 0px; display: block; width: 50px; height: 50px; object-fit: cover; border-radius: 50%;border: 1px solid #ccc; cursor: pointer"
                                                            alt="img">
                                                    @else
                                                        <div class="bg-black" style=" cursor: pointer; width: 50px; height: 50px; border-radius: 50%; border: 1px solid #eee; display: flex; align-items: center; justify-content: center;">
                                                            <span class="text-white font_weight_bold" style="">{{ Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_name ?? '' }}</span>
                                                        </div>
                                                    @endif


                                                </li>
                                                <ul class="dropdown-menu" style="width: 200px; ">
                                                    <div class="p-3">
                                                        <p class="m-0">Xin chào !</p>
                                                        <span
                                                            class="badge bg-secondary">{{ \Illuminate\Support\Str::limit(Illuminate\Support\Facades\Auth::guard('web')->user()->fullname, 20, '...') }}</span>
                                                    </div>

                                                    {{--                                                // switch account--}}
                                                    @if(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 2)
                                                        <li class="p-0 m-1">
                                                            <form action="{{ route('frontend.switchAccount.switchToStudent') }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item categories_button p-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chuyển sang chế độ của học viên ngay tại đây">
                                                                    <small class="categories_link" style="cursor: pointer">Chuyển sang Người dùng</small>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @elseif(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 0)
                                                        @if(Illuminate\Support\Facades\Auth::guard('web')->user()->approved == 2 || Illuminate\Support\Facades\Auth::guard('web')->user()->approved == 4 || Illuminate\Support\Facades\Auth::guard('web')->user()->approved == 5 || Illuminate\Support\Facades\Auth::guard('web')->user()->approved == 6)
                                                            <li class="p-0 m-1">
                                                                <form action="{{ route('frontend.switchAccount.switchToExpert') }}" method="POST">
                                                                    @csrf

                                                                    <button type="submit" class="dropdown-item categories_button p-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chuyển sang chế độ của chuyên gia ngay tại đây">
                                                                        <small class="categories_link" style="cursor: pointer">Chuyển sang Chuyên gia</small>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @else

                                                        @endif

                                                    @endif



                                                    @if(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 2)
                                                        <li><a class="dropdown-item"
                                                               href="/chuyen-gia/{{ str_replace(' ', '', \Illuminate\Support\Facades\Auth::guard('web')->user()->fullname) }}.{{Illuminate\Support\Facades\Auth::guard('web')->user()->id}}">Trang
                                                                cá nhân</a></li>

                                                    @else

                                                    @endif


                                                    <li><a class="dropdown-item"
                                                           href="{{ route('frontend.user.profile') }}">Cài đặt tài khoản</a></li>

                                                    <li class="d-flex"><a class="dropdown-item"
                                                                          href="{{ route('frontend.user.logout') }}">Đăng
                                                            xuất</a></li>
                                                </ul>
                                            </div>
                                        @else
                                            <li class="nav-item">

                                                <a href="{{ route('frontend.user.login') }}" class="login_btn" style="font-weight: bold">  <span>Đăng
                                                    nhập </span></a>

                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('frontend.user.login') }}" class="register_btn" style="font-weight: bold">  <span>Đăng
                                                    ký </span></a>
                                            </li>
                                        @endif

                                    </ul>
                                </div>






                            </div>
                        </nav>
                    </div>
                    <div class="tgmobile__menu-backdrop"></div>
                    <!-- End Mobile Menu -->
                </div>
            </div>
        </div>
    </div>

    <!-- header-search -->
    <div class="search__popup">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search__wrapper">
                        <div class="search__close">
                            <button type="button" class="search-close-btn">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 1L1 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                    <path d="M1 1L17 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="search__form">
                            <form action="#">
                                <div class="search__input">
                                    <input class="search-input-field" type="text" placeholder="Type keywords here">
                                    <span class="search-focus-border"></span>
                                    <button>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                            <path d="M19.0002 19.0002L17.2002 17.2002" stroke="currentcolor"
                                                  stroke-width="1.5" stroke-linecap="round"
                                                  stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search-popup-overlay"></div>
    <!-- header-search-end -->

</header>
