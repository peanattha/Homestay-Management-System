<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\homestay;
use App\Models\homestay_type;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->email_verified_at == NULL) {
                return redirect('email/verify');
            } else {
                if (Auth::user()->role == 2) {
                    return view('admin.dashboard');
                } else {
                    return view('home');
                }
            }
        } else {
            return view('home');
        }
    }
    public function accommodation_rules()
    {
        return view('description.accommodation-rules');
    }
    public function description_details(){
        return view('description.details');
    }
    public function service_charge(){
        return view('description.service-charge');
    }
    public function homestay(){
        $homestay_types = homestay_type::all();
        return view('user.homestay',compact('homestay_types'));
    }
}
