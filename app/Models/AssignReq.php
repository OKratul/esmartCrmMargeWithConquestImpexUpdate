<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignReq extends Model
{
    use HasFactory;

    protected $guarded;

    public function users (){
        return $this->belongsTo(User::class,'user_id');
    }
    public function queries(){
        return $this->belongsTo(Query::class,'query_id')->with('customers');
    }
    public function reqIds(){
        return $this->belongsTo(User::class,'request_id');
    }

}
