<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\user;
use App\Models\booking;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function manage_customer()
    {
        $users = user::all();
        return view('admin.manage-customer', compact('users'));
    }

    //ตรวจสอบ 22/12/65
    public function search_customer(Request $request)
    {
        if (isset($request->firstName) && isset($request->lastName)) {
            $users = user::where(DB::raw('lower(firstName)'), strtolower($request->firstName))
                ->where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();

            //ถ้าชื่อเเละนามสกุลไม่ตรง
            if ($users->count() == 0) {
                return redirect()->route('manage-customer')->with('warning', 'ไม่มีรายการค้นหา');
                // ถ้า ชื่อเเละนามสกลุตรง
            } else {
                return view('admin.manage-customer', compact('users'));
            }
            // ค้นหาเเค่ชื่อ
        } else if (isset($request->firstName)) {
            $users = user::where(DB::raw('lower(firstName)'), strtolower($request->firstName))->get();
            if ($users->count() == 0) {
                return redirect()->route('manage-customer')->with('warning', 'ไม่มีรายการค้นหาสำหรับชื่อนี้');
            } else {
                return view('admin.manage-customer', compact('users'));
            }
            // ค้นหาเเค่นามสกุล
        } else if (isset($request->lastName)) {
            $users = user::where(DB::raw('lower(lastName)'), strtolower($request->lastName))->get();
            if ($users->count() == 0) {
                return redirect()->route('manage-customer')->with('warning', 'ไม่มีรายการค้นหาสำหรับนามสกุลนี้');
            } else {
                return view('admin.manage-customer', compact('users'));
            }
        } else {
            $users = user::all();
            return view('admin.manage-customer', compact('users'));
        }
    }
    public function customer_detail($id)
    {
        $user = user::find($id);
        $bookings = booking::where('user_id', $id)->get();
        return view('admin.customer-detail', compact('user', 'bookings'));
    }
    public function add_customer(Request $request)
    {
        $info = user::where("firstName", $request->firstName)
            ->where("lastName", $request->lastName)->get();

        $checkInfoUser = user::where("firstName", $request->firstName)
            ->where("lastName", $request->lastName)
            ->where("email", $request->email)->get();

        if ($checkInfoUser->count() != 0) {
            return redirect()->route('manage-customer')->with('warning', 'ข้อมูลนี้ได้เป็นสมาชิกอยู่เเล้ว');
        } else {
            if ($info->count() != 0) {
                return redirect()->route('manage-customer')->with('warning', 'ชื่อเเละนามสกุลมีในฐานข้อมูลเเล้ว');
            } else {
                $dupEmail = user::where("email", $request->email)->get();
                if ($dupEmail->count() != 0) {
                    return redirect()->route('manage-customer')->with('warning', 'อีเมลซ้ำในฐานข้อมูล');
                } else {
                    $add_user = new user();
                    $add_user->firstName =  $request->firstName;
                    $add_user->lastName =  $request->lastName;
                    $add_user->email =  $request->email;
                    if (!empty($request->tel)) {
                        $add_user->tel =  $request->tel;
                    }
                    if (!empty($request->gender)) {
                        $add_user->gender =  $request->gender;
                    }

                    $add_user->role =  1;

                    if ($request->hasfile('img_profile')) {
                        $this->validate($request, [
                            'img_profile' => 'required',
                            'img_profile.*' => 'mimes:jpg,jpeg,png', 'max:10240'
                        ]);

                        $img = $request->file('img_profile');
                        $name = $img->getClientOriginalName();
                        $img->move(public_path() . '/storage/images/', $name);
                        $add_user->image = $name;
                    }

                    $add_user->password =  Hash::make($request->password);

                    $add_user->save();
                    return redirect()->route('manage-customer')->with('message', 'เพิ่มข้อมูลลูกค้าเสร็จสิ้น');
                }
            }
        }
    }
    public function delete_customer($id)
    {
        user::find($id)->delete();
        return redirect()->route('manage-customer')->with('message', 'ลบข้อมูลลูกค้าเสร็จสิ้น');
    }
}
