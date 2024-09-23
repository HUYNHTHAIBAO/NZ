<style>
    .footer__widget-title::before {
        background-color: #000 !important;
    }

    .footer__area {
        border-top: 1px solid #ccc;
    }
</style>
<footer class="bg-white p-5" style="margin-top: 46px">
    <div class="">
        <div class="container-fluid">
            <div class="row align-center justify-content-between">
                <div class="col-12 col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h4 class="footer__widget-title text-black font_weight_bold" style="font-size: 20px">LIÊN
                            HỆ</h4>
                        <div class="">
                            <ul class="list-wrap">
                                <li class="py-2"><a class="text-black" href="/"><span>Contact us</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h4 class="footer__widget-title text-black font_weight_bold" style="font-size: 20px">GIỚI
                            THIỆU</h4>
                        <div class="">
                            <ul class="list-wrap">
                                <li class="py-2"><a class="text-black" href="{{route('frontend.page.neztwork_team')}}">Neztwork Bạn bè</a>
                                </li>
                                <li class="py-2"><a class="text-black" href="{{route('frontend.page.ai')}}">NeztWork AI</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h4 class="footer__widget-title text-black font_weight_bold" style="font-size: 20px">HỖ TRỢ</h4>
                        <div class="">
                            <ul class="list-wrap">
                                <li class="py-2"><a class="text-black"
                                                    href="{{route('frontend.info.STORAGE_INSTRUCTIONS')}}">Chính
                                        sách thanh toán</a></li>
                                <li class="py-2"><a class="text-black"
                                                    href="{{route('frontend.info.informationPrivacy')}}">Chính
                                        sách về quyền riêng tư</a></li>
                                <li class="py-2"><a class="text-black" href="{{route('frontend.info.termOfUse')}}">Điều
                                        khoản sử
                                        dụng</a></li>
                                <li class="py-2"><a class="text-black" href="{{route('frontend.info.VNPAY')}}">Hướng dẫn thanh toán VNPAY</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h4 class="footer__widget-title text-black font_weight_bold" style="font-size: 20px">CÔNG
                            TY</h4>
                        <div class="">
                            <ul class="list-wrap">
                                <li class="py-2"><a class="text-black" href="{{route('frontend.pages.aboutNew')}}">Giới
                                        thiệu</a></li>
                                <li class="py-2"><a class="text-black" href="{{route('frontend.page.socialImpact')}}">Tác
                                        động
                                        xã hội</a></li>
                                <li class="py-2"><a class="text-black" href="{{route('frontend.page.careers')}}">Nghề
                                        nghiệp  </a>
                                </li>
                                <li class="py-2"><a class="text-black" href="{{route('frontend.page.trustCenter')}}">Điều
                                        khoản tin
                                        cậy</a></li>
                            </ul>
                        </div>

                    </div>
                </div>


                <div class="col-12 col-xl-2 col-lg-2 col-md-12 col-sm-12">
                    <div class="footer__widget">
                        <div class="footer__contact-content">
                            <div class="footer__widget">
{{--                                <div class="logo mb-10">--}}
{{--                                    <a href="/">--}}
{{--                                        <img src="{{url('/storage/uploads').'/'.$LOGO}}" width="100" height="" style="" alt="img">--}}
{{--                                    </a>--}}
{{--                                </div>--}}
                                <div class="footer__content">
                                    <h4 class="text-black">{{$COMPANY_NAME}}</h4>
                                </div>

                                <div class="mt-2">
                                    <p class="text-black"> <span style="font-weight: 500">Địa chỉ : </span> {{$ADDRESS}}</p>
                                </div>
                                <div class="mt-2">
                                    <p class="text-black"> <span style="font-weight: 500">Mã số thuế :</span> {{$MST}} </p>
                                </div>
                                <div class="mt-2">
                                    <span class="text-black"> <span style="font-weight: 500"> Số điện thoại : </span> {{$PHONE}}</span>
                                </div>
                                <div class="mt-2">
                                    <span class="text-black"> <span style="font-weight: 500"> Email : </span> {{$EMAIL}}</span>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>


            </div>
            <hr style="background-color: #ccc; height: 2px">
        </div>

    </div>
    <div class="bg-white">
        <div class="container-fluid">
            <div class="text-center">
                <h3>NEZTWORK</h3>
            </div>
            <div class="row align-items-center mt-4 mt-md-0">
                <div class="col-12 col-md-3 col-lg-2 p-2" style="display: flex;align-items: center;border: 1px solid #ccc;border-radius: 20px;justify-content: space-around;">
                    <img class="me-2" src="https://cdn-icons-png.flaticon.com/128/2889/2889312.png" alt=""
                         style="width: 25px; height: 25px">
                    <select class="form-select form-select-lg mb-0" aria-label="Large select example"
                            style="border: none; font-size: 16px !important;">
                        <option selected style="font-size: 16px"> Tiếng Việt</option>
                        <option value="1" style="font-size: 16px">Tiếng Anh</option>
                        <option value="3" style="font-size: 16px">Tiếng Trung</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-8 mt-4 mt-md-0">
                    <div class="">
                        <ul class="list-wrap footer__social d-flex align-center justify-content-center m-0">
                            <li>
                                <a href="{{$FACEBOOK}}" target="_blank">
                                    <img src="https://cdn-icons-png.flaticon.com/128/1384/1384005.png"
                                         style="object-fit: cover; width: 40px; height: 40px" alt="Facebook" class="">
                                </a>
                            </li>

                            <li>
                                <a href="{{$LINKEDIN}}" target="_blank">
                                    <img src="https://cdn-icons-png.flaticon.com/128/1384/1384014.png"
                                         style=" object-fit: cover; width: 40px; height: 40px" alt="LinkedIn" class="">
                                </a>
                            </li>

                            <li>
                                <a href="{{$PINTEREST}}" target="_blank">
                                    <img src="https://cdn-icons-png.flaticon.com/128/2175/2175205.png"
                                         style="object-fit: cover; width: 40px; height: 40px" alt="Pinterest" class="">
                                </a>
                            </li>

                            <li>
                                <a href="{{$TWITTER}}" target="_blank">
                                    <img src="https://cdn-icons-png.flaticon.com/128/5969/5969020.png"
                                         style="object-fit: cover; width: 40px; height: 40px" alt="X" class="">
                                </a>
                            </li>

                            <li>
                                <a href="{{$YOUTUBE}}" target="_blank">
                                    <img src="https://cdn-icons-png.flaticon.com/128/3669/3669688.png"
                                         style="object-fit: cover; width: 40px; height: 40px" alt="YouTube" class="">
                                </a>
                            </li>

                            <li>
                                <a href="{{$INSTAGRAM}}" target="_blank">
                                    <img src="https://cdn-icons-png.flaticon.com/128/1384/1384015.png"
                                         style="object-fit: cover; width: 40px; height: 40px" alt="Instagram" class="">
                                </a>
                            </li>


                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-3 col-lg-2 mt-4 mt-md-0">
                    <div class="text-center text-md-start">
                        <p class="text-black font_weight_bold m-0">© 2024 NeztWork </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
