<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<style>
    * {
        font-family: "Be Vietnam Pro", sans-serif;
    }
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-attachment: fixed;
        background-color: #f0f4ff;
        background-image: url(//sf1-scmcdn-cn.feishucdn.com/obj/feishu-static/scheduler/static/image/app-bg.d16fe635.png);
        background-repeat: no-repeat;
        background-size: cover;
    }


    .form_expert {
        border-radius: 20px;
        box-shadow: 2px 2px 16px 0px #d2e7eb;

    }

    .form_expert_left {
        background-color: #f8f9fe;
    }

    .link_back {
        transition: all 0.2s linear;
        padding: 10px;
        color: #000;
        border-radius: 10px;
    }

    .link_back:hover {
        background-color: #f8f9fe;
    }

    .link_continued {
        border: none;
        transition: all 0.2s linear;
        padding: 10px;
        color: #000;
        border-radius: 10px;
        background-color: transparent;
    }

    .link_continued:hover {
        background-color: #f8f9fe;
    }


    .wrapper {
        max-width: 18rem;
        padding: 0 0.5rem;
        margin-left: auto;
        margin-right: auto;
        padding-top: 4rem;
    }

    .date {
        font-size: 0.75rem;
        font-weight: 400;
        display: block;
        margin-bottom: 0.5rem;
        color: #B0BEC5;
        border: 1px solid #ECEFF1;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
    }

    input {
        font-family: 'Roboto', sans-serif;
        display: block;
        border: none;
        border-radius: 0.25rem;
        border: 1px solid transparent;
        line-height: 1.5rem;
        padding: 0;
        font-size: 1rem;
        color: #607D8B;
        width: 100%;
        margin-top: 0.5rem;
    }

    input:focus {
        outline: none;
    }

    #ui-datepicker-div {
        display: none;
        background-color: #fff;
        box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1);
        margin-top: 0.25rem;
        border-radius: 0.5rem;
        padding: 0.5rem;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    .ui-datepicker-calendar thead th {
        padding: 0.25rem 0;
        text-align: center;
        font-size: 0.75rem;
        font-weight: 400;
        color: #78909C;
    }

    .ui-datepicker-calendar tbody td {
        width: 2.5rem;
        text-align: center;
        padding: 0;
    }

    .ui-datepicker-calendar tbody td a {
        display: block;
        border-radius: 0.25rem;
        line-height: 2rem;
        transition: 0.3s all;
        color: #546E7A;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
    }

    .ui-datepicker-calendar tbody td a:hover {
        background-color: #E0F2F1;
    }

    .ui-datepicker-calendar tbody td a.ui-state-active {
        background-color: #009688;
        color: white;
    }

    .ui-datepicker-header a.ui-corner-all {
        cursor: pointer;
        position: absolute;
        top: 0;
        width: 2rem;
        height: 2rem;
        margin: 0.5rem;
        border-radius: 0.25rem;
        transition: 0.3s all;
    }

    .ui-datepicker-header a.ui-corner-all:hover {
        background-color: #ECEFF1;
    }

    .ui-datepicker-header a.ui-datepicker-prev {
        left: 0;
        background: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMyIgaGVpZ2h0PSIxMyIgdmlld0JveD0iMCAwIDEzIDEzIj48cGF0aCBmaWxsPSIjNDI0NzcwIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik03LjI4OCA2LjI5NkwzLjIwMiAyLjIxYS43MS43MSAwIDAgMSAuMDA3LS45OTljLjI4LS4yOC43MjUtLjI4Ljk5OS0uMDA3TDguODAzIDUuOGEuNjk1LjY5NSAwIDAgMSAuMjAyLjQ5Ni42OTUuNjk1IDAgMCAxLS4yMDIuNDk3bC00LjU5NSA0LjU5NWEuNzA0LjcwNCAwIDAgMS0xLS4wMDcuNzEuNzEgMCAwIDEtLjAwNi0uOTk5bDQuMDg2LTQuMDg2eiIvPjwvc3ZnPg==");
        background-repeat: no-repeat;
        background-size: 0.5rem;
        background-position: 50%;
        transform: rotate(180deg);
    }

    .ui-datepicker-header a.ui-datepicker-next {
        right: 0;
        background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMyIgaGVpZ2h0PSIxMyIgdmlld0JveD0iMCAwIDEzIDEzIj48cGF0aCBmaWxsPSIjNDI0NzcwIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik03LjI4OCA2LjI5NkwzLjIwMiAyLjIxYS43MS43MSAwIDAgMSAuMDA3LS45OTljLjI4LS4yOC43MjUtLjI4Ljk5OS0uMDA3TDguODAzIDUuOGEuNjk1LjY5NSAwIDAgMSAuMjAyLjQ5Ni42OTUuNjk1IDAgMCAxLS4yMDIuNDk3bC00LjU5NSA0LjU5NWEuNzA0LjcwNCAwIDAgMS0xLS4wMDcuNzEuNzEgMCAwIDEtLjAwNi0uOTk5bDQuMDg2LTQuMDg2eiIvPjwvc3ZnPg==');
        background-repeat: no-repeat;
        background-size: 10px;
        background-position: 50%;
    }

    .ui-datepicker-header a > span {
        display: none;
    }

    .ui-datepicker-title {
        display: flex;
        align-items: center;
        justify-content: space-around;
        text-align: center;
        line-height: 2rem;
        font-size: 0.875rem;
        font-weight: 500;
        padding: 5px;
    }

    .ui-datepicker-week-col {
        color: #78909C;
        font-weight: 400;
        font-size: 0.75rem;
    }

    .list-email {
        margin: 0px;
    }

    .list-email-group {
        background: #fff;
        border: 10px;
        display: none;
        max-height: 200px;
        overflow-y: auto;
        margin: 10px 0px;
    }

    .list-email-group::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    .list-email-group::-webkit-scrollbar-track {
        background-color: #fafafa;
    }

    /* Handle */
    .list-email-group::-webkit-scrollbar-thumb {
        background-image: linear-gradient(-45deg, #f8f9fe, #ccc);
        border-radius: 50px;
    }

    .list-email-group ul {
        padding: 0;
    }

    .list-email-group ul li {
        cursor: pointer;
        list-style: none;
        font-size: 14px;
        padding: 5px 10px;
        color: #6a6666;
        border-bottom: 1px solid #fff;

    }

    .list-email-group ul li:hover {
        background: #f8f9fe;
    }

    /* Tùy chỉnh giao diện của datepicker */
    .ui-datepicker {
        border-radius: 10px;
        padding: 5px;
        background-color: #fff;
    }

    /* Tùy chỉnh tiêu đề của datepicker (tháng, năm) */
    .ui-datepicker-header {
        border-bottom: 1px solid #ddd;
        padding: 5px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        text-align: center;
    }

    /* Tùy chỉnh các nút điều hướng (trước, sau) */
    .ui-datepicker-prev, .ui-datepicker-next {
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        padding: 5px;
        cursor: pointer;
    }

    /* Tùy chỉnh các nút chọn tháng và năm */
    .ui-datepicker-calendar .ui-datepicker-prev,
    .ui-datepicker-calendar .ui-datepicker-next {
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        padding: 5px;
        cursor: pointer;
    }

    /* Tùy chỉnh dropdown chọn tháng và năm */
    .ui-datepicker-month, .ui-datepicker-year {
        border-radius: 5px;
        cursor: pointer;
        padding: 5px 15px;
        box-shadow: 0px 1px 2px 2px #fafafa;
        border: none;
    }

    /* Tùy chỉnh các ngày trong calendar */
    .ui-datepicker-calendar td a {
        color: #007bff;
    }

    /* Tùy chỉnh ngày được chọn */
    .ui-datepicker-calendar .ui-state-active {
        background-color: #007bff;
        color: white;
        border-radius: 5px;
    }

    .ui-datepicker-today {
        background-color: #d0f0c0; /* Màu xanh nhạt cho ngày hiện tại */
        border-radius: 10px;
    }

    .ui-datepicker-prev-day {
        background-color: #fdd; /* Màu đỏ nhạt cho các ngày trước đó */
    }

    .ui-datepicker-calendar tbody td {
        color: #eee;
    }

    .tbody, td, tfoot, th, thead, tr {
        font-weight: bold !important;
        color: #000;
    }

    option {
        cursor: pointer;
    }
</style>
<body>
<div class="container p-0 d-flex justify-content-center">
    <div class="form_expert row col-8 ">
        <div class="col-12 col-lg-4 form_expert_left p-4" style="border-radius: 10px 0px 0px 10px">
            <div class="">
                @if(!empty($data->userExpert->avatar_file_path))
                    <img
                        src="{{asset('storage/uploads') . '/' . $data->userExpert->avatar_file_path ?? ''}}"
                        style="padding: 0px; display: block; width: 50px; height: 50px; object-fit: contain; border-radius: 50%;border: 1px solid #ccc; cursor: pointer"
                        alt="img">
                @else
                    <div class="bg-black"
                         style="cursor: pointer; width: 50px; height: 50px; border-radius: 50%; border: 1px solid #eee; display: flex; align-items: center; justify-content: center;">
                            <span class="text-white font_weight_bold"
                                  style="">{{ $data->userExpert->avatar_name ?? '' }}</span>
                    </div>
                @endif
                <p>{{ $data->userExpert->fullname ?? '' }}</p>
            </div>
            <div class="">
                <p style="font-size: 20px;font-weight: bold"><i class="fa-regular fa-clock"></i>
                    <span>{{$data->duration_id ?? ''}}</span></p>

            </div>
        </div>
        <div class="col-12 col-lg-8 bg-white p-4 row" style="border-radius: 0px 10px 10px 0px">
            <div class="d-flex align-items-center">
                <div class="">
                    <a href="javascript:void(0);" onclick="history.back();" class="text-decoration-none ">
                        <p class="link_back"><i class="fa-solid fa-chevron-left"></i> Quay lại</p>
                    </a>
                </div>
            </div>

            <div class="row">



                <div class="col-md-6">
                                <div class="">
                                    <p class="fw-medium">Chọn ngày :</p>
                                </div>
                    {{--                    <div class="form-control-wrapper">--}}
                    {{--                        <input type="text" id="min-date" class="form-control floating-label input_user datepicker"  autocomplete="off" readonly--}}
                    {{--                               placeholder="Chọn ngày">--}}
                    {{--                    </div>--}}
                    <div class="datepicker-popup input_user"></div>
                </div>
                <div class="col-md-6">
                    <div class="">
                        <p class="fw-medium">Chọn giờ : </p>
                    </div>
                    <div class="form-control-wrapper">
                        <input type="time" id="min-time" class="form-control floating-label input_user"
                               placeholder="Nhập giờ">
                    </div>
                </div>
            </div>

            <div class="form-control-wrapper mt-3">
                <select class="js-example-basic-multiple" name="states[]" multiple="multiple">

                    @foreach($listPackageEmail as $key => $value)
                        <option value="{{  $value->email }}">{{ $value->email }}</option>
                    @endforeach

                </select>
{{--                <input class="form-control floating-label input_user searchEmail" onkeyup="searchEmail()" type="text"--}}
{{--                       placeholder="Nhập email bạn bè của bạn để chia sẽ đến họ ...">--}}
{{--                <div class="list-email-group">--}}
{{--                    <ul class="list-email">--}}

{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="content-email">--}}

{{--                </div>--}}
            </div>
            <div class="text-end">
                <button type="submit" class="link_continued btn-order-group mt-3">Tiếp tục <i
                        class="fa-solid fa-angles-right"></i></button>
            </div>
        </div>
    </div>
</div>

{{--<div class="wrapper">--}}
{{--    <label class="date" for="datepicker">Pick a Date--}}
{{--        <input type="text" class="datepicker" autocomplete="off" readonly>--}}
{{--    </label>--}}
{{--</div>--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    $(function () {
        $.datepicker.regional["vi-VN"] = {
            closeText: "Đóng",
            prevText: "Trước",
            nextText: "Sau",
            currentText: "Hôm nay",
            monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
            monthNamesShort: ["Một", "Hai", "Ba", "Bốn", "Năm", "Sáu", "Bảy", "Tám", "Chín", "Mười", "Mười một", "Mười hai"],
            dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
            dayNamesShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
            dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            weekHeader: "Tuần",
            dateFormat: "dd/mm/yy",
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ""
        };

        $.datepicker.setDefaults($.datepicker.regional["vi-VN"]);
        // Lấy năm hiện tại
        var currentYear = new Date().getFullYear();
        // Đặt ngày bắt đầu của năm hiện tại
        var minDate = new Date(currentYear, 0, 1);
        $(".datepicker-popup").datepicker({
            dateFormat: "dd-mm-yy",
            duration: "fast",
            changeMonth: true, // Cho phép chọn tháng
            changeYear: true,  // Cho phép chọn năm
            showOtherMonths: true,
            selectOtherMonths: true,
            showAnim: "fadeIn",
            minDate: new Date(), // Cấm chọn ngày trước ngày hiện tại

        }).datepicker("show");


    });
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    document.getElementById('image_file_id_form').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById('img_preview');
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            const img = document.getElementById('img_preview');
            img.src = '#';
            img.style.display = 'none';
        }
    });


    var group_id = null;
    let arrayEmail = [];
    $(document).ready(function () {
        $('.btn_time_month').on('click', function () {
            var id = $(this).data('id');
            let data = {
                id: id,
                key: 2,
                _token: "{{ csrf_token() }}"
            }

            $.ajax({
                url: "{{ route('frontend.expert.booking.plan') }}",
                type: "POST",
                data: data,
                success: function (data) {
                    window.location.href = '{{ url('/thong-tin-dat-lich') }}/' + data.data.data.id;
                }
            });
        })

        $('.btn_time_group').on('click', function (event) {
            event.preventDefault();
            var id = $(this).data('id');

            // Gửi yêu cầu Ajax tới server để mã hóa id
            $.ajax({
                url: '/encrypt-id', // URL để server xử lý mã hóa
                method: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}' // Đảm bảo thêm token CSRF cho bảo mật
                },
                success: function (response) {
                    // Khi thành công, chuyển hướng với id đã mã hóa
                    window.location.href = `/chon-thoi-gian-dat-lich-goi-nhom/${response.encryptedId}`;
                }
            });
        });


        $('.btn-order-group').on('click', function () {
            event.preventDefault();
            let data = {
                id: group_id,
                email: arrayEmail,
                key: 3,
                date: $('#min-date').val(),
                time: $('#min-time').val(),
                _token: "{{ csrf_token() }}"
            }
            $.ajax({
                url: "{{ route('frontend.expert.booking.plan') }}",
                type: "POST",
                data: data,
                success: function (data) {
                    console.log(data)
                    window.location.href = '{{ url('/thong-tin-dat-lich') }}/' + data.data.data.id;
                }
            });

        })
    });

    $(document).ready(function () {
        $('.js-example-basic-multiple10').select2();
    });
    var typingTimer; // Biến để lưu trữ timeout
    var doneTypingInterval = 1000; // Thời gian chờ là 1 giây (1000 ms)

    function searchEmail() {
        $('.list-email-group').show();
        var value = $('.searchEmail').val();

        clearTimeout(typingTimer); // Xóa timeout cũ nếu có

        typingTimer = setTimeout(function () {
            $.ajax({
                url: "{{ route('frontend.expert.search.email') }}",
                type: "GET",
                data: {email: value}, // Sử dụng object để truyền dữ liệu
                success: function (data) {

                    $('.list-email').html(data.data.html)
                }
            });
        }, doneTypingInterval);
    }

    $(document).on('click', '.delete-email', function () {
        var email = $(this).data('email');
        arrayEmail = arrayEmail.filter(item => item !== email);
        $(this).parent().remove();
        $('.searchEmail').val('')
    })


    function chooseEmail(email) {
        arrayEmail.push(email);
        $('.content-email').append('<div class="row"><p class="col-10">' + email + '</p> <i class="text-danger delete-email col-2" data-email="' + email + '">x</i> </div>');
        $('.list-email-group').hide();
    }

    // $(function () {
    //     // Khởi tạo Datepicker
    //     $("#min-date").datepicker({
    //         dateFormat: "yy-mm-dd", // Định dạng ngày
    //         onSelect: function (dateText, inst) {
    //             // Khi ngày được chọn, thêm thời gian hiện tại (hoặc tùy chỉnh)
    //             var time = $("#min-time").val();
    //             if (time) {
    //                 $(this).val(dateText + ' ' + time);
    //             } else {
    //                 $(this).val(dateText);
    //             }
    //         }
    //     });
    // });

</script>


</body>
</html>
