<section class="categories-area-three fix px-4 categories__bg"
             style="margin-top: 100px">
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-7">
                    <div class="section__title text-center mb-40">
                        <h2 class="categories_title"> Quy trình chốt <span class="title_rgba">BOOKING</span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center align-items-stretch">
                @foreach($booking as $key => $item)
                    <div class="col-12 col-lg-4 col-xl-3 col-sm-6 d-flex mb-4" style="height: auto">
                        <div class="p-3 flex-grow-1 d-flex flex-column" style="background-color: #f4f4f4; border-radius: 10px; border: 1px solid #ccc">
                            <a href="#" class="d-flex flex-column flex-grow-1 text-decoration-none">
                                <div class="text-center">
                                    <img src="{{$item->file_src ?? ''}}" alt="" style="width: 100px; height: 100px; object-fit: cover">
                                </div>
                                <div class="px-5 pt-2 d-flex flex-column justify-content-between">
                                    <p class="text-black text-center" style="font-size: 18px; font-weight: 600">{{$item->title ?? ''}}</p>
                                    <p class="text-black text-center" style="font-size: 15px; font-weight: 400">{{$item->desc ?? ''}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
</section>
