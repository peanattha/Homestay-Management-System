<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class homestay_detail extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'homestay_details';

    public function homestay()
    {
        return $this->belongsTo(homestay::class)->withTrashed();
    }

    public function appliance()
    {
        return $this->belongsTo(appliance::class)->withTrashed();
    }
}
