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
        Route::post('/booking-user', "booking_user")->name('booking-user');
        Route::post('/add-booking-user', "add_booking_user")->name('add-booking-user');
        Route::get('/show-payment/{id}', "show_payment")->name('show-payment');
        Route::post('/payment', "payment")->name('payment');
        Route::post('/cancel-pay-user/{id}', "cancel_pay_user")->name('cancel-pay-user');
        Route::get('/change-status-payment/{id}', "change_status_payment")->name('change-status-payment');
    });
    Route::controller(HomestayController::class)->group(function () {
        Route::get('/homestay-details-user/{id}', "homestay_details_user")->name('homestay-details-user');
        Route::post('/search-homestay', "search_homestay")->name('search-homestay');
    });
    Route::controller(ReviewController::class)->group(function () {
        Route::post('/delete-review/{id}', "delete_review")->name('delete-review');
        Route::post('/edit-review/{id}', "edit_review")->name('edit-review');
        Route::post('/add-review/{id}', "add_review")->name('add-review');
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
        Route::get('/manage-bank-name', "manage_bank_name")->name('manage-bank-name');
        Route::post('/add-bank-name', "add_bank_name")->name('add-bank-name');
        Route::post('/edit-bank-name', "edit_bank_name")->name('edit-bank-name');
        Route::post('/delete-bank-name/{id}', "delete_bank_name")->name('delete-bank-name');
    });

    Route::controller(BookingController::class)->group(function () {
        Route::get('/booking-admin', "booking_admin")->name('booking-admin');
        Route::get('/confirm-booking', "confirm_booking")->name('confirm-booking');
        Route::post('/confirm-pay-admin', "confirm_pay_admin")->name('confirm-pay-admin');
        Route::post('/cancel-pay-admin/{id}', "cancel_pay_admin")->name('cancel-pay-admin');
        Route::get('/confirm-cancel-booking', "confirm_cancel_booking")->name('confirm-cancel-booking');
        Route::post('/search-confirm-booking', "search_confirm_booking")->name('search-confirm-booking');
        Route::post('/search-confirm-cancel', "search_confirm_cancel")->name('search-confirm-cancel');
        Route::post('/search-booking-admin', "search_booking_admin")->name('search-booking-admin');
        Route::get('/check-in-admin', "show_check_in")->name('check-in-admin');
        Route::get('/check-out-admin', "show_check_out")->name('check-out-admin');
        Route::post('/check-in', "check_in")->name('check-in');
        Route::post('/check-out', "check_out")->name('check-out');
        Route::post('/search-check-in', "search_check_in")->name('search-check-in');
        Route::post('/search-check-out', "search_check_out")->name('search-check-out');
        Route::get('/booking-detail/{id}', "booking_detail")->name('booking-detail');
        Route::get('/add-booking-admin', "add_booking_admin")->name('add-booking-admin');
        Route::get('/calendar-booking', "calendar_booking")->name('calendar-booking');
        Route::post('/add-booking', "add_booking")->name('add-booking');
    });

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/manage-customer', "manage_customer")->name('manage-customer');
        Route::post('/search-customer', "search_customer")->name('search-customer');
        Route::get('/customer-detail/{id}', "customer_detail")->name('customer-detail');
        Route::post('/add-customer', "add_customer")->name('add-customer');
        Route::post('/delete-customer/{id}', "delete_customer")->name('delete-customer');
    });

    Route::controller(PromotionController::class)->group(function () {
        Route::get('/manage-promotion', "manage_promotion")->name('manage-promotion');
        Route::get('/promotion-detail/{id}', "promotion_detail")->name('promotion-detail');
        Route::post('/add-promotion', "add_promotion")->name('add-promotion');
        Route::post('/edit-promotion/{id}', "edit_promotion")->name('edit-promotion');
        Route::post('/delete-promotion/{id}', "delete_promotion")->name('delete-promotion');
        Route::post('/search-promotion', "search_promotion")->name('search-promotion');
        Route::post('/promotion-filter', "promotion_filter")->name('promotion-filter');
    });

    Route::controller(ReviewController::class)->group(function () {
        Route::get('/manage-review', "manage_review")->name('manage-review');
        Route::get('/review-admin', "review_admin")->name('review-admin');
        Route::get('/review-detail/{id}', "review_detail")->name('review-detail');
    });

    Route::controller(ApplianceController::class)->group(function () {
        Route::get('/manage-appliance', "manage_appliance")->name('manage-appliance');
        Route::post('/add-appliance', "add_appliance")->name('add-appliance');
        Route::post('/edit-appliance', "edit_appliance")->name('edit-appliance');
        Route::post('/delete-appliance/{id}', "delete_appliance")->name('delete-appliance');
    });

    Route::controller(WindenController::class)->group(function () {
        Route::get('/winden-appliance-booking', "manage_appliance_booking")->name('manage-appliance-booking');
        Route::get('/winden-appliance-homestay', "manage_appliance_homestay")->name('manage-appliance-homestay');

        Route::get('/appliance-homestay-detail/{id}', "appliance_homestay_detail")->name('appliance-homestay-detail');
        Route::get('/appliance-booking-detail/{id}', "appliance_booking_detail")->name('appliance-booking-detail');
    });
});
