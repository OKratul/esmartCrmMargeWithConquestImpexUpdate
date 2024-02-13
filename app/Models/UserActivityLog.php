<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function admins(){
        return $this->belongsTo(CrmAdmin::class,'admin_id');
    }

}
