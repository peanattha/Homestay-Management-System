<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class appliance extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'appliances';

    public function widens()
    {
        return $this->hasMany(widen::class,'appliance_id','id');
    }

    public function homestay_details()
    {
        return $this->hasMany(homestay_detail::class,'appliance_id','id');
    }
}
