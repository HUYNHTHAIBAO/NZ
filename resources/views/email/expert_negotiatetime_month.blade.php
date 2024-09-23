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
<h2>Neztwork</h2>

<div class="" style="padding: 10px">
    <p style="font-weight: bold">Thông tin chi tiết đơn thương lượng lại</p>
    <li>Mã đơn: #{{$data->id}}</li>
    <li>Họ tên KH: {{ $data->user->fullname ?? '' }}</li>
    <li>Email KH: {{ $data->user->email ?? '' }}</li>
    <li>Ghi chú: {{ $data->note ?? 'Không có ghi chú.' }}</li>
    <li>Số tiền: {{ number_format($data->price) ?? '0' }} VNĐ</li>
    @if(!empty($data->time))
        <li>Giờ gọi: {{ $data->time ?? '.' }}</li>
    @endif
    @if(!empty($data->date))
        <li>Ngày gọi: {{ $data->date ?? '.' }}</li>
    @endif
    @if(!empty($data->duration_id))
        <li>Thời lượng gọi: {{ $data->duration_id ?? '.' }}</li>
    @endif

</div>
Vui lòng truy cập <a href="https://neztwork.com/tai-khoan/lich-su-dat-lich">https://neztwork.com/tai-khoan/lich-su-dat-lich</a> chọn xác nhận hay từ chối với thời gian của chuyên gia đề ra.



</body>
</html>


