<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function users(){
        return $this->hasOne(UserProfile::class,'user_id');
    }

}
