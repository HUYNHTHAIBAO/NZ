@extends('frontend.layouts.frontend')
@section('content')
    <style>
        .dashboard__nav-wrap .nav-tabs {
            border: none;
            gap: 0px;
        }
    </style>
    <div class="container">
        <div class="row mt-5 align-items-center justify-content-center p-4"
             style="background: linear-gradient(to left bottom, #f6f6f6, #fff)">
            <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                <h1 style="">Neztwork Đội Nhóm</h1>
                <p style="font-size: 20px">
                    <span class="" style="font-weight: bold">Bạn đã sẵn sàng chưa?</span> Giờ đây, bạn có thể mời bạn bè hoặc đồng đội tham gia buổi tư vấn video cùng bạn! Tính năng mới này không chỉ giúp bạn tiết kiệm chi phí mà còn tạo ra một không gian vui vẻ, thân thiện và cởi mở. Hãy cùng nhau chia sẻ kiến thức, tăng cường sự tự tin và biến buổi tư vấn thành một trải nghiệm thú vị và hiệu quả.
                </p>
                <p class="">
                    <a href="{{'frontend.user.register'}}"
                       class="btn arrow-btn btn-four categories_button">Mời ngay bạn bè của bạn để cùng nhau phát triển và tiến bộ với Neztwork nhé!
                    </a>
                </p>
            </div>
            <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                <img src="https://static-cse.canva.com/blob/1643905/Teamsbanner16.9compressedx2.b5194387.avif" alt=""
                     style="width: 100%; height: 400px ; object-fit: contain;border-radius: 20px">
            </div>

        </div>
    </div>

{{--    <div class="container">--}}
{{--        <div class="brand-area-three mt-4">--}}
{{--            <div class="container">--}}
{{--                <div class="row justify-content-between">--}}
{{--                    <div class="col-4 row">--}}
{{--                        <div class="col-12 d-flex justify-content-start align-items-center">--}}
{{--                            <span class="text-black">6+ million teams are using Canva</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-8 row justify-content-between">--}}
{{--                        <div class="col-lg-2 col-md-4 text-center text-lg-start">--}}
{{--                            <img src="https://static-cse.canva.com/_next/static/media/hoorae.file.7b4182f7.png" alt=""--}}
{{--                                 style="width: 100px; height: 100px; object-fit: contain">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-2 col-md-4 text-center text-lg-start">--}}
{{--                            <img src="https://static-cse.canva.com/_next/static/media/usa-today.file.c4b44321.png"--}}
{{--                                 alt=""--}}
{{--                                 style="width: 100px; height: 100px; object-fit: contain">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-2 col-md-4 text-center text-lg-start">--}}
{{--                            <img src="https://static-cse.canva.com/_next/static/media/fast-company.file.c39dd7f1.svg"--}}
{{--                                 alt=""--}}
{{--                                 style="width: 100px; height: 100px; object-fit: contain">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-2 col-md-4 text-center text-lg-start">--}}
{{--                            <img src="https://static-cse.canva.com/_next/static/media/orangetheory.file.1e2162d2.png"--}}
{{--                                 alt=""--}}
{{--                                 style="width: 100px; height: 100px; object-fit: contain">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-2 col-md-4 text-center text-lg-start">--}}
{{--                            <img src="https://static-cse.canva.com/_next/static/media/peppy.file.273ee55c.png" alt=""--}}
{{--                                 style="width: 100px; height: 100px; object-fit: contain">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="container">
        <section class="categories-area-three fix categories__bg" style="margin-top: 100px">
            <div class="container">
                <div class="">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-8">
                            <div class="section__title text-center">
                                <p class="bold text-black" style="font-size: 30px">Trải nghiệm ngay tính năng mời tư vấn cho Đội nhóm </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="dashboard__nav-wrap">
                                <ul class="nav nav-tabs d-flex align-items-center justify-content-center" id="myTab"
                                    role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="itemOne-tab" data-bs-toggle="tab"
                                                data-bs-target="#itemOne-tab-pane" type="button" role="tab"
                                                aria-controls="itemOne-tab-pane" aria-selected="false" tabindex="-1">
                                            Cá Nhân Hóa Tư Vấn Cùng Chuyên Gia Hàng Đầu
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " id="itemTwo-tab" data-bs-toggle="tab"
                                                data-bs-target="#itemTwo-tab-pane" type="button" role="tab"
                                                aria-controls="itemTwo-tab-pane" aria-selected="true">Tối Ưu Hóa Năng Suất và Giá Trị Tư Vấn
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="itemThree-tab" data-bs-toggle="tab"
                                                data-bs-target="#itemThree-tab-pane" type="button" role="tab"
                                                aria-controls="itemThree-tab-pane" aria-selected="false" tabindex="-1">
                                            Tối ưu hóa chi phí - Chia sẻ niềm vui
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="itemFour-tab" data-bs-toggle="tab"
                                                data-bs-target="#itemFour-tab-pane" type="button" role="tab"
                                                aria-controls="itemFour-tab-pane" aria-selected="false" tabindex="-1">
                                            Đa dạng hóa trải nghiệm tư vấn
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content mt-5" id="myTabContent">
                                <div class="tab-pane fade active show" id="itemOne-tab-pane" role="tabpanel"
                                     aria-labelledby="itemOne-tab" tabindex="0">
                                    <div class="row d-flex align-items-center justify-content-center">
                                        <div class="col-lg-6 col-12">
                                            <img
                                                src="https://static-cse.canva.com/blob/1643890/Benefitstransformteamworkcompresssedx2.065c1083.avif"
                                                alt="" style="border-radius: 20px">
                                        </div>
                                        <div class="col-lg-6 col-12 p-md-0 p-lg-5">
{{--                                            <p class="font-weight-bold text-black" style="font-size: 30px">•	Mời Thêm Thành Viên:--}}
{{--                                            </p>--}}
                                            <div class="mt-4 mt-md-0">
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <span class="me-2">-</span> <b class="text-black">
                                                        Mời Thêm Thành Viên: </b> <span>Mời bạn bè, đồng nghiệp, hoặc người thân tham gia buổi tư vấn trực tiếp với chuyên gia. Đây là cơ hội để cả nhóm cùng khám phá và học hỏi.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <span class="me-2">-</span> <b class="text-black">
                                                        Học Hỏi và Phát Triển: </b> <span>Neztwork giúp bạn không chỉ nhận lời khuyên mà còn chia sẻ kiến thức và cùng phát triển.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <span class="me-2">-</span> <b class="text-black">
                                                        Tư Vấn Theo Nhu Cầu: </b> <span>Mỗi thành viên trong nhóm sẽ nhận sự tư vấn phù hợp với nhu cầu và mục tiêu riêng.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <span class="me-2">-</span> <b class="text-black">
                                                        Trải Nghiệm Linh Hoạt: </b>
                                                    <span>Bạn có thể dễ dàng sắp xếp thời gian và cách thức tham gia sao cho phù hợp với lịch trình của cả nhóm.</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="itemTwo-tab-pane" role="tabpanel"
                                     aria-labelledby="itemTwo-tab" tabindex="0">
                                    <div class="row d-flex align-items-center justify-content-center">
                                        <div class="col-lg-6 col-12">
                                            <img
                                                src="https://static-cse.canva.com/blob/1643900/Benefitssimplifyworkflowscompresssedx2.81fca9e6.avif"
                                                alt="" style="border-radius: 20px">
                                        </div>
                                        <div class="col-lg-6 col-12 p-md-0 p-lg-5">
{{--                                            <p class="font-weight-bold text-black" style="font-size: 30px">Simplify--}}
{{--                                                workflows--}}
{{--                                            </p>--}}
                                            <div class="mt-4 mt-md-0">
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black">
                                                        Tăng Tốc Quyết Định</b> <span>Khi có bạn bè và đồng nghiệp tham gia, bạn sẽ nhận được nhiều góc nhìn khác nhau, giúp đưa ra quyết định nhanh và chính xác hơn.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black">
                                                        Cộng Tác Linh Hoạt: </b> <span>Mời tối đa 5 người cùng tham gia buổi tư vấn. Mỗi người đều có thể đóng góp ý kiến và nhận tư vấn riêng.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black">Giao Tiếp Hiệu Quả :</b> <span>Các cuộc trò chuyện diễn ra trong môi trường an toàn và bảo mật, giúp bạn thoải mái chia sẻ ý tưởng.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black"> Nâng Cao Hiệu Quả Công Việc: </b>
                                                    <span>Sự hỗ trợ từ nhóm giúp bạn làm việc hiệu quả hơn và đạt kết quả nhanh hơn.</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="itemThree-tab-pane" role="tabpanel"
                                     aria-labelledby="itemThree-tab" tabindex="0">
                                    <div class="row d-flex align-items-center justify-content-center">
                                        <div class="col-lg-6 col-12">
                                            <img
                                                src="https://static-cse.canva.com/blob/1643903/Benefitscreatecontentfastcompresssedx2.1ab16796.avif"
                                                alt="" style="border-radius: 20px">
                                        </div>
                                        <div class="col-lg-6 col-12 p-md-0 p-lg-5">
{{--                                            <p class="font-weight-bold text-black" style="font-size: 30px">Tối ưu hóa chi phí - Chia sẻ niềm vui--}}
{{--                                            </p>--}}
                                            <div class="mt-4 mt-md-0">
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black">
                                                        Tiết kiệm chi phí: </b> <span>Với Neztwork Teams, bạn có thể mời tối đa 5 người tham gia buổi tư vấn của mình mà không phải lo lắng về chi phí. Cùng nhau, bạn và nhóm của mình sẽ chia sẻ chi phí một cách hợp lý, tối ưu hóa nguồn lực.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black"> Không gian thân thiện và cởi mở: </b>
                                                    <span>Mời bạn bè, đồng đội tham gia không chỉ giúp buổi tư vấn trở nên thú vị hơn mà còn tạo ra một môi trường thân thiện, nơi mọi người có thể thoải mái chia sẻ suy nghĩ, ý tưởng.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black">Khuyến khích sự tự tin: </b>
                                                    <span>Khi có bạn bè và đồng đội đồng hành, bạn sẽ cảm thấy tự tin hơn trong việc đối mặt với những thử thách và quyết định quan trọng. Neztwork Teams mang đến cơ hội để bạn phát huy hết tiềm năng của mình, với sự hỗ trợ từ những người mà bạn tin tưởng.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black"> Chia sẻ niềm vui và thành công: </b>
                                                    <span>Cùng nhau trải nghiệm, học hỏi và đạt được những thành công trong các buổi tư vấn, tạo nên một kỷ niệm đáng nhớ cùng nhóm của bạn.</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="itemFour-tab-pane" role="tabpanel"
                                     aria-labelledby="itemFour-tab" tabindex="0">
                                    <div class="row d-flex align-items-center justify-content-center">
                                        <div class="col-lg-6 col-12">
                                            <img
                                                src="https://static-cse.canva.com/blob/1643909/Benefitspoweryourbrandcompresssedx2.72e25590.avif"
                                                alt="" style="border-radius: 20px">
                                        </div>
                                        <div class="col-lg-6 col-12 p-md-0 p-lg-5">
{{--                                            <p class="font-weight-bold text-black" style="font-size: 30px">Tạo không gian sáng tạo--}}
{{--                                            </p>--}}
                                            <div class="mt-4 mt-md-0">
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black">
                                                        Tạo không gian sáng tạo</b> <span>Mỗi buổi tư vấn với Neztwork Teams là cơ hội để bạn và nhóm sáng tạo ra những ý tưởng mới mẻ và đột phá.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black"> Tư vấn xuyên lĩnh vực: </b>
                                                    <span>Neztwork cho phép bạn kết nối với các chuyên gia trong nhiều lĩnh vực khác nhau, từ đó mở rộng phạm vi tư vấn và ứng dụng kiến thức vào nhiều khía cạnh khác nhau của cuộc sống.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black">
                                                        Phát triển kỹ năng mềm: </b> <span>Tham gia tư vấn nhóm giúp bạn cải thiện kỹ năng giao tiếp, làm việc nhóm, và thuyết trình trước đám đông.</span>
                                                </p>
                                                <p class="text-secondary" style="font-size: 18px">
                                                    <i class="fa-solid fa-check me-2"></i> <b class="text-black"> Xây dựng mối quan hệ bền vững: </b>
                                                    <span>Qua các buổi tư vấn nhóm, bạn không chỉ học hỏi mà còn xây dựng mối quan hệ gắn bó, tin cậy với đồng đội và chuyên gia.</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="container">
        <section style="margin-top: 100px">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="section__title text-center">
                        <p class="bold text-black" style="font-size: 30px">Tính năng dành cho cả đội</p>
                        <p class="bold text-black" style="font-size: 20px">Những tính năng giúp các đội vừa và nhỏ thỏa yêu cầu thương hiệu, tiết kiệm thời gian và sắp xếp ngăn nắp:</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row mt-4">
                    <div class="col-12 col-lg-6" style="border-radius: 10px; overflow: hidden;">
                        <div style="border-radius: 10px 10px 0px 0px; overflow: hidden;">
                            <img src="https://static-cse.canva.com/blob/1643899/Featureteammanagementcompresssedx2.jpg"
                                 alt="Small and medium teams image"
                                 style="width: 100%;border-radius: 10px 10px 0px 0px;">
                        </div>
                        <div class="p-4" style="background-color: #e1effe;border-radius: 0px 0px 10px 10px">
                            <p class="text-black" style="font-size: 20px; font-family: 'Kanit', sans-serif;">Quản lý nhóm:
                            </p>
                            <p style="font-family: 'Kanit', sans-serif;">Dễ dàng quản lý và phân quyền cho từng thành viên trong nhóm, đảm bảo mọi người đều có vai trò cụ thể và rõ ràng.</p>
{{--                            <div class="text-center text-lg-start mt-3">--}}
{{--                                <a href="#" class="btn arrow-btn btn-four categories_button">Learn more--}}
{{--                                </a>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mt-4 mt-lg-0" style="border-radius: 10px; overflow: hidden;">
                        <div style="border-radius: 10px 10px 0px 0px; overflow: hidden;">
                            <img src="https://static-cse.canva.com/blob/1643908/Featurebrandkitscompresssedx2.jpg"
                                 alt="Small and medium teams image"
                                 style="width: 100%;border-radius: 10px 10px 0px 0px;">
                        </div>
                        <div class="p-4" style="background-color: #e1effe;border-radius: 0px 0px 10px 10px">
                            <p class="text-black" style="font-size: 20px; font-family: 'Kanit', sans-serif;">Bộ công cụ cộng tác: </p>
                            <p style="font-family: 'Kanit', sans-serif;">Các công cụ hỗ trợ cộng tác trực tuyến như bảng trắng, ghi chú chung, và chia sẻ tài liệu giúp tối ưu hóa hiệu quả làm việc nhóm.</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 ">
                    <div class="col-12 col-lg-4">
                        <div style="border-radius: 10px 10px 0px 0px; overflow: hidden;">
                            <img src="https://static-cse.canva.com/blob/1643892/Featurebrandtemplatescompresssedx2.jpg"
                                 alt="Small and medium teams image"
                                 style="width: 100%; border-radius: 10px 10px 0px 0px;">
                        </div>
                        <div class="p-4" style="background-color: #e1effe;border-radius: 0px 0px 10px 10px">
                            <p class="text-black" style="font-size: 20px; font-family: 'Kanit', sans-serif;">Lịch trình tư vấn: </p>
                            <p style="font-family: 'Kanit', sans-serif;">Tích hợp tính năng lập lịch và quản lý thời gian giúp cả nhóm dễ dàng tổ chức và tham gia các buổi tư vấn một cách hiệu quả.</p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 mt-4 mt-lg-0">
                        <div style="border-radius: 10px 10px 0px 0px; overflow: hidden;">
                            <img
                                src="https://static-cse.canva.com/blob/1643896/Featureappsandintegrationscompresssedx2.jpg"
                                alt="Small and medium teams image"
                                style="width: 100%; border-radius: 10px 10px 0px 0px;">
                        </div>
                        <div class="p-4" style="background-color: #e1effe;border-radius: 0px 0px 10px 10px">
                            <p class="text-black" style="font-size: 20px; font-family: 'Kanit', sans-serif;">Lưu trữ và truy cập tài liệu: </p>
                            <p style="font-family: 'Kanit', sans-serif;">Tính năng lưu trữ và chia sẻ tài liệu giúp tất cả thành viên dễ dàng truy cập các thông tin cần thiết trong quá trình tư vấn.</p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 mt-4 mt-lg-0">
                        <div style="border-radius: 10px 10px 0px 0px; overflow: hidden;">
                            <img src="https://static-cse.canva.com/blob/1643895/Featuremagicstudiocompresssedx2.jpg"
                                 alt="Small and medium teams image"
                                 style="width: 100%; border-radius: 10px 10px 0px 0px;">
                        </div>
                        <div class="p-4" style="background-color: #e1effe;border-radius: 0px 0px 10px 10px">
                            <p class="text-black" style="font-size: 20px; font-family: 'Kanit', sans-serif;">Báo cáo và đánh giá: </p>
                            <p style="font-family: 'Kanit', sans-serif;">Hệ thống báo cáo tự động cho phép nhóm theo dõi tiến trình và đánh giá kết quả sau mỗi buổi tư vấn.            </p>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </div>



    <div class="bg-light py-5" style="margin-top: 100px;">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="section__title text-center">
                        <p class="bold text-black" style="font-size: 30px">Dành cho tất cả các lĩnh vực </p>
                        <p>Neztwork Teams phù hợp với tất cả các lĩnh vực, đặc biệt mang lại lợi ích cao cho:</p>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <img src="https://static-cse.canva.com/blob/1643906/Departmentmarketingcompresssedx2.jpg" alt=""
                         style="border-radius: 10px">
                    <p class="text-black mt-4">Kinh doanh và Khởi nghiệp: </p>
                    <p>Giúp các doanh nhân và nhóm khởi nghiệp nhận được sự tư vấn chiến lược từ các chuyên gia để phát triển và mở rộng doanh nghiệp.</p>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mt-2 mt-md-0">
                    <img src="https://static-cse.canva.com/blob/1643904/Departmentcreativecompresssedx2.jpg" alt=""
                         style="border-radius: 10px">
                    <p class="text-black mt-4">Giáo dục và Đào tạo: </p>
                    <p>Các giáo viên và nhóm học viên có thể cùng nhau tham gia các buổi tư vấn để nâng cao kỹ năng giảng dạy và học tập.</p>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mt-2 mt-md-0">
                    <img src="https://static-cse.canva.com/blob/1643893/Departmentsalescompressedx2.jpg" alt=""
                         style="border-radius: 10px">
                    <p class="text-black mt-4">Y tế và Chăm sóc sức khỏe: </p>
                    <p>Các chuyên gia y tế và nhóm bệnh nhân có thể cùng tham gia tư vấn để cải thiện sức khỏe và đời sống tinh thần.</p>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mt-2 mt-md-0">
                    <img src="https://static-cse.canva.com/blob/1643894/Departmenthrcompresssedx2.jpg" alt=""
                         style="border-radius: 10px">
                    <p class="text-black mt-4">Công nghệ và Sáng tạo: </p>
                    <p>Nhóm sáng tạo và phát triển công nghệ có thể sử dụng Neztwork Teams để tư vấn và triển khai các dự án mới một cách hiệu quả.</p>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <section class="features__area-five features__bg" style="margin: 100px 0px">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-8">
                        <div class="section__title text-center">
                            <p class="bold text-black" style="font-size: 30px">Quyền lợi dành cho khách hàng NeztWork Đội nhóm</p>
                        </div>
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col-12 col-lg-3 text-center">
                        <p class="m-0 text-black font-weight-bold" style="font-size: 30px">80%</p>
                        <span>Thời gian tư vấn nhanh hơn: Nhờ tính năng cộng tác nhóm và các công cụ hỗ trợ hiệu quả, thời gian hoàn thành buổi tư vấn được rút ngắn đến 80% so với cách truyền thống.</span>
                    </div>
                    <div class="col-12 col-lg-3 text-center">
                        <p class="m-0 text-black font-weight-bold" style="font-size: 30px">60%</p>
                        <span>Tăng cường sự tự tin: Khi có bạn bè và đồng đội tham gia, người dùng cảm thấy tự tin hơn trong việc thảo luận và ra quyết định, giúp tăng cường khả năng lãnh đạo và thuyết phục.</span>
                    </div>
                    <div class="col-12 col-lg-3 text-center">
                        <p class="m-0 text-black font-weight-bold" style="font-size: 30px">70%</p>
                        <span>Cải thiện chất lượng tư vấn: Sự đa dạng trong góc nhìn và sự hỗ trợ từ nhóm giúp các buổi tư vấn đạt được kết quả chất lượng hơn, với các giải pháp toàn diện và thực tiễn.</span>
                    </div>
                    <div class="col-12 col-lg-3 text-center">
                        <p class="m-0 text-black font-weight-bold" style="font-size: 30px">50%</p>
                        <span>Tiết kiệm chi phí tư vấn: Khi mời thêm bạn bè và đồng đội tham gia, chi phí cho mỗi người giảm đáng kể, giúp tối ưu hóa ngân sách trong khi vẫn nhận được sự tư vấn chất lượng cao.</span>
                    </div>
                </div>
                <div class="row justify-content-center aboutNew_slider_feedback">
                    <div class="col-12 d-flex align-items-center flex-wrap">
                        <div class="col-lg-6 col-12 ">
                            <img class="margin-top"
                                 src="https://static-cse.canva.com/blob/1643901/Testimonialblackbirdcompresssedx2.jpg"
                                 alt="" style="width: 100%; max-height: 500px; object-fit: contain; padding: 20px;">
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="">
                                <p class="text-black" style="font-size: 20px;">
                                    <span class="text-black" style="font-weight: bold">Công ty X</span>: "Chúng tôi đã tăng gấp đôi hiệu suất làm việc khi sử dụng Neztwork Teams. Mỗi buổi tư vấn đều mang lại những giải pháp sáng tạo, giúp chúng tôi giải quyết vấn đề nhanh chóng và hiệu quả."
                                </p>
                                <div class="">
                                    <p class="m-0 font-italic "><span class="text-black" style="font-weight: bold">Nguyễn Văn B </span>, Giám đốc Điều hành, Công ty X </p>
                                    {{--                                <p>Global Creative Manager, Zoom</p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex align-items-center flex-wrap">
                        <div class="col-lg-6 col-12">
                            <img class="margin-top"
                                 src="https://static-cse.canva.com/blob/1643901/Testimonialblackbirdcompresssedx2.jpg"
                                 alt="" style="width: 100%; max-height: 500px; object-fit: contain;padding: 20px;">
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="">
                                <p class="text-black" style="font-size: 20px;">
                                    <span class="text-black" style="font-weight: bold">Nhóm Y</span>: "Việc có thể mời thêm đồng nghiệp tham gia tư vấn đã giúp chúng tôi đưa ra các quyết định nhanh hơn và chính xác hơn. Neztwork Teams thực sự là công cụ không thể thiếu của nhóm chúng tôi."
                                </p>
                                <div class="">
                                    <p class="m-0 font-italic "><span class="text-black" style="font-weight: bold">Trần Thị C</span>, Trưởng phòng Marketing, Nhóm Y.</p>
                                    {{--                                <p>Global Creative Manager, Zoom</p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex align-items-center flex-wrap">
                        <div class="col-lg-6 col-12">
                            <img class="margin-top"
                                 src="https://static-cse.canva.com/blob/1643902/Testimonialobviousbrandpartnerscompresssedx2.jpg"
                                 alt="" style="width: 100%; max-height: 500px; object-fit: contain;padding: 20px;">
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="">
                                <p class="text-black" style="font-size: 20px;">
                                    <span class="text-black" style="font-weight: bold">Tổ chức Z: </span>:
                                    "Neztwork Teams giúp chúng tôi duy trì liên lạc và cộng tác một cách hiệu quả ngay cả khi làm việc từ xa. Chúng tôi đã tạo ra nhiều dự án thành công nhờ vào tính năng tư vấn nhóm này."                                 </p>
                                <div class="">
                                    <p class="m-0 font-italic "><span class="text-black" style="font-weight: bold">Phạm Văn D</span>, Giám đốc Sáng tạo, Tổ chức Z.</p>
                                    {{--                                <p>Global Creative Manager, Zoom</p>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-flex align-items-center flex-wrap">
                        <div class="col-lg-6 col-12">
                            <img class="margin-top"
                                 src="https://static-cse.canva.com/blob/1643907/Testimonialpeppycompresssedx2.jpg"
                                 alt="" style="width: 100%; max-height: 500px; object-fit: contain;padding: 20px;">
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="">
                                <p class="text-black" style="font-size: 20px;">
                                    <span class="text-black" style="font-weight: bold">Công ty Q:  </span>:
                                    "Nhờ Neztwork Teams, chúng tôi đã giảm đáng kể chi phí tư vấn mà vẫn đảm bảo chất lượng và hiệu quả công việc. Đây là giải pháp tuyệt vời cho các doanh nghiệp nhỏ như chúng tôi."
                                </p>
                                <div class="">
                                    <p class="m-0 font-italic "><span class="text-black" style="font-weight: bold">Lê Thị E</span>, Giám đốc Nhân sự, Công ty Q.</p>
                                    {{--                                <p>Global Creative Manager, Zoom</p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="bg-light py-5" style="margin-top: 100px;">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="section__title text-center">
                        <p class="bold text-black" style="font-size: 30px">Neztwork Teams: Các gói và mức giá</p>
                        <p class="bold text-black" style="font-size: 20px">
                            An option for every team and organization, your plan can grow with you.</p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center mt-4">
                    <div class="col-12 col-lg-4">
                        <div class="p-2">
                            <p class="text-center text-black">Giải pháp linh hoạt dành cho mọi đội nhóm và tổ chức</p>
                            <p>Neztwork Teams mang đến các gói đăng ký phù hợp cho mọi quy mô, từ những đội nhóm nhỏ đến những tổ chức lớn. Bạn có thể dễ dàng điều chỉnh gói đăng ký theo nhu cầu và quy mô của doanh nghiệp.</p>
{{--                            <div class="" style="box-shadow: 0px 0px 5px 2px #ccc">--}}
{{--                                <div class="bg-light">--}}
{{--                                    <div class=" p-4">--}}
{{--                                        <p class="badge bg-white text-black">For one person</p>--}}
{{--                                        <p class="text-black" style="font-size: 20px">Canva Free</p>--}}
{{--                                        <p>Design anything and bring your ideas to life. No cost, just creativity.</p>--}}
{{--                                        <p><span class="text-black" style="font-size: 30px">0đ</span></p>--}}
{{--                                        <div class="text-center text-lg-start mt-3" >--}}
{{--                                            <a href="#"--}}
{{--                                               class="btn arrow-btn btn-four categories_button text-center d-flex align-items-center justify-content-center" style="width: 100%"><span>Start</span>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                               <div class="bg-white">--}}
{{--                                   <div class="p-4">--}}
{{--                                       <p class="text-black">Features you'll love:</p>--}}
{{--                                       <p class=""> <i class="fa-solid fa-check"></i> Easy drag-and-drop editor</p>--}}
{{--                                       <p class=""> <i class="fa-solid fa-check"></i> Easy drag-and-drop editor</p>--}}
{{--                                       <p class=""> <i class="fa-solid fa-check"></i> Easy drag-and-drop editor</p>--}}
{{--                                       <p class=""> <i class="fa-solid fa-check"></i> Easy drag-and-drop editor</p>--}}
{{--                                       <p class=""> <i class="fa-solid fa-check"></i> Easy drag-and-drop editor</p>--}}
{{--                                   </div>--}}
{{--                               </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 mt-4 mt-lg-0">
                        <div class="p-2">
                            <p class="text-center text-black">Bạn có nhiều đội hay một đội lớn?</p>
                            <p>Tìm hiểu thêm về Neztwork Doanh nghiệp để khám phá các giải pháp tư vấn tối ưu cho các đội nhóm lớn trong tổ chức của bạn.</p>
{{--                            <div class="" style="box-shadow: 0px 0px 5px 2px #ccc">--}}
{{--                                <div class="" style="background-color: #f0ebff">--}}
{{--                                    <div class=" p-4">--}}
{{--                                        <p class="badge bg-white text-black">For one person</p>--}}
{{--                                        <p class="text-black" style="font-size: 20px">Canva Free</p>--}}
{{--                                        <p>Design anything and bring your ideas to life. No cost, just creativity.</p>--}}
{{--                                        <p><span class="text-black" style="font-size: 30px">0đ</span></p>--}}
{{--                                        <div class="text-center text-lg-start mt-3" >--}}
{{--                                            <a href="#"--}}
{{--                                               class="btn arrow-btn btn-four categories_button text-center d-flex align-items-center justify-content-center" style="width: 100%"><span>Start</span>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="bg-white">--}}
{{--                                    <div class="p-4">--}}
{{--                                        <p class="text-black">Features you'll love:</p>--}}
{{--                                        <p class=""> <i class="fa-solid fa-check"></i> Easy drag-and-drop editor</p>--}}
{{--                                        <p class=""> <i class="fa-solid fa-check"></i> Easy drag-and-drop editor</p>--}}
{{--                                        <p class=""> <i class="fa-solid fa-check"></i> Easy drag-and-drop editor</p>--}}
{{--                                        <p class=""> <i class="fa-solid fa-check"></i> Easy drag-and-drop editor</p>--}}
{{--                                        <p class=""> <i class="fa-solid fa-check"></i> Easy drag-and-drop editor</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
            </div>
        </div>
    </div>


    <div class="container">
        <section style="margin-top: 100px">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-8">
                    <div class="section__title text-center">
                        <p class="bold text-black" style="font-size: 30px">Thiết kế cho các đội nhóm thuộc mọi quy mô </p>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-lg-8" style="border-radius: 10px; overflow: hidden;">
                    <div style="border-radius: 10px 10px 0px 0px; overflow: hidden;">
                        <img src="https://static-cse.canva.com/blob/1643897/Smalltomediumteamscompresssedx2.jpg"
                             alt="Small and medium teams image" style="width: 100%; border-radius: 10px 10px 0px 0px;">
                    </div>
                    <div class="p-4"
                         style="background-color: #e1effe;border-radius: 0px 0px 10px 10px; overflow: hidden;">
                        <p class="text-black" style="font-size: 20px; font-family: 'Kanit', sans-serif;">Nhóm Nhỏ và Vừa</p>
                        <p style="font-family: 'Kanit', sans-serif;">Tối ưu hóa chi phí và nâng cao hiệu quả tư vấn với Neztwork Teams. Giải pháp toàn diện này giúp bạn và nhóm tiếp cận các chuyên gia hàng đầu, nhận tư vấn cá nhân hóa và cải thiện kỹ năng nhanh chóng. Khám phá công cụ này để phát triển, sáng tạo và đạt kết quả tốt hơn.</p>
                        <div class="text-center text-lg-start mt-3">
                            <a href="{{route('frontend.user.register')}}" class="btn arrow-btn btn-four categories_button">Dùng ngay gói cho Đội nhóm </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 mt-4 mt-lg-0" style="border-radius: 10px; overflow: hidden;">
                    <div style="border-radius: 10px 10px 0px 0px; overflow: hidden;">
                        <img src="https://static-cse.canva.com/blob/1643898/Teamsizeenterprisectatilecompresssedx2.jpg"
                             alt="Enterprise teams image" style="width: 100%; border-radius: 10px 10px 0px 0px;">
                    </div>
                    <div class="p-4" style="background-color: #e8dbfe;border-radius: 0px 0px 10px 10px; overflow: hidden;">
                        <p class="text-black" style="font-size: 20px; font-family: 'Kanit', sans-serif;">Doanh Nghiệp</p>
                        <p style="font-family: 'Kanit', sans-serif;">Bạn có một tổ chức lớn với nhiều đội nhóm? Liên hệ với đội ngũ bán hàng của Neztwork để tìm giải pháp đăng ký phù hợp nhất cho tổ chức của bạn. Neztwork Teams sẽ hỗ trợ bạn tối ưu hóa hiệu suất và tạo ra giá trị cho từng đội nhóm.</p>
                        <div class="text-center text-lg-start mt-3">
                            <a href="#" class="btn arrow-btn btn-four categories_button">Liên hệ</a>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>

    <div class="container">
        <div class="row" style="margin-top: 100px">
            <div class="col-12 col-lg-4">
                <div class="section__title text-center">
                    <p class="bold text-black" style="font-size: 30px">Câu hỏi thường gặp</p>
                </div>
            </div>
            <div class="col-12 col-lg-8 mt-4 mt-lg-0">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Neztwork Teams là gì?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Neztwork Teams là gói đăng ký lý tưởng dành cho các đội nhóm trong doanh nghiệp có quy mô nhỏ đến trung bình. Với Neztwork Teams, bạn sẽ tận hưởng các tính năng tư vấn chuyên sâu, bảo mật cao cấp, cùng với nhiều công cụ để cộng tác và chia sẻ thông tin hiệu quả. Đây là lựa chọn hoàn hảo cho những đội nhóm cần sự hỗ trợ từ các chuyên gia hàng đầu, đồng thời muốn tối ưu hóa chi phí và tăng cường sự tương tác trong đội.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Tại sao tôi nên sử dụng Neztwork Teams?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Neztwork Teams không chỉ mang lại trải nghiệm tư vấn cá nhân hóa mà còn cho phép bạn mời bạn bè và đồng đội tham gia, giúp tiết kiệm chi phí và tối ưu hóa giá trị nhận được. Đây là lựa chọn lý tưởng cho những ai muốn nâng cao kỹ năng, phát triển bản thân và tạo dựng sự tự tin trong một không gian cộng tác thân thiện và bảo mật.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Neztwork Pro và Neztwork Teams khác nhau như thế nào?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Neztwork Pro chủ yếu phục vụ nhu cầu tư vấn cá nhân, trong khi Neztwork Teams được thiết kế để hỗ trợ các đội nhóm làm việc cùng nhau. Neztwork Teams bao gồm các tính năng bổ sung như khả năng mời tối đa 5 người tham gia buổi tư vấn, quản lý đội nhóm và chia sẻ chi phí một cách hợp lý.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Những loại hình doanh nghiệp nào có thể sử dụng Neztwork Teams?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Neztwork Teams phù hợp với mọi loại hình doanh nghiệp, từ các công ty khởi nghiệp, doanh nghiệp vừa và nhỏ, đến các tập đoàn lớn. Đặc biệt, các đội nhóm trong các lĩnh vực như marketing, nhân sự, sáng tạo, và quản lý dự án sẽ nhận được nhiều lợi ích từ tính năng cộng tác và tư vấn của Neztwork Teams.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Quy trình thanh toán hoạt động như thế nào khi tôi thêm thành viên mới vào đội?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Khi bạn thêm thành viên mới vào đội, chi phí sẽ được tính toán và điều chỉnh theo số lượng người tham gia. Neztwork Teams đảm bảo tính minh bạch trong quy trình thanh toán và giúp bạn dễ dàng quản lý ngân sách của mình.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Trường hợp có người tham gia đội sau khi chốt hóa đơn thì sao?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Nếu có thành viên mới tham gia sau khi hóa đơn đã được chốt, chi phí của họ sẽ được tính vào chu kỳ thanh toán tiếp theo. Điều này giúp bạn linh hoạt trong việc quản lý đội ngũ và đảm bảo rằng tất cả các thành viên đều có quyền truy cập vào dịch vụ mà không gặp bất kỳ trở ngại nào.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                Làm cách nào để tạo một đội trong Neztwork?
                            </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Bạn chỉ cần đăng nhập vào tài khoản Neztwork của mình, chọn tính năng "Tạo đội", sau đó thêm thông tin các thành viên mà bạn muốn mời. Quá trình này chỉ mất vài phút và bạn sẽ sẵn sàng để bắt đầu buổi tư vấn với đội nhóm của mình.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                Nếu tôi thêm một thành viên đội, họ có thể xem tất cả các tư vấn của tôi hay không?
                            </button>
                        </h2>
                        <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Không. Chỉ những tư vấn mà bạn cho phép mới có thể được xem bởi các thành viên khác trong đội. Neztwork Teams cho phép bạn tùy chỉnh quyền truy cập, đảm bảo rằng mỗi buổi tư vấn đều bảo mật và an toàn.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                Làm thế nào để liên hệ với đội ngũ bán hàng?
                            </button>
                        </h2>
                        <div id="collapseNine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Bạn có thể liên hệ với đội ngũ bán hàng của Neztwork thông qua trang web của chúng tôi hoặc gửi email trực tiếp. Chúng tôi luôn sẵn sàng hỗ trợ bạn trong việc tìm ra gói dịch vụ phù hợp nhất cho nhu cầu của bạn và đội nhóm.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
