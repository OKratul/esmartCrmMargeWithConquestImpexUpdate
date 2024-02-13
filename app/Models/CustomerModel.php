<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function quotations(){
        return $this->hasMany(Quotation::class,'customer_id');
    }
    public function queries(){
        return $this->hasMany(Query::class,'customer_id')->with('notes');
    }
    public function invoices (){
        return $this->hasMany(Invoice::class,'customer_id');
    }

    public function notes(){
        return $this->hasMany(CustomerNotes::class);
    }


}
