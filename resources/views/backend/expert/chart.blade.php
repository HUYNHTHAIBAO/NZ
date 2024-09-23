@extends('backend.layouts.main')

@section('content')

    <style>
        .chart_expert {
             border-radius: 20px;
            padding: 20px;
        }
    </style>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">Thống kê KPI chuyên gia</h3>
        </div>
        <div class="col-md-7 align-self-center">
{{--            {{ Breadcrumbs::render('backend.expert.detail') }}--}}
        </div>
    </div>
    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body row">
                    <div class="col-12 col-lg-3 ">
                        <p class="text-center font-weight-bold">Hoàn thành</p>
                        <div class="chart_expert text-center bg-secondary">
                            <span class="font_weight_bold text-white ">{{$accept ?? ''}}</span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <p class="text-center font-weight-bold">Từ chối</p>
                        <div class="chart_expert text-center bg-secondary">
                            <span class="font_weight_bold text-white ">{{$nonAccept ?? ''}}</span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <p class="text-center font-weight-bold">Thương lượng lại</p>
                        <div class="chart_expert text-center bg-secondary">
                            <span class="font_weight_bold text-white ">{{$deal ?? ''}}</span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 ">
                        <p class="text-center font-weight-bold">Tổng</p>
                        <div class="chart_expert text-center bg-secondary">
                            <span class="font_weight_bold text-white ">{{$total ?? ''}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
