@extends('frontend.layouts.frontend')

@section('content')

    <!-- dashboard-area -->
    <section class="dashboard__area custom_session">
        <div class="container">
            <div class="py-4 ">
                <p class="bg-light p-1"><a class="text-black font_weight_bold" href="{{route('frontend.user.profile')}}"> Tài khoản </a> / Lên lịch thời gian chuyên gia</p>
            </div>
            <i class="my-5 text-danger">( Lưu ý : Tất cả sẽ được lưu tự động khi chọn )</i>
            <h4 class="mt-5">Độ dài thời gian cho 1 buổi </h4>
            <div class="row">
                @foreach($listTimes as $item)
                    <div class="col checkbox-group">
                        <input type="checkbox" name="time[]" value="{{$item->id}}"
                               @if($item->duration_type == 2) checked @endif
                               id="{{$item->id}}" onchange="updateType({{$item->id}})"/>
                        <label for="{{$item->id}}">{{$item->duration_name}}</label>
                    </div>
                @endforeach
            </div>
            <h4 class="mt-4">Giá tiền cho khung giờ. </h4>
            <span>Đặt giá cho cuộc gọi điện video 15 phút và chúng tôi sẽ tính phần còn lại</span>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        @foreach($listTimes as $item)
                            <th scope="col">{{$item->duration_name}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Giá</td>
                        @foreach($listTimes as $k => $item)
                            <td>
                                <input type="text" class="form-control" placeholder="{{ number_format($item->price, 0, ',', '.') }} vnđ"
                                       onchange="UpdatePrice({{ $item->id }})"
                                       id="price_{{ $item->id }}"
                                       oninput="formatCurrency(this)"
                                       @if($k > 0) disabled @endif
                                />
                            </td>
                        @endforeach




                    </tr>
{{--                    <tr>--}}
{{--                        <td>Giảm giá</td>--}}
{{--                        @foreach($listTimes as $item)--}}
{{--                            <td>--}}
{{--                                <input type="text" class="form-control" placeholder="0$" disabled/>--}}
{{--                            </td>--}}
{{--                        @endforeach--}}
{{--                    </tr>--}}


                    </tbody>
                </table>
            </div>
            <h4>Khung giờ. </h4>
            @foreach($dateArray as $itemDate)
                <p style="border-bottom: 1px solid; color: #0A0A0A">{{ $itemDate['day_name'] }} - {{ $itemDate['date'] }}</p>

                <div class="row checkbox-container">
                    @php
                        $date = \Carbon\Carbon::createFromFormat('d/m/Y', $itemDate['date'])->format('Y-m-d');
                        $start = 6; // Starting hour (6 AM)
                        $end = 22;  // Ending hour (10 PM)
                    @endphp

                    @for($hour = $start; $hour <= $end; $hour++)
                        @php
                            $checked = '5';
                            $aHour = $hour <= 12 ? $hour : $hour - 12 ;
                            $bHour = $hour < 12 ? 'am' : 'pm';
                            $sumHour = $aHour . $bHour;
                            $isCheck = \App\Models\TimeDurations::where('user_id',$user->id)
                                        ->where('date',$date)
                                        ->where('key',$sumHour)->first();
                            if (!empty($isCheck)) {
                                $checked = 'checked';
                            }
                        @endphp

                        <label class="checkbox-btn">
                            <input type="checkbox"
                                   {{$checked}}
                                   onchange="FrameTime('{{$itemDate['date']}}', {{$hour}}, '{{  $bHour }}')">
                            <span></span>
                            {{ $aHour }}{{ $bHour}}
                        </label>
                    @endfor

                </div>
            @endforeach
        </div>


    </section>



    <style>

        .checkbox-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(70px, 1fr));
            gap: 10px;
        }

        .checkbox-btn {
            display: flex;
            align-items: center;
        }


        .checkbox-group input[type="checkbox"] {
            display: none;
        }

        .checkbox-group label {
            display: inline-block;
            padding: 0.5em 1em;
            margin: 0.5em;
            cursor: pointer;
            border: 1px solid #999999;
            border-radius: 5px;
        }

        .checkbox-group input[type="checkbox"]:checked + label {
            background-color: #007bff;
            color: #ffffff;
            border-color: #007bff;
        }

        /* Checkbox Input */
        .checkbox-btn span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: #ddd;
            transition: 0.3s;
        }

        .checkbox-btn span::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 12px;
            border-bottom: 3px solid #fff;
            border-left: 3px solid #fff;
            transform: scale(0) rotate(-45deg);
            position: relative;
            bottom: 4px;
            transition: 0.6s;
        }

        .checkbox-btn input {
            display: none;
        }

        .checkbox-btn input:checked ~ span {
            background-color: #02bcf0;
        }

        .checkbox-btn input:checked ~ span::before {
            transform: scale(1) rotate(-45deg);
        }

        .checkbox-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            row-gap: 20px
        }
    </style>
@endsection

    <script>
        function updateType(id) {
            let data = {
                _token: '{{ csrf_token() }}',
                id: id,
            }
            $.ajax({
                type: "POST",
                url: '{{ route('frontend.user.change.type.time') }}',
                dataType: 'json',
                data: data,
                success: function (data) {
                    console.log(data)
                },
                error: function (data) {
                }
            });
        }


        {{--function UpdatePrice(id) {--}}
        {{--    let data = {--}}
        {{--        _token: '{{ csrf_token() }}',--}}
        {{--        id: id,--}}
        {{--        price: $('#price_' + id).val(),--}}
        {{--    }--}}

        {{--    //console.log(data)--}}
        {{--    $.ajax({--}}
        {{--        type: "POST",--}}
        {{--        url: '{{ route('frontend.user.change.price.time') }}',--}}
        {{--        dataType: 'json',--}}
        {{--        data: data,--}}
        {{--        success: function (data) {--}}
        {{--            Swal.fire({--}}
        {{--                icon: 'success',--}}
        {{--                title: 'Lưu thành công',--}}
        {{--                showConfirmButton: false,--}}
        {{--                timer: 1500--}}
        {{--            }).then(() => {--}}
        {{--                // Tải lại trang sau khi thông báo toast biến mất--}}
        {{--                location.reload();--}}
        {{--            });--}}
        {{--        },--}}
        {{--        error: function (data) {--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
        function formatCurrency(input) {
            // Xóa các ký tự không phải số
            let value = input.value.replace(/\D/g, '');

            // Định dạng số tiền
            value = new Intl.NumberFormat('vi-VN').format(value);

            // Thêm ' vnđ' vào cuối giá trị
            input.value = value + ' vnđ';
        }

        function UpdatePrice(id) {
            let input = document.getElementById('price_' + id);
            let value = input.value.replace(/\D/g, ''); // Chỉ giữ lại số

            let data = {
                _token: '{{ csrf_token() }}',
                id: id,
                price: value,
            }

            //console.log(data)
            $.ajax({
                type: "POST",
                url: '{{ route('frontend.user.change.price.time') }}',
                dataType: 'json',
                data: data,
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Lưu thành công',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Tải lại trang sau khi thông báo toast biến mất
                        location.reload();
                    });
                },
                error: function (data) {
                    // Xử lý lỗi nếu có
                }
            });
        }



        function FrameTime(date, hour, type) {
            let data = {
                _token: '{{ csrf_token() }}',
                date: date,
                hour: hour,
                type: type
            }
            // console.log(data)
            // return;
            $.ajax({
                type: "POST",
                url: '{{ route('frontend.user.change.frame.time') }}',
                dataType: 'json',
                data: data,
                success: function (data) {
                    console.log(data)
                    return
                },
                error: function (data) {
                }
            });
        }



    </script>


