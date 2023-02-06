<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bank_admin;
use App\Models\bank_name;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function manage_bank()
    {
        $banks = bank_admin::all();
        $bank_names = bank_name::all();
        return view('admin.manage-bank', compact('banks', 'bank_names'));
    }

    public function manage_bank_name()
    {
        $bank_names = bank_name::all();
        return view('admin.manage-bank-name', compact('bank_names'));
    }

    public function add_bank_name(Request $request)
    {
        $add_bank_name = new bank_name;
        $add_bank_name->name = $request->bank_name;

        $add_bank_name->save();
        return redirect()->back()->with('message', "เพิ่มชื่อธนาคารเสร็จสิ้น");
    }

    public function edit_bank_name(Request $request)
    {
        if (bank_name::where('name', $request->bank_name)->exists()) {
            return redirect()->back()->with('warning', "มีชื่อธนาคาร " . $request->bank_name . " ในฐานข้อมูลเเล้ว");
        } else {
            $update_bank_name = bank_name::find($request->id);
            $update_bank_name->name = $request->bank_name;

            $update_bank_name->save();
            return redirect()->back()->with('message', "แก้ใขชื่อธนาคารเสร็จสิ้น");
        }
    }

    public function delete_bank_name($id)
    {
        bank_name::find($id)->delete();
        return redirect()->back()->with('message', "ลบชื่อธนาคารเสร็จสิ้นเสร็จสิ้น");
    }

    public function add_bank(Request $request)
    {
        $add_bank_detail = new bank_admin;
        $add_bank_detail->firstName = $request->firstName;
        $add_bank_detail->lastName = $request->lastName;
        $add_bank_detail->bank_name_id =  $request->bank_name;
        $add_bank_detail->acc_number = $request->acc_number;
        $add_bank_detail->prompt_pay = $request->prompt_pay;

        if ($request->hasfile('qr_code')) {
            $this->validate($request, [
                'qr_code' => 'required',
                'qr_code.*' => 'mimes:jpg,jpeg,png', 'max:10240'
            ]);

            $img = $request->file('qr_code');
            $name = $img->getClientOriginalName();
            $img->move(public_path() . '/storage/images/', $name);
            $add_bank_detail->qr_code = $name;
        }

        $add_bank_detail->save();
        return redirect()->back()->with('message', "เพิ่มบัญชีชำระเงินเสร็จสิ้น");
    }

    public function delete_bank($id)
    {
        bank_admin::find($id)->delete();
        return redirect()->back()->with('message', "ลบบัญชีชำระเงินเสร็จสิ้น");
    }

    public function edit_bank($id, Request $request)
    {
        $update_bank = bank_admin::find($id);
        $update_bank->firstName = $request->firstName;
        $update_bank->lastName = $request->lastName;
        $update_bank->bank_name_id =  $request->bank_name;
        $update_bank->acc_number = $request->acc_number;
        $update_bank->prompt_pay = $request->prompt_pay;

        if ($request->hasfile('qr_code')) {
            $this->validate($request, [
                'qr_code' => 'required',
                'qr_code.*' => 'mimes:jpg,jpeg,png', 'max:10240'
            ]);

            $img = $request->file('qr_code');
            $name = $img->getClientOriginalName();
            $img->move(public_path() . '/storage/images/', $name);
            $update_bank->qr_code = $name;
        }

        $update_bank->save();
        return redirect()->back()->with('message', "แก้ใขบัญชีชำระเงินเสร็จสิ้น");
    }
}
