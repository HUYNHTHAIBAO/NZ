<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url('/favicon.ico')}}" type="image/x-icon"/>

    <title>@if($title!=''){{ $title.' | ' }}@endif{{ config('app.name', 'HomeDoctor') }}</title>

    <meta name="description" content="@isset($description){{ $description }}@endisset">
    <meta name="keywords" content="@isset($keywords){{ $keywords }}@endisset">
    <meta name="author" content="@isset($author){{ $author }}@endisset">

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('/storage/backend/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/storage/backend/assets/plugins/dropzone-master/dist/dropzone.css')}}" rel="stylesheet"
          type="text/css"/>

    @yield('style_top')

    <link href="{{ asset('/storage/backend/assets/plugins/bootstrap-select/bootstrap-select.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/storage/backend')}}/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="{{ asset('/storage/backend')}}/assets/plugins/select2/dist/css/select2-bootstrap.css"
          rel="stylesheet">
    <link href="{{ asset('/storage/backend')}}/js/fancybox/jquery.fancybox.min.css"
          rel="stylesheet">
    <link href="{{ asset('/storage/backend/main/css/style.css')}}?v={{config('constants.assets_version')}}"
          rel="stylesheet">
    <link href="{{ asset('/storage/backend/main/css/custom.css')}}?v={{config('constants.assets_version')}}"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <!-- You can change the theme colors from here -->
    <link href="{{ asset('/storage/backend/main/css/colors/blue.css')}}" id="theme" rel="stylesheet">
    <link href="{{ asset('/storage/backend/main/css/sweetalert2.min.css')}}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Popup CSS -->
    <link href="{{ asset('/storage/backend')}}/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css"
          rel="stylesheet">

    <link href="{{ asset('/storage/backend')}}/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="{{ asset('/storage/backend')}}/assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="{{ asset('/storage/backend')}}/assets/plugins/datepicker/jquery.datetimepicker.css"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    @yield('style')

    <script>
        var BASE_URL = "{{config('app.url')}}";

        var STATIC_URL = "{{ asset('/storage')}}";

        var PRODUCT_UNAPPROVED_URL = "{{route('backend.products.ajax.un_approved')}}";
        var PRODUCT_APPROVED_URL = "{{route('backend.products.ajax.approved')}}";
        var PRODUCT_DELETE_URL = "{{route('backend.products.ajax.delete')}}";

        var USER_SEARCH_URL = "{{route('backend.ajax.searchUser')}}";
    </script>

    @yield('script_top')

{{--    // custom css--}}
    <style>
        .custom_line_2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        body, * {
            font-family: "Poppins", sans-serif;
        }
        .video_wrap_play {
            position: relative;
            display: inline-block;
        }

        .video_wrap_play_img {
            display: block;
            max-width: 200px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #ccc;
        }

        .video-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 48px;
            color: red;
            opacity: 0.9;
            transition: transform 0.3s ease, opacity 0.3s ease;
            z-index: 2;
        }

        .video-icon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 80px;
            height: 80px;
            background-color: rgba(224, 186, 39, 0.86);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: ripple 1.5s infinite ease-out;
            z-index: 1;
        }

        @keyframes ripple {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0;
            }
        }

        .video_wrap_play:hover .video-icon {
            transform: translate(-50%, -50%) scale(1.1);
            opacity: 1;
        }

        .video-icon i {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body
    class="{{Route::currentRouteName() != 'backend.login' ? 'fix-header fix-sidebar card-no-border logo-center' : ''}}">

@if(Route::currentRouteName() != 'backend.login')

    <div id="main-wrapper">
        @include('backend.partials.header')
        <div class="page-wrapper">

            @yield('content')

            <footer class="footer">
                © Copyrights <?php echo date('Y');?> <a href="#">APP24h</a> All rights reserved.
            </footer>
        </div>
    </div>

@else
    @yield('content')
@endif

<script src="{{ asset('/storage/backend/assets/plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('/storage/backend/assets/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{ asset('/storage/backend/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('/storage/backend/main/js/jquery.slimscroll.js')}}"></script>

<!--Wave Effects -->
<script src="{{ asset('/storage/backend/main/js/waves.js')}}"></script>

<!--Menu sidebar -->
<script src="{{ asset('/storage/backend/main/js/sidebarmenu.js')}}"></script>

<!--stickey kit -->
<script src="{{ asset('/storage/backend/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
<script src="{{ asset('/storage/backend/assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

<!--Custom JavaScript -->
<script src="{{ asset('/storage/backend/main/js/custom.min.js')}}"></script>

<script src="{{ asset('/storage/backend/main/js/mustache.min.js')}}"></script>
<!-- ============================================================== -->

<!-- Magnific popup JavaScript -->
<script
    src="{{ asset('/storage/backend')}}/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
<script
    src="{{ asset('/storage/backend')}}/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
<script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- chartist chart -->
<script src="{{ asset('/storage/backend')}}/assets/plugins/chartist-js/dist/chartist.min.js"></script>
<script
    src="{{ asset('/storage/backend')}}/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>

<script src="{{ asset('/storage/backend')}}/assets/plugins/datepicker/jquery.datetimepicker.js"></script>


<script src="{{ asset('/storage/backend/assets/plugins/select2/dist/js/select2.full.min.js')}}"
        type="text/javascript"></script>
<script src="{{ asset('/storage/backend/assets/plugins/dropzone-master/dist/dropzone.js')}}"
        type="text/javascript"></script>

<script src="{{ asset('/storage/backend/assets/plugins/bootstrap-select/bootstrap-select.min.js')}}"
        type="text/javascript"></script>

<script src="{{ asset('/storage/backend')}}/js/custom.js?v={{config('constants.assets_version')}}"></script>
<script src="{{ asset('/storage/backend')}}/js/app.js?v={{config('constants.assets_version')}}"></script>
<script src="{{ asset('/storage/backend')}}/js/sweetalert2.min.js"></script>
<script src="{{ asset('/storage/backend')}}/js/fancybox/jquery.fancybox.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>


<script>
    LCK_App.url_get_district = "{{route('location.district')}}";
    LCK_App.url_get_ward = "{{route('location.ward')}}";
    LCK_App.google_maps_key = "{{config('constants.google_maps_key')}}";
    LCK_App.init();

</script>

<script>
    jQuery('.date_time_select').css({'cursor': 'pointer'}).datetimepicker({
        format: 'Y-m-d H:i:00',
        step: 15,
        lang: 'vi'
    });
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
    $(document).ready(function () {
        let table = new DataTable('#table_id', {
            // options
            language: {
                search: "",
                paginate: {
                    first: "Trang đầu",
                    previous: "Trang trước",
                    next: "Trang sau",
                    last: "Trang cuối"
                },
                emptyTable: "Không có dữ liệu",
                info: "Hiển thị _START_ đến _END_ Tổng cộng _TOTAL_ ",
                infoEmpty: "Không có dữ liệu, Hiển thị 0 bản ghi ",
                zeroRecords: "Không có dữ liệu bạn muốn tìm",
                infoFiltered: "",
                lengthMenu: "Hiển thị số lượng _MENU_ ",
            }
        });
        $('#table_id_filter input').attr('placeholder', 'Tìm kiếm...');
    });

</script>

<script>
    $(function () {
        $(document).on('click', '#delete', function (e) {
            e.preventDefault();
            var link = $(this).attr("href");


            Swal.fire({
                title: 'Bạn có chắc xóa không?',
                text: "Xóa dữ liệu này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link
                    Swal.fire(
                        'Xóa!',
                        'Xóa dữ liệu thành công.',
                        'success'
                    )
                }
            })


        });

    });
</script>
@yield('script')
@yield('script2')
@yield('script3')
@yield('script4')
</body>
</html>
