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
        return redirect()->back();
    }
    public function add(Request $request)
    {
        if (user::where('email', $request->email)->exists()) {
            $role = user::where('email', $request->email)->first()->role;
            if ($role == 2) {
                return redirect()->back()->with('notEmail', true)->with('emailAdmin', $request->email);
            } else {
                $add_admin = user::find(user::where('email', $request->email)->first()->id);
                $add_admin->role = 2;
                $add_admin->save();
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('notEmail', true)->with('email', $request->email);
        }
    }
}
