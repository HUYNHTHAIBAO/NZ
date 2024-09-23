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
                                        <form id="approveForm" action="{{ route('frontend.user.approve', $data->id) }}"
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
                                                                <span data-date="{{$i_time['date']}}"> {{$i_time['date']}} </span>
                                                                <ul class="row p-0">
                                                                    {{--                                    // todo : check disable giờ đã đc thuê--}}
                                                                    @foreach($i_time['duration'] as $time)
                                                                        @php
                                                                            $expertId = $data->user_expert_id;
                                                                            $date = $i_time['date'];
                                                                            $formattedDate = \Carbon\Carbon::parse($date)->format('Y-m-d'); // Định dạng lại ngày tháng năm
                                                                            $time1 = $time['time'];
                                                                       $isCheckDisable = \App\Models\RequestExpert::where('user_expert_id', $expertId)
                                                                            ->where('date', $formattedDate)
                                                                            ->where('time', $time1)
                                                                            ->where(function($query) {
                                                                                $query->where('status', 1)
                                                                                      ->orWhere('status', 2);
                                                                            })
                                                                            ->first();

                                                                        @endphp
                                                                        @if(!empty($isCheckDisable))
                                                                            <script>
                                                                                document.addEventListener('DOMContentLoaded', function () {
                                                                                    var date = "{{$i_time['date']}}";
                                                                                    var currentDateTime = "{{$isCheckDisable->time}}";
                                                                                    var duration = "{{$isCheckDisable->duration_id}}";
                                                                                    onDisibleBefor(duration, currentDateTime, date);

                                                                                    function onDisibleBefor(duration_time, time, duration_date) {
                                                                                        var durationMinutes = parseInt(duration_time.split(' ')[0], 10);
                                                                                        // Parse selected time
                                                                                        var startTime = parseTime(time);
                                                                                        // Add duration to start time
                                                                                        startTime.setMinutes(startTime.getMinutes() + durationMinutes);
                                                                                        // Get result time
                                                                                        var resultTime = formatTime(startTime);
                                                                                        const compareDate = duration_date;
                                                                                        const compareTime = resultTime;

                                                                                        function parseTime(timeString) {
                                                                                            const [hourMinute, period] = timeString.split(' ');
                                                                                            let [hour, minute] = hourMinute.split(':').map(Number);
                                                                                            if (period === 'PM' && hour !== 12) hour += 12;
                                                                                            if (period === 'AM' && hour === 12) hour = 0;
                                                                                            return new Date(2024, 0, 1, hour, minute);
                                                                                        }

                                                                                        const compareDateTime = parseTime(compareTime);
                                                                                        const startDateTime = parseTime(time);
                                                                                        // Get all input elements with the specified date
                                                                                        const inputs = document.querySelectorAll(`input[data-date="${compareDate}"]`);
                                                                                        console.log(inputs)
                                                                                        inputs.forEach(input => {
                                                                                            const inputTime = parseTime(input.getAttribute('value'));

                                                                                            if (inputTime <= compareDateTime && inputTime >= startDateTime) {
                                                                                                input.classList.add('readonly_2');
                                                                                                input.disabled = true;

                                                                                            }
                                                                                        });
                                                                                    }
                                                                                });

                                                                            </script>
                                                                        @endif
                                                                        {{--   // todo : end--}}
                                                                        <div class="col-6 checkbox-group">
                                                                            <input type="checkbox" name="time" value="{{ $time['time'] }}"
                                                                                   id="{{ $i_time['date'].$i_time['id']. str_slug($time['time']) }}"
                                                                                   data-time="{{ $time['time'] }}"
                                                                                   data-date="{{ $i_time['date'] }}"
                                                                                   class="single_select {{ !empty($isCheckDisable) ? 'readonly' : '' }}"
                                                                                   onclick="onDisible(this)"
                                                                                   required
                                                                                   @if(!empty($isCheckDisable)) disabled @endif>
                                                                            <label
                                                                                for="{{$i_time['date'].$i_time['id']. str_slug($time['time'])}}">{{$time['time']}}</label>
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
                                                                <span data-date="{{$i_time['date']}}"> {{$i_time['date']}} </span>
                                                                <ul class="row p-0">
                                                                    {{--                                    // todo : check disable giờ đã đc thuê--}}
                                                                    @foreach($i_time['duration'] as $time)
                                                                        @php
                                                                            $expertId = $data->user_expert_id;
                                                                            $date = $i_time['date'];
                                                                            $formattedDate = \Carbon\Carbon::parse($date)->format('Y-m-d'); // Định dạng lại ngày tháng năm
                                                                            $time1 = $time['time'];
                                                                       $isCheckDisable = \App\Models\RequestExpert::where('user_expert_id', $expertId)
                                                                            ->where('date', $formattedDate)
                                                                            ->where('time', $time1)
                                                                            ->where(function($query) {
                                                                                $query->where('status', 1)
                                                                                      ->orWhere('status', 2);
                                                                            })
                                                                            ->first();

                                                                        @endphp
                                                                        @if(!empty($isCheckDisable))
                                                                            <script>
                                                                                document.addEventListener('DOMContentLoaded', function () {
                                                                                    var date = "{{$i_time['date']}}";
                                                                                    var currentDateTime = "{{$isCheckDisable->time}}";
                                                                                    var duration = "{{$isCheckDisable->duration_id}}";
                                                                                    onDisibleBefor(duration, currentDateTime, date);

                                                                                    function onDisibleBefor(duration_time, time, duration_date) {
                                                                                        var durationMinutes = parseInt(duration_time.split(' ')[0], 10);
                                                                                        // Parse selected time
                                                                                        var startTime = parseTime(time);
                                                                                        // Add duration to start time
                                                                                        startTime.setMinutes(startTime.getMinutes() + durationMinutes);
                                                                                        // Get result time
                                                                                        var resultTime = formatTime(startTime);
                                                                                        const compareDate = duration_date;
                                                                                        const compareTime = resultTime;

                                                                                        function parseTime(timeString) {
                                                                                            const [hourMinute, period] = timeString.split(' ');
                                                                                            let [hour, minute] = hourMinute.split(':').map(Number);
                                                                                            if (period === 'PM' && hour !== 12) hour += 12;
                                                                                            if (period === 'AM' && hour === 12) hour = 0;
                                                                                            return new Date(2024, 0, 1, hour, minute);
                                                                                        }

                                                                                        const compareDateTime = parseTime(compareTime);
                                                                                        const startDateTime = parseTime(time);
                                                                                        // Get all input elements with the specified date
                                                                                        const inputs = document.querySelectorAll(`input[data-date="${compareDate}"]`);
                                                                                        console.log(inputs)
                                                                                        inputs.forEach(input => {
                                                                                            const inputTime = parseTime(input.getAttribute('value'));

                                                                                            if (inputTime <= compareDateTime && inputTime >= startDateTime) {
                                                                                                input.classList.add('readonly_2');
                                                                                                input.disabled = true;

                                                                                            }
                                                                                        });
                                                                                    }
                                                                                });

                                                                            </script>
                                                                        @endif
                                                                        {{--   // todo : end--}}
                                                                        <div class="col-6 checkbox-group">
                                                                            <input type="checkbox" name="time" value="{{ $time['time'] }}"
                                                                                   id="{{ $i_time['date'].$i_time['id']. str_slug($time['time']) }}"
                                                                                   data-time="{{ $time['time'] }}"
                                                                                   data-date="{{ $i_time['date'] }}"
                                                                                   class="single_select {{ !empty($isCheckDisable) ? 'readonly' : '' }}"
                                                                                   onclick="onDisible(this)"
                                                                                   @if(!empty($isCheckDisable)) disabled @endif>
                                                                            <label
                                                                                for="{{$i_time['date'].$i_time['id']. str_slug($time['time'])}}">{{$time['time']}}</label>
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
                                                            <textarea id="reject" name="note_reject"
                                                                      disabled>{{ old('note_reject', $data->note_reject) }}</textarea>
                                                            @if ($errors->has('note_reject'))
                                                                <div
                                                                    class="custom_error">{{ $errors->first('note_reject') }}</div>
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
                                                                      name="note_reject">{{ old('note_reject', $data->note_reject) }}</textarea>
                                                            @if ($errors->has('note_reject'))
                                                                <div
                                                                    class="custom_error">{{ $errors->first('note_reject') }}</div>
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
@section('style')
    <style>
        .checkbox-btn {
            display: flex;
            align-items: center;
        }


        .checkbox-group input[type="radio"],
        .checkbox-group input[type="checkbox"] {
            display: none;
        }

        .checkbox-group input[type="radio"].readonly,
        .checkbox-group input[type="checkbox"].readonly_1,
        .checkbox-group input[type="checkbox"].readonly_2,
        .checkbox-group input[type="checkbox"].readonly {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .checkbox-group input[type="radio"].readonly + label,
        .checkbox-group input[type="checkbox"].readonly_1 + label,
        .checkbox-group input[type="checkbox"].readonly_2 + label,
        .checkbox-group input[type="checkbox"].readonly + label {
            background: #bbb7b7;;
        }

        .checkbox-group label {
            display: inline-block;
            padding: 0.5em 1em;
            margin: 0.5em;
            cursor: pointer;
            border: 1px solid #999999;
            border-radius: 5px;
            width: 100%;
            text-align: center;
        }

        .checkbox-group input[type="radio"]:checked + label,
        .checkbox-group input[type="checkbox"]:checked + label {
            background-color: #007bff;
            color: #ffffff;
            border-color: #007bff;
        }
    </style>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {


        var currentDate = getCurrentDate();
        var currentDateTime = getCurrentDateTime();

        onDisibleBefor('60 phút', currentDateTime, currentDate)

        function onDisibleBefor(duration_time, time, duration_date) {

            var durationMinutes = parseInt(duration_time.split(' ')[0], 10);

            // Parse selected time
            var startTime = parseTime(time);


            // Add duration to start time
            startTime.setMinutes(startTime.getMinutes() + durationMinutes);

            // Get result time
            var resultTime = formatTime(startTime);


            const compareDate = duration_date;
            const compareTime = resultTime;

            function parseTime(timeString) {
                const [hourMinute, period] = timeString.split(' ');
                let [hour, minute] = hourMinute.split(':').map(Number);
                if (period === 'PM' && hour !== 12) hour += 12;
                if (period === 'AM' && hour === 12) hour = 0;
                return new Date(2024, 0, 1, hour, minute);
            }

            const compareDateTime = parseTime(compareTime);
            const startDateTime = parseTime(time);


            // Get all input elements with the specified date
            const inputs = document.querySelectorAll(`input[data-date="${compareDate}"]`);
            console.log(inputs)
            inputs.forEach(input => {
                const inputTime = parseTime(input.getAttribute('value'));

                if (inputTime <= compareDateTime) {
                    input.classList.add('readonly_2');
                    input.disabled = true;

                }
            });
        }
    });


    function onDisible(element) {

        var checkboxes = document.querySelectorAll('input[name="time"]');

        checkboxes.forEach(function (checkbox) {
            // If the checkbox is not the current checkbox, uncheck it
            if (checkbox !== element) {
                checkbox.checked = false;
                removeCheck(checkboxes)
            }
        });
        var duration_time = $('.duration:checked').attr('data-duration');
        var time = $('input[name="time"]:checked').val();
        var duration_date = $('.single_select:checked').attr('data-date');

        $('input[name="date"]').val(duration_date);
        onDisibleAfter(duration_time, time, duration_date)


    }
    //
    // $('.single_select').onclick(function () {
    //     console.log('adsdasdasd')
    // })




    function onDisibleAfter(duration_time, time, duration_date) {


        var durationMinutes = parseInt(duration_time.split(' ')[0], 10);

        // Parse selected time
        var startTime = parseTime(time);


        // Add duration to start time
        startTime.setMinutes(startTime.getMinutes() + durationMinutes);

        // Get result time
        var resultTime = formatTime(startTime);


        const compareDate = duration_date;
        const compareTime = resultTime;

        function parseTime(timeString) {
            const [hourMinute, period] = timeString.split(' ');
            let [hour, minute] = hourMinute.split(':').map(Number);
            if (period === 'PM' && hour !== 12) hour += 12;
            if (period === 'AM' && hour === 12) hour = 0;
            return new Date(2000, 0, 1, hour, minute);
        }

        const compareDateTime = parseTime(compareTime);
        const startDateTime = parseTime(time);


        // Get all input elements with the specified date
        const inputs = document.querySelectorAll(`input[data-date="${compareDate}"]`);
        console.log(inputs)
        inputs.forEach(input => {
            const inputTime = parseTime(input.getAttribute('value'));
            if (inputTime <= compareDateTime && inputTime >= startDateTime) {
                input.classList.add('readonly_1');
            }
        });

    }


    function removeCheck(checkboxes) {
        checkboxes.forEach(function (checkbox) {
            checkbox.classList.remove('readonly_1')
        });
    }

    function convertToDateObject(dateString) {
        // Tách ngày, giờ và AM/PM từ chuỗi
        var parts = dateString.split(' ');
        var datePart = parts[0];
        var timePart = parts[1] + ' ' + parts[2];

        // Tách ngày và tháng năm
        var dateParts = datePart.split('-');
        var day = parseInt(dateParts[0], 10);
        var month = parseInt(dateParts[1], 10) - 1; // Tháng bắt đầu từ 0 trong JavaScript Date
        var year = parseInt(dateParts[2], 10);

        // Tách giờ, phút từ thời gian
        var timeParts = timePart.split(':');
        var hour = parseInt(timeParts[0], 10);
        var minute = parseInt(timeParts[1], 10);
        var ampm = timeParts[2];

        // Nếu là PM và giờ không phải 12 thì thêm 12 vào giờ
        if (ampm === 'PM' && hour !== 12) {
            hour += 12;
        }
        // Nếu là AM và giờ là 12 thì chuyển giờ về 0
        if (ampm === 'AM' && hour === 12) {
            hour = 0;
        }

        // Tạo đối tượng Date
        var dateObject = new Date(year, month, day, hour, minute);
        return dateObject;
    }

    function parseTime(timeString) {
        const [time, period] = timeString.split(' ');
        let [hours, minutes] = time.split(':').map(Number);
        if (period === 'PM' && hours !== 12) hours += 12;
        if (period === 'AM' && hours === 12) hours = 0;
        return new Date(2000, 0, 1, hours, minutes);
    }

    // Function to format Date object as time string
    function formatTime(date) {
        let hours = date.getHours();
        const minutes = date.getMinutes();
        const period = hours >= 12 ? 'PM' : 'AM';
        if (hours > 12) hours -= 12;
        if (hours === 0) hours = 12;
        return `${hours}:${minutes < 10 ? '0' : ''}${minutes} ${period}`;
    }

    function getCurrentDate() {
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var year = today.getFullYear();

        return day + '-' + month + '-' + year;
    }

    function getCurrentDateTime() {
        var today = new Date();

        // Get date components
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var year = today.getFullYear();

        // Get time components
        var hours = today.getHours();
        var minutes = String(today.getMinutes()).padStart(2, '0');
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'

        // Combine date and time
        var currentDate = day + '-' + month + '-' + year;
        var currentTime = hours + ':' + minutes + ' ' + ampm;

        return currentTime;
    }



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

    document.getElementById('approveForm').addEventListener('submit', function() {
        // Hiển thị thông báo đang xử lý
        alert('Đang xử lý, vui lòng chờ...');

        // Disable các phần tử của form để ngăn việc submit lại
        const formElements = this.elements;
        for(let i = 0; i < formElements.length; i++) {
            formElements[i].disabled = true;
        }
    });
</script>
