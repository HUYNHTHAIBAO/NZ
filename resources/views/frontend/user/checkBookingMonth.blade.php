@extends('frontend.layouts.frontend')

@section('content')

    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard__content-wrap">
                        <h4>THÔNG TIN GÓI THÁNG</h4>

                        <div class="row">
                            <div class="col-4">
                                <ul>
                                    <li>Mã đơn: #{{$data->id}}</li>
                                    <li>Họ tên KH: {{ $data->user->fullname ?? '' }}</li>
                                    <li>Email KH: {{ $data->user->email ?? '' }}</li>
                                    <li>Ghi chú: {{ $data->note ?? 'Không có ghi chú.' }}</li>
                                    <li>Số tiền: {{ number_format($data->price) ?? '0' }} VNĐ</li>
                                </ul>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-2">
                                <button class="btn btn-danger" id="btnCancel" data-id="{{ $data->id }}">Từ chối</button>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-info" id="btnnegotiatetime" data-id="{{ $data->id }}">Thương lượng ngày
                                    giờ
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
    <div class="modal fade" id="negotiatetimeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thuoương lượng thời gian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('frontend.user.month.negotiatetime', $data->id) }} " method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-control-wrapper">
                                    <input type="text" id="min-date" class="form-control floating-label input_user" name="date" required placeholder="Ngày gọi">
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="form-control-wrapper">
                                    <input type="time" id="min-time" class="form-control floating-label input_user" name="time" required placeholder="Giờ gọi">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-control-wrapper">
                                    <input type="number" id="min-time" class="form-control floating-label input_user" name="duration_id" required placeholder="Thời lượng cuộc gọi">
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

        $('#btnnegotiatetime').click(function () {
            $('#negotiatetimeModal').modal('toggle');


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
