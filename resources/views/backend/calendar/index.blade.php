@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.calendarExpert.duration') }}
        </div>
    </div>

    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="p-2">
                                    <span class="font-weight-bold">Tên Chuyên gia </span>:
                                    <span class="btn btn-info text-white">{{$user->fullname ?? ''}}</span>
                                </div>
                                <div class="col-12">
                                    <table id="table_id" class="table color-table muted-table table-striped">
                                        <thead class="bg-secondary">
                                        <tr>
                                            <th>#</th>
                                            <th>Thời gian</th>
                                            <th>Giá</th>
                                            <th>Giảm giá</th>
                                            <th>Ngày tạo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($settingTime as $key => $item)
                                            <tr>
                                                <td>{{$key+=1}}</td>
                                                @if($item->duration_type == 2)
                                                    <td>
                                                        <span
                                                            class="font_weight_bold bg-success p-2 text-white">{{$item->duration_name ?? ''}} </span>
                                                            <span class="ml-2"><i class="mdi mdi-check-circle"></i></span>
                                                    </td>
                                                @else
                                                    <td>
                                                        <span
                                                            class="font_weight_bold ">{{$item->duration_name ?? ''}}</span>
                                                    </td>
                                                @endif
                                                <td><mark>{{ number_format($item->price ?? 0, 0, '', ',') }} <sup>vnđ</sup></mark> </td>
                                                <td><mark> 0 <sup>vnđ</sup></mark> </td>
                                                <td>{{format_date_custom($item->created_at)}}</td>
                                            </tr>
                                        @empty

                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
