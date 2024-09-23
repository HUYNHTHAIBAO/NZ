{{--<div class="dashboard__top-wrap">--}}
{{--    --}}{{--    <div class="dashboard__top-bg" data-background="{{asset('storage/frontendNew')}}/assets/img/bg/student_bg.jpg"></div>--}}
{{--    <div class="dashboard__top-bg" style="background: linear-gradient(to right, #0c0b0b, #ada9a9);"></div>--}}
{{--    <div class="dashboard__instructor-info">--}}
{{--        <div class="dashboard__instructor-info-left">--}}

{{--            <div class="thumb">--}}
{{--                <img src="{{asset('storage/uploads') . '/' . Illuminate\Support\Facades\Auth::guard('web')->user()->avatar_file_path ?? ''}}" style="padding: 0px;display: block; max-width: 100px; height: 100px; object-fit: cover; border-radius: 50%;border: 1px solid #ccc" alt="img">--}}
{{--                <img src="{{asset('storage/frontendNew')}}/assets/img/courses/details_instructors02.jpg" alt="img">--}}
{{--            </div>--}}
{{--            <div class="content">--}}
{{--                <h4 class="title">{{Illuminate\Support\Facades\Auth::guard('web')->user()->fullname ?? ''}}</h4>--}}
{{--                <ul class="list-wrap">--}}
{{--                    <li>--}}
{{--                        <div>--}}
{{--                            <span--}}
{{--                                class="badge bg-primary">Ngày tham gia : {{date_format(Illuminate\Support\Facades\Auth::guard('web')->user()->created_at, 'd/m/Y')}}</span>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    |--}}
{{--                    <li>--}}
{{--                        <div class="">--}}
{{--                            @if(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 0)--}}
{{--                                <span class="font-weight-bold badge bg-secondary text-white"> Người dùng <i class="fa-regular fa-user"></i></span>--}}
{{--                            @elseif(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 1)--}}
{{--                                <span class="font-weight-bold badge bg-secondary text-white"> Đang chờ duyệt <i class="fa-solid fa-circle-exclamation"></i></span>--}}
{{--                            @elseif(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 2)--}}
{{--                                    <span class="font-weight-bold badge bg-secondary text-white"> Chuyên gia <i class="fa-solid fa-star"></i> </span>--}}
{{--                            @else--}}
{{--                                    <span class="font-weight-bold badge bg-secondary text-white">Chưa xác định <i class="fa-solid fa-exclamation"></i></span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        --}}{{--        <div class="dashboard__instructor-info-right">--}}
{{--        --}}{{--            <a href="#" class="btn btn-two arrow-btn">Become an Instructor <img src="{{asset('storage/frontendNew')}}/assets/img/icons/right_arrow.svg" alt="img" class="injectable"></a>--}}
{{--        --}}{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
