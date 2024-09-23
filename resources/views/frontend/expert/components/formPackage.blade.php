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
        display: flex;
        align-items: center;
        justify-content: center;
        height : 100vh;
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
        <div class="row rounded">
            <div class="col-12 col-lg-4 form_expert_left p-4">
                <div class="">
                    @if(!empty($data->userExpert->avatar_file_path))
                        <img
                            src="{{asset('storage/uploads') . '/' . $data->userExpert->avatar_file_path ?? ''}}"
                            style="padding: 0px; display: block; width: 50px; height: 50px; object-fit: contain; border-radius: 50%;border: 1px solid #ccc; cursor: pointer"
                            alt="img">
                    @else
                        <div class="bg-black"
                             style=" cursor: pointer; width: 50px; height: 50px; border-radius: 50%; border: 1px solid #eee; display: flex; align-items: center; justify-content: center;">
                            <span class="text-white font_weight_bold"
                                  style="">{{ $data->userExpert->avatar_name ?? '' }}</span>
                        </div>
                    @endif
                    <p>{{ $data->userExpert->fullname ?? '' }}</p>
                </div>
                <div class="">
                    <p style="font-size: 20px;font-weight: bold"><i class="fa-regular fa-clock"></i>
                        <span>{{$data->duration_id ?? ''}}</span></p>

                </div>
            </div>
            <div class="col-12 col-lg-8 bg-white p-4">
                <div class="d-flex align-items-center">
                    <div class="">
                        <a href="javascript:void(0);" onclick="history.back();">
                            <p><i class="fa-solid fa-chevron-left"></i> Quay lại</p>
                        </a>
                    </div>

                </div>
                <div class="">
                    <p>Chọn Ngày & Giờ</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-control-wrapper">
                            <input type="text" id="min-date" class="form-control floating-label input_user"
                                   placeholder="Chọn ngày">
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="form-control-wrapper">
                            <input type="time" id="min-time" class="form-control floating-label input_user"
                                   placeholder="Nhập giờ">
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
                <hr>
                <div class="text-end">
                    <button type="submit" class="btn btn-outline-secondary btn-order-group">Tiếp tục</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script>
    document.getElementById('image_file_id_form').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById('img_preview');
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            const img = document.getElementById('img_preview');
            img.src = '#';
            img.style.display = 'none';
        }
    });
</script>
</body>
</html>



