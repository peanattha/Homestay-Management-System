<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplianceController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function manage_appliance(){

        return view('admin.manage-appliance');
    }


}
