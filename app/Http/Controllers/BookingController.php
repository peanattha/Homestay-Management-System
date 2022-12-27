<?php

namespace App\Http\Controllers;

use App\Models\appliance;
use App\Models\booking;
use App\Models\booking_detail;
use App\Models\homestay;
use App\Models\payment;
use App\Models\promotion;
use App\Models\set_menu;
use App\Models\widen;
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

    // Admin
    public function booking_admin()
    {
        $bookings = booking::orderBy('created_at', 'desc')->get();
        return view('admin.booking-admin', compact('bookings'));
    }
    public function booking_detail($id)
    {
        $booking = booking::find($id);
        $homestays = homestay::all();
        $set_menus = set_menu::all();
        $promotions = promotion::all();
        $widens = widen::where('booking_id', $id)->get();
        $appliances = appliance::all();

        $answers = collect([]);
        foreach ($booking as $info) {
            $booking_details = booking_detail::where('booking_id', $id)->get();
            foreach ($booking_details as $booking_detail) {
                $answers->push($booking_detail->homestay_id);
            }
        }

        $homestaysN = DB::table('homestays')->whereNotIn('id', $answers)->get();

        return view('admin.booking-detail', compact('booking', 'set_menus', 'promotions', 'homestays', 'widens', 'appliances', 'homestaysN'));
    }
    public function confirm_booking()
    {
        $bookings = booking::where('status', 6)
            ->orderBy('created_at', 'asc')->get(); //รอยืนยันการชำระเงิน
        $set_menus = set_menu::all();
        $promotions = promotion::all();
        return view('admin.confirm-booking', compact('bookings', 'set_menus', 'promotions'));
    }
    public function confirm_cancel_booking()
    {
        $bookings = booking::where('status', 7)
            ->orderBy('start_date', 'asc')->get(); //รอยืนยันยกเลิกการจอง
        return view('admin.confirm-cancel-booking', compact('bookings'));
    }
    public function confirm_pay_admin(Request $request)
    {
        $update_homestay = booking::find($request->idConfirmPay);
        $update_homestay->status = 3; //รอ check in ชำระเงินมัดจำเสร็จสิ้น
        $update_homestay->save();
        return redirect()->back()->with('message', "ยืนยันการจองเสร็จสิ้น");
    }
    public function cancel_pay_admin($id)
    {
        $update_homestay = booking::find($id);
        $update_homestay->status = 4;  //ยกเลิกการจอง
        $update_homestay->save();

        return redirect()->back()->with('message', "ยกเลิกการจองเสร็จสิ้น");
    }

    //ตรวจสอบเเล้ว 19/12/65
    public function search_confirm_booking(Request $request)
    {
        // ถ้าค้นหาโดยid
        if (isset($request->booking_id)) {
            $bookings = booking::where('id', $request->booking_id)
                ->where('status', 6)->get(); //รอยืนยันการชำระเงิน
            // เจอ
            if (($bookings->count() == 0)) {
                return redirect()->route('confirm-booking')->with('warning', 'ไม่มีรายการค้นหา');
                // ไม่เจอ
            } else {
                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.confirm-booking', compact('bookings', 'promotions', 'set_menus'));
            }
            // ค้าหา ทั้งชื่อเเละนามสกุล
        } else if (isset($request->firstName) && isset($request->lastName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(firstName)'), strtolower($request->firstName))
                ->where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();

            //ถ้าชื่อเเละนามสกุลไม่ตรง
            if ($users->count() == 0) {
                return redirect()->route('confirm-booking')->with('warning', 'ไม่มีรายการค้นหา');
                // ถ้า ชื่อเเละนามสกลุตรง
            } else {
                $bookings = booking::where('status', 6) //รอยืนยันการชำระเงิน
                    ->whereIn('user_id', $users)->get();

                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.confirm-booking', compact('bookings', 'promotions', 'set_menus'));
            }
            // ค้นหาเเค่ชื่อ
        } else if (isset($request->firstName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(firstName)'), strtolower($request->firstName))->get();
            if ($users->count() == 0) {
                return redirect()->route('confirm-booking')->with('warning', 'ไม่มีรายการค้นหาสำหรับชื่อนี้');
            } else {
                $bookings = booking::where('status', 6) //รอยืนยันการชำระเงิน
                    ->whereIn('user_id', $users)->get();

                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.confirm-booking', compact('bookings', 'promotions', 'set_menus'));
            }
            // ค้นหาเเค่นามสกุล
        } else if (isset($request->lastName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();
            if ($users->count() == 0) {
                return redirect()->route('confirm-booking')->with('warning', 'ไม่มีรายการค้นหาสำหรับนามสกุลนี้');
            } else {
                $bookings = booking::where('status', 6) //รอยืนยันการชำระเงิน
                    ->whereIn('user_id', $users)->get();

                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.confirm-booking', compact('bookings', 'promotions', 'set_menus'));
            }
        } else {
            $bookings = booking::where('status', 6)->get(); //รอยืนยันการชำระเงิน
            $set_menus = set_menu::all();
            $promotions = promotion::all();
            return view('admin.confirm-booking', compact('bookings', 'promotions', 'set_menus'));
        }
    }

    //ตรวจสอบเเล้ว 19/12/65
    public function search_confirm_cancel(Request $request)
    {
        // ถ้าค้นหาโดยid
        if (isset($request->booking_id)) {
            $bookings = booking::where('id', $request->booking_id)
                ->where('status', 7)->get(); //รอยืนยันยกเลิกการจอง
            // เจอ
            if (($bookings->count() == 0)) {
                return redirect()->route('confirm-cancel-booking')->with('warning', 'ไม่มีรายการค้นหา');
                // ไม่เจอ
            } else {
                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.confirm-cancel-booking', compact('bookings', 'promotions', 'set_menus'));
            }
            // ค้าหา ทั้งชื่อเเละนามสกุล
        } else if (isset($request->firstName) && isset($request->lastName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(firstName)'), strtolower($request->firstName))
                ->where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();

            //ถ้าชื่อเเละนามสกุลไม่ตรง
            if ($users->count() == 0) {
                return redirect()->route('confirm-cancel-booking')->with('warning', 'ไม่มีรายการค้นหา');
                // ถ้า ชื่อเเละนามสกลุตรง
            } else {
                $bookings = booking::where('status', 7) //รอยืนยันยกเลิกการจอง
                    ->whereIn('user_id', $users)->get();

                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.confirm-cancel-booking', compact('bookings', 'promotions', 'set_menus'));
            }
            // ค้นหาเเค่ชื่อ
        } else if (isset($request->firstName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(firstName)'), strtolower($request->firstName))->get();
            if ($users->count() == 0) {
                return redirect()->route('confirm-cancel-booking')->with('warning', 'ไม่มีรายการค้นหาสำหรับชื่อนี้');
            } else {
                $bookings = booking::where('status', 7) //รอยืนยันยกเลิกการจอง
                    ->whereIn('user_id', $users)->get();

                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.confirm-cancel-booking', compact('bookings', 'promotions', 'set_menus'));
            }
            // ค้นหาเเค่นามสกุล
        } else if (isset($request->lastName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();
            if ($users->count() == 0) {
                return redirect()->route('confirm-cancel-booking')->with('warning', 'ไม่มีรายการค้นหาสำหรับนามสกุลนี้');
            } else {
                $bookings = booking::where('status', 7) //รอยืนยันยกเลิกการจอง
                    ->whereIn('user_id', $users)->get();

                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.confirm-cancel-booking', compact('bookings', 'promotions', 'set_menus'));
            }
        } else {
            $bookings = booking::where('status', 7)->get(); //รอยืนยันยกเลิกการจอง
            $set_menus = set_menu::all();
            $promotions = promotion::all();
            return view('admin.confirm-cancel-booking', compact('bookings', 'promotions', 'set_menus'));
        }
    }

    public function search_booking_admin(Request $request)
    {
        // ถ้าค้นหาโดยid
        if (isset($request->booking_id)) {
            $bookings = booking::where('id', $request->booking_id)->get();
            // ไม่เจอ
            if (($bookings->count() == 0)) {
                return redirect()->route('booking-admin')->with('warning', 'ไม่มีรายการค้นหา');
                // เจอ
            } else {
                return view('admin.booking-admin', compact('bookings'));
            }
            // ค้าหา ทั้งชื่อเเละนามสกุล
        } else if (isset($request->firstName) && isset($request->lastName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(firstName)'), strtolower($request->firstName))
                ->where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();

            //ถ้าชื่อเเละนามสกุลไม่ตรง
            if ($users->count() == 0) {
                return redirect()->route('booking-admin')->with('warning', 'ไม่มีรายการค้นหา');
                // ถ้า ชื่อเเละนามสกลุตรง
            } else {
                $bookings = booking::whereIn('user_id', $users)->get();
                return view('admin.booking-admin', compact('bookings'));
            }
            // ค้นหาเเค่ชื่อ
        } else if (isset($request->firstName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(firstName)'), strtolower($request->firstName))->get();
            if ($users->count() == 0) {
                return redirect()->route('booking-admin')->with('warning', 'ไม่มีรายการค้นหาสำหรับชื่อนี้');
            } else {
                $bookings = booking::whereIn('user_id', $users)->get();
                return view('admin.booking-admin', compact('bookings'));
            }
            // ค้นหาเเค่นามสกุล
        } else if (isset($request->lastName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();
            if ($users->count() == 0) {
                return redirect()->route('booking-admin')->with('warning', 'ไม่มีรายการค้นหาสำหรับนามสกุลนี้');
            } else {
                $bookings = booking::whereIn('user_id', $users)->get();
                return view('admin.booking-admin', compact('bookings'));
            }
        } else {
            $bookings = booking::all();
            return view('admin.booking-admin', compact('bookings'));
        }
    }

    //ตรวจสอบเเล้ว 20/12/65
    public function search_check_in(Request $request)
    {
        // ถ้าค้นหาโดยid
        if (isset($request->booking_id)) {
            $bookings = booking::where('id', $request->booking_id)
                ->where('status', 3)->get();
            // เจอ
            if (($bookings->count() == 0)) {
                return redirect()->route('check-in-admin')->with('warning', 'ไม่มีรายการค้นหา');
                // ไม่เจอ
            } else {
                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.check-in', compact('bookings', 'promotions', 'set_menus'));
            }
            // ค้าหา ทั้งชื่อเเละนามสกุล
        } else if (isset($request->firstName) && isset($request->lastName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(firstName)'), strtolower($request->firstName))
                ->where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();

            //ถ้าชื่อเเละนามสกุลไม่ตรง
            if ($users->count() == 0) {
                return redirect()->route('check-in-admin')->with('warning', 'ไม่มีรายการค้นหา');
                // ถ้า ชื่อเเละนามสกลุตรง
            } else {
                $bookings = booking::where('status', 3) //รอCheckIn
                    ->whereIn('user_id', $users)->get();

                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.check-in', compact('bookings', 'promotions', 'set_menus'));
            }
            // ค้นหาเเค่ชื่อ
        } else if (isset($request->firstName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(firstName)'), strtolower($request->firstName))->get();
            if ($users->count() == 0) {
                return redirect()->route('check-in-admin')->with('warning', 'ไม่มีรายการค้นหาสำหรับชื่อนี้');
            } else {
                $bookings = booking::where('status', 3) //รอCheckIn
                    ->whereIn('user_id', $users)->get();

                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.check-in', compact('bookings', 'promotions', 'set_menus'));
            }
            // ค้นหาเเค่นามสกุล
        } else if (isset($request->lastName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();
            if ($users->count() == 0) {
                return redirect()->route('check-in-admin')->with('warning', 'ไม่มีรายการค้นหาสำหรับนามสกุลนี้');
            } else {
                $bookings = booking::where('status', 3) //รอCheckIn
                    ->whereIn('user_id', $users)->get();

                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.check-in', compact('bookings', 'promotions', 'set_menus'));
            }
        } else {
            $bookings = booking::where('status', 3)->get(); //รอCheckIn
            $set_menus = set_menu::all();
            $promotions = promotion::all();
            return view('admin.check-in', compact('bookings', 'promotions', 'set_menus'));
        }
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

    public function show_check_out(Request $request)
    {
        $bookings = booking::where('status', 1)
            ->where('end_date', Carbon::today())->get(); //Check-In เเล้ว

        return view('admin.check-out', compact('bookings'));
    }
    public function show_check_in(Request $request)
    {
        $bookings = booking::where('status', 3)
            ->where('start_date', Carbon::today())->get();  //รอ Check-In ยืนยันจ่ายเงินเเล้ว
        $set_menus = set_menu::all();
        $promotions = promotion::all();
        return view('admin.check-in', compact('bookings', 'set_menus', 'promotions'));
    }
    public function check_in(Request $request)
    {
        $now = Carbon::now();
        $update_booking = booking::find($request->idCheckIn);
        $update_booking->check_in = $now;
        $update_booking->check_in_by = Auth::user()->firstName . " " . Auth::user()->lastName;
        $update_booking->status = 1; //Check In
        $update_booking->save();

        $new_payment = new payment();
        $new_payment->booking_id = $request->idCheckIn;
        $new_payment->payment_type = 2;
        $new_payment->total_price = $request->toPay;
        $new_payment->pay_price = $request->payPrice;
        $new_payment->change = $request->change;
        $new_payment->save();

        return redirect()->back()->with('message', "Check In เสร็จสิ้น");
    }
    public function check_out($id)
    {
        $now = Carbon::now();
        $update_booking = booking::find($id);
        $update_booking->check_out = $now;
        $update_booking->check_out_by = Auth::user()->firstName . " " . Auth::user()->lastName;
        $update_booking->status = 2; //Check Out
        $update_booking->save();
        return redirect()->back()->with('message', "Check Out เสร็จสิ้น");
    }
}
