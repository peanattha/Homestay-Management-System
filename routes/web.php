<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomestayController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ApplianceController;
use App\Http\Controllers\WindenController;

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

Auth::routes(['verify' => true]);

Route::controller(HomeController::class)->group(function () {
    Route::get('/', "index")->name("home");
    Route::get('/accommodation-rules', "accommodation_rules")->name("accommodation-rules");
    Route::get('/description-details', "description_details")->name("description-details");
    Route::get('/service-charge', "service_charge")->name("service-charge");
    Route::get('/homestay', "homestay")->name("homestay");
});

// Users
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', "profile")->name('profile');
        Route::post('/edit-profile/{id}', "edit")->name('edit-profile');
        Route::post('/change-password', "changePassword")->name('change-password');
        Route::post('/delete-account', "delete")->name('delete-account');
    });
    Route::controller(BookingController::class)->group(function () {
        Route::get('/booking-history', "history")->name('booking-history');
        Route::get('/booking-history-details/{id}', "history_details")->name('booking-history-details');
        Route::post('/payment', "payment")->name('payment');
    });
    Route::controller(HomestayController::class)->group(function () {
        Route::get('/homestay-details-user/{id}/{date}/{guests}', "homestay_details_user")->name('homestay-details-user');
        Route::post('/search-homestay', "search_homestay")->name('search-homestay');
    });
});

// Admin
Route::group(['middleware' => ['auth', 'verified', 'CheckAdmin']], function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile-admin', "profile_admin")->name('profile-admin');
    });
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/dashboard', "dashboard")->name('admin-dashboard');
        Route::get('/manage-admin', "manage")->name('manage-admin');
        Route::post('/delete-admin', "delete")->name('delete-admin');
        Route::post('/add-admin', "add")->name('add-admin');
    });
    Route::controller(MenuController::class)->group(function () {
        Route::get('/manage-menu', "manage_menu")->name('manage-menu');
        Route::post('/add-menu', "add_menu")->name('add-menu');
        Route::get('/menu-details/{id}', "menu_details")->name('menu-details');
        Route::post('/delete-menu/{id}', "delete_menu")->name('delete-menu');
        Route::post('/delete-img-menu/{id}/{menu_img}', "delete_img")->name('delete-img-menu');
        Route::post('/edit-menu/{id}', "edit_menu")->name('edit-menu');
        Route::post('/search-set-menu', "search_set_menu")->name('search-set-menu');
    });

    Route::controller(HomestayController::class)->group(function () {
        Route::get('/manage-homestay', "manage_homestay")->name('manage-homestay');
        Route::get('/manage-homestay-type', "manage_homestay_type")->name('manage-homestay-type');
        Route::post('/add-homestay-type', "add_homestay_type")->name('add-homestay-type');
        Route::post('/delete-homestay-type/{id}', "delete_homestay_type")->name('delete-homestay-type');
        Route::post('/edit-homestay-type', "edit_homestay_type")->name('edit-homestay-type');
        Route::post('/add-homestay', "add_homestay")->name('add-homestay');
        Route::post('/delete-homestay/{id}', "delete_homestay")->name('delete-homestay');
        Route::get('/homestay-details-admin/{id}', "homestay_details_admin")->name('homestay-details-admin');
        Route::post('/delete-img/{id}/{name_img}', "delete_img")->name('delete-img');
        Route::post('/edit-homestay/{id}', "edit_homestay")->name('edit-homestay');
        Route::get('/homestay-admin', "homestay_admin")->name('homestay-admin');
        Route::post('/search-homestay-admin', "search_homestay_admin")->name('search-homestay-admin');
    });

    Route::controller(BankController::class)->group(function () {
        Route::get('/manage-bank', "manage_bank")->name('manage-bank');
        Route::post('/add-bank', "add_bank")->name('add-bank');
        Route::post('/delete-bank/{id}', "delete_bank")->name('delete-bank');
        Route::post('/edit-bank/{id}', "edit_bank")->name('edit-bank');
    });

    Route::controller(BookingController::class)->group(function () {
        Route::get('/booking-admin', "booking_admin")->name('booking-admin');
        Route::get('/confirm-booking', "confirm_booking")->name('confirm-booking');
        Route::get('/confirm-pay-admin/{id}', "confirm_pay_admin")->name('confirm-pay-admin');
        Route::get('/cancel-pay-admin/{id}', "cancel_pay_admin")->name('cancel-pay-admin');
        Route::get('/confirm-cancel-booking', "confirm_cancel_booking")->name('confirm-cancel-booking');
        Route::post('/search-confirm-booking', "search_confirm_booking")->name('search-confirm-booking');
        Route::post('/search-confirm-cancel', "search_confirm_cancel")->name('search-confirm-cancel');
        Route::post('/search-booking-admin', "search_booking_admin")->name('search-booking-admin');
        Route::get('/check-in-admin', "show_check_in")->name('check-in-admin');
        Route::get('/check-out-admin', "show_check_out")->name('check-out-admin');
        Route::get('/check-in/{id}', "check_in")->name('check-in');
        Route::get('/check-out/{id}', "check_out")->name('check-out');
        Route::post('/search-check-in', "search_check_in")->name('search-check-in');
        Route::post('/search-check-out', "search_check_out")->name('search-check-out');
        Route::get('/booking-detail/{id}', "booking_detail")->name('booking-detail');
    });

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/manage-customer', "manage_customer")->name('manage-customer');
        Route::post('/search-customer', "search_customer")->name('search-customer');
        Route::get('/customer-detail/{id}', "customer_detail")->name('customer-detail');
    });

    Route::controller(PromotionController::class)->group(function () {
        Route::get('/manage-promotion', "manage_promotion")->name('manage-promotion');
        Route::get('/promotion-admin', "promotion_admin")->name('promotion-admin');
        Route::get('/promotion-detail/{id}', "promotion_detail")->name('promotion-detail');
    });

    Route::controller(ReviewController::class)->group(function () {
        Route::get('/manage-review', "manage_review")->name('manage-review');
        Route::get('/review-admin', "review_admin")->name('review-admin');
        Route::get('/review-detail/{id}', "review_detail")->name('review-detail');
    });

    Route::controller(ApplianceController::class)->group(function () {
        Route::get('/manage-appliance', "manage_appliance")->name('manage-appliance');

    });

    Route::controller(WindenController::class)->group(function () {
        Route::get('/winden-appliance-booking', "manage_appliance_booking")->name('manage-appliance-booking');
        Route::get('/winden-appliance-homestay', "manage_appliance_homestay")->name('manage-appliance-homestay');
        
        Route::get('/appliance-homestay-detail/{id}', "appliance_homestay_detail")->name('appliance-homestay-detail');
        Route::get('/appliance-booking-detail/{id}', "appliance_booking_detail")->name('appliance-booking-detail');
    });
});
