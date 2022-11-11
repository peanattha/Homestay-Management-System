<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'payments';

    public function bank_admin()
    {
        return $this->belongsTo(bank_admin::class)->withTrashed();
    }

    
}
