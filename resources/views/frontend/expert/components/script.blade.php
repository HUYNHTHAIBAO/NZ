<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('.duration').click(function () {
            var duration_time = $('input[data-type]:checked').val();
            var user_expert_id = $('#user_expert_id').val(); // Lấy giá trị user_expert_id từ input ẩn
            function formatCurrency(amount) {
                return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + ' VND';
            }
            $.ajax({
                url: '{{ route('frontend.ajax.get.price') }}',
                type: 'GET',
                data: {
                    duration_id: duration_time, // Gửi duration_id
                    user_expert_id: user_expert_id,
                },
                success: function (response) {
                    var formattedPrice = formatCurrency(response.price);
                    $('.title_price').text(formattedPrice);
                    $('.title_price_input').val(response.price)
                    var duration_time = $('.duration:checked').attr('data-duration');
                    var time = $('input[name="time"]:checked').val();
                    var duration_date = $('.single_select:checked').attr('data-date');
                    onDisibleAfter(duration_time, time, duration_date)
                }
            })
        })

        $('#hireBtn').click(function () {
            var date = $('input[data-date]:checked').data('date');
            console.log(date);
            var durationId = $('input[data-duration]:checked').val();
            var durationName = $('input[data-duration]:checked').data('duration');
            var time = $('input[data-time]:checked').data('time');
            var user_id = $('#user_id').val();
            var user_expert_id = $('#user_expert_id').val();
            var duration_time = $('input[data-type]:checked').val();
            var price = $('.title_price_input').val();
            var email_user = $('#email_user').val();
            var email_user_expert = $('#email_user_expert').val();
            // check rỗng
            if (!durationId || !durationName || !time) {
                Swal.fire({
                    title: 'Thông báo!',
                    text: 'Vui lòng chọn Thời gian',
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Đóng'
                });
                return; // Dừng lại nếu không có thời gian nào được chọn
            }
            // Lấy giá price tương ứng với durationId
            $.ajax({
                url: '{{ route('frontend.ajax.get.price') }}',
                type: 'GET',
                data: {
                    duration_id: durationId, // Gửi duration_id
                    user_expert_id: user_expert_id,
                },
                success: function (response) {
                    if (response.success) {
                        // Sau khi lấy được giá price, gửi yêu cầu AJAX tiếp theo để lưu dữ liệu vào database
                        $.ajax({
                            url: '{{ route('frontend.ajax.request.expert') }}',
                            type: 'POST',
                            data: {
                                date: date,
                                duration_name: durationName,
                                time: time,
                                user_id: user_id,
                                user_expert_id: user_expert_id,
                                price: price, // Gửi giá price
                                email_user: email_user, // Gửi giá price
                                email_user_expert: email_user_expert, // Gửi giá price
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function () {
                                Swal.fire({
                                    title: 'Vui lòng đợi...',
                                    text: 'Đang xử lý yêu cầu của bạn.',
                                    icon: 'info',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    onOpen: function () {
                                        Swal.showLoading();
                                    }
                                });
                            },
                            success: function (response) {
                                // window.location.href = response.data.url_payment;
                                var newId = response.data.id;

                                window.location.href = '{{ url('/thong-tin-dat-lich') }}/' + newId;

                            },
                        });
                    } else {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Đóng'
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Đã xảy ra lỗi khi lấy giá, vui lòng thử lại sau!',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Đóng'
                    });
                }
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
        var currentDate = getCurrentDate();
        var currentDateTime = getCurrentDateTime();

        onDisibleBefor('60 phút', currentDateTime, currentDate)

        function onDisibleBefor(duration_time, time, duration_date) {

            var durationMinutes = parseInt(duration_time.split(' ')[0], 10);

            // Parse selected time
            var startTime = parseTime(time);


            // Add duration to start time
            startTime.setMinutes(startTime.getMinutes() + durationMinutes);

            // Get result time
            var resultTime = formatTime(startTime);


            const compareDate = duration_date;
            const compareTime = resultTime;

            function parseTime(timeString) {
                const [hourMinute, period] = timeString.split(' ');
                let [hour, minute] = hourMinute.split(':').map(Number);
                if (period === 'PM' && hour !== 12) hour += 12;
                if (period === 'AM' && hour === 12) hour = 0;
                return new Date(2024, 0, 1, hour, minute);
            }

            const compareDateTime = parseTime(compareTime);
            const startDateTime = parseTime(time);


            // Get all input elements with the specified date
            const inputs = document.querySelectorAll(`input[data-date="${compareDate}"]`);
            console.log(inputs)
            inputs.forEach(input => {
                const inputTime = parseTime(input.getAttribute('value'));

                if (inputTime <= compareDateTime) {
                    input.classList.add('readonly_2');
                    input.disabled = true;

                }
            });
        }
    });


    function onDisible(element) {

        var checkboxes = document.querySelectorAll('input[name="time"]');

        checkboxes.forEach(function (checkbox) {
            // If the checkbox is not the current checkbox, uncheck it
            if (checkbox !== element) {
                checkbox.checked = false;
                removeCheck(checkboxes)
            }
        });
        var duration_time = $('.duration:checked').attr('data-duration');
        var time = $('input[name="time"]:checked').val();
        var duration_date = $('.single_select:checked').attr('data-date');
        onDisibleAfter(duration_time, time, duration_date)


    }


    function onDisibleAfter(duration_time, time, duration_date) {


        var durationMinutes = parseInt(duration_time.split(' ')[0], 10);

        // Parse selected time
        var startTime = parseTime(time);


        // Add duration to start time
        startTime.setMinutes(startTime.getMinutes() + durationMinutes);

        // Get result time
        var resultTime = formatTime(startTime);


        const compareDate = duration_date;
        const compareTime = resultTime;

        function parseTime(timeString) {
            const [hourMinute, period] = timeString.split(' ');
            let [hour, minute] = hourMinute.split(':').map(Number);
            if (period === 'PM' && hour !== 12) hour += 12;
            if (period === 'AM' && hour === 12) hour = 0;
            return new Date(2000, 0, 1, hour, minute);
        }

        const compareDateTime = parseTime(compareTime);
        const startDateTime = parseTime(time);


        // Get all input elements with the specified date
        const inputs = document.querySelectorAll(`input[data-date="${compareDate}"]`);
        console.log(inputs)
        inputs.forEach(input => {
            const inputTime = parseTime(input.getAttribute('value'));
            if (inputTime <= compareDateTime && inputTime >= startDateTime) {
                input.classList.add('readonly_1');
            }
        });

    }


    function removeCheck(checkboxes) {
        checkboxes.forEach(function (checkbox) {
            checkbox.classList.remove('readonly_1')
        });
    }

    function convertToDateObject(dateString) {
        // Tách ngày, giờ và AM/PM từ chuỗi
        var parts = dateString.split(' ');
        var datePart = parts[0];
        var timePart = parts[1] + ' ' + parts[2];

        // Tách ngày và tháng năm
        var dateParts = datePart.split('-');
        var day = parseInt(dateParts[0], 10);
        var month = parseInt(dateParts[1], 10) - 1; // Tháng bắt đầu từ 0 trong JavaScript Date
        var year = parseInt(dateParts[2], 10);

        // Tách giờ, phút từ thời gian
        var timeParts = timePart.split(':');
        var hour = parseInt(timeParts[0], 10);
        var minute = parseInt(timeParts[1], 10);
        var ampm = timeParts[2];

        // Nếu là PM và giờ không phải 12 thì thêm 12 vào giờ
        if (ampm === 'PM' && hour !== 12) {
            hour += 12;
        }
        // Nếu là AM và giờ là 12 thì chuyển giờ về 0
        if (ampm === 'AM' && hour === 12) {
            hour = 0;
        }

        // Tạo đối tượng Date
        var dateObject = new Date(year, month, day, hour, minute);
        return dateObject;
    }

    function parseTime(timeString) {
        const [time, period] = timeString.split(' ');
        let [hours, minutes] = time.split(':').map(Number);
        if (period === 'PM' && hours !== 12) hours += 12;
        if (period === 'AM' && hours === 12) hours = 0;
        return new Date(2000, 0, 1, hours, minutes);
    }

    // Function to format Date object as time string
    function formatTime(date) {
        let hours = date.getHours();
        const minutes = date.getMinutes();
        const period = hours >= 12 ? 'PM' : 'AM';
        if (hours > 12) hours -= 12;
        if (hours === 0) hours = 12;
        return `${hours}:${minutes < 10 ? '0' : ''}${minutes} ${period}`;
    }

    function getCurrentDate() {
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var year = today.getFullYear();

        return day + '-' + month + '-' + year;
    }


    function getCurrentDateTime() {
        var today = new Date();

        // Get date components
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var year = today.getFullYear();

        // Get time components
        var hours = today.getHours();
        var minutes = String(today.getMinutes()).padStart(2, '0');
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'

        // Combine date and time
        var currentDate = day + '-' + month + '-' + year;
        var currentTime = hours + ':' + minutes + ' ' + ampm;

        return currentTime;
    }


    document.addEventListener('DOMContentLoaded', function () {
        var btnTime = document.querySelector('#btn_time');
        var expertCall = document.querySelector('#expert_call');
        var sidebar = document.querySelector('.sidebar');
        var arowSidebar = document.querySelector('.arow_sidebar');
        var infoSidebar = document.querySelector('.info_sidebar');
        var sidebarMonth = document.querySelector('.sidebarMonth');
        var question = document.querySelector('.question');

        if (btnTime && expertCall) {
            btnTime.addEventListener('click', function () {
                expertCall.style.display = 'block';
                sidebar.style.display = 'none';
                sidebarMonth.style.display = 'none';
                question.style.display = 'none';
                arowSidebar.style.display = 'block';
                infoSidebar.style.display = 'block';
            });
        }
        arowSidebar.addEventListener('click', function () {
            sidebar.style.display = 'block';
            sidebarMonth.style.display = 'block';
            question.style.display = 'block';
            expertCall.style.display = 'none';
            arowSidebar.style.display = 'none';
            infoSidebar.style.display = 'none';

        });
    });




</script>
