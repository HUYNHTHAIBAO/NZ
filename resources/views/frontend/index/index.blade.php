@extends('frontend.layouts.frontend')
@section('content')

    <!-- banner-area -->
    @include('frontend.index.components.banner')
    <!-- banner-area-end -->

    <!-- -categories -->
    @include('frontend.index.components.categories')
{{--    end--}}
    <!-- -branh -->
    @include('frontend.index.components.brand')
    {{--    end--}}

    <!-- -topExpert -->
    @include('frontend.index.components.topExperts')
    {{--    end--}}

    <!-- -booking -->
    @include('frontend.index.components.booking')
    {{--    end--}}
    <!-- -topic -->
    @include('frontend.index.components.topic')
    {{--    end--}}
    <!-- -review -->
    @include('frontend.index.components.review')
    {{--    end--}}


    <!-- -news -->
    @include('frontend.index.components.news')
    {{--    end--}}

    <!-- -news -->
    @include('frontend.index.components.blog')
    {{--    end--}}


    <!-- -solagan -->
    @include('frontend.index.components.solagan')
    {{--    end--}}



    <!-- -subcribe -->
    @include('frontend.index.components.subcribe')
    {{--    end--}}



@endsection
