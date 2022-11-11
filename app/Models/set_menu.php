<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class set_menu extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'set_menus';

    public function homestays()
    {
        return $this->hasMany(homestay::class,'set_menu_id','id');
    }

}
