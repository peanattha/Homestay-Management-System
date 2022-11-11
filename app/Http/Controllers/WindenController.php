<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WindenController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function manage_appliance_booking(){

        return view('admin.winden-appliance-booking');
    }
    public function manage_appliance_homestay(){

        return view('admin.winden-appliance-homestay');
    }
    public function appliance_homestay_detail($id){

        return view('admin.winden-detail-homestay');
    }
    public function appliance_booking_detail($id){

        return view('admin.winden-detail-booking');
    }
}
