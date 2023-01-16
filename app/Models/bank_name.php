<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bank_name extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'bank_names';

    public function bank_admin()
    {
        return $this->hasOne(bank_name::class,'bank_name_id','id');
    }
}
