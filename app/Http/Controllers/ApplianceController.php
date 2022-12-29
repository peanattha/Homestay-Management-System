<?php

namespace App\Http\Controllers;

use App\Models\appliance;
use Illuminate\Http\Request;

class ApplianceController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function manage_appliance()
    {

        $appliances = appliance::all();
        return view('admin.manage-appliance', compact('appliances'));
    }

    public function add_appliance(Request $request)
    {

        $add_appliance = new appliance;
        $add_appliance->appliance_name = $request->appliance_name;
        $add_appliance->stock = $request->amount;
        $add_appliance->price = $request->price;

        $add_appliance->save();
        return redirect()->back()->with('message', "เพิ่มของใช้เสร็จสิ้น");
    }

    public function edit_appliance(Request $request)
    {

        $update_appliance = appliance::find($request->id);
        $update_appliance->appliance_name = $request->appliance_name;
        $update_appliance->stock = $request->amount;
        $update_appliance->price = $request->price;

        $update_appliance->save();
        return redirect()->back()->with('message', "แก้ใขของใช้เสร็จสิ้น");
    }

    public function delete_appliance($id)
    {

        appliance::find($id)->delete();
        return redirect()->back()->with('message', "ลบของใช้เสร็จสิ้น");
    }
}
