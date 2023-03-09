<?php

namespace App\Http\Controllers;

use App\Models\appliance;
use App\Models\homestay;
use App\Models\homestay_detail;
use App\Models\booking;
use App\Models\widen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WidenController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    //booking
    public function search_widen_booking(Request $request)
    {
        if ($request->booking_id != 0) {
            $widens = widen::where('booking_id', $request->booking_id)->orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(10);
        } elseif ($request->appliance_id != 0) {
            $widens = widen::where('appliance_id', $request->appliance_id)->orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(10);
        } elseif ($request->status != 0) {
            $widens = widen::where('status', $request->status)->orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(10);
        }
        $appliances = appliance::all();
        $bookings = booking::where('status', 1)->get();  //Check in เเล้ว
        return view('admin.widen-appliance-booking', compact('appliances', 'bookings', 'widens'));
    }

    public function manage_appliance_booking()
    {
        $appliances = appliance::all();
        $bookings = booking::where('status', 1)->get();  //Check in เเล้ว
        $widens = widen::orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.widen-appliance-booking', compact('appliances', 'bookings', 'widens'));
    }
    public function widen_booking(Request $request)
    {
        foreach ($request->appliance_id as $appliance_id) {
            $appliances = appliance::select('stock')->where('id', $appliance_id)->first();
            if (($appliances->stock > 0) && ($appliances->stock >= $request->input("amount" . $appliance_id))) {
                $add_widen_booking = new widen();
                $add_widen_booking->appliance_id = $appliance_id;
                $add_widen_booking->booking_id = $request->booking_id;
                $add_widen_booking->amount = $request->input("amount" . $appliance_id);
                $add_widen_booking->price = $request->input("totalPrice" . $appliance_id);
                $add_widen_booking->widen_by = Auth::user()->firstName . " " . Auth::user()->lastName;
                $add_widen_booking->status = 1;
                $add_widen_booking->save();

                //เบิก
                $update_appliance = appliance::find($appliance_id);
                $update_appliance->stock = intval($appliances->stock) - intval($request->input("amount" . $appliance_id));
                $update_appliance->save();
            } else {
                return redirect()->back()->with('danger', "ของใช้ในคลังไม่เพียงพอ");
            }
        }
        return redirect()->back()->with('message', "เบิกของใช้เข้าบ้านพักเสร็จสิ้น");
    }

    public function edit_widen_booking(Request $request)
    {
        $appliances = appliance::select('stock')->where('id',$request->edit_appliance_id)->first();

        if (($appliances->stock > 0) && ($appliances->stock >= $request->stockAmountEdit)) {
            $update_widen_booking = widen::find($request->widen_id);
            $update_widen_booking->booking_id = $request->edit_booking_id;

            if ($update_widen_booking->appliance_id == $request->edit_appliance_id) { //ของตัวเดิม
                $update_widen_booking->appliance_id = $request->edit_appliance_id;

                //คืน
                $stock = appliance::select('stock')->where('id', $request->edit_appliance_id)->first();
                $update_appliance = appliance::find($request->edit_appliance_id);
                $update_appliance->stock = intval($update_widen_booking->amount) + intval($stock->stock);
                $update_appliance->save();

                //เบิกใหม่
                $update_appliance = appliance::find($request->edit_appliance_id);
                $stock = appliance::select('stock')->where('id', $request->edit_appliance_id)->first();
                $update_appliance->stock = intval($stock->stock) - intval($request->editAmount);
                $update_appliance->save();
            } else {
                //คืน
                $stock = appliance::select('stock')->where('id', $update_widen_booking->appliance_id)->first();
                $update_appliance = appliance::find($update_widen_booking->appliance_id);
                $update_appliance->stock = intval($update_widen_booking->amount) + intval($stock->stock);
                $update_appliance->save();

                $update_widen_booking->appliance_id = $request->edit_appliance_id;
                //เบิกใหม่
                $update_appliance = appliance::find($request->edit_appliance_id);
                $stock = appliance::select('stock')->where('id', $request->edit_appliance_id)->first();
                $update_appliance->stock = intval($stock->stock) - intval($request->editAmount);
                $update_appliance->save();
            }

            $update_widen_booking->amount = $request->editAmount;
            $update_widen_booking->price = $request->editTotalPrice;
            $update_widen_booking->widen_by = Auth::user()->firstName . " " . Auth::user()->lastName;
            $update_widen_booking->status = 1;
            $update_widen_booking->save();

            return redirect()->back()->with('message', "แก้ใขเบิกของใช้จากรายการจองเสร็จสิ้น");
        } else {
            return redirect()->back()->with('danger', "ของใช้ในคลังไม่เพียงพอ");
        }
    }

    public function draw_back_booking($id)
    {
        $update_widen = widen::find($id);
        $update_widen->status = 2;
        $update_widen->save();

        //คืน
        $stock = appliance::select('stock')->where('id', $update_widen->appliance_id)->first();
        $update_appliance = appliance::find($update_widen->appliance_id);
        $update_appliance->stock = intval($update_widen->amount) + intval($stock->stock);
        $update_appliance->save();

        return redirect()->back()->with('message', "คืนของใช้เสร็จสิ้น");
    }

    //homestay
    public function manage_appliance_homestay()
    {
        $homestays = homestay::where('status', 1)->get();
        $appliances = appliance::all();
        $homestay_details = homestay_detail::orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.widen-appliance-homestay', compact('homestays', 'appliances', 'homestay_details'));
    }

    public function widen_homestay(Request $request)
    {
        foreach ($request->appliance_id as $appliance_id) {
            $appliances = appliance::select('stock')->where('id', $appliance_id)->first();
            if (($appliances->stock > 0) && ($appliances->stock >= $request->input("amount" . $appliance_id))) {
                $add_homestay_detail = new homestay_detail();
                $add_homestay_detail->appliance_id = $appliance_id;
                $add_homestay_detail->homestay_id = $request->homestay_id;
                $add_homestay_detail->amount = $request->input("amount" . $appliance_id);
                $add_homestay_detail->widen_by = Auth::user()->firstName . " " . Auth::user()->lastName;
                $add_homestay_detail->status = 1;
                $add_homestay_detail->save();

                //เบิก
                $update_appliance = appliance::find($appliance_id);
                $update_appliance->stock = intval($appliances->stock) - intval($request->input("amount" . $appliance_id));

                $update_appliance->save();
            } else {
                return redirect()->back()->with('danger', "ของใช้ในคลังไม่เพียงพอ");
            }
        }
        return redirect()->back()->with('message', "เบิกของใช้เข้าบ้านพักเสร็จสิ้น");
    }

    public function edit_widen_homestay(Request $request)
    {
        $appliances = appliance::select('stock')->where('id', $request->edit_appliance_id)->first();

        if (($appliances->stock > 0) && ($appliances->stock >= $request->editAmount)) {
            $update_homestay_detail = homestay_detail::find($request->homestay_detail_id);
            $update_homestay_detail->homestay_id = $request->edit_homestay_id;

            if ($update_homestay_detail->appliance_id == $request->edit_appliance_id) {
                $update_homestay_detail->appliance_id = $request->edit_appliance_id;

                //คืน
                $stock = appliance::select('stock')->where('id', $request->edit_appliance_id)->first();
                $update_appliance = appliance::find($request->edit_appliance_id);
                $update_appliance->stock = intval($update_homestay_detail->amount) + intval($stock->stock);
                $update_appliance->save();

                //เบิกใหม่
                $update_appliance = appliance::find($request->edit_appliance_id);
                $stock = appliance::select('stock')->where('id', $request->edit_appliance_id)->first();
                $update_appliance->stock = intval($stock->stock) - intval($request->editAmount);
                $update_appliance->save();
            } else {
                //คืน
                $stock = appliance::select('stock')->where('id', $update_homestay_detail->appliance_id)->first();
                $update_appliance = appliance::find($update_homestay_detail->appliance_id);
                $update_appliance->stock = intval($update_homestay_detail->amount) + intval($stock->stock);
                $update_appliance->save();

                $update_homestay_detail->appliance_id = $request->edit_appliance_id;
                //เบิกใหม่
                $update_appliance = appliance::find($request->edit_appliance_id);
                $stock = appliance::select('stock')->where('id', $request->edit_appliance_id)->first();
                $update_appliance->stock = intval($stock->stock) - intval($request->editAmount);
                $update_appliance->save();
            }

            $update_homestay_detail->amount = $request->editAmount;
            $update_homestay_detail->widen_by = Auth::user()->firstName . " " . Auth::user()->lastName;
            $update_homestay_detail->status = 1;
            $update_homestay_detail->save();

            return redirect()->back()->with('message', "แก้ใขเบิกของใช้เข้าบ้านพักเสร็จสิ้น");
        } else {
            return redirect()->back()->with('danger', "ของใช้ในคลังไม่เพียงพอ");
        }
    }
    public function draw_back_homestay_detail($id)
    {
        $update_homestay_detail = homestay_detail::find($id);
        $update_homestay_detail->status = 2;
        $update_homestay_detail->save();

        //คืน
        $stock = appliance::select('stock')->where('id', $update_homestay_detail->appliance_id)->first();
        $update_appliance = appliance::find($update_homestay_detail->appliance_id);
        $update_appliance->stock = intval($update_homestay_detail->amount) + intval($stock->stock);
        $update_appliance->save();

        return redirect()->back()->with('message', "คืนของใช้เสร็จสิ้น");
    }
}
