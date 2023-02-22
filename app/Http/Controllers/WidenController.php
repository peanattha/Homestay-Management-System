<?php

namespace App\Http\Controllers;

use App\Models\appliance;
use App\Models\homestay;
use App\Models\homestay_detail;
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
    public function manage_appliance_booking()
    {

        return view('admin.widen-appliance-booking');
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
        $homestay_details = homestay_detail::all();
        return view('admin.widen-appliance-homestay', compact('homestays', 'appliances', 'homestay_details'));
    }
    public function appliance_homestay_detail($id)
    {

        return view('admin.widen-detail-homestay');
    }
    public function widen_homestay(Request $request)
    {
        $appliances = appliance::select('stock')->where('id', $request->appliance_id)->get();
        if (($appliances[0]->stock > 0) && ($appliances[0]->stock >= $request->amount)) {
            $add_homestay_detail = new homestay_detail();
            $add_homestay_detail->appliance_id = $request->appliance_id;
            $add_homestay_detail->homestay_id = $request->homestay_id;
            $add_homestay_detail->amount = $request->amount;
            $add_homestay_detail->widen_by = Auth::user()->firstName . " " . Auth::user()->lastName;
            $add_homestay_detail->status = 1;
            $add_homestay_detail->save();

            //เบิก
            $stock = appliance::select('stock')->where('id', $request->appliance_id)->get();
            $update_appliance = appliance::find($request->appliance_id);
            $update_appliance->stock = intval($stock[0]->stock) - intval($request->amount);

            $update_appliance->save();

            return redirect()->back()->with('message', "เบิกของใช้เข้าบ้านพักเสร็จสิ้น");
        } else {
            return redirect()->back()->with('danger', "ของใช้ในคลังไม่เพียงพอ");
        }
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
