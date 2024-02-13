<?php

namespace App\Models\conquest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConquestPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customers(){
        return $this->belongsTo(ConquestCustomer::class,'customer_id');
    }
}
