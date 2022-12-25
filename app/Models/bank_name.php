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
        return $this->belongsTo(bank_admin::class)->withTrashed();
    }
}
