<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\user;

class ProfileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function profile()
    {
        $user = user::find(Auth::user()->id);
        return view('profile', compact('user'));
    }
    public function profile_admin()
    {
        $user = user::find(Auth::user()->id);
        return view('admin.profile-admin', compact('user'));
    }
    public function edit(Request $request, $id)
    {
        $tel = user::select('tel')->where('id', '!=', $id)->where('tel', $request->tel)->get();
        $email = user::select('email')->where('id', '!=', $id)->where('email', $request->email)->get();


        if ($request->tel != null) {
            if (($tel->count() == 0) && ($email->count() == 0)) {
                $update_user = user::find($id);
                $update_user->firstName = $request->firstName;
                $update_user->lastName = $request->lastName;
                $update_user->gender = $request->gender;
                $update_user->tel = $request->tel;
                if ($request->get('email') != $update_user->email) {
                    $update_user->email = $request->email;
                    $update_user->email_verified_at = null;
                }

                if ($request->hasfile('img_profile')) {
                    $this->validate($request, [
                        'img_profile' => 'required',
                        'img_profile.*' => 'mimes:jpg,jpeg,png', 'max:10240'
                    ]);

                    $img = $request->file('img_profile');
                    $name = $img->getClientOriginalName();
                    $img->move(public_path() . '/storage/images/', $name);
                    $update_user->image = $name;
                }

                $update_user->save();
                return redirect()->back()->with("message", "แก้ใขข้อมูลโปรไฟล์เสร็จสิ้น");
            } else {
                if (($tel->count() != 0) && ($email->count() != 0)) {
                    return redirect()->back()->with("warning", "อีเมล เเละ เบอร์โทรศัพทร์ ซ้ำในระบบ");
                } elseif ($email->count() != 0) {
                    return redirect()->back()->with("warning", "อีเมลซ้ำในระบบ");
                } else {
                    return redirect()->back()->with("warning", "เบอร์โทรศัพทร์ซ้ำในระบบ");
                }
            }
        }else{
            if ($email->count() == 0) {
                $update_user = user::find($id);
                $update_user->firstName = $request->firstName;
                $update_user->lastName = $request->lastName;
                $update_user->gender = $request->gender;
                if ($request->get('email') != $update_user->email) {
                    $update_user->email = $request->email;
                    $update_user->email_verified_at = null;
                }

                if ($request->hasfile('img_profile')) {
                    $this->validate($request, [
                        'img_profile' => 'required',
                        'img_profile.*' => 'mimes:jpg,jpeg,png', 'max:10240'
                    ]);

                    $img = $request->file('img_profile');
                    $name = $img->getClientOriginalName();
                    $img->move(public_path() . '/storage/images/', $name);
                    $update_user->image = $name;
                }

                $update_user->save();
                return redirect()->back()->with("message", "แก้ใขข้อมูลโปรไฟล์เสร็จสิ้น");
            } else {
                return redirect()->back()->with("warning", "อีเมลซ้ำในระบบ");
            }
        }
    }
    public function delete()
    {
        user::destroy(Auth::user()->id);
        Session::flush();
        return redirect('/');
    }

    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with("message", "รหัสผ่านปัจจุบันของคุณ ไม่ตรงกับรหัสผ่านที่ใช้อยู่.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with("error", "รหัสผ่านใหม่ ต้องไม่เหมือนกับรหัสผ่านปัจจุบันของคุณ.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8',
            'new-password-confirm' => ['same:new-password'],
        ]);

        $user = user::find(Auth::user()->id);
        $user->password = Hash::make($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success", "เปลี่ยนรหัสผ่านสำเร็จ!");
    }
}
