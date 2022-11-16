<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class booking_detail extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'booking_details';

    public function booking()
    {
        return $this->belongsTo(booking::class)->withTrashed();
    }

    public function homestay()
    {
        return $this->belongsTo(homestay::class)->withTrashed();
    }
}
