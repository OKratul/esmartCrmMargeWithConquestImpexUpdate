<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [ ];

    public function users (){
        return $this->belongsTo(User::class,'user_id');
    }
    public function customers(){
        return $this->belongsTo(CustomerModel::class,'customer_id');
    }

    public function invoices(){
        return $this->belongsTo(Invoice::class,'invoice_id');
    }

    public function accounts(){
        return $this->belongsTo(Accounts::class,'account_id');
    }

}
