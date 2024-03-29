<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\booking;
use App\Models\review;
use Carbon\Carbon;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role == 2) {
            $cBookings = booking::orWhere('status', 3)->where('start_date', Carbon::today())
                ->orWhere('status', 1)->where('end_date', Carbon::today())
                ->orWhere('status', 6)
                ->orWhere('status', 7)
                ->get()->count();

            $cCheckIn = booking::where('status', 3)->where('start_date', Carbon::today())->get()->count();
            $cCheckOut = booking::where('status', 1)->where('end_date', Carbon::today())->get()->count();
            $cWaitConfirm = booking::where('status', 6)->get()->count();
            $cWaitcancel = booking::where('status', 7)->get()->count();
            $cWaitReply = review::where('reply', null)->get()->count();

            session(['noti' => [
                'cBookings' => $cBookings,
                'cCheckIn' => $cCheckIn,
                'cCheckOut' => $cCheckOut,
                'cWaitConfirm' => $cWaitConfirm,
                'cWaitcancel' => $cWaitcancel,
                'cWaitReply' => $cWaitReply,
            ]]);

            return $next($request);
        } else {
            return redirect('/')->with('notAdmin','คุณไม่ใช่ผู้ดูเเลระบบ');
        }
    }
}
