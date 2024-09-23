<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chia sẻ cuộc họp với bạn bè của bạn</h5>

            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-control-wrapper">
                            <input type="text" id="min-date" class="form-control floating-label input_user" placeholder="Chọn ngày">
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="form-control-wrapper">
                            <input type="time" id="min-time" class="form-control floating-label input_user" placeholder="Nhập giờ">
                        </div>
                    </div>
                </div>

                <input class="from-control input_user searchEmail" onkeyup="searchEmail()" type="text"
                       placeholder="Nhập Email bạn bè">
                <div class="list-email-group">
                    <ul class="list-email">

                    </ul>

                </div>
                <div class="content-email">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="categories_button " data-dismiss="modal"><span class="categories_link">Đóng</span></button>
                <button type="button" class="categories_button btn-order-group  "><span class="categories_link">Tiếp tục</span></button>
            </div>
        </div>
    </div>
</div>
