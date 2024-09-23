@extends('frontend.layouts.frontend')

@section('content')
    <section class="about-area-three section-py-120">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                {!! html_entity_decode($VNPAY) !!}
            </div>
        </div>
    </section>
@endsection
