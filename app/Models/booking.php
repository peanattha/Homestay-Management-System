<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'bookings';

    public function user()
    {
        return $this->belongsTo(user::class)->withTrashed();
    }

    public function homestay()
    {
        return $this->belongsTo(homestay::class)->withTrashed();
    }

    public function widens()
    {
        return $this->hasMany(widen::class,'booking_id','id');
    }

    public function set_menu()
    {
        return $this->belongsTo(set_menu::class)->withTrashed();
    }

    public function payments()
    {
        return $this->hasMany(payment::class,'payment_id','id');
    }

    public function review()
    {
        return $this->hasOne(booking::class,'review_id','id');
    }
    public function promotion()
    {
        return $this->belongsTo(promotion::class)->withTrashed();
    }
}
