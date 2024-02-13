<?php

namespace App\Models\conquest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConquestInvoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customers(){
        return $this->belongsTo(ConquestCustomer::class,'customer_id');
    }

    public function payments(){
        return $this->belongsTo(ConquestPayment::class,'invoice_id');
    }
    public function transections(){

        return $this->hasMany(ConquestTransection::class,'invoice_id');

    }
}
