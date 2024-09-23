@extends('frontend.layouts.frontend')

@section('content')

    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard__content-wrap">
                        <h4>THÔNG TIN GÓI NHÓM</h4>

                        <div class="row">
                            <div class="col-4">
                                <ul>
                                    <li>Mã đơn: #{{$data->id}}</li>
                                    <li>Họ tên KH: {{ $data->user->fullname ?? '' }}</li>
                                    <li>Email KH: {{ $data->user->email ?? '' }}</li>
                                    <li>Ghi chú: {{ $data->note ?? 'Không có ghi chú.' }}</li>

                                    @if(!empty($data->time))
                                        <li>Giờ gọi: {{ $data->time ?? '.' }}</li>
                                    @endif
                                    @if(!empty($data->date))
                                        <li>Ngày gọi: {{ $data->date ?? '.' }}</li>
                                    @endif
                                    @if(!empty($data->duration_id))
                                        <li>Thời lượng gọi: {{ $data->duration_id ?? '.' }}</li>
                                    @endif
                                    <li>Danh sách người tham gia: {{ $data->list_email ?? '' }} </li>

                                    <li>Số tiền: {{ number_format($data->price) ?? '0' }} VNĐ</li>

                                </ul>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-2">
                                <button class="btn btn-danger" id="btnCancel" data-id="{{ $data->id }}">Từ chối</button>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-info" id="btnconfirm" data-id="{{ $data->id }}"> Đồng ý
                                </button>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- Cancel modal-->
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lý do từ chối</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('frontend.user.reject', $data->id) }} " method="POST">
                    @csrf
                    <div class="modal-body">
                          <textarea id="reject"  class="form-control" name="note_reject" required
                          >{{ old('note_reject', $data->note_reject) }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Thương lươ thời gian modal-->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Để lại lời nhắn</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('frontend.user.approve', $data->id) }} " method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-grp">
                                    <label for="approve">Để lại lời nhắn</label>
                                    <textarea id="approve" class="form-control" name="note"></textarea>
                                </div>


                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('style')

@endsection
@section('script')
    <script>

        $('#btnCancel').click(function () {
            $('#cancelModal').modal('toggle');


        });

        $('#btnconfirm').click(function () {

            $('#confirmModal').modal('toggle');


        });

        $(function() {
            // Khởi tạo Datepicker
            $("#min-date").datepicker({
                dateFormat: "yy-mm-dd", // Định dạng ngày
                onSelect: function(dateText, inst) {
                    // Khi ngày được chọn, thêm thời gian hiện tại (hoặc tùy chỉnh)
                    var time = $("#min-time").val();
                    if (time) {
                        $(this).val(dateText + ' ' + time);
                    } else {
                        $(this).val(dateText);
                    }
                }
            });


        });
    </script>

@endsection
