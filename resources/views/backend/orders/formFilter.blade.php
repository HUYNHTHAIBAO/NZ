<form action="" method="get" id="form-filter">
    <div class="form-body">
        <div class="row p-t-20">

            <div class="col-md-1">
                <div class="form-group form-group-sm">
                    <input type="text"
                           name="order_code"
                           value="{{request('order_code')}}"
                           id="order_code"
                           class="form-control form-control-sm" placeholder="Mã DH">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group form-group-sm">
                    <input type="text"
                           name="fullname"
                           value="{{request('fullname')}}"
                           id="fullname"
                           class="form-control form-control-sm" placeholder="Họ tên">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group form-group-sm">
                    <input type="email"
                           name="email"
                           value="{{request('email')}}"
                           id="email"
                           class="form-control form-control-sm" placeholder="Email">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group form-group-sm">
                    <input type="text"
                           name="phone"
                           value="{{request('phone')}}"
                           id="phone"
                           class="form-control form-control-sm" placeholder="Điện thoại">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control form-control-sm"
                            name="status">
                        <option value="">Trạng thái</option>
                        @foreach($status as $k=>$v)
                            <option value="{{$k}}"
                                {!! request('status')===$k?'selected="selected"':'' !!}>{{$v}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group form-group-sm">
                    <select class="form-control form-control-sm"
                            name="limit">
                        @foreach($_limits as $st)
                            <option value="{{$st}}"
                                {!! $filter['limit']==$st?'selected="selected"':'' !!}>{{number_format($st)}} record
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{--    Lọc từ ngày đến ngày        --}}
            <div class="col-md-2">
                <div class="form-group form-group-sm">
                    <!--                    <label class="control-label" for="working_date_to">Từ ngày</label>-->
                    <input type="text"
                           name="working_date_from"
                           value="{{--$filter['working_date_from']--}}"
                           id="working_date_from" readonly
                           class="form-control form-control-sm date_time_select" placeholder="Từ ngày">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group form-group-sm">
                    <!--                    <label class="control-label" for="working_date_to">Đến ngày</label>-->
                    <input type="text"
                           name="working_date_to"
                           value="{{--$filter['working_date_to']--}}"
                           id="working_date_to" readonly
                           class="form-control form-control-sm date_time_select" placeholder="Đến ngày">
                </div>
            </div>

            <div class="col-md-1">
                <button type="submit" class="btn waves-effect waves-light btn-block btn-info btn-sm">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Tìm
                </button>


            </div>
        </div>
        <div class="row">
            <div class="btn-group ml-2" role="group" style="display: inherit">
                <button type="button" class="btn btn-info btn-sm btn-ExPortExcel">
                    Xuất Excel
                </button>
            </div>
            <div class="btn-group ml-2" role="group" style="display: inherit">
                <button type="button" class="btn btn-warning btn-sm btn-ExPortWhereHouse">
                    Phiêu xuất kho
                </button>
            </div>
        </div>

    </div>
</form>
{{--<div class="col-md-3">--}}
{{--    <a href="{{ route('backend.orders.print', 188) }}">--}}
{{--        <button type="submit" class="btn waves-effect waves-light btn-block btn-info btn-sm">--}}
{{--            <i class="fa fa-plus"></i>&nbsp;&nbsp;Print--}}
{{--        </button>--}}
{{--    </a>--}}
{{--</div>--}}
