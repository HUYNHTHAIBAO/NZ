@extends('frontend.layouts.frontend')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
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
                        <div class="dashboard__content-title">
                            <h4 class="title text-center">Ví</h4>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="itemTwo-tab-pane" role="tabpanel"
                                         aria-labelledby="itemTwo-tab" tabindex="0">
                                        <div class="instructor__profile-form-wrap">
                                            <div class="mb-3">
                                                <a href="{{route('frontend.wallet.history')}}" class="categories_button text-light"><span class="categories_link">Xem lịch sử</span></a>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-lg-8 col-12">
                                                    <div class="shadow p-3 mb-5 bg-body rounded col-3">
                                                        <p class="text-center"><i class="fa-solid fa-wallet"></i></p>
                                                        <p class="text-center text-black font_weight_bold">Số dư hiện có</p>
                                                        <p class="text-center text-black font_weight_bold"> {{format_number_vnd($user->point ?? "")}} vnđ</p>
                                                    </div>
                                            <form action="{{route('frontend.wallet.index')}}"
                                                  class="instructor__profile-form" method="Post">
                                                @csrf
                                                <label for="bank_stk" class="font_weight_bold">Nhập thông tin yêu cầu : </label>
                                                <div class="">

                                                    <input id="bank_stk" name="bank_stk" type="text" autocomplete="off"
                                                           placeholder="Số tài khoản *" value="{{old('bank_stk')}}" class="input_user">
                                                    @if ($errors->has('bank_stk'))
                                                        <div class="custom_error">{{ $errors->first('bank_stk') }}</div>
                                                    @endif
                                                </div>
                                                <div class="">
                                                    <input id="bank_name" name="bank_name" type="text"
                                                           autocomplete="off" placeholder="Tên ngân hàng *"
                                                           value="{{old('bank_name')}}" class="input_user">
                                                    @if ($errors->has('bank_name'))
                                                        <div
                                                            class="custom_error">{{ $errors->first('bank_name') }}</div>
                                                    @endif
                                                </div>

                                                <div class="">
                                                    <input id="name" name="name" type="text" autocomplete="off"
                                                           placeholder="Tên tài khoản *" value="{{old('name')}}" class="input_user">
                                                    @if ($errors->has('name'))
                                                        <div class="custom_error">{{ $errors->first('name') }}</div>
                                                    @endif
                                                </div>
                                                <div class="">
                                                    <input id="price" name="price" type="text" autocomplete="off"
                                                           placeholder="Số tiền cần rút *" value="{{old('price')}}" class="input_user">
                                                    @if ($errors->has('price'))
                                                        <div class="custom_error">{{ $errors->first('price') }}</div>
                                                    @endif
                                                </div>

                                                <div class="mt-2">
                                                    <textarea id="note" name="note" class="form-control input_user" placeholder="Ghi chú">{{old('note')}}</textarea>
                                                </div>

                                                <div class="submit-btn mt-25 text-center">
                                                    <button type="submit" class="categories_button ">
                                                        <span class="categories_link">Yêu cầu rút tiền</span>
                                                    </button>
                                                </div>
                                            </form>
                                                </div>
                                            </div>
                                        </div>
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

