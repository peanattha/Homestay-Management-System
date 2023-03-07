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
    public function manage_appliance_booking()
    {
        $appliances = appliance::all();
        $bookings = booking::where('status', 1)->get();  //Check in เเล้ว
        $widens = widen::where('status', 1)->get();
        return view('admin.widen-appliance-booking', compact('appliances', 'bookings', 'widens'));
    }
    public function widen_booking(Request $request)
    {
        foreach ($request->appliance_id as $appliance_id) {
            $appliances = appliance::select('stock')->where('id', $appliance_id)->get();
            if (($appliances[0]->stock > 0) && ($appliances[0]->stock >= $request->input("amount" . $appliance_id))) {
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
                $update_appliance->stock = intval($appliances[0]->stock) - intval($request->input("amount" . $appliance_id));
                $update_appliance->save();
            } else {
                return redirect()->back()->with('danger', "ของใช้ในคลังไม่เพียงพอ");
            }
        }
        return redirect()->back()->with('message', "เบิกของใช้เข้าบ้านพักเสร็จสิ้น");
    }

    public function appliance_booking_detail($id)
    {

        return view('admin.widen-detail-booking');
    }

    //homestay
    public function manage_appliance_homestay()
    {
        $homestays = homestay::where('status', 1)->get();
        $appliances = appliance::all();
        $homestay_details = homestay_detail::orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(10);;
        return view('admin.widen-appliance-homestay', compact('homestays', 'appliances', 'homestay_details'));
    }
    public function appliance_homestay_detail($id)
    {

        return view('admin.widen-detail-homestay');
    }
    public function widen_homestay(Request $request)
    {
        foreach ($request->appliance_id as $appliance_id) {
            $appliances = appliance::select('stock')->where('id', $appliance_id)->get();
            if (($appliances[0]->stock > 0) && ($appliances[0]->stock >= $request->input("amount" . $appliance_id))) {
                $add_homestay_detail = new homestay_detail();
                $add_homestay_detail->appliance_id = $appliance_id;
                $add_homestay_detail->homestay_id = $request->homestay_id;
                $add_homestay_detail->amount = $request->input("amount" . $appliance_id);
                $add_homestay_detail->widen_by = Auth::user()->firstName . " " . Auth::user()->lastName;
                $add_homestay_detail->status = 1;
                $add_homestay_detail->save();

                //เบิก
                $update_appliance = appliance::find($appliance_id);
                $update_appliance->stock = intval($appliances[0]->stock) - intval($request->input("amount" . $appliance_id));

                $update_appliance->save();
            } else {
                return redirect()->back()->with('danger', "ของใช้ในคลังไม่เพียงพอ");
            }
        }
        return redirect()->back()->with('message', "เบิกของใช้เข้าบ้านพักเสร็จสิ้น");
    }

    public function edit_widen_homestay(Request $request)
    {
        $appliances = appliance::select('stock')->where('id', $request->edit_appliance_id)->get();

        if (($appliances[0]->stock > 0) && ($appliances[0]->stock >= $request->editAmount)) {
            $update_homestay_detail = homestay_detail::find($request->homestay_detail_id);
            $update_homestay_detail->homestay_id = $request->edit_homestay_id;

            if ($update_homestay_detail->appliance_id == $request->edit_appliance_id) {
                $update_homestay_detail->appliance_id = $request->edit_appliance_id;

                //คืน
                $stock = appliance::select('stock')->where('id', $request->edit_appliance_id)->get();
                $update_appliance = appliance::find($request->edit_appliance_id);
                $update_appliance->stock = intval($update_homestay_detail->amount) + intval($stock[0]->stock);
                $update_appliance->save();

                //เบิกใหม่
                $update_appliance = appliance::find($request->edit_appliance_id);
                $stock = appliance::select('stock')->where('id', $request->edit_appliance_id)->get();
                $update_appliance->stock = intval($stock[0]->stock) - intval($request->editAmount);
                $update_appliance->save();
            } else {
                //คืน
                $stock = appliance::select('stock')->where('id', $update_homestay_detail->appliance_id)->get();
                $update_appliance = appliance::find($update_homestay_detail->appliance_id);
                $update_appliance->stock = intval($update_homestay_detail->amount) + intval($stock[0]->stock);
                $update_appliance->save();

                $update_homestay_detail->appliance_id = $request->edit_appliance_id;
                //เบิกใหม่
                $update_appliance = appliance::find($request->edit_appliance_id);
                $stock = appliance::select('stock')->where('id', $request->edit_appliance_id)->get();
                $update_appliance->stock = intval($stock[0]->stock) - intval($request->editAmount);
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
        $stock = appliance::select('stock')->where('id', $update_homestay_detail->appliance_id)->get();
        $update_appliance = appliance::find($update_homestay_detail->appliance_id);
        $update_appliance->stock = intval($update_homestay_detail->amount) + intval($stock[0]->stock);
        $update_appliance->save();

        return redirect()->back()->with('message', "คืนของใช้เสร็จสิ้น");
    }
}
