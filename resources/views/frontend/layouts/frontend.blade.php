<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">
@include('frontend.layouts.components.head')
@yield('style')
<style>
     h1, h2, h3, h4, h5, h6, p, span, div, label, input, textarea ,a , button, ul, li  {
        /*font-family: "Kanit", sans-serif; !important;*/
        font-family: "Roboto", sans-serif !important;
    }
     .loading {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: #fff;
         z-index: 9999;
     }
     .loading-text {
         position: absolute;
         top: 0;
         bottom: 0;
         left: 0;
         right: 0;
         margin: auto;
         text-align: center;
         width: 100%;
         height: 100px;
         line-height: 100px;
     }
     .loading-text span {
         display: inline-block;
         margin: 0 5px;
         color: #000;
         font-weight: 500;
         /*font-family: 'Quattrocento Sans', sans-serif;*/
     }
     .loading-text span:nth-child(1) {
         filter: blur(0px);
         animation: blur-text 1.5s 0s infinite linear alternate;
     }
     .loading-text span:nth-child(2) {
         filter: blur(0px);
         animation: blur-text 1.5s 0.2s infinite linear alternate;
     }
     .loading-text span:nth-child(3) {
         filter: blur(0px);
         animation: blur-text 1.5s 0.4s infinite linear alternate;
     }
     .loading-text span:nth-child(4) {
         filter: blur(0px);
         animation: blur-text 1.5s 0.6s infinite linear alternate;
     }
     .loading-text span:nth-child(5) {
         filter: blur(0px);
         animation: blur-text 1.5s 0.8s infinite linear alternate;
     }
     .loading-text span:nth-child(6) {
         filter: blur(0px);
         animation: blur-text 1.5s 1s infinite linear alternate;
     }

     .loading-text span:nth-child(7) {
         filter: blur(0px);
         animation: blur-text 1.5s 1.2s infinite linear alternate;
     }
     .loading-text span:nth-child(8) {
         filter: blur(0px);
         animation: blur-text 1.5s 1.4s infinite linear alternate;
     }
     @keyframes blur-text {
         0% {
             filter: blur(0px);
         }
         100% {
             filter: blur(4px);
         }
     }
    .tg-header__style-five .tgmenu__navbar-wrap ul {
        margin: auto !important;
    }
    .categories_title {
        font-size: 30px !important;
    }
    .banner_image_bg img {
        height: 500px !important;
    }
</style>
<body>
<div class="loading">
    <div class="loading-text">
        <span class="loading-text-words">N</span>
        <span class="loading-text-words">E</span>
        <span class="loading-text-words">Z</span>
        <span class="loading-text-words">T</span>
        <span class="loading-text-words">W</span>
        <span class="loading-text-words">O</span>
        <span class="loading-text-words">R</span>
        <span class="loading-text-words">K</span>
    </div>
</div>
<!--Preloader-end -->
<!-- Scroll-top -->
<button class="scroll__top scroll-to-target" data-target="html">
    <i class="tg-flaticon-arrowhead-up"></i>
</button>
<!-- Scroll-top-end-->
<!-- header-area -->
@include('frontend.layouts.components.header')
<!-- header-area-end -->
<!-- main-area -->
<main class="main-area fix">
    @yield('content')
</main>
<!-- main-area-end -->
<!-- footer-area -->
@include('frontend.layouts.components.footer')
<!-- footer-area-end -->
<!-- JS here -->
@include('frontend.layouts.components.script')
@yield('script')
</body>
</html>
