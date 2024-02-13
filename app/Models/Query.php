<?php

namespace App\Models;

use App\Notifications\QueryNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Query extends Model
{
    use Notifiable;
    use HasFactory;
    protected $guarded =[''];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function customers(){
        return $this->belongsTo(CustomerModel::class,'customer_id');
    }
    public function notes (){
        return $this->hasMany(QueryNote::class,'query_id');
    }

    public function assignReq(){
        return $this->hasOne(AssignReq::class);
    }



}
