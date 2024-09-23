<style>
    /*.newsletter__area {*/
    /*    background-color: #212121 !important; !* Màu đen với độ mờ 70% *!*/
    /*    !*position: relative; !* Để định vị các phần tử con *!*!*/
    /*}*/

    .newsletter__area::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('https://images.unsplash.com/photo-1714593468171-729465a0060d?q=80&w=2072&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
        background-size: cover;
        background-repeat: no-repeat;
        /*background-position: center;*/
        z-index: -2; /* Đảm bảo hình ảnh ở dưới các phần tử khác */
        opacity: 1; /* Hiển thị hình ảnh không bị mờ */
    }

    .newsletter__area::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5); /* Màu đen bán trong suốt phủ lên trên hình ảnh */
        z-index: -1; /* Đặt lớp phủ ở trên hình ảnh */
    }


</style>


<section class="newsletter__area p-5 bg-light" style="margin-top: 100px">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="newsletter__content" style="padding: 50px 0px">
                    <p class="title text-center text-black font_weight_bold text-white" style="font-size: 30px;"><span class="title_rgba">ĐĂNG KÝ</span>để nhận thông tin mới nhất từ <span class="title_rgba">NEZTWORK</span></p>
                    <div class="newsletter__form d-flex justify-content-center">
                        <form id="subscribe-form" action="#" class="col-12 col-md-6" method="POST">
                            @csrf
                            <input id="email-input" class="col-12 bg-white text-black" type="email" name="email" placeholder="Nhập Email của bạn ..." style="border-radius: 10px;border: none">
                            <button type="submit" name="subscribe" class="btn col-4 text-white categories_button" style="background-color: #363636">ĐĂNG KÝ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
