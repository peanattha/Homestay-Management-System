<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bank_admin;
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
        return view('admin.manage-bank', compact('banks'));
    }
    public function add_bank(Request $request)
    {
        $add_bank_detail = new bank_admin;
        $add_bank_detail->firstName = $request->firstName;
        $add_bank_detail->lastName = $request->lastName;
        $add_bank_detail->bank_name =  $request->bank_name;
        $add_bank_detail->acc_number = $request->acc_number;
        if ($request->has('prompt_pay')) {
            $add_bank_detail->prompt_pay = $request->prompt_pay;
        }
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
        return redirect()->back();
    }
    public function delete_bank($id)
    {
        bank_admin::find($id)->delete();
        return redirect()->back();
    }
    public function edit_bank($id,Request $request)
    {

        $update_bank = bank_admin::find($id);
        $update_bank->firstName = $request->firstName;
        $update_bank->lastName = $request->lastName;
        $update_bank->bank_name =  $request->bank_name;
        $update_bank->acc_number = $request->acc_number;
        if ($request->has('prompt_pay')) {
            $update_bank->prompt_pay = $request->prompt_pay;
        }
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
        return redirect()->back();

    }
}
