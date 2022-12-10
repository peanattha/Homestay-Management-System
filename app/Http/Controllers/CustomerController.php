<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\user;
use App\Models\booking;
use Illuminate\Support\Facades\DB;

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
    public function search_customer(Request $request)
    {
        $firstName = user::where('firstName', $request->firstName)->get();
        $lastName = user::where('lastName', $request->lastName)->get();
        if (($firstName->count() == 0) || ($lastName->count() == 0)) {
            return redirect()->route('manage-customer')->with('error', 'ไม่มีรายการค้นหา');
        } else {
            $user_id = DB::table('users')
                ->where('firstName', $request->firstName)
                ->where('lastName', $request->lastName)
                ->first()->id;

            $users = user::where('id', $user_id)->get();
            return view('admin.manage-customer', compact('users'));
        }
    }
    public function customer_detail($id)
    {
        $user = user::find($id);
        $bookings = booking::where('user_id', $id)->get();
        return view('admin.customer-detail', compact('user', 'bookings'));
    }
}
