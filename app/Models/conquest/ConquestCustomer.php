<?php

namespace App\Models\conquest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConquestCustomer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoices (){

        return $this->hasMany(ConquestInvoice::class,'customer_id');
    }

    public function payments(){
        return $this->hasMany(ConquestPayment::class,'customer_id');
    }

}
