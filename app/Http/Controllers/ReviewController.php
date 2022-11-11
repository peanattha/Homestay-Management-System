<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function manage_review(){

        return view('admin.manage-review');
    }

    public function review_admin(){

        return view('admin.review-admin');
    }
    public function review_detail($id){

        return view('admin.review-detail');
    }
}
