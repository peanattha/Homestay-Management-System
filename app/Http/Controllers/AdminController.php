<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function manage()
    {
        $admins = user::where('role', 2)->get();
        return view('admin.manage-admin', compact('admins'));
    }
    public function delete(Request $request)
    {
        $delete_admin = user::find($request->id);
        $delete_admin->role = 1;
        $delete_admin->save();
        return redirect()->back()->with('message', "ลบสิทธิ์ผู้ดูเเลระบบให้อีเมล ".$delete_admin->email." เสร็จสิ้น");
    }
    public function add(Request $request)
    {
        if (user::where('email', $request->email)->exists()) {
            $role = user::where('email', $request->email)->first()->role;
            if ($role == 2) {
                return redirect()->back()->with('warning', "อีเมลนี้ ".$request->email." มีสิทธิ์ผู้ดูเเลระบบเเล้ว");
            } else {
                $add_admin = user::find(user::where('email', $request->email)->first()->id);
                $add_admin->role = 2;
                $add_admin->save();
                return redirect()->back()->with('message', "เพิ่มสิทธิ์ผู้ดูเเลระบบให้อีเมล ".$request->email." เสร็จสิ้น");
            }
        } else {
            return redirect()->back()->with('warning', "ไม่มีอีเมลนี้ ".$request->email." ในฐานข้อมูล");
        }
    }
}
