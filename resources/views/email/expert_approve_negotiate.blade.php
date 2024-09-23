
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
{{--// mail tham gia gửi cho user khi user chập nhận thương lượng--}}
<h2>Neztwork</h2>
<p> Bạn đã chấp nhận yêu cầu
    lại thời gian với chuyên gia <span style="font-weight: bold; color: #6e0808">{{$data->user_expert->fullname ?? ''}}  vào lúc <span style="font-weight: bold; color: #6e0808">{{$data->time_negotiate ?? ''}} - </span> ngày <span style="font-weight: bold; color: #6e0808"> {{format_date_custom($data->date_negotiate ?? '')}}</span></p>
<p>Chúc bạn có cuộc gọi vui vẻ !</p>
<p>
    <a href="{{ url('/meeting.html') }}">Link tham gia cuộc họp: {{ url('/meeting.html') }}</a>
</p>
<p>
    <strong>Mã cuộc họp: {{ $room->rom_code }}</strong>
</p>


<div class="" style="padding: 10px">
    <p style="font-weight: bold">Thông tin chi tiết đơn ban đầu</p>
    <ul>
        <li>Mã đơn : <span style="font-weight: bold">{{$data->order_code ?? ''}}</span></li>
        <li>
            Ngày : <span style="font-weight: bold">{{ format_date_custom($data->date ?? '') }}</span>
        </li>
        <li>
            Giờ : <span style="font-weight: bold">{{$data->time ?? ''}}</span>
        </li>
        <li>
            Thời lượng cuộc gọi : <span style="font-weight: bold">{{$data->duration_id ?? ''}}</span>
        </li>
    </ul>
</div>
<div class="" style="padding: 10px">
    <p style="font-weight: bold">Thông tin chi tiết đơn thương lượng lại</p>
    <ul>
        <li>Mã đơn : <span style="font-weight: bold">{{$data->order_code ?? ''}}</span></li>
        <li>
            Ngày : <span style="font-weight: bold">{{ format_date_custom($data->date_negotiate ?? '') }}</span>
        </li>
        <li>
            Giờ : <span style="font-weight: bold">{{$data->time_negotiate ?? ''}}</span>
        </li>
        <li>
            Thời lượng cuộc gọi : <span style="font-weight: bold">{{$data->duration_id ?? ''}}</span>
        </li>
    </ul>
</div>
<p>Trạng thái thanh toán :
    @if($data->status == 1 )
        <span style="font-weight: bold">Thanh toán thành công</span>
    @elseif($data->status == 2)
        <span style="font-weight: bold">Thanh toán thất bại</span>
    @endif
</p>
<p>Phương thức thanh toán : <span style="font-weight: bold">Ví điện tử VNPAY</span></p>
<p>Số tiền đã thanh toán : <span
        style="font-weight: bold">{{number_format($data->price ?? '', 0, ',', '.')}} vnđ</span>
</p>
<p style="font-style: italic">Bạn vui lòng kiểm tra email để tham gia cuộc gọi !</p>

</body>
</html>


