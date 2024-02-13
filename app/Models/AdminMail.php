<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMail extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function admins(){
        return $this->belongsTo(CrmAdmin::class,'admin_id');
    }
}
