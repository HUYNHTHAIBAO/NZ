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
                                                       href="{{route('frontend.user.profile')}}"> Tài khoản </a>
                                <a class="text-black font_weight_bold" href="{{route('frontend.user.bookingHistory')}}">
                                    / Quản lý đặt lịch</a> / Câp nhật đặt lịch</p>
                        </div>
                        {{--                        <div class="dashboard__content-title">--}}
                        {{--                            <h4 class="title">Duyệt / Từ chối đặt lịch</h4>--}}
                        {{--                        </div>--}}
                        <div class="tab-content " id="myTabContent">
                            <div class="tab-pane fade active show" id="itemOne-tab-pane" role="tabpanel"
                                 aria-labelledby="itemOne-tab" tabindex="0">

                                <div class="instructor__profile-form-wrap row">
                                    <div class="col-12 col-lg-4">
                                        <form action="{{ route('frontend.user.approve', $data->id) }}"
                                              class="instructor__profile-form" method="POST">
                                            @csrf
                                            @if(isset($data) && $data->type == 2 ||  $data->type == 3 ||  $data->type == 5)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-grp">
                                                            <label for="approve">Để lại lời nhắn</label>
                                                            <textarea id="approve" name="note"
                                                                      disabled>{{ old('note', $data->note ?? '') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="submit-btn mt-25">
                                                    <button type="submit" class="" disabled
                                                            style="background-color: #ccc;padding: 10px; border-radius: 10px; border: none; color: #fff"><span
                                                            class="categories_link">
                                                        Duyệt
                                                    </span>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-grp">
                                                            <label for="approve">Để lại lời nhắn</label>
                                                            <textarea id="approve"
                                                                      name="note">{{ old('note', $data->note ?? '') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="submit-btn mt-25">
                                                    <button type="submit" class="categories_button">
                                                    <span class="categories_link">
                                                        Duyệt
                                                    </span>
                                                    </button>
                                                </div>
                                            @endif
                                        </form>
                                    </div>


                                    <div class="col-12 col-lg-4">
                                        <form action="{{ route('frontend.user.timeNegotiate', $data->id) }}" class="instructor__profile-form" method="POST">
                                            @csrf
                                            @if(isset($data) && ($data->type == 2 ||  $data->type == 3 ||  $data->type == 5))
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div style="height: 400px; overflow-y: auto; overflow-x: hidden">
                                                            @foreach($times as $i_time)
                                                                <span data-date="{{ $i_time['date'] }}"> {{ $i_time['date'] }} </span>
                                                                <ul class="row p-0">
                                                                    @foreach($i_time['duration'] as $time)
                                                                        <div class="col-6 checkbox-group">
                                                                            <input type="radio" name="time" value="{{ $time['time'] }}"
                                                                                   id="{{ $i_time['date'].$i_time['id']. str_slug($time['time']) }}"
                                                                                   data-time="{{ $time['time'] }}"
                                                                                   data-date="{{ $i_time['date'] }}"
                                                                                   class="{{ !empty($isCheckDisable) ? 'readonly' : '' }}">
                                                                            <label for="{{ $i_time['date'].$i_time['id']. str_slug($time['time']) }}">{{ $time['time'] }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </ul>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="date" id="date-input">
                                                <div class="submit-btn mt-25">
                                                    <button type="submit" class="submit-button" disabled style="background-color: #ccc; padding: 10px; border-radius: 10px; border: none; color: #fff">
                                                        <span class="categories_link">Thương lượng lại</span>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div style="height: 400px; overflow-y: auto; overflow-x: hidden">
                                                            @foreach($times as $i_time)
                                                                <span data-date="{{ $i_time['date'] }}"> {{ $i_time['date'] }} </span>
                                                                @if ($errors->has('time'))
                                                                    <div class="custom_error">{{ $errors->first('time') }}</div>
                                                                @endif
                                                                <ul class="row p-0">
                                                                    @foreach($i_time['duration'] as $time)
                                                                        <div class="col-6 checkbox-group">
                                                                            <input type="radio" name="time" value="{{ $time['time'] }}"
                                                                                   id="{{ $i_time['date'].$i_time['id']. str_slug($time['time']) }}"
                                                                                   data-time="{{ $time['time'] }}"
                                                                                   data-date="{{ $i_time['date'] }}"
                                                                                   class="{{ !empty($isCheckDisable) ? 'readonly' : '' }}">
                                                                            <label for="{{ $i_time['date'].$i_time['id']. str_slug($time['time']) }}">{{ $time['time'] }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </ul>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="date" id="date-input">
                                                <div class="submit-btn mt-25">
                                                    <button type="submit" class="categories_button">
                                                        <span class="categories_link">Thương lượng lại</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </form>
                                    </div>


                                    <div class="col-12 col-lg-4">
                                        <form action="{{ route('frontend.user.reject', $data->id) }}"
                                              class="instructor__profile-form" method="POST">
                                            @csrf

                                            @if(isset($data) && $data->type == 2 ||  $data->type == 3 ||  $data->type == 5)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-grp">
                                                            <label for="reject">Lý do hủy <span
                                                                    class="text-danger">*</span></label>
                                                            <textarea id="reject" name="note"
                                                                      disabled>{{ old('note') }}</textarea>
                                                            @if ($errors->has('note'))
                                                                <div
                                                                    class="custom_error">{{ $errors->first('note') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="submit-btn mt-25">
                                                    <button type="submit" class="" disabled
                                                            style="background-color: #ccc;padding: 10px; border-radius: 10px; border: none; color: #fff"><span
                                                            class="">
                                                        Từ chối
                                                    </span>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-grp">
                                                            <label for="reject">Lý do hủy <span
                                                                    class="text-danger">*</span></label>
                                                            <textarea id="reject"
                                                                      name="note">{{ old('note', $data->note) }}</textarea>
                                                            @if ($errors->has('note'))
                                                                <div
                                                                    class="custom_error">{{ $errors->first('note') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="submit-btn mt-25">
                                                    <button type="submit" class="categories_button"><span
                                                            class="categories_link">
                                                        Từ chối
                                                    </span>
                                                    </button>
                                                </div>
                                            @endif
                                        </form>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radioButtons = document.querySelectorAll('input[name="time"]');
        const submitButton = document.querySelector('.submit-button');
        const dateInput = document.getElementById('date-input');

        radioButtons.forEach(function (radio) {
            radio.addEventListener('change', function () {
                dateInput.value = this.dataset.date;
                submitButton.disabled = !radioButtons.some(radio => radio.checked);
                submitButton.style.backgroundColor = radioButtons.some(radio => radio.checked) ? '#28a745' : '#ccc';
            });
        });
    });
</script>
