<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\ProductType;
use App\Utils\Category;

Route::group(['prefix' => 'admin'], function () {

    Route::any('/login', 'Backend\AuthController@login')->name('backend.login');
    Route::any('/logout', 'Backend\AuthController@logout')->name('backend.logout');

    Route::group(['middleware' => 'backend'], function () {

        Route::any('/', 'Backend\DashboardController@index')->name('backend.dashboard');
        Route::any('/notification', 'Backend\NotificationController@index')->name('backend.notification.index')->middleware('permission:notification.index');
        Route::any('/notification/add', 'Backend\NotificationController@add')->name('backend.notification.add')->middleware('permission:notification.add');

        Route::any('/profile', 'Backend\UsersController@profile')->name('backend.users.profile');

        Route::any('/users', 'Backend\UsersController@index')->name('backend.users.index')->middleware('permission:users.index');
        Route::any('/users/add', 'Backend\UsersController@add')->name('backend.users.add')->middleware('permission:users.add');
        Route::any('/users/edit/{id}', 'Backend\UsersController@edit')->name('backend.users.edit')->middleware('permission:users.edit');
        Route::any('/users/delete/{id}', 'Backend\UsersController@delete')->name('backend.users.delete')->middleware('permission:users.delete');

        Route::group(['prefix' => 'salary'], function () {
            Route::any('/', 'Backend\SalaryController@index')->name('backend.salary.index');
            Route::any('/export', 'Backend\SalaryController@export')->name('backend.salary.export');
            Route::any('/delete/{id}', 'Backend\SalaryController@delete')->name('backend.salary.delete');
        });

        Route::group(['prefix' => 'expert'], function () {
            Route::any('/', 'Backend\ExpertController@index')->name('backend.expert.index');
            Route::any('/expertApplication', 'Backend\ExpertController@expertApplication')->name('backend.expert.expertApplication');
            Route::any('/expertApplicationUpdate', 'Backend\ExpertController@expertApplicationUpdate')->name('backend.expert.expertApplicationUpdate');
            Route::any('/detail/{id}', 'Backend\ExpertController@detail')->name('backend.expert.detail');
            Route::any('/detailUpdate/{id}', 'Backend\ExpertController@detailUpdate')->name('backend.expert.detailUpdate');
            Route::any('/approved/{id}', 'Backend\ExpertController@approved')->name('backend.expert.approved');
            Route::any('/approvedUpdate/{id}', 'Backend\ExpertController@approvedUpdate')->name('backend.expert.approvedUpdate');
            Route::any('/reject/{id}', 'Backend\ExpertController@reject')->name('backend.expert.reject');
            Route::any('/rejectUpdate/{id}', 'Backend\ExpertController@rejectUpdate')->name('backend.expert.rejectUpdate');
            Route::any('/users/edit/{id}', 'Backend\UsersController@edit')->name('backend.users.edit');
            Route::any('/users/delete/{id}', 'Backend\UsersController@delete')->name('backend.users.delete')->middleware('permission:expert.delete');
            Route::any('/settingsExpert/{id}', 'Backend\UsersController@settingsExpert')->name('backend.users.settingsExpert');
            Route::any('/chart/{id}', 'Backend\UsersController@chart')->name('backend.users.chart');
        });


        Route::group(['prefix' => 'youtubeExpert'], function () {
            Route::any('/', 'Backend\YoutubeExpertController@index')->name('backend.youtubeExpert.index');
            Route::any('/approved/{id}', 'Backend\YoutubeExpertController@approved')->name('backend.youtubeExpert.approved');
            Route::any('/reject/{id}', 'Backend\YoutubeExpertController@reject')->name('backend.youtubeExpert.reject');
        });


        Route::group(['prefix' => 'ExpertProfileOrther'], function () {
            Route::any('/', 'Backend\ExpertProfileOrtherController@index')->name('backend.ExpertProfileOrther.index');
            Route::any('/approved/{id}', 'Backend\ExpertProfileOrtherController@approved')->name('backend.ExpertProfileOrther.approved');
            Route::any('/reject/{id}', 'Backend\ExpertProfileOrtherController@reject')->name('backend.ExpertProfileOrther.reject');
        });



        Route::group(['prefix' => 'shortVideoExpert'], function () {
            Route::any('/', 'Backend\ShortVideoExpertController@index')->name('backend.shortVideoExpert.index');
            Route::any('/approved/{id}', 'Backend\ShortVideoExpertController@approved')->name('backend.shortVideoExpert.approved');
            Route::any('/reject/{id}', 'Backend\ShortVideoExpertController@reject')->name('backend.shortVideoExpert.reject');
        });


        Route::group(['prefix' => 'questionExpert'], function () {
            Route::any('/', 'Backend\QuestionExpertController@index')->name('backend.questionExpert.index');
            Route::any('/approved/{id}', 'Backend\QuestionExpertController@approved')->name('backend.questionExpert.approved');
            Route::any('/reject/{id}', 'Backend\QuestionExpertController@reject')->name('backend.questionExpert.reject');
        });


        Route::group(['prefix' => 'walletExpert'], function () {
            Route::any('/', 'Backend\WalletController@index')->name('backend.walletExpert.index');
            Route::any('/approve/{id}', 'Backend\WalletController@approve')->name('backend.walletExpert.approve');
        });


//        Route::group(['prefix' => 'expert'], function () {
//            Route::any('/', 'Backend\ExpertController@index')->name('backend.expert.index');
//            Route::any('/expertApplication', 'Backend\ExpertController@expertApplication')->name('backend.expert.expertApplication');
//            Route::any('/detail/{id}', 'Backend\ExpertController@detail')->name('backend.expert.detail');
//            Route::any('/approved/{id}', 'Backend\ExpertController@approved')->name('backend.expert.approved');
//            Route::any('/reject/{id}', 'Backend\ExpertController@reject')->name('backend.expert.reject');
//        });


        Route::group(['prefix' => 'expertCategory'], function () {
            Route::any('/', 'Backend\ExpertCategoryController@index')->name('backend.expertCategory.index');
            Route::any('/add', 'Backend\ExpertCategoryController@add')->name('backend.expertCategory.add');
            Route::any('/edit/{id}', 'Backend\ExpertCategoryController@edit')->name('backend.expertCategory.edit');
            Route::any('/del/{id}', 'Backend\ExpertCategoryController@del')->name('backend.expertCategory.del');
            Route::any('/settings/{id}', 'Backend\ExpertCategoryController@settings')->name('backend.users.settings');
        });

        Route::group(['prefix' => 'expertCategoryTags'], function () {
            Route::any('/', 'Backend\ExpertCategoryTagsController@index')->name('backend.expertCategoryTags.index');
            Route::any('/add', 'Backend\ExpertCategoryTagsController@add')->name('backend.expertCategoryTags.add');
            Route::any('/edit/{id}', 'Backend\ExpertCategoryTagsController@edit')->name('backend.expertCategoryTags.edit');
            Route::any('/del/{id}', 'Backend\ExpertCategoryTagsController@del')->name('backend.expertCategoryTags.del');

        });

        Route::group(['prefix' => 'staff'], function () {
            Route::any('', 'Backend\StaffController@index')->name('backend.staff.index')->middleware('permission:staff.index');
            Route::any('/add', 'Backend\StaffController@add')->name('backend.staff.add')->middleware('permission:staff.add');
            Route::any('/edit/{id}', 'Backend\StaffController@edit')->name('backend.staff.edit')->middleware('permission:staff.edit');
            Route::any('/delete/{id}', 'Backend\StaffController@delete')->name('backend.staff.delete')->middleware('permission:staff.delete');
        });

        Route::group(['prefix' => 'products'], function () {
            Route::any('', 'Backend\Product\ProductsController@index')->name('backend.products.index')->middleware('permission:products.index');
            Route::any('/inventory', 'Backend\Product\ProductsController@inventory')->name('backend.products.inventory');

            Route::any('/change/priority', 'Backend\Product\ProductsController@Changepriority')->name('backend.products.change.priority');

            Route::any('/deletePriceRange/{id}', 'Backend\Product\ProductsController@deletePriceRange')->name('backend.products.deletePriceRange');
            Route::any('/add/{type_id}', 'Backend\Product\ProductsController@add')->name('backend.products.add')->middleware('permission:products.add');
            Route::any('/edit/{id}-{type_id}', 'Backend\Product\ProductsController@edit')->name('backend.products.edit')->middleware('permission:products.edit');
            Route::post('/ajax/delete', 'Backend\Product\ProductsController@ajaxdelete')->name('backend.products.ajax.delete');

            Route::post('/ajax/approved', 'Backend\Product\ProductsController@approved')->name('backend.products.ajax.approved');
            Route::post('/ajax/un_approved', 'Backend\Product\ProductsController@un_approved')->name('backend.products.ajax.un_approved');
            Route::post('/ajax/savePriceRange', 'Backend\Product\ProductsController@savePriceRange')->name('backend.products.ajax.savePriceRange');


            Route::group(['prefix' => 'type'], function () {
                Route::any('/', 'Backend\Product\TypeController@index')->name('backend.products.type.index')->middleware('permission:products.type.index');
                Route::any('/add', 'Backend\Product\TypeController@add')->name('backend.products.type.add')->middleware('permission:products.type.add');
                Route::any('/edit/{id}', 'Backend\Product\TypeController@edit')->name('backend.products.type.edit')->middleware('permission:products.type.edit');
                Route::post('/delete', 'Backend\Product\TypeController@delete')->name('backend.products.type.del')->middleware('permission:products.type.del');
                Route::any('/sort', 'Backend\Product\TypeController@sort')->name('backend.products.type.sort')->middleware('permission:products.type.index');
            });

            Route::group(['prefix' => 'attributes'], function () {
                Route::any('/', 'Backend\Product\Attributes\IndexController@index')->name('backend.products.attributes.index');
                Route::any('/add', 'Backend\Product\Attributes\IndexController@add')->name('backend.products.attributes.add');
                Route::any('/edit/{id}', 'Backend\Product\Attributes\IndexController@edit')->name('backend.products.attributes.edit');
                Route::post('/delete', 'Backend\Product\Attributes\IndexController@delete')->name('backend.products.attributes.del');
                Route::any('/sort', 'Backend\Product\Attributes\IndexController@sort')->name('backend.products.attributes.sort');

                Route::group(['prefix' => 'values'], function () {
                    Route::any('{attribute_id}/', 'Backend\Product\Attributes\ValuesController@index')->name('backend.products.attributes.values.index');
                    Route::any('/{attribute_id}/add', 'Backend\Product\Attributes\ValuesController@add')->name('backend.products.attributes.values.add');
                    Route::any('/{attribute_id}/edit/{value_id}', 'Backend\Product\Attributes\ValuesController@edit')->name('backend.products.attributes.values.edit');
                    Route::post('/{attribute_id}/delete', 'Backend\Product\Attributes\ValuesController@delete')->name('backend.products.attributes.values.del');
                    Route::post('/{attribute_id}/sort', 'Backend\Product\Attributes\ValuesController@sort')->name('backend.products.attributes.values.sort');
                });
            });
        });

        Route::any('/notification', 'Backend\NotificationController@index')->name('backend.notification.index')->middleware('permission:notification.index');
        Route::any('/notification/add', 'Backend\NotificationController@add')->name('backend.notification.add')->middleware('permission:notification.add');

        Route::group(['prefix' => 'location'], function () {
            Route::any('/province', 'Backend\Location\ProvinceController@index')->name('backend.location.province.index');
            Route::any('/province/add', 'Backend\Location\ProvinceController@add')->name('backend.location.province.add');
            Route::any('/province/edit/{id}', 'Backend\Location\ProvinceController@edit')->name('backend.location.province.edit');
            Route::any('/province/del/{id}', 'Backend\Location\ProvinceController@delete')->name('backend.location.province.del');

            Route::any('/district', 'Backend\Location\DistrictController@index')->name('backend.location.district.index');
            Route::any('/district/add', 'Backend\Location\DistrictController@add')->name('backend.location.district.add');
            Route::any('/district/edit/{id}', 'Backend\Location\DistrictController@edit')->name('backend.location.district.edit');
            Route::any('/district/del/{id}', 'Backend\Location\DistrictController@delete')->name('backend.location.district.del');

            Route::any('/ward', 'Backend\Location\WardController@index')->name('backend.location.ward.index');
            Route::any('/ward/add', 'Backend\Location\WardController@add')->name('backend.location.ward.add');
            Route::any('/ward/edit/{id}', 'Backend\Location\WardController@edit')->name('backend.location.ward.edit');
            Route::any('/ward/del/{id}', 'Backend\Location\WardController@delete')->name('backend.location.ward.del');

        });

        //ajax
        Route::group(['prefix' => 'ajax'], function () {
            Route::any('/ajax-shipping-fee', 'Backend\AjaxController@shippingFee')->name('backend.ajax.shipping-fee');

            Route::any('/search-user', 'Backend\AjaxController@searchUser')->name('backend.ajax.searchUser');
            Route::post('/add-street', 'Backend\AjaxController@addStreet')->name('backend.ajax.addStreet');
            Route::post('/upload-image', 'Backend\AjaxController@uploadImage')->name('backend.ajax.uploadImage');
            Route::post('/remove-image', 'Backend\AjaxController@removeImage')->name('backend.ajax.removeImage');

            Route::post('/product/variation/delete', 'Backend\Product\ProductsController@deleteVariation')->name('backend.products.variation.delete');
            Route::post('/product/variation/add', 'Backend\Product\ProductsController@createVariation')->name('backend.products.variation.add');

            Route::get('/variation-image', 'Backend\Product\ProductsController@getVariationImage')->name('backend.products.variation.image');
            Route::post('/variation-image', 'Backend\Product\ProductsController@uploadVariationImage')->name('backend.products.variation.image.upload');
            Route::post('/variation-image/delete', 'Backend\Product\ProductsController@deleteVariationImage')->name('backend.products.variation.image.delete');
            Route::post('/variation-image/sort', 'Backend\Product\ProductsController@sortVariationImage')->name('backend.products.variation.image.sort');

            Route::get('/variation/value', 'Backend\AjaxController@getVariationValue')->name('backend.ajax.variation.value');
            Route::post('/variation/create', 'Backend\AjaxController@createVariation')->name('backend.ajax.variation.create');
            Route::post('/add-salary', 'Backend\AjaxController@addSalary')->name('backend.ajax.addSalary');
            Route::post('/ajax-salary', 'Backend\AjaxController@ajaxSalary')->name('backend.ajax.ajaxSalary');
            Route::post('/ajax-salary/agree', 'Backend\AjaxController@ajaxSalaryAgree')->name('backend.ajax.ajaxSalaryAgree');
            Route::post('/payed-salary', 'Backend\AjaxController@paySalary')->name('backend.ajax.paySalary');

        });

        Route::group(['prefix' => 'post'], function () {
            Route::any('/', 'Backend\PostsController@index')->name('backend.posts.index')->middleware('permission:posts.index');
            Route::any('/add', 'Backend\PostsController@add')->name('backend.posts.add')->middleware('permission:posts.add');
            Route::any('/edit/{id}', 'Backend\PostsController@edit')->name('backend.posts.edit')->middleware('permission:posts.edit');
            Route::any('/delete/{id}', 'Backend\PostsController@delete')->name('backend.posts.del')->middleware('permission:posts.del');


            Route::group(['prefix' => 'category'], function () {
                Route::any('/', 'Backend\PostsCategoryController@index')->name('backend.posts.category.index')->middleware('permission:posts.category.index');
                Route::any('/sort', 'Backend\PostsCategoryController@sort')->name('backend.posts.category.sort')->middleware('permission:posts.category.index');
                Route::any('/add', 'Backend\PostsCategoryController@add')->name('backend.posts.category.add')->middleware('permission:posts.category.add');
                Route::any('/edit/{id}', 'Backend\PostsCategoryController@edit')->name('backend.posts.category.edit')->middleware('permission:posts.category.edit');
                Route::any('/delete', 'Backend\PostsCategoryController@delete')->name('backend.posts.category.del')->middleware('permission:posts.category.del');
            });
        });


        Route::group(['prefix' => 'postExpert'], function () {
            Route::any('/', 'Backend\PostExpertController@index')->name('backend.postExpert.index');
            Route::any('/add', 'Backend\PostExpertController@add')->name('backend.postExpert.add');
            Route::any('/edit/{id}', 'Backend\PostExpertController@edit')->name('backend.postExpert.edit');
            Route::any('/delete/{id}', 'Backend\PostExpertController@delete')->name('backend.postExpert.del');
            Route::any('/approve/{id}', 'Backend\PostExpertController@approve')->name('backend.postExpert.approve');
            Route::any('/reject/{id}', 'Backend\PostExpertController@reject')->name('backend.postExpert.reject');
        });




        Route::group(['prefix' => 'calendarExpert'], function () {
            Route::any('/duration/{id}', 'Backend\CalendarExpertController@duration')->name('backend.calendarExpert.duration');
            Route::any('/time/{id}', 'Backend\CalendarExpertController@time')->name('backend.calendarExpert.time');
        });


        Route::group(['prefix' => 'requestExpert'], function () {
            Route::any('/', 'Backend\RequestExpertController@index')->name('backend.requestExpert.index');
//            Route::any('/detail/{id}', 'Backend\RequestExpertController@index')->name('backend.requestExpert.index');
        });


        Route::group(['prefix' => 'calendarExpert'], function () {
            Route::any('/duration/{id}', 'Backend\CalendarExpertController@duration')->name('backend.calendarExpert.duration');
            Route::any('/time/{id}', 'Backend\CalendarExpertController@time')->name('backend.calendarExpert.time');
        });

        Route::group(['prefix' => 'policy'], function () {
            Route::any('/', 'Backend\PolicyController@index')->name('backend.policy.index')->middleware('permission:policy.index');
            Route::any('/add', 'Backend\PolicyController@add')->name('backend.policy.add')->middleware('permission:policy.add');
            Route::any('/edit/{id}', 'Backend\PolicyController@edit')->name('backend.policy.edit')->middleware('permission:policy.edit');
            Route::any('/delete/{id}', 'Backend\PolicyController@delete')->name('backend.policy.del')->middleware('permission:policy.del');

            Route::group(['prefix' => 'category'], function () {
                Route::any('/', 'Backend\PolicyCategoryController@index')->name('backend.policy.category.index')->middleware('permission:policy.category.index');
                Route::any('/sort', 'Backend\PolicyCategoryController@sort')->name('backend.policy.category.sort')->middleware('permission:policy.category.index');
                Route::any('/add', 'Backend\PolicyCategoryController@add')->name('backend.policy.category.add')->middleware('permission:policy.category.add');
                Route::any('/edit/{id}', 'Backend\PolicyCategoryController@edit')->name('backend.policy.category.edit')->middleware('permission:policy.category.edit');
                Route::any('/delete', 'Backend\PolicyCategoryController@delete')->name('backend.policy.category.del')->middleware('permission:policy.category.del');
            });
        });

        Route::group(['prefix' => 'orders'], function () {
            Route::any('/', 'Backend\OrdersController@index')->name('backend.orders.index')->middleware('permission:orders.index');
            Route::any('/export', 'Backend\OrdersController@export')->name('backend.orders.export')->middleware('permission:orders.index');
            Route::any('/{id}', 'Backend\OrdersController@detail')->name('backend.orders.detail')->middleware('permission:orders.index');
            Route::any('/delete/{id}', 'Backend\OrdersController@delete')->name('backend.orders.delete')->middleware('permission:orders.index');


            Route::any('/excel/excel_export', 'Backend\OrdersController@excelExport')->name('backend.orders.excel.export');
            Route::any('/excel/wherehouseExport', 'Backend\OrdersController@wherehouseExport')->name('backend.orders.wherehouse.export');

            Route::any('/delete/detail/{id}', 'Backend\OrdersController@detailDelete')->name('backend.orders.detail.delete');
            Route::any('/add/detail', 'Backend\OrdersController@detailadd')->name('backend.orders.detail.add');
            Route::any('/print', 'Backend\OrdersController@print')->name('backend.orders.print');
            Route::any('/pay_debt/{id}', 'Backend\OrdersController@pay_debt')->name('backend.orders.pay_debt');

        });

        Route::group(['prefix' => 'menu'], function () {
            Route::group(['prefix' => 'products'], function () {
                Route::any('/', 'Backend\MenuController@index')->name('backend.menu.index');
                Route::any('/sort', 'Backend\MenuController@sort')->name('backend.menu.sort');
                Route::any('/add', 'Backend\MenuController@add')->name('backend.menu.add');
                Route::any('/edit/{id}', 'Backend\MenuController@edit')->name('backend.menu.edit');
                Route::any('/delete', 'Backend\MenuController@delete')->name('backend.menu.del');
            });

            Route::group(['prefix' => 'news'], function () {
                Route::any('/', 'Backend\MenuNewsController@index')->name('backend.menu.news.index');
                Route::any('/sort', 'Backend\MenuNewsController@sort')->name('backend.menu.news.sort');
                Route::any('/add', 'Backend\MenuNewsController@add')->name('backend.menu.news.add');
                Route::any('/edit/{id}', 'Backend\MenuNewsController@edit')->name('backend.menu.news.edit');
                Route::any('/delete', 'Backend\MenuNewsController@delete')->name('backend.menu.news.del');
            });
        });


        Route::group(['prefix' => 'setting'], function () {
            Route::any('/', 'Backend\SettingController@index')->name('backend.setting.index');
            Route::any('/coupon', 'Backend\SettingController@coupon')->name('backend.setting.coupon');
            Route::any('/time/rates', 'Backend\SettingController@TimeRates')->name('backend.setting.time.rates');
            Route::any('/time/rates/delete/{id}', 'Backend\SettingController@TimeRatesDelete')->name('backend.setting.time.rates.delete');
        });

        Route::group(['prefix' => 'banner'], function () {
            Route::any('/', 'Backend\BannerController@index')->name('backend.banner.index');
            Route::any('/add', 'Backend\BannerController@add')->name('backend.banner.add');
            Route::any('/edit/{id}', 'Backend\BannerController@edit')->name('backend.banner.edit');
            Route::any('/delete/{id}', 'Backend\BannerController@delete')->name('backend.banner.del');
        });


        Route::group(['prefix' => 'HomeAi'], function () {
            Route::any('/editHomeAi/{id}', 'Backend\SettingController@editHomeAi')->name('backend.HomeAi.edit');
        });
        Route::group(['prefix' => 'HomeGroup'], function () {
            Route::any('/editHomeGroup/{id}', 'Backend\SettingController@editHomeGroup')->name('backend.HomeGroup.edit');
        });


        Route::group(['prefix' => 'partner'], function () {
            Route::any('/', 'Backend\PartnerController@index')->name('backend.partner.index');
            Route::any('/add', 'Backend\PartnerController@add')->name('backend.partner.add');
            Route::any('/edit/{id}', 'Backend\PartnerController@edit')->name('backend.partner.edit');
            Route::any('/delete/{id}', 'Backend\PartnerController@delete')->name('backend.partner.del');
        });

        Route::group(['prefix' => 'booking'], function () {
            Route::any('/', 'Backend\BookingController@index')->name('backend.booking.index');
            Route::any('/add', 'Backend\BookingController@add')->name('backend.booking.add');
            Route::any('/edit/{id}', 'Backend\BookingController@edit')->name('backend.booking.edit');
            Route::any('/delete/{id}', 'Backend\BookingController@delete')->name('backend.booking.del');
        });

        Route::group(['prefix' => 'review'], function () {
            Route::any('/', 'Backend\ReviewController@index')->name('backend.review.index');
            Route::any('/add', 'Backend\ReviewController@add')->name('backend.review.add');
            Route::any('/edit/{id}', 'Backend\ReviewController@edit')->name('backend.review.edit');
            Route::any('/delete/{id}', 'Backend\ReviewController@delete')->name('backend.review.del');
        });


        Route::any('/subscribers', 'Backend\SubscribersController@index')->name('backend.subscribers.index');

        Route::group(['prefix' => 'discount'], function () {
            Route::any('/', 'Backend\DiscountController@index')->name('backend.discount.index')->middleware('permission:discount.index');
            Route::any('/add', 'Backend\DiscountController@add')->name('backend.discount.add')->middleware('permission:discount.add');
            Route::any('/edit/{id}', 'Backend\DiscountController@edit')->name('backend.discount.edit')->middleware('permission:discount.edit');
            Route::any('/delete/{id}', 'Backend\DiscountController@delete')->name('backend.discount.del')->middleware('permission:discount.del');
        });
    });

});

Route::any('/', 'Frontend\IndexController@index')->name('frontend.index');

//chuyen gia
Route::any('/chuyen-gia/{slug}.{id}', 'Frontend\IndexController@Expert')->name('frontend.expert');
Route::any('/thong-tin-dat-lich/{id}', 'Frontend\IndexController@formBookingExpert')->name('frontend.formBookingExpert');
Route::any('/chon-thoi-gian-dat-lich-goi-nhom/{id}', 'Frontend\IndexController@formBookingExpertPackageGroup')->name('frontend.formBookingExpertPackageGroup');
Route::any('/tom-tat-dat-lich/{id}', 'Frontend\IndexController@formBookingExpertSummary')->name('frontend.formBookingExpertSummary');
Route::any('/processPayment/{id}', 'Frontend\IndexController@processPayment')->name('frontend.processPayment');
Route::post('/encrypt-id', function (Illuminate\Http\Request $request) {
    // Mã hóa id
    $encryptedId = \Illuminate\Support\Facades\Crypt::encrypt($request->id);

    // Trả về mã hóa id cho Ajax
    return response()->json(['encryptedId' => $encryptedId]);
});

// theo dõi
Route::any('theo-doi/{id}', 'Frontend\IndexController@followExpert')->name('frontend.followExpert');
Route::any('bo-theo-doi/{id}', 'Frontend\IndexController@unfollowExpert')->name('frontend.unfollowExpert');


Route::any('/chinh-sach-doi-tra-hang.html', 'Frontend\IndexController@policy')->name('frontend.info.policy');
Route::any('/cau-hoi-thuong-gap.html', 'Frontend\IndexController@faq')->name('frontend.info.faq');
Route::any('/huong-dan-dat-hang-doi-tra.html', 'Frontend\IndexController@orderingGuide')->name('frontend.info.orderingGuide');
Route::any('/chinh-sach-thanh-toan.html', 'Frontend\IndexController@STORAGE_INSTRUCTIONS')->name('frontend.info.STORAGE_INSTRUCTIONS');
Route::any('/chinh-sach-van-chuyen-giao-nhan.html', 'Frontend\IndexController@shippingPolicy')->name('frontend.info.shippingPolicy');


//
Route::any('/dieu-khoan-su-dung.html', 'Frontend\IndexController@termOfUse')->name('frontend.info.termOfUse');
Route::any('/chinh-sach-quyen-rieng-tu.html', 'Frontend\IndexController@informationPrivacy')->name('frontend.info.informationPrivacy');
Route::any('/chinh-sach-ve-so-huu-tri-tue.html', 'Frontend\IndexController@INTELLECTUAL_PROPERTY_POLICY')->name('frontend.info.INTELLECTUAL_PROPERTY_POLICY');
Route::any('/thoa-thuan-dich-vu-khung.html', 'Frontend\IndexController@FRAMEWORK_SERVICE_AGREEMENT')->name('frontend.info.FRAMEWORK_SERVICE_AGREEMENT');
Route::any('/tuyen-bo-ve-quyen-rieng-tu-neztwork-business.html', 'Frontend\IndexController@PRIVACY_NEZTWORK')->name('frontend.info.PRIVACY_NEZTWORK');
Route::any('/dieu-khoan-danh-cho-chuyen-gia.html', 'Frontend\IndexController@TERMS_FOR_EXPERTS')->name('frontend.info.TERMS_FOR_EXPERTS');
Route::any('/dieu-khoan-va-dieu-kien-cho-don-vi-lien-ket.html', 'Frontend\IndexController@TERMS_FOR_AFFILIATEST')->name('frontend.info.TERMS_FOR_AFFILIATEST');
Route::any('/ra-mat-dich-vu.html', 'Frontend\IndexController@SERVICE_LAUNCH')->name('frontend.info.SERVICE_LAUNCH');
Route::any('/chinh-sach-gia-ca-va-khuyen-mai.html', 'Frontend\IndexController@PRICING_POLICY')->name('frontend.info.PRICING_POLICY');
Route::any('/huong-dan-thanh-toan-VNPAY.html', 'Frontend\IndexController@VNPAY')->name('frontend.info.VNPAY');


//
Route::any('/chat.html', 'Frontend\IndexController@chat')->name('frontend.info.chat');
Route::any('/meeting.html', 'Frontend\IndexController@meeting')->name('frontend.info.meeting');
Route::any('/smartttube_stable', 'Frontend\IndexController@smartttubeStable')->name('frontend.info.smartttubeStable');
Route::any('/ajax/check-discount-code', 'Frontend\AjaxController@checkDiscount')->name('frontend.ajax.checkDiscount');
Route::any('/weebhook/memobot', 'Frontend\AjaxController@webhookmemobot')->name('frontend.memobot');
Route::any('/callback/quickom', 'Frontend\AjaxController@callbackquickom')->name('frontend.callback.quickom');

Route::get('/feed', function () {

    $feed = App::make("feed");

    //$feed->setCache(60, 'my_rss');

    if (!$feed->isCached()) {

        $posts = App\Models\Post::get_by_where([
            'status' => App\Models\Post::STATUS_SHOW,
            'limit' => 1000,
        ], ['detail']);

        $feed->title = 'Balo Nguyên Phúc | Hệ thống cửa hàng Balo, Vali, Túi Xách, Phụ Kiện';
        $feed->description = 'Balo Nguyên phúc chuyên cung cấp sỉ lẻ các loại balo, vali, túi xách cho học sinh, dân công sở, doanh nhân, cho du lịch với nhiều kiểu dáng thời trang thỏa sức cho bạn lựa chọn.';
        $feed->logo = 'https://nguyenphucstore.vn/storage/uploads/2020/08/24/5f43857b0f331.png';
        $feed->link = url('feed');
        $feed->setDateFormat('datetime');
        $feed->pubdate = $posts[0]->created_at->format(DateTime::RFC822);
        $feed->lang = 'vi';
        $feed->setShortening(true);
        $feed->setTextLimit(100);

        foreach ($posts as $post) {
            $feed->add(strip_tags($post->name), 'Nguyen Phuc Store', url($post->post_link()), $post->created_at->format(DateTime::RFC822), strip_tags($post->excerpt), strip_tags($post->details));
        }

    }

    return $feed->render('rss');
});
Route::any('/gio-hang.html', 'Frontend\CartController@index')->name('frontend.cart.index');
Route::any('/lich-su-thanh-toan.html', 'Frontend\SalaryController@index')->name('frontend.salary.index');
Route::any('/dat-hang.html', 'Frontend\CartController@checkout')->name('frontend.cart.checkout');
Route::any('/tra-cuu-don-hang.html', 'Frontend\OrderController@tracking')->name('frontend.order.tracking');
Route::any('/quan-ly-he-thong', 'Frontend\ProductController@system')->name('frontend.products.system');
Route::any('/ajax-user', 'Frontend\ProductController@ajaxUser')->name('frontend.products.ajaxUser');

Route::group(['prefix' => 'ajax'], function () {
    Route::post('/cart/add', 'Frontend\AjaxController@addItemCart')->name('frontend.ajax.cart.add');
    Route::post('/checkroom', 'Frontend\AjaxController@checkroom')->name('frontend.ajax.checkroom');



    Route::any('/check-discount-point', 'Frontend\AjaxController@checkDiscountPoint')->name('frontend.ajax.checkDiscountPoint');
    Route::any('/get-tags-by-category', 'Frontend\AjaxController@getTagsByCategory')->name('frontend.ajax.getTagsByCategory');

    Route::post('/wishlist/add', 'Frontend\AjaxController@addWishlist')->name('frontend.ajax.addWishlist');
    Route::post('/wishlist/delete', 'Frontend\AjaxController@deleteWishlist')->name('frontend.ajax.deleteWishlist');
    Route::post('/address/delete', 'Frontend\AjaxController@deleteAddress')->name('frontend.ajax.deleteAddress');
    Route::post('/address/add', 'Frontend\AjaxController@addAddress')->name('frontend.ajax.addAddress');
    Route::get('/address/getById', 'Frontend\AjaxController@getAddressById')->name('frontend.ajax.getAddressById');
    Route::post('/ajax/image', 'Frontend\AjaxController@uploadImage')->name('frontend.ajax.uploadImage');
    Route::post('/cart/delete', 'Frontend\AjaxController@deleteItemCart')->name('frontend.ajax.cart.delete');
    Route::post('/cart/clear', 'Frontend\AjaxController@clearCart')->name('frontend.ajax.cart.clear');

    Route::get('/product-variation', 'Frontend\ProductController@variation')->name('frontend.ajax.variation');

    Route::any('/subscribe-email.html', 'Frontend\AjaxController@subscribeEmail')->name('frontend.ajax.subscribeEmail');

    // yêu cầu thuê chuyên gia
    Route::any('/requestExpert', 'Frontend\AjaxController@requestExpert')->name('frontend.ajax.request.expert');
    Route::any('/get-price', 'Frontend\AjaxController@getPrice')->name('frontend.ajax.get.price');

    // noti chuyên gia
    Route::any('/notiExpert', 'Frontend\AjaxController@notiExpert')->name('frontend.ajax.notiExpert');
    // kết thúc cuộc gọi
    Route::any('/end_call', 'Frontend\AjaxController@endCall')->name('frontend.ajax.endCall');
    // đặt dich vụ theo gói
    Route::post('/booking/plan', 'Frontend\AjaxController@BookingPlan')->name('frontend.expert.booking.plan');
    // search theo email

    Route::get('/search/email', 'Frontend\AjaxController@SearchEmail')->name('frontend.expert.search.email');


});
Route::get('/danh-sach-yeu-thich', 'Frontend\ProductController@wishlist')->name('frontend.product.wishlist');
Route::get('/chuyen-gia', 'Frontend\ProductController@main')->name('frontend.product.main');
Route::get('/lien-he.html', 'Frontend\PagesController@contact')->name('frontend.page.contact');
Route::get('/experts.html', 'Frontend\PagesController@becom')->name('frontend.page.becom');
Route::get('/marketplace.html', 'Frontend\PagesController@marketplace')->name('frontend.page.marketplace');
Route::get('/introDetail.html', 'Frontend\PagesController@introDetail')->name('frontend.page.introDetail');
Route::any('/dang-ky-tro-thanh-chuyen-gia', 'Frontend\PagesController@expertRegister')->name('frontend.page.registerExpert');

Route::get('/gioi-thieu.html', 'Frontend\PagesController@about')->name('frontend.pages.aboutNew');
Route::any('/tac-dong-xa-hoi', 'Frontend\PagesController@socialImpact')->name('frontend.page.socialImpact');
Route::any('/nghe-nghiep', 'Frontend\PagesController@careers')->name('frontend.page.careers');
Route::any('/dieu-khoan-tin-cay', 'Frontend\PagesController@trustCenter')->name('frontend.page.trustCenter');
Route::any('/ai', 'Frontend\PagesController@ai')->name('frontend.page.ai');
Route::any('/neztwork_team', 'Frontend\PagesController@neztwork_team')->name('frontend.page.neztwork_team');


Route::get('webview/{id}', 'Frontend\PostsController@webviewDetail')->name('post.webview.detail');
Route::get('webview/product/{id}', 'Frontend\ProductController@webviewDetail')->name('product.webview.detail');
Route::any('/api/quickom/oauth2/verify', 'Api\HomeController@oauth2')->name('quickom.oauth2.verify');

Route::group(['prefix' => 'tai-khoan'], function () {

    Route::any('/dang-nhap', 'Frontend\UserController@login')->name('frontend.user.login');
    Route::any('/dang-ky', 'Frontend\UserController@register')->name('frontend.user.register');
    Route::any('/bank', 'Frontend\UserController@bank')->name('frontend.user.bank');
    Route::any('/activate/{token}', 'Frontend\UserController@activate')->name('frontend.user.activate');

    Route::any('/forgot-password', 'Frontend\UserController@forgotPassword')->name('frontend.user.forgotPassword');
    Route::any('/reset-password/{token}', 'Frontend\UserController@resetPassword')->name('frontend.user.resetPassword');

    Route::group(['middleware' => 'frontend'], function () {
        Route::any('/cap-nhat-thong-tin.html', 'Frontend\UserController@index')->name('frontend.user.account');
        Route::any('/thong-tin-tai-khoan.html', 'Frontend\UserController@profile')->name('frontend.user.profile');
        Route::any('/anh.html', 'Frontend\UserController@avatar')->name('frontend.user.avatar');
        Route::any('/order', 'Frontend\UserController@order')->name('frontend.user.order');
        Route::any('/address', 'Frontend\UserController@address')->name('frontend.user.address');
        Route::any('/address/edit/{id}', 'Frontend\UserController@editAddress')->name('frontend.user.editAddress');
        Route::any('/dang-xuat', 'Frontend\UserController@logout')->name('frontend.user.logout');
        Route::any('/doi-mat-khau.html', 'Frontend\UserController@changePassword')->name('frontend.user.changePassword');
        Route::any('/dang-ky-chuyen-gia', 'Frontend\UserController@registerExpert')->name('frontend.user.registerExpert');
        Route::any('/lich-su-dat-lich', 'Frontend\UserController@bookingHistory')->name('frontend.user.bookingHistory');
        Route::any('/thong-bao', 'Frontend\UserController@notification')->name('frontend.user.notification');
        // đánh giá của user
        Route::any('/danh-sach-hoi-nghi.html', 'Frontend\UserController@conference')->name('frontend.user.conference');

        //chuyên gia phê duyệt đặt lịch
        Route::any('/phe-duyet/{id}', 'Frontend\UserController@check')->name('frontend.user.check');
        Route::any('/duyet/{id}', 'Frontend\UserController@approve')->name('frontend.user.approve');
        Route::any('/tu-choi/{id}', 'Frontend\UserController@reject')->name('frontend.user.reject');
        Route::any('/negotiatetime/{id}', 'Frontend\UserController@negotiatetime')->name('frontend.user.month.negotiatetime');




        Route::any('/thuong-luong-lai/{id}', 'Frontend\UserController@timeNegotiate')->name('frontend.user.timeNegotiate');

        //
        //Khách hàng phê duyệt đặt lịch
        Route::any('/duyet-dat-lich/{id}', 'Frontend\UserController@userApprove')->name('frontend.user.userApprove');
        Route::any('/huy-dat-lich/{id}', 'Frontend\UserController@UserCancel')->name('frontend.user.UserCancel');
        //Khách hàng phê duyệt thương lượng lại
        Route::any('/duyet-thuong-luong/{id}', 'Frontend\UserController@userApproveNegotiate')->name('frontend.user.userApproveNegotiate');
        Route::any('/huy-thuong-luong/{id}', 'Frontend\UserController@UserCancelNegotiate')->name('frontend.user.UserCancelNegotiate');

        //
        Route::any('/cai-dat-thoi-gian', 'Frontend\SettingController@SettingTime')->name('frontend.user.setting.time');
        Route::any('/change/type', 'Frontend\SettingController@ChangeType')->name('frontend.user.change.type.time');
        Route::any('/change/price', 'Frontend\SettingController@ChangePrice')->name('frontend.user.change.price.time');
        Route::any('/frame/time', 'Frontend\SettingController@FrameTime')->name('frontend.user.change.frame.time');
        Route::any('/end_call', 'Frontend\SettingController@endCall')->name('frontend.user.endCall');


        Route::group(['prefix' => 'youtube-chuyen-gia'], function () {
            Route::any('/', 'Frontend\YoutubeExpertController@index')->name('frontend.youtubeExpert.index');
            Route::any('/them', 'Frontend\YoutubeExpertController@add')->name('frontend.youtubeExpert.add');
            Route::any('/cap-nhat/{id}', 'Frontend\YoutubeExpertController@edit')->name('frontend.youtubeExpert.edit');
            Route::any('/xoa/{id}', 'Frontend\YoutubeExpertController@delete')->name('frontend.youtubeExpert.delete');
        });

        Route::group(['prefix' => 'tao-goi'], function () {
            Route::any('/', 'Frontend\ExpertPlanController@index')->name('frontend.plan.index');
            Route::any('/them', 'Frontend\ExpertPlanController@add')->name('frontend.plan.add');
            Route::any('/cap-nhat/{id}', 'Frontend\ExpertPlanController@edit')->name('frontend.plan.edit');
            Route::any('/xoa/{id}', 'Frontend\ExpertPlanController@delete')->name('frontend.plan.delete');
        });



        Route::group(['prefix' => 'video-ngan'], function () {
            Route::any('/', 'Frontend\ShortVideoExpertController@index')->name('frontend.shortVideoExpert.index');
            Route::any('/them', 'Frontend\ShortVideoExpertController@add')->name('frontend.shortVideoExpert.add');
            Route::any('/cap-nhat/{id}', 'Frontend\ShortVideoExpertController@edit')->name('frontend.shortVideoExpert.edit');
            Route::any('/xoa/{id}', 'Frontend\ShortVideoExpertController@delete')->name('frontend.shortVideoExpert.delete');
        });


        Route::group(['prefix' => 'cau-hoi-chuyen-gia'], function () {
            Route::any('/', 'Frontend\QuestionExpertController@index')->name('frontend.questionExpert.index');
            Route::any('/them', 'Frontend\QuestionExpertController@add')->name('frontend.questionExpert.add');
            Route::any('/cap-nhat/{id}', 'Frontend\QuestionExpertController@edit')->name('frontend.questionExpert.edit');
            Route::any('/xoa/{id}', 'Frontend\QuestionExpertController@delete')->name('frontend.questionExpert.delete');
        });


        Route::group(['prefix' => 'danh-gia'], function () {
            Route::any('/', 'Frontend\RatingController@index')->name('frontend.rating.index');
            Route::any('/them/{id}', 'Frontend\RatingController@add')->name('frontend.rating.add');
            Route::any('/chi-tiet/{id}', 'Frontend\RatingController@detail')->name('frontend.rating.detail');
        });


        Route::group(['prefix' => 'switchAccount'], function () {
            Route::any('/switch-to-student', 'Frontend\AccountSwitchController@switchToStudent')->name('frontend.switchAccount.switchToStudent');
            Route::any('/switch-to-expert', 'Frontend\AccountSwitchController@switchToExpert')->name('frontend.switchAccount.switchToExpert');
        });
    });
});



Route::group(['prefix' => 'brand'], function () {
    Route::get('/', 'Backend\Branch\BranchController@index')->name('backend.brands.index');
    Route::get('/create', 'Backend\Branch\BranchController@create')->name('backend.brands.create');
    Route::post('/store', 'Backend\Branch\BranchController@store')->name('backend.brands.store');
    Route::post('/ajax-wareHouse', 'Backend\Branch\BranchController@ajaxWareHouse')->name('backend.brands.ajaxWareHouse');
    Route::get('/edit/{id}', 'Backend\Branch\BranchController@edit')->name('backend.brands.edit');
    Route::post('/update/{id}', 'Backend\Branch\BranchController@update')->name('backend.brands.update');
    Route::post('/delete', 'Backend\Branch\BranchController@destroy')->name('backend.brands.delete');
});

Route::group(['prefix' => 'debt'], function () {
    Route::get('/', 'Backend\DebtController@index')->name('backend.debt.index');
    Route::get('/detail/{id}', 'Backend\DebtController@detail')->name('backend.debt.detail');
    Route::get('/delete', 'Backend\DebtController@destroy')->name('backend.debt.delete');
});
//Route::group(['prefix' => 'debtDetail'], function () {
//    Route::get('/', 'Backend\DebtDetailController@index')->name('backend.debtDetail.index');
//    Route::post('/detail', 'Backend\DebtDetailController@detail')->name('backend.debtDetail.detail');
//    Route::post('/delete', 'Backend\DebtDetailController@destroy')->name('backend.debt.delete');
//});

Route::get('sitemap.xml', function () {
    $sitemap = App::make('sitemap');
    $sitemap->setCache('laravel.sitemap', 60);
    // check if there is cached sitemap and build new only if is not

    if (!$sitemap->isCached()) {

        // add item to the sitemap (url, date, priority, freq)

        $sitemap->add(URL::to('/'), '2012-08-25T20:10:00+02:00', '1.0', 'daily');

        $sitemap->add(route('frontend.product.main'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
        $sitemap->add(route('frontend.page.about'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
        $sitemap->add(route('frontend.news.main'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
        $all_category_db = ProductType::get_by_where([
            'status' => 1,
            'assign_key' => true,
        ]);

        $category_tree = Category::buildTreeType($all_category_db);

        $all_category = Category::tree_to_array($category_tree);

        \View::share('category_tree', $category_tree);
        \View::share('all_category', $all_category);

        foreach ($all_category as $cate) {
            $sitemap->add(url($cate['link']), $cate['created_at'], '0.8', 'monthly');
        }

        $products = App\Models\Product::get_by_where([
            'status' => 1,
            'limit' => 1000,
        ]);

        foreach ($products as $product) {
            $sitemap->add(url(product_link($product->slug, $product->id, $product->product_type_id)), $product->created_at, '0.8', 'monthly');
        }

        $posts = App\Models\Post::get_by_where([
            'status' => App\Models\Post::STATUS_SHOW,
            'limit' => 1000,
        ]);

        // add every post to the sitemap
        foreach ($posts as $post) {
            $sitemap->add(url($post->post_link()), $post->created_at, '0.8', 'monthly');
        }
    }
    return $sitemap->render('xml');
});

Route::group(['prefix' => 'tin-tuc-&-bai-viet'], function () {
    Route::any('/', 'Frontend\NewsController@main')->name('frontend.news.main');

    Route::get('/{slug}', 'Frontend\NewsController@route')
        ->name('frontend.news.route')
        ->where('slug', '(.*)');
});





Route::group(['prefix' => 'thanh-toan-vnpay'], function () {
    Route::any('/create', 'Payment\VnpayController@create')->name('payment.create');
    Route::any('/vnpay-return', 'Payment\VnpayController@vnpayReturn')->name('payment.vnpayReturn');
    Route::any('/ipn', 'Payment\VnpayController@ipn')->name('payment.ipn');
    Route::any('/refund', 'Payment\VnpayController@refund')->name('payment.refund');
});

// viết bài expert


Route::group(['prefix' => 'bai-viet-chuyen-gia'], function () {
    Route::any('/', 'Frontend\BlogExpertController@main')->name('frontend.blogExpert.main');
    Route::any('/quan-ly-bai-viet', 'Frontend\BlogExpertController@index')->name('frontend.blogExpert.index');
    Route::any('/dang-bai', 'Frontend\BlogExpertController@create')->name('frontend.blogExpert.create');
    Route::any('/sua-bai/{id}', 'Frontend\BlogExpertController@edit')->name('frontend.blogExpert.edit');
    Route::any('/xoa-bai/{id}', 'Frontend\BlogExpertController@delete')->name('frontend.blogExpert.delete');
    Route::get('/{slug}', 'Frontend\BlogExpertController@detail')->name('frontend.blogExpert.detail');
    Route::get('/danh-muc/{slug}', 'Frontend\BlogExpertController@categories')->name('frontend.blogExpert.categories');
    Route::post('/binh-luan/{id}', 'Frontend\BlogExpertController@comment')->name('frontend.blogExpert.comment');
    Route::post('/thich/{id}', 'Frontend\BlogExpertController@like')->name('frontend.blogExpert.like');
    Route::post('/bo-thich/{id}', 'Frontend\BlogExpertController@unLike')->name('frontend.blogExpert.unLike');
});


Route::group(['prefix' => 'ho-so-chuyen-gia-khac'], function () {
    Route::any('/', 'Frontend\ExpertProfileOrtherController@index')->name('frontend.profileOrther.index');
    Route::any('/them', 'Frontend\ExpertProfileOrtherController@create')->name('frontend.profileOrther.create');
    Route::any('/cap-nhap/{id}', 'Frontend\ExpertProfileOrtherController@edit')->name('frontend.profileOrther.edit');
    Route::any('/xoa/{id}', 'Frontend\ExpertProfileOrtherController@delete')->name('frontend.profileOrther.delete');
});

Route::group(['prefix' => 'vi'], function () {
    Route::any('/', 'Frontend\WalletExpertController@index')->name('frontend.wallet.index');
    Route::any('/lich-su', 'Frontend\WalletExpertController@history')->name('frontend.wallet.history');
});


Route::group(['prefix' => 'chinh-sach'], function () {
    Route::any('/', 'Frontend\PolicyController@main')->name('frontend.policy.main');

    Route::get('/{slug}', 'Frontend\PolicyController@route')
        ->name('frontend.policy.route')
        ->where('slug', '(.*)');
});

Route::get('/{slug}', 'Frontend\ProductController@route')
    ->name('frontend.product.route')
    ->where('slug', '(.*)');
