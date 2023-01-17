<?php

namespace App\Http\Controllers;

use App\Models\appliance;
use App\Models\bank_admin;
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
        $bookings = booking::where('user_id', Auth::user()->id)->paginate(5);
        return view('user.booking-history', compact('bookings'));
    }
    public function add_booking_user(Request $request)
    {
        $add_booking = new booking;
        $add_booking->user_id =  Auth::user()->id;
        if ($request->promotion != 0) {
            $add_booking->promotion_id = $request->promotion;
        }
        $add_booking->set_menu_id = $request->set_menu;
        $add_booking->num_menu = $request->num_menu;
        $add_booking->booking_type = 1;  //ลูกค้าจอง

        $dateArr = explode(" - ", $request->dateRange);
        $start_date = date('Y-m-d', strtotime($dateArr[0]));
        $end_date = date('Y-m-d', strtotime($dateArr[1]));

        $add_booking->start_date = $start_date;
        $add_booking->end_date = $end_date;
        $add_booking->number_guests = $request->number_guests;
        $add_booking->total_price = $request->total_price;
        $add_booking->total_price_discount = $request->total_price_discount;
        $add_booking->deposit = $request->deposit;
        $add_booking->status = 5; //รอชำระเงิน
        $add_booking->save();

        if (count($request->homestay_name) > 1) {
            foreach ($request->homestay_name as $homestay_id) {
                $add_booking_detail = new booking_detail;
                $add_booking_detail->booking_id = $add_booking->id;
                $add_booking_detail->homestay_id = $homestay_id;
                $add_booking_detail->save();
            }
        } else {
            $add_booking_detail = new booking_detail;
            $add_booking_detail->booking_id = $add_booking->id;
            $add_booking_detail->homestay_id = $request->homestay_name[0];
            $add_booking_detail->save();
        }

        return redirect()->route('show-payment', $add_booking->id);
    }

    public function show_payment($id)
    {
        $bank_admin = bank_admin::first();
        $booking = booking::find($id);
        $homestays = homestay::where('status', 1)->get();
        $promotions = promotion::where('status', 1)->get();

        $created_at = strtotime($booking->created_at);
        $endTime = Carbon::createFromTimestamp($created_at)->addMinutes(15);
        $curTime = Carbon::now();

        if ($endTime->lt($curTime)) {
            return redirect()->route('home')->with('danger', "หมดเวลาชำระเงิน");
        } else {
            if ($booking->status == 5) {
                return view('user.payment', compact('booking', 'bank_admin', 'homestays', 'promotions'));
            } else {
                return redirect()->route('home');
            }
        }
    }
    public function change_status_payment($id)
    {
        $update_booking = booking::find($id);
        $update_booking->status = 7;  //ยกเลิกการจอง
        $update_booking->save();
        return redirect()->route('home')->with('danger', "Aหมดเวลาชำระเงิน");
    }

    public function payment(Request $request)
    {
        $add_payment = new payment();
        $add_payment->bank_admin_id =  $request->bank_admin_id;
        $add_payment->booking_id =  $request->booking_id;
        $add_payment->payment_type =  1;

        if ($request->hasfile('slip_img')) {
            $this->validate($request, [
                'slip_img' => 'required',
                'slip_img.*' => 'mimes:jpg,jpeg,png', 'max:10240'
            ]);

            $img = $request->file('slip_img');
            $name = $img->getClientOriginalName();
            $img->move(public_path() . '/storage/images/', $name);
            $add_payment->slip_img =  $name;
        }

        $add_payment->total_price =  $request->deposit;
        $add_payment->pay_price =  $request->deposit;
        $add_payment->change =  0;
        $add_payment->save();

        $update_booking = booking::find($request->booking_id);
        $update_booking->status = 6;  //รอยืนยันการชำระเงิน
        $update_booking->save();

        return redirect()->route('booking-history')->with('message', "ชำระเงินเสร็จสิ้น รอยืนยันจากทางเจ้าของโฮมสเตย์");
    }

    public function history_details($id)
    {
        $booking = booking::find($id);
        $homestays = homestay::all();
        $promotions = promotion::all();
        return view('user.booking-history-details', compact('booking', 'homestays', 'promotions'));
    }
    public function cancel_pay_user($id)
    {
        $update_booking = booking::find($id);
        $update_booking->status = 4;  //ยกเลิกการจอง
        $update_booking->save();

        return redirect()->back()->with('message', "ยกเลิกการจองเสร็จสิ้น รอกการยืนยันจากเจ้าของโฮมสเตย์");
    }
    public function booking_user(Request $request)
    {
        $homestays = homestay::whereIn('id', $request->homestay_id)->get();
        $dateRange = $request->dateRange;
        $user = Auth::user();
        $set_menus = set_menu::where('status', 1)->get();
        $promotions = promotion::where('status', 1)->get();
        return view('user.booking-user', compact('homestays', 'dateRange', 'user', 'set_menus', 'promotions'));
    }
    // Admin
    public function calendar_booking()
    {
        $bookings = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('homestays', 'booking_details.homestay_id', '=', 'homestays.id')
            ->select('bookings.id', 'bookings.start_date', 'bookings.end_date', 'homestays.homestay_name')
            ->Where('bookings.status', '!=', 4)
            ->get()->groupBy('id');

        return view('admin.calendar-booking', compact('bookings'));
    }
    public function booking_admin()
    {
        $bookings = booking::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.booking-admin', compact('bookings'));
    }
    public function booking_detail($id)
    {
        $booking = booking::find($id);
        $homestays = homestay::all();
        $set_menus = set_menu::all();
        $promotions = promotion::all();

        $answers = collect([]);
        foreach ($booking as $info) {
            $booking_details = booking_detail::where('booking_id', $id)->get();
            foreach ($booking_details as $booking_detail) {
                $answers->push($booking_detail->homestay_id);
            }
        }

        $homestaysN = DB::table('homestays')->whereNotIn('id', $answers)->get();

        return view('admin.booking-detail', compact('booking', 'set_menus', 'promotions', 'homestays', 'homestaysN'));
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

    //ตรวจสอบเเล้ว 3/1/66
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
                ->where('status', 3)->where('start_date', Carbon::today())->get();
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
                    ->whereIn('user_id', $users)->where('start_date', Carbon::today())->get();

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
                    ->whereIn('user_id', $users)->where('start_date', Carbon::today())->get();

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
                    ->whereIn('user_id', $users)->where('start_date', Carbon::today())->get();

                $set_menus = set_menu::all();
                $promotions = promotion::all();
                return view('admin.check-in', compact('bookings', 'promotions', 'set_menus'));
            }
        } else {
            $bookings = booking::where('status', 3)->where('start_date', Carbon::today())->get(); //รอCheckIn
            $set_menus = set_menu::all();
            $promotions = promotion::all();
            return view('admin.check-in', compact('bookings', 'promotions', 'set_menus'));
        }
    }

    //ตรวจสอบเเล้ว 3/1/66
    public function search_check_out(Request $request)
    {
        // ถ้าค้นหาโดยid
        if (isset($request->booking_id)) {
            $bookings = booking::where('id', $request->booking_id)
                ->where('status', 1)
                ->where('end_date', Carbon::today())->get();
            // เจอ
            if (($bookings->count() == 0)) {
                return redirect()->route('check-out-admin')->with('warning', 'ไม่มีรายการค้นหา');
                // ไม่เจอ
            } else {
                $set_menus = set_menu::all();
                $widens = widen::all();
                $appliances = appliance::all();
                return view('admin.check-out', compact('bookings', 'widens', 'set_menus', 'appliances'));
            }
            // ค้าหา ทั้งชื่อเเละนามสกุล
        } else if (isset($request->firstName) && isset($request->lastName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(firstName)'), strtolower($request->firstName))
                ->where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();

            //ถ้าชื่อเเละนามสกุลไม่ตรง
            if ($users->count() == 0) {
                return redirect()->route('check-out-admin')->with('warning', 'ไม่มีรายการค้นหา');
                // ถ้า ชื่อเเละนามสกลุตรง
            } else {
                $bookings = booking::where('status', 1) //รอCheckOut
                    ->whereIn('user_id', $users)
                    ->where('end_date', Carbon::today())->get();

                $set_menus = set_menu::all();
                $widens = widen::all();
                $appliances = appliance::all();
                return view('admin.check-out', compact('bookings', 'widens', 'set_menus', 'appliances'));
            }
            // ค้นหาเเค่ชื่อ
        } else if (isset($request->firstName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(firstName)'), strtolower($request->firstName))->get();
            if ($users->count() == 0) {
                return redirect()->route('check-out-admin')->with('warning', 'ไม่มีรายการค้นหาสำหรับชื่อนี้');
            } else {
                $bookings = booking::where('status', 1) //รอCheckOut
                    ->whereIn('user_id', $users)
                    ->where('end_date', Carbon::today())->get();

                $set_menus = set_menu::all();
                $widens = widen::all();
                $appliances = appliance::all();
                return view('admin.check-out', compact('bookings', 'widens', 'set_menus', 'appliances'));
            }
            // ค้นหาเเค่นามสกุล
        } else if (isset($request->lastName)) {
            $users = user::select('id')
                ->where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();
            if ($users->count() == 0) {
                return redirect()->route('check-out-admin')->with('warning', 'ไม่มีรายการค้นหาสำหรับนามสกุลนี้');
            } else {
                $bookings = booking::where('status', 1) //รอCheckOut
                    ->whereIn('user_id', $users)
                    ->where('end_date', Carbon::today())->get();

                $set_menus = set_menu::all();
                $widens = widen::all();
                $appliances = appliance::all();
                return view('admin.check-out', compact('bookings', 'widens', 'set_menus', 'appliances'));
            }
        } else {
            $bookings = booking::where('status', 1)->where('end_date', Carbon::today())->get(); //รอCheckOut
            $set_menus = set_menu::all();
            $widens = widen::all();
            $appliances = appliance::all();
            return view('admin.check-out', compact('bookings', 'widens', 'set_menus', 'appliances'));
        }
    }

    public function show_check_out(Request $request)
    {
        $bookings = booking::where('status', 1)
            ->where('end_date', Carbon::today())->get(); //Check-In เเล้ว
        $set_menus = set_menu::all();
        $widens = widen::all();
        $appliances = appliance::all();
        return view('admin.check-out', compact('bookings', 'set_menus', 'widens', 'appliances'));
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

        $payment_types = payment::select('payment_type')->where('id', $request->idCheckIn)->get();
        if ($payment_types->contains('payment_type', '!=', 4)) {
            $new_payment = new payment();
            $new_payment->booking_id = $request->idCheckIn;
            $new_payment->payment_type = 2;
            $new_payment->total_price = $request->toPay;
            $new_payment->pay_price = $request->payPrice;
            $new_payment->change = $request->change;
            $new_payment->save();
        }

        return redirect()->back()->with('message', "Check In เสร็จสิ้น");
    }
    public function check_out(Request $request)
    {
        $now = Carbon::now();
        $update_booking = booking::find($request->idCheckOut);
        $update_booking->check_out = $now;
        $update_booking->check_out_by = Auth::user()->firstName . " " . Auth::user()->lastName;
        $update_booking->status = 2; //Check Out
        $update_booking->save();

        $c_widen = widen::where('booking_id', $request->idCheckOut)->get()->count();
        if ($c_widen > 0) {
            $new_payment = new payment();
            $new_payment->booking_id = $request->idCheckOut;
            $new_payment->payment_type = 3;
            $new_payment->total_price = $request->payExtra;
            $new_payment->pay_price = $request->payPrice;
            $new_payment->change = $request->change;
            $new_payment->save();
        }

        return redirect()->back()->with('message', "Check Out เสร็จสิ้น");
    }

    public function add_booking_admin()
    {
        $homestays = homestay::where('status', 1)->get();
        $set_menus = set_menu::where('status', 1)->get();
        $promotions = promotion::where('status', 1)->get();
        $users = user::all();
        return view('admin.add-booking-admin', compact('set_menus', 'promotions', 'homestays', 'users'));
    }

    public function add_booking(Request $request)
    {
        $dateArr = explode(" - ", $request->dateRange);
        $start_date = date('Y-m-d', strtotime($dateArr[0]));
        $end_date = date('Y-m-d', strtotime($dateArr[1]));

        $homestay_id = $request->homestay_name;

        //เข้าออกวันเดียวกัน //ผ่าน
        //เข้าออก ไปคลุม  //ผ่าน
        //เข้าออก อยู่ระหว่าง  //ผ่าน
        //เข้า อยู่ระหว่าง  //ผ่าน
        //ออก อยู่ระหว่าง   //ผ่าน

        $booking_infos = DB::table('bookings')
            ->select('bookings.id')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->where(function ($query) use ($start_date, $end_date, $homestay_id) {
                $query->where('bookings.start_date', $start_date)
                    ->Where('bookings.end_date', $end_date)
                    ->whereIn('booking_details.homestay_id', $homestay_id)
                    ->Where('bookings.status', '!=', 4);
            })->orWhere(function ($query) use ($start_date, $end_date, $homestay_id) {
                $query->where('bookings.start_date', '>=', $start_date)
                    ->Where('bookings.end_date', '<=', $end_date)
                    ->whereIn('booking_details.homestay_id', $homestay_id)
                    ->Where('bookings.status', '!=', 4);
            })->orWhere(function ($query) use ($start_date, $end_date, $homestay_id) {
                $query->where('bookings.start_date', '<', $start_date)
                    ->Where('bookings.end_date', '>', $end_date)
                    ->whereIn('booking_details.homestay_id', $homestay_id)
                    ->Where('bookings.status', '!=', 4);
            })->orWhere(function ($query) use ($start_date, $end_date, $homestay_id) {
                $query
                    ->Where('bookings.start_date', '>=', $start_date)
                    ->Where('bookings.start_date', '<', $end_date)
                    ->Where('bookings.end_date', '>=', $end_date)
                    ->whereIn('booking_details.homestay_id', $homestay_id)
                    ->Where('bookings.status', '!=', 4);
            })->orWhere(function ($query) use ($start_date, $end_date, $homestay_id) {
                $query->where('bookings.start_date', '<=', $end_date)
                    ->Where('bookings.end_date', '>', $start_date)
                    ->Where('bookings.end_date', '<=', $end_date)
                    ->whereIn('booking_details.homestay_id', $homestay_id)
                    ->Where('bookings.status', '!=', 4);
            })->get();

        //เช็ค==0 ไม่มีการจองซ้ำในdatabase
        if (count($booking_infos) == 0) {
            if (isset($request->email)) {
                $user_id = user::select('id')->where('email', $request->email)->get();
                $add_booking = new booking;
                $add_booking->user_id =  $user_id[0]->id;
                if ($request->promotion != 0) {
                    $add_booking->promotion_id = $request->promotion;
                }
                $add_booking->set_menu_id = $request->set_menu;
                $add_booking->num_menu = $request->num_menu;
                $add_booking->booking_type = 2;  //Adminจองให้

                $dateArr = explode(" - ", $request->dateRange);
                $start_date = date('Y-m-d', strtotime($dateArr[0]));
                $end_date = date('Y-m-d', strtotime($dateArr[1]));

                $add_booking->start_date = $start_date;
                $add_booking->end_date = $end_date;
                $add_booking->number_guests = $request->number_guests;
                $add_booking->total_price = $request->total_price;
                $add_booking->total_price_discount = $request->total_price_discount;
                $add_booking->deposit = $request->deposit;
                $add_booking->status = 3; //รอ Check In

                $add_booking->save();  //ผ่าน


                if (count($request->homestay_name) > 1) {
                    foreach ($request->homestay_name as $homestay_id) {
                        $add_booking_detail = new booking_detail;
                        $add_booking_detail->booking_id = $add_booking->id;
                        $add_booking_detail->homestay_id = $homestay_id;
                        $add_booking_detail->save();
                    }
                } else {
                    $add_booking_detail = new booking_detail;
                    $add_booking_detail->booking_id = $add_booking->id;
                    $add_booking_detail->homestay_id = $request->homestay_name[0];
                    $add_booking_detail->save();
                }  //ผ่าน

                //มัดจำ
                if ($request->paytype == 1) {
                    $add_payment = new payment();
                    $add_payment->booking_id = $add_booking->id;
                    $add_payment->payment_type = 1; //ชำระเงินมัดจำ
                    $add_payment->total_price = $request->deposit;
                    $add_payment->pay_price = $request->payPrice;
                    $add_payment->change = $request->change;
                    $add_payment->save();
                } else {
                    $add_payment = new payment();
                    $add_payment->booking_id = $add_booking->id;
                    $add_payment->payment_type = 4; //ชำระเงินเต็มจำนวนตอนจอง
                    $add_payment->total_price = $request->total_price_discount;
                    $add_payment->pay_price = $request->payPrice;
                    $add_payment->change = $request->change;
                    $add_payment->save();
                } //ผ่าน
                return redirect()->back()->with('message', "เพิ่มรายการจองเสร็จสิ้น");
            } else {
                $add_user = new user;
                $add_user->firstName =  $request->firstName;
                $add_user->lastName =  $request->lastName;
                $add_user->tel =  $request->tel;
                $add_user->role =  1;
                $add_user->save(); //ผ่าน

                $add_booking = new booking;
                $add_booking->user_id =  $add_user->id;
                if (isset($request->promotion)) {
                    $add_booking->promotion_id = $request->promotion;
                }
                $add_booking->set_menu_id = $request->set_menu;
                $add_booking->num_menu = $request->num_menu;
                $add_booking->booking_type = 2;

                $dateArr = explode(" - ", $request->dateRange);
                $start_date = date('Y-m-d', strtotime($dateArr[0]));
                $end_date = date('Y-m-d', strtotime($dateArr[1]));

                $add_booking->start_date = $start_date;
                $add_booking->end_date = $end_date;
                $add_booking->number_guests = $request->number_guests;
                $add_booking->total_price = $request->total_price;
                $add_booking->total_price_discount = $request->total_price_discount;
                $add_booking->deposit = $request->deposit;
                $add_booking->status = 3;

                $add_booking->save(); //ผ่าน

                if (count($request->homestay_name) > 1) {
                    foreach ($request->homestay_name as $homestay_id) {
                        $add_booking_detail = new booking_detail;
                        $add_booking_detail->booking_id = $add_booking->id;
                        $add_booking_detail->homestay_id = $homestay_id;
                        $add_booking_detail->save();
                    }
                } else {
                    $add_booking_detail = new booking_detail;
                    $add_booking_detail->booking_id = $add_booking->id;
                    $add_booking_detail->homestay_id = $request->homestay_name[0];
                    $add_booking_detail->save();
                } //ผ่าน

                //มัดจำ
                if ($request->paytype == 1) {
                    $add_payment = new payment();
                    $add_payment->booking_id = $add_booking->id;
                    $add_payment->payment_type = 1; //ชำระเงินมัดจำ
                    $add_payment->total_price = $request->deposit;
                    $add_payment->pay_price = $request->payPrice;
                    $add_payment->change = $request->change;
                    $add_payment->save();
                } else {
                    $add_payment = new payment();
                    $add_payment->booking_id = $add_booking->id;
                    $add_payment->payment_type = 4; //ชำระเงินเต็มจำนวนตอนจอง
                    $add_payment->total_price = $request->total_price_discount;
                    $add_payment->pay_price = $request->payPrice;
                    $add_payment->change = $request->change;
                    $add_payment->save();
                } //ผ่าน
                return redirect()->back()->with('message', "เพิ่มรายการจองเสร็จสิ้น");
            }
        } else {
            return redirect()->back()->with('danger', "ช่วงเวลาเเละบ้านพัก มีการจองเเล้ว");
            // echo $booking_infos;
        }
    }
}
