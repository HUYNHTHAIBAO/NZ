@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.notification.index') }}
        </div>

        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">

                    @if(auth()->guard('backend')->user()->can('notification.add'))
                        <div class="row">
                            <div class="col-md-2 pull-right">
                                <a href="{{Route('backend.notification.add')}}"
                                   class="btn waves-effect waves-light btn-block btn-info">
                                    <i class="fa fa-plus"></i>&nbsp;Push thông báo
                                </a>
                            </div>
                        </div>
                    @endif

                    <br>

                    <div class="table-responsive">
                        <table class="table color-table muted-table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tiêu đề</th>
                                    <th>Kênh</th>
                                    <th>Người nhận</th>
                                    <th>Ngày gửi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notifications as $notification)
                                    <tr>
                                        <td>{{++$start}}</td>
                                        <td>{{$notification->title}}</td>
                                        <td>{{$chanels[$notification->chanel]}}</td>
                                        <td>{{!empty($notification->to_user)?$notification->to_user->fullname:'Toàn hệ thống'}}</td>
                                        <td>{{$notification->created_at}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Chưa có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection