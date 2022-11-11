<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class widen extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'widens';

    public function booking()
    {
        return $this->belongsTo(booking::class)->withTrashed();
    }

    public function appliance()
    {
        return $this->belongsTo(appliance::class)->withTrashed();
    }
}
