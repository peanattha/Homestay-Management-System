<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bank_admin extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'bank_admins';

    public function payments()
    {
        return $this->hasMany(payment::class,'bank_admin_id','id');
    }

    public function bank_name()
    {
        return $this->belongsTo(bank_name::class)->withTrashed();
    }
}
