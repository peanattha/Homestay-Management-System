<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class promotion extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'promotions';

    public function bookings()
    {
        return $this->hasMany(booking::class,'promotion_id','id');
    }
}
