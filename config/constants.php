<?php

return [
    'account_kit_app_id'     => '2220797271491128',
    'account_kit_app_secret' => '3d79d25158cc151dfe982f1f5322e68d',
    'account_kit_version'    => 'v1.1',

    'assets_version' => '4.5',

    'upload_dir'      => [
        'root' => storage_path('app/public/uploads'),
        'url'  => config('app.url') . '/storage/uploads',
    ],

    'upload_dir_temp' => [
        'root' => storage_path('app/public/uploads/temp'),
        'url'  => config('app.url') . '/storage/uploads/temp',
    ],

    'firebase_api_key'    => 'AAAA8Qldlj4:APA91bGghhoyuc1G0t0DN30MmS2VYd1gVkIkuweRuCF2LccUbSRmZt91GayGzf4QNXVWAh74eGsLiI1Q2HjSJ3B_yOCmDpbfdItKxiXjWlC1K2348v16kORZDwIMsMTZgQGLXY5-Vlc2',
    'item_perpage'        => 10,
    'item_per_page_admin' => 30,
    'company_id'          => 6,
    'google_maps_key'     => 'AIzaSyB711stPiEwDrN_Biq6Tcx7KHhtu-QPxm0',
    'limit_records'       => [10, 30, 50, 100, 500, 1000, 5000, 10000],
    'mail_driver'         => 'smtp',
    'mail_host'           => 'smtp.gmail.com',
    'mail_port'           => 587,
    'mail_from_address'   => 'huynhthaibao.it@gmail.com',
    'mail_from_name'      => 'Neztwork',
    'mail_encryption'     => 'tls',
    'mail_username'       => 'huynhthaibao.it@gmail.com',
    'mail_password'       => 'miibphgeoogdrnbm',


    'constants.vnpay.vnp_TmnCode'    => '9XU572WX',
    'constants.vnpay.vnp_HashSecret' => 'CAP9JKK7MSYISPAVWKNB0NY9M1FYO1X7',
];
