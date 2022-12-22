<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\homestay_type;
use App\Models\homestay;
use Illuminate\Support\Facades\DB;
use App\Models\booking;
use App\Models\booking_detail;
use App\Models\set_menu;

class homestayController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function manage_homestay()
    {
        $homestay_types = homestay_type::all();
        $homestays = homestay::all();

        return view('admin.manage-homestay', compact('homestay_types', 'homestays'));
    }
    public function manage_homestay_type()
    {
        $homestay_types = homestay_type::all();
        $homestays = homestay::all();
        return view('admin.manage-homestay-type', compact('homestay_types', 'homestays'));
    }
    public function add_homestay_type(Request $request)
    {
        if (homestay_type::where('homestay_type_name', $request->homestay_type_name)->exists()) {
            return redirect()->back()->with('warning', "มีประเภทที่พัก ".$request->homestay_type_name." ในฐานข้อมูลเเล้ว");
        } else {
            $add_homestay_type = new homestay_type;
            $add_homestay_type->homestay_type_name = $request->homestay_type_name;
            $add_homestay_type->save();
            return redirect()->back()->with('message', "เพิ่มประเภทที่พักเสร็จสิ้น");
        }
    }
    public function delete_homestay_type($id)
    {
        homestay_type::find($id)->delete();
        return redirect()->back()->with('message', "ลบประเภทที่พักเสร็จสิ้น");
    }
    public function edit_homestay_type(Request $request)
    {
        if (homestay_type::where('homestay_type_name', $request->homestay_type_name)->exists()) {
            return redirect()->back()->with('warning', "มีประเภทที่พัก ".$request->homestay_type_name." ในฐานข้อมูลเเล้ว");
        } else {
            $update_homestay_type = homestay_type::find($request->id);
            $update_homestay_type->homestay_type_name = $request->homestay_type_name;
            $update_homestay_type->save();
            return redirect()->back()->with('message', "แก้ใขประเภทที่พักเสร็จสิ้น");
        }
    }

    public function add_homestay(Request $request)
    {
        $add_homestay = new homestay;
        $add_homestay->homestay_type_id =  $request->homestay_type;
        $add_homestay->homestay_name = $request->homestay_name;
        $add_homestay->homestay_detail = $request->details;
        $add_homestay->homestay_price = $request->price;
        $add_homestay->number_guests = $request->number_guests;
        $add_homestay->num_bedroom = $request->bedroom;
        $add_homestay->num_bathroom = $request->bathroom;
        $add_homestay->status = $request->status;
        $this->validate($request, [
            'homestay_img' => 'required',
            'homestay_img.*' => 'mimes:jpg,jpeg,png', 'max:10240'
        ]);

        foreach ($request->file('homestay_img') as $img) {
            $name = $img->getClientOriginalName();
            $img->move(public_path() . '/storage/images/', $name);
            $data[] = $name;
        }

        $add_homestay->homestay_img = json_encode($data);
        $add_homestay->save();
        return redirect()->back()->with('message', "เพิ่มที่พักเสร็จสิ้น");
    }

    public function delete_homestay($id)
    {
        homestay::find($id)->delete();
        return redirect()->back()->with('message', "ลบที่พักเสร็จสิ้น");
    }

    public function homestay_details_admin($id)
    {
        $detail = homestay::find($id);
        $homestay_types = homestay_type::all();
        $set_menus = set_menu::all();

        return view('admin.homestay-details', compact('detail', 'homestay_types','set_menus'));
    }

    public function delete_img($id, $name_img)
    {
        $update_homestay = homestay::find($id);
        $homestay = homestay::find($id);
        foreach (json_decode($homestay->homestay_img) as $img) {
            if ($img == $name_img) {
                $path = public_path() . '/storage/images/' . $img;
                unlink($path);
            } else {
                $data[] = $img;
            }
        }
        $update_homestay->homestay_img = json_encode($data);
        $update_homestay->save();
        return redirect()->back();
    }

    public function edit_homestay(Request $request, $id)
    {
        $update_homestay = homestay::find($id);
        $update_homestay->homestay_type_id =  $request->homestay_type;
        $update_homestay->homestay_name = $request->homestay_name;
        $update_homestay->homestay_detail = $request->details;
        $update_homestay->homestay_price = $request->price;
        $update_homestay->number_guests = $request->number_guests;
        $update_homestay->num_bedroom = $request->bedroom;
        $update_homestay->num_bathroom = $request->bathroom;
        $update_homestay->status = $request->status;
        if ($request->hasfile('homestay_img')) {
            $this->validate($request, [
                'homestay_img' => 'required',
                'homestay_img.*' => 'mimes:jpg,jpeg,png', 'max:10240'
            ]);

            $homestay = homestay::find($id);

            foreach (json_decode($homestay->homestay_img) as $imgIn) {
                $data[] = $imgIn;
            }

            foreach ($request->file('homestay_img') as $img) {
                $duplicate = 0;
                foreach (json_decode($homestay->homestay_img) as $imgIn) {
                    $name = $img->getClientOriginalName();
                    if ($imgIn == $name) {
                        $duplicate += 1;
                    }
                }
                if ($duplicate == 0) {
                    $img->move(public_path() . '/storage/images/', $name);
                    $data[] = $name;
                }
            }
            $update_homestay->homestay_img = json_encode($data);
        }

        $update_homestay->save();
        return redirect()->back()->with('message', "แก้ใขที่พักเสร็จสิ้น");
    }
    public function homestay_admin()
    {
        $homestays = homestay::all();
        $bookings = booking::all();

        return view('admin.homestay-admin', compact('homestays','bookings'));
    }
    public function search_homestay_admin(Request $request)
    {
        if (isset($request->homestay_name)) {
            $homestays = homestay::where('homestay_name', $request->homestay_name)->get();
            if ($homestays->count() == 0) {
                return redirect()->route('homestay-admin')->with('warning', 'ไม่มีรายการค้นหา');
            }
        } else if (isset($request->homestay_type)) {
            $homestay_type_id = homestay_type::where('homestay_type_name', $request->homestay_type)->first()->id;
            $homestays = homestay::where('homestay_type_id', $homestay_type_id)->get();
            if ($homestays->count() == 0) {
                return redirect()->route('homestay-admin')->with('warning', 'ไม่มีรายการค้นหา');
            }
        } else {
            $homestays = homestay::all();
        }

        if (($request->homestay_name != '') && ($request->homestay_type != '')) {
            $homestay_type_id = homestay_type::where('homestay_type_name', $request->homestay_type)->first()->id;
            $homestays = homestay::where('homestay_type_id', $homestay_type_id)->where('homestay_name', $request->homestay_name)->get();
            if ($homestays->count() == 0) {
                return redirect()->route('homestay-admin')->with('warning', 'ไม่มีรายการค้นหา');
            }
        }

        return view('admin.homestay-admin', compact('homestays'));
    }

    /////////////////////////////

    public function homestay_details_user($id, $date, $guests)
    {
        $details = homestay::find($id);
        return view('user.homestay-details', compact('details', 'date', 'guests'));
    }
    public function search_homestay(Request $request)
    {
        $dateRange = $request->dateRange;
        $dateArr = explode(" - ", $request->dateRange);
        $start_date = date('Y-m-d', strtotime($dateArr[0]));
        $end_date = date('Y-m-d', strtotime($dateArr[1]));

        //เข้าออกวันเดียวกัน
        //เข้าออก ไปคลุม
        //เข้าออก อยู่ระหว่าง
        //เข้า อยู่ระหว่าง
        //ออก อยู่ระหว่าง

        $booking_infos = DB::table('bookings')
            ->select('id')
            ->where(function ($query) use ($start_date, $end_date) {
                $query->where('start_date', $start_date)
                    ->Where('end_date', $end_date);
            })->orWhere(function ($query) use ($start_date, $end_date) {
                $query->where('start_date', '>', $start_date)
                    ->Where('end_date', '<', $end_date);
            })->orWhere(function ($query) use ($start_date, $end_date) {
                $query->where('start_date', '<', $start_date)
                    ->Where('end_date', '>', $end_date);
            })->orWhere(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('start_date', [$start_date, $end_date])
                    ->Where('end_date', '>', $end_date);
            })->orWhere(function ($query) use ($start_date, $end_date) {
                $query->where('start_date', '<', $start_date)
                    ->whereBetween('end_date', [$start_date, $end_date]);
            })->get();

        $answers = collect([]);

        foreach ($booking_infos as $info) {
            $booking_details = booking_detail::where('booking_id',$info->id)->get();
            foreach($booking_details as $booking_detail){
                $answers->push($booking_detail->homestay_id);
            }
        }

        $homestays = DB::table('homestays')->whereNotIn('id', $answers)->get();

        $number_guests = $request->number_guests;
        if (isset($request->number_guests)) {
            $homestays = DB::table('homestays')
                ->whereNotIn('id', $answers)
                ->where('number_guests', '>=', $number_guests)
                ->get();
        }

        $homestay_types = homestay_type::all();
        return view('user.homestay', compact('homestays', 'homestay_types', 'dateRange', 'number_guests'));
    }
}
