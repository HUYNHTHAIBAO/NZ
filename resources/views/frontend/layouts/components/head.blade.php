<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    @php
        $_title = $META_TITLE;
        $_description = $META_DESCRIPTIONS;
        $_keywords = $META_KEYWORDS;

        if(isset($seo_title)&&!empty($seo_title)){
        $_title = $seo_title;
    }elseif (isset($title)&&!empty($title)){
    $_title = $title;
    }

    if(isset($seo_description)&&!empty($seo_description)){
    $_description = $seo_description;
    }elseif (isset($description)&&!empty($description)){
    $_description = $description;
    }

    if(isset($seo_keywords)&&!empty($seo_keywords)){
    $_keywords = $seo_keywords;
    }

    $_image_fb_url = url('/storage/uploads').'/'.$LOGO;

    if(isset($image_fb_url)&&!empty($image_fb_url)){
    $_image_fb_url = $image_fb_url;
    }

    @endphp

    <title>{{$_title}}</title>



    <link rel="canonical" href="{{url()->current()}}"/>
    <meta name="description" content="{{$_description}}">
    <meta name="keywords" content="{{$_keywords}}">
    <meta name="author" content="{{$META_AUTHOR}}">
    <meta property="fb:app_id" content="970891727087844" />
    <meta property="og:locale" content="vi_VN">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{$_title}}">
    <meta property="og:description" content="{{$_description}}">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:site_name" content="{{$COMPANY_NAME}}">
    <meta property="og:image" content="{{$_image_fb_url}}">
    <meta property="og:image:alt" content="{{$_description}}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{$_title}}">
    <meta name="twitter:description" content="{{$_description}}">
    <meta name="twitter:image" content="{{$_image_fb_url}}">

    <link rel="alternate" type="application/rss+xml" title="{{$META_TITLE}}" href="{{url('feed')}}"/>


    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{url('/storage/uploads').'/'.$FAVICON}}">

    <!-- CSS here -->

    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/animate.min.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/flaticon-skillgro.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/flaticon-skillgro-new.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/default-icons.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/odometer.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/aos.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/plyr.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/spacing.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/tg-cursor.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ asset('/storage/frontendNew')}}/assets/css/custom.css">
{{--    <link rel="preconnect" href="https://fonts.googleapis.com">--}}
{{--    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">--}}
{{--    // buff thông báo--}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link href="https://anocha.me/storage/backend/main/css/jquery.toast.css" rel="stylesheet">
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"
    />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        var BASE_URL = "{{config('app.url')}}";

        var STATIC_URL = "{{ asset('/storage')}}";
    </script>


</head>
