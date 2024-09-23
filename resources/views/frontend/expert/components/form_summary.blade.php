<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<style>
    body {
        background-color: rgba(241, 246, 246, 0.76);
    }

    .form_expert {
        border-radius: 20px;
    }

    .form_expert_left {
        background-color: rgba(228, 236, 236, 0.91);
    }
</style>
<body>


<div class="container p-5">
    <div class="form_expert p-5 ">
        <div class="row rounded justify-content-center">
            <div class="col-12 col-lg-8 bg-white p-4">
                <div class="d-flex align-items-center">
                    <div class="">
                        <a href="javascript:void(0);" onclick="history.back();">
                            <p><i class="fa-solid fa-chevron-left"></i> Quay lại</p>
                        </a>
                    </div>
                </div>
                <div class="bg-light row align-items-center p-2">
                    <img class="col-12 col-lg-4" src="https://cdn-icons-png.flaticon.com/128/17484/17484460.png" alt="" style="width: 200px; height: 100px; object-fit: contain">
                    <p class="col-12 col-lg-8 m-0" style="font-weight: bold">Email sẽ được gửi về cho bạn khi bạn đã hoàn thành đặt lịch</p>
                </div>

                    <div class="row justify-content-center bg-white mt-4">
                        <div class="col-2">
                            <p style="font-weight: bold">Tổng tiền :</p>
                        </div>
                        <div class="col-4">
                            <p class="text-end"><i>{{format_number_vnd($data->price ?? '')}}</i> vnđ</p>
                        </div>
                    </div>
{{--                <div class="text-center">--}}
{{--                    <button type="submit" class="btn btn-secondary">Thanh toán</button>--}}
{{--                </div>--}}
                <form method="POST" action="{{ route('frontend.processPayment', ['id' => $data->id]) }}">
                    @csrf
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-outline-secondary">Thanh toán</button>
                                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">

</script>

</body>
</html>



