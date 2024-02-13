<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $guarded =[''];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function customers(){
        return $this->belongsTo(CustomerModel::class,'customer_id');
    }

    public function histories(){

        return $this->hasMany(QuotationHistory::class);

    }
}
