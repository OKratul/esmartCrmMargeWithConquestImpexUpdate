<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expanse extends Model
{
    use HasFactory;

    protected $guarded =[''];

    public function invoices (){
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function accounts(){

        return $this->belongsTo(Accounts::class,'account_id');
    }

    public function expenseNames(){
        return $this->belongsTo(ExpenseName::class,'expense_name_id');
    }

}
