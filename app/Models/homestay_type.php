<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class homestay_type extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'homestay_types';

    public function homestays()
    {
        return $this->hasMany(homestay::class,'homestay_type_id','id');
    }

}
