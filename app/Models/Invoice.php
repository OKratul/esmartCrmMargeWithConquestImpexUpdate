<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function customers(){
        return $this->belongsTo(CustomerModel::class,'customer_id');
    }
    public function payments(){
        return $this->hasMany(Payment::class,'invoice_id');
    }
    public function expanses(){
        return $this->hasMany(Expanse::class,'invoice_id');
    }
    public function admins(){
        return $this->belongsTo(CrmAdmin::class,'admin_id');
    }
}
