@extends('backend.layouts.main')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.calendarExpert.time') }}
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
                                            <th>Ngày</th>
                                            <th>Giờ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($settingTime as $key => $item)
                                            <tr>
                                                <td>{{$key+=1}}</td>
                                                <td><span class="font-weight-bold">{{format_date_custom($item->date ?? '')}}</span></td>
                                                <td>{{$item->time ?? ''}}</td>
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
