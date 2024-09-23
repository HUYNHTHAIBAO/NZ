@extends('backend.layouts.main')
@section('style_top')
    <style>
        .select2 {
            width: 100% !important;
            height: 36px !important;
        }

        .checkbox-basic {
            position: initial !important;
            left: initial !important;
            opacity: 1 !important;
        }

        a.sort.active {
            color: red;
        }

        .sort_btn {
            margin-top: 10px;
        }
    </style>
@stop
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.orders.index') }}
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline-info">
                    <div class="card-body">

                        @include('backend.orders.formFilter')

                        <div class="ajax-result">
                            @include('backend.orders.ajaxTable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/storage/backend')}}/assets/plugins/datepicker/jquery.datetimepicker.js"></script>

@endsection
