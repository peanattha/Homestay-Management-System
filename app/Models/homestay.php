<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class homestay extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'homestays';

    public function bookings()
    {
        return $this->hasMany(booking::class,'homestay_id','id');
    }

    public function homestay_type()
    {
        return $this->belongsTo(homestay_type::class)->withTrashed();
    }

    public function homestay_details()
    {
        return $this->hasMany(homestay_detail::class,'homestay_detail_id','id');
    }

}
