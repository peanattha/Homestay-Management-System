<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\homestay_type;
use App\Models\homestay;
use App\Models\user;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function history()
    {
        $bookings = booking::where('user_id', Auth::user()->id)->get();
        return view('user.booking-history', compact('bookings'));
    }
    public function payment(Request $request)
    {

        return view('user.payment');
    }
    public function history_details($id)
    {
        
        return view('user.booking-history-details');
    }

    ////////////////////

    public function booking_admin()
    {
        $bookings = booking::all();
        return view('admin.booking-admin', compact('bookings'));
    }
    public function booking_detail($id)
    {
        $booking = booking::find($id);
        $homestay_types = homestay_type::all();
        $homestays = homestay::all();
        return view('admin.booking-detail', compact('booking', 'homestay_types', 'homestays'));
    }
    public function confirm_booking()
    {
        $bookings = booking::where('status', 6)->get(); //รอยืนยันการชำระเงิน
        return view('admin.confirm-booking', compact('bookings'));
    }
    public function confirm_cancel_booking()
    {
        $bookings = booking::where('status', 7)->get(); //รอยืนยันยกเลิกการจอง
        return view('admin.confirm-cancel-booking', compact('bookings'));
    }
    public function confirm_pay_admin($id)
    {
        $update_homestay = booking::find($id);
        $update_homestay->status = 3; //รอ check in ชำระเงินมัดจำเสร็จสิ้น
        $update_homestay->save();
        return redirect()->back();
    }
    public function cancel_pay_admin($id)
    {
        $update_homestay = booking::find($id);
        $update_homestay->status = 4;  //ยกเลิกการจอง
        $update_homestay->save();

        return redirect()->back();
    }
    public function search_confirm_booking(Request $request)
    {
        if (isset($request->booking_id)) {
            $bookings = booking::where('id', $request->booking_id)->get();
            if (($bookings->count() == 0)) {
                return redirect()->route('confirm-booking')->with('error', 'ไม่มีรายการค้นหา');;
            }
        } else if (isset($request->firstName) && isset($request->lastName)) {
            $firstName = user::where('firstName', $request->firstName)->get();
            $lastName = user::where('lastName', $request->lastName)->get();
            if (($firstName->count() == 0) && ($firstName->count() == 0)) {
                return redirect()->route('confirm-booking')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('firstName', $request->firstName)
                    ->where('lastName', $request->lastName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 6) //รอยืนยันการชำระเงิน
                ->where('user_id', $user_id)->get();
        } else if (isset($request->firstName)) {
            $firstName = user::where('firstName', $request->firstName)->get();
            if ($firstName->count() == 0) {
                return redirect()->route('confirm-booking')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('firstName', $request->firstName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 6) //รอยืนยันการชำระเงิน
                ->where('user_id', $user_id)->get();
        } else if (isset($request->lastName)) {
            $lastName = user::where('lastName', $request->lastName)->get();
            if ($lastName->count() == 0) {
                return redirect()->route('confirm-booking')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('lastName', $request->lastName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 6) //รอยืนยันการชำระเงิน
                ->where('user_id', $user_id)->get();
        } else {
            $bookings = booking::where('status', 6)->get(); //รอยืนยันการชำระเงิน
        }
        return view('admin.confirm-booking', compact('bookings'));
    }
    public function search_confirm_cancel(Request $request)
    {
        if (isset($request->booking_id)) {
            $bookings = booking::where('id', $request->booking_id)->get();
            if (($bookings->count() == 0)) {
                return redirect()->route('confirm-cancel-booking')->with('error', 'ไม่มีรายการค้นหา');;
            }
        } else if (isset($request->firstName) && isset($request->lastName)) {
            $firstName = user::where('firstName', $request->firstName)->get();
            $lastName = user::where('lastName', $request->lastName)->get();
            if (($firstName->count() == 0) && ($firstName->count() == 0)) {
                return redirect()->route('confirm-cancel-booking')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('firstName', $request->firstName)
                    ->where('lastName', $request->lastName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 7) //รอยืนยันยกเลิกการจอง
                ->where('user_id', $user_id)->get();
        } else if (isset($request->firstName)) {
            $firstName = user::where('firstName', $request->firstName)->get();
            if ($firstName->count() == 0) {
                return redirect()->route('confirm-cancel-booking')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('firstName', $request->firstName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 7) //รอยืนยันยกเลิกการจอง
                ->where('user_id', $user_id)->get();
        } else if (isset($request->lastName)) {
            $lastName = user::where('lastName', $request->lastName)->get();
            if ($lastName->count() == 0) {
                return redirect()->route('confirm-cancel-booking')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('lastName', $request->lastName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 7) //รอยืนยันยกเลิกการจอง
                ->where('user_id', $user_id)->get();
        } else {
            $bookings = booking::where('status', 7)->get(); //รอยืนยันยกเลิกการจอง
        }
        return view('admin.confirm-cancel-booking', compact('bookings'));
    }
    public function search_booking_admin(Request $request)
    {
        if (isset($request->booking_id)) {
            $bookings = booking::where('id', $request->booking_id)->get();
            if (($bookings->count() == 0)) {
                return redirect()->route('booking-admin')->with('error', 'ไม่มีรายการค้นหา');;
            }
        } else if (isset($request->firstName) && isset($request->lastName)) {
            $firstName = user::where('firstName', $request->firstName)->get();
            $lastName = user::where('lastName', $request->lastName)->get();
            if (($firstName->count() == 0) && ($firstName->count() == 0)) {
                return redirect()->route('booking-admin')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('firstName', $request->firstName)
                    ->where('lastName', $request->lastName)
                    ->first()->id;
            }
            $bookings = booking::where('user_id', $user_id)->get();
        } else if (isset($request->firstName)) {
            $firstName = user::where('firstName', $request->firstName)->get();
            if ($firstName->count() == 0) {
                return redirect()->route('booking-admin')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('firstName', $request->firstName)
                    ->first()->id;
            }
            $bookings = booking::where('user_id', $user_id)->get();
        } else if (isset($request->lastName)) {
            $lastName = user::where('lastName', $request->lastName)->get();
            if ($lastName->count() == 0) {
                return redirect()->route('booking-admin')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('lastName', $request->lastName)
                    ->first()->id;
            }
            $bookings = booking::where('user_id', $user_id)->get();
        } else {
            $bookings = booking::all();
        }
        return view('admin.booking-admin', compact('bookings'));
    }
    public function show_check_in(Request $request)
    {
        $bookings = booking::where('status', 3)->get();  //รอ Check-In ยืนยันจ่ายเงินเเล้ว
        return view('admin.check-in', compact('bookings'));
    }
    public function search_check_in(Request $request)
    {
        if (isset($request->booking_id)) {
            $bookings = booking::where('id', $request->booking_id)->get();
            if (($bookings->count() == 0)) {
                return redirect()->route('check-in-admin')->with('error', 'ไม่มีรายการค้นหา');;
            }
        } else if (isset($request->firstName) && isset($request->lastName)) {
            $firstName = user::where('firstName', $request->firstName)->get();
            $lastName = user::where('lastName', $request->lastName)->get();
            if (($firstName->count() == 0) && ($firstName->count() == 0)) {
                return redirect()->route('check-in-admin')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('firstName', $request->firstName)
                    ->where('lastName', $request->lastName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 3) //รอ Check-In
                ->where('payment_status', 1) //รอยืนยันการชำระเงิน
                ->where('user_id', $user_id)->get();
        } else if (isset($request->firstName)) {
            $firstName = user::where('firstName', $request->firstName)->get();
            if ($firstName->count() == 0) {
                return redirect()->route('check-in-admin')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('firstName', $request->firstName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 3) //รอ Check-In
                ->where('payment_status', 1) //รอยืนยันการชำระเงิน
                ->where('user_id', $user_id)->get();
        } else if (isset($request->lastName)) {
            $lastName = user::where('lastName', $request->lastName)->get();
            if ($lastName->count() == 0) {
                return redirect()->route('check-in-admin')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('lastName', $request->lastName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 3) //รอ Check-In
                ->where('payment_status', 1) //รอยืนยันการชำระเงิน
                ->where('user_id', $user_id)->get();
        } else {
            $bookings = booking::where('status', 3) //รอ Check-In
                ->where('payment_status', 1)->get(); //รอยืนยันการชำระเงิน
        }
        return view('admin.check-in', compact('bookings'));
    }
    public function show_check_out(Request $request)
    {
        $bookings = booking::where('status', 1)->get(); //Check-In เเล้ว
        return view('admin.check-out', compact('bookings'));
    }
    public function search_check_out(Request $request)
    {
        if (isset($request->booking_id)) {
            $bookings = booking::where('id', $request->booking_id)->get();
            if (($bookings->count() == 0)) {
                return redirect()->route('check-out-admin')->with('error', 'ไม่มีรายการค้นหา');;
            }
        } else if (isset($request->firstName) && isset($request->lastName)) {
            $firstName = user::where('firstName', $request->firstName)->get();
            $lastName = user::where('lastName', $request->lastName)->get();
            if (($firstName->count() == 0) && ($firstName->count() == 0)) {
                return redirect()->route('check-out-admin')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('firstName', $request->firstName)
                    ->where('lastName', $request->lastName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 1) //Check-In เเล้ว
                ->where('user_id', $user_id)->get();
        } else if (isset($request->firstName)) {
            $firstName = user::where('firstName', $request->firstName)->get();
            if ($firstName->count() == 0) {
                return redirect()->route('check-out-admin')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('firstName', $request->firstName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 1) //Check-In เเล้ว
                ->where('user_id', $user_id)->get();
        } else if (isset($request->lastName)) {
            $lastName = user::where('lastName', $request->lastName)->get();
            if ($lastName->count() == 0) {
                return redirect()->route('check-out-admin')->with('error', 'ไม่มีรายการค้นหา');;
            } else {
                $user_id = DB::table('users')
                    ->where('lastName', $request->lastName)
                    ->first()->id;
            }
            $bookings = booking::where('status', 1) //Check-In เเล้ว
                ->where('user_id', $user_id)->get();
        } else {
            $bookings = booking::where('status', 1)->get(); //Check-In เเล้ว

        }
        return view('admin.check-out', compact('bookings'));
    }
    public function check_in($id)
    {
        $now = Carbon::now();
        $update_homestay = booking::find($id);
        $update_homestay->check_in = $now;
        $update_homestay->status = 1; //Check In
        $update_homestay->save();
        return redirect()->back();
    }
    public function check_out($id)
    {
        $now = Carbon::now();
        $update_homestay = booking::find($id);
        $update_homestay->check_out = $now;
        $update_homestay->status = 2; //Check Out
        $update_homestay->save();
        return redirect()->back();
    }
}
