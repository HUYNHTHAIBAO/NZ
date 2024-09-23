@extends('frontend.layouts.frontend')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>




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
                        <div class="pb-4">
                            <p class="bg-light p-1"><a class="text-black font_weight_bold" href="{{route('frontend.user.profile')}}"> Tài khoản </a> /
                                <a class="text-black font_weight_bold" href="{{route('frontend.questionExpert.index')}}"> Quản lý câu hỏi </a> / <span>Cập nhật</span>
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tab-content" id="myTabContent">
                                    <button type="button" class="btn_custom my-4" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop">
                                        Xem hướng dẫn
                                    </button>
                                    <div class="tab-pane fade active show" id="itemTwo-tab-pane" role="tabpanel"
                                         aria-labelledby="itemTwo-tab" tabindex="0">
                                        <div class="instructor__profile-form-wrap">
                                            <form
                                                action="{{route('frontend.questionExpert.edit', $questionExpert->id)}}"
                                                class="instructor__profile-form" method="POST">
                                                @csrf
                                                <div class="form-grp">
                                                    <label for="title">Tiêu đề <span class="text-danger">*</span>
                                                    </label>
                                                    <input id="title" type="text" name="title" placeholder=""
                                                           value="{{old('title', $questionExpert->title ?? '')}}">
                                                    @if ($errors->has('title'))
                                                        <div class="custom_error">{{ $errors->first('title') }}</div>
                                                    @endif
                                                </div>

                                                <div class="form-grp">
                                                    <label for="desc">Mô tả <span
                                                            class="text-danger">*</span></label>
                                                    <textarea id="desc"
                                                              name="desc">{{$questionExpert->desc ?? ''}}</textarea>
                                                    @if ($errors->has('desc'))
                                                        <div class="custom_error">{{ $errors->first('desc') }}</div>
                                                    @endif
                                                </div>
                                                <div class="submit-btn mt-25 text-center">
                                                    <button type="submit" class="categories_button"><span class="categories_link">Cập nhật</span></button>
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
    </section>
    {{--// modal --}}
    @include('frontend.youtubeExpert.modal.index')
@endsection

