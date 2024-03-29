<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\promotion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PromotionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function manage_promotion()
    {
        $promotions = promotion::orderBy('status', 'asc')->get();
        return view('admin.manage-promotion', compact('promotions'));
    }

    public function promotion_detail($id)
    {
        $promotion = promotion::find($id);
        $bookings = booking::where('promotion_id', $id)->get();
        return view('admin.promotion-detail', compact('promotion', 'bookings'));
    }
    public function add_promotion(Request $request)
    {
        $add_promotion = new promotion();
        $add_promotion->promotion_name =  $request->promotion_name;

        if ($request->select_type == 1) {
            $add_promotion->discount_price =  $request->price;
        } elseif ($request->select_type == 2) {
            $add_promotion->percent =  $request->percent;
        }

        $add_promotion->promotion_detail =  $request->promotion_detail;
        $datetimeArr = explode(" - ", $request->datetimes);
        $date1 = explode(" ", $datetimeArr[0]);
        $date2 = explode(" ", $datetimeArr[1]);
        $start_date = date('Y-m-d', strtotime($date1[0]));
        $end_date = date('Y-m-d', strtotime($date2[0]));
        $start_time = date('H:i:s', strtotime($date1[1] . $date1[2]));
        $end_time = date('H:i:s', strtotime($date2[1] . $date2[2]));

        $today = explode(" ", Carbon::today());
        if ($start_date == $today[0]) {
            if ($start_time < date('H:i:s')) {
                $add_promotion->status =  1;
            } else {
                $add_promotion->status =  3;
            }
        } else {
            $add_promotion->status =  3;
        }

        $add_promotion->start_date =  $start_date;
        $add_promotion->end_date = $end_date;
        $add_promotion->start_time =  $start_time;
        $add_promotion->end_time = $end_time;

        $add_promotion->save();
        return redirect()->back()->with('message', 'เพิ่มโปรโมชั่น ' . $request->promotion_name . ' เสร็จสิ้น');
    }
    public function delete_promotion($id)
    {
        promotion::find($id)->delete();
        return redirect()->back()->with('message', 'ลบโปรโมชั่นเสร็จสิ้น');
    }
    public function edit_promotion(Request $request, $id)
    {
        $edit_promotion = promotion::find($id);
        $edit_promotion->promotion_name =  $request->promotion_name;

        if ($request->select_type == 1) {
            $edit_promotion->discount_price =  $request->price;
        } elseif ($request->select_type == 2) {
            $edit_promotion->percent =  $request->percent;
        }

        $edit_promotion->promotion_detail =  $request->promotion_detail;

        $datetimeArr = explode(" - ", $request->datetimes);
        $date1 = explode(" ", $datetimeArr[0]);
        $date2 = explode(" ", $datetimeArr[1]);
        $start_date = date('Y-m-d', strtotime($date1[0]));
        $end_date = date('Y-m-d', strtotime($date2[0]));
        $start_time = date('H:i:s', strtotime($date1[1] . $date1[2]));
        $end_time = date('H:i:s', strtotime($date2[1] . $date2[2]));
        // echo Carbon::today();
        $today = explode(" ", Carbon::today());
        if ($start_date == $today[0]) {
            if ($start_time < date('H:i:s')) {
                $edit_promotion->status =  1;
            } else {
                $edit_promotion->status =  3;
            }
        } else {
            $edit_promotion->status =  3;
        }

        $edit_promotion->start_date =  $start_date;
        $edit_promotion->end_date = $end_date;
        $edit_promotion->start_time =  $start_time;
        $edit_promotion->end_time = $end_time;

        $edit_promotion->save();
        return redirect()->route('promotion-detail', $id)->with('message', 'แก้ใขโปรโมชั่น ' . $request->promotion_name . ' เสร็จสิ้น');
    }
    public function search_promotion(Request $request)
    {
        $promotions = promotion::where('promotion_name', $request->promotion_name)->get();
        if ($promotions->count() == 0) {
            return redirect()->route('manage-promotion')->with('warning', 'ไม่มีรายการค้นหา');
        } else {
            $promotion_name = $request->promotion_name;
            return view('admin.manage-promotion', compact('promotions', 'promotion_name'));
        }
        return redirect()->route('promotion-detail');
    }
    public function promotion_filter(Request $request)
    {
        $status = $request->status;
        if (!empty($request->promotion_name)) {
            $promotion_name = $request->promotion_name;
            $promotions = promotion::where('promotion_name', $request->promotion_name)
                ->where('status', $request->status)->get();
            return view('admin.manage-promotion', compact('promotions', 'promotion_name', 'status'));
        } else {
            $promotions = promotion::where('status', $request->status)->get();
            return view('admin.manage-promotion', compact('promotions', 'status'));
        }
    }
}
