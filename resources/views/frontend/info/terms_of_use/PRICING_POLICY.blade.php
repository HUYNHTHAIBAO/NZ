

@extends('frontend.layouts.frontend')
@section('content')
    <div class="row py-5 px-3">
        <div class="col-lg-2 col-12 sidebar_term_of_use">
            @include('frontend.info.sidebar')
        </div>
        <div class="col-lg-10 col-12">
            <section class="about-area-three">
                <div class="p-2">
                    <div class="">
                        {!! html_entity_decode($PRICING_POLICY) !!}
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
