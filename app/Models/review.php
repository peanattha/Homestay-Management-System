<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class review extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'reviews';

    public function booking()
    {
        return $this->belongsTo(booking::class)->withTrashed();
    }
}
