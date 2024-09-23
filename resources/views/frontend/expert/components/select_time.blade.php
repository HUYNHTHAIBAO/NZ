<div class="courses__details-sidebar m-0" id="expert_call" style="display: none">
    @if(!empty($times))
        <div class="courses__cost-wrap bg-black">
            <span>Giá: </span>
            <input type="hidden" class="title_price_input" value="">
            <h2 class="title_price text-white">
            </h2>
        </div>
        <div class="courses__information-wrap"
             style="height: 300px; overflow-x: hidden; overflow-y: auto; padding: 10px">
            <h5 class="title">Thời lượng cuộc gọi </h5>
            <ul class="row p-0">
                @foreach($expert->duration as $duration)
                    <div class="col-6 checkbox-group">
                        <input type="radio" name="time[]" value="{{$duration->duration_id}}"
                               data-duration="{{$duration->duration_name}}"
                               data-type="{{$duration->duration_id}}"
                               id="{{$duration->duration_id}}"
                               required
                               @if($duration->duration_type == 1)
                               disabled class="readonly"
                               @else
                               class="duration"
                            @endif>
                        <label
                            for="{{$duration->duration_id}}">{{$duration->duration_name}}</label>
                    </div>
                @endforeach
            </ul>
            <h5 class="title">Thời gian gọi </h5>
            @foreach($times as $i_time)
                <span data-date="{{$i_time['date']}}"> {{$i_time['date']}} </span>
                <ul class="row p-0">
                    {{--                                    // todo : check disable giờ đã đc thuê--}}
                    @foreach($i_time['duration'] as $time)
                        @php
                            $expertId = $expert->id;
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
        {{--                    // user_id expert--}}
        <input type="hidden" id="user_expert_id" name="user_expert_id" value="{{$expert->id}}">
        {{--                    // user_id--}}
        <input type="hidden" id="user_id" name="user_id"
               value="{{ Illuminate\Support\Facades\Auth::guard('web')->id() }}">

        <input type="hidden" id="email_user" name="email_user"
               value="{{Illuminate\Support\Facades\Auth::guard('web')->user()->email ?? ''}}">
        <input type="hidden" id="email_user_expert" name="email_user_expert"
               value="{{$expert->email ?? ''}}">

        @if(!empty(\Illuminate\Support\Facades\Auth::guard('web')->id()))
            @if(\Illuminate\Support\Facades\Auth::guard('web')->id() != $expert->id)
                <div class="text-center p-2">
                    <button type="button" class="categories_button" id="hireBtn">
                        <span class="categories_link">Đặt lịch</span>
                    </button>
                </div>
            @elseif(Illuminate\Support\Facades\Auth::guard('web')->user()->account_type == 2)
                <div class="text-center p-2">
                    <button type="button" class="categories_button" id="hireBtn"
                            style="display: none">
                        <span class="categories_link">Đặt lịch</span>
                    </button>
                </div>
            @else
                <div class="text-center p-2">
                    <button type="button" class="categories_button" id="hireBtn"
                            style="display: none">
                        <span class="categories_link">Đặt lịch</span>
                    </button>
                </div>
            @endif
        @else
            <div class="text-center p-2">
                <button type="button" class="categories_button" id="hireBtn"
                        style="display: none">
                    <a href="{{ route('frontend.user.login') }}"
                       class="categories_link">Đặt lịch</a>
                </button>
            </div>
        @endif
    @else
        <p class="font_weight_bold text-center">Chuyên gia chưa lên lịch, vui lòng quay lại sau
            !
            Xin cảm ơn ...</p>
    @endif
</div>
