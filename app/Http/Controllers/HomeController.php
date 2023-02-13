<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\homestay;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->email_verified_at == NULL) {
                return redirect('email/verify');
            } else {
                if (Auth::user()->role == 2) {
                    return redirect()->route('admin-dashboard');
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
        $homestays_filter = homestay::all();
        return view('user.homestay',compact('homestays_filter'));
    }
    public function calendar_booking_user()
    {
        $bookings = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('homestays', 'booking_details.homestay_id', '=', 'homestays.id')
            ->select('bookings.id', 'bookings.start_date', 'bookings.end_date', 'homestays.homestay_name')
            ->Where('bookings.status', '!=', 4)
            ->get()->groupBy('id');

        return view('user.calendar-booking-user', compact('bookings'));
    }
}
