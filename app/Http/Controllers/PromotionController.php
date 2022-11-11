<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromotionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function manage_promotion(){

        return view('admin.manage-promotion');
    }

    public function promotion_admin(){

        return view('admin.promotion-admin');
    }
    public function promotion_detail($id){

        return view('admin.promotion-detail');
    }
}
