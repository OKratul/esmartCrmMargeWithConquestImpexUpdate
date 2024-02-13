<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseName extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function expanses(){
        return $this->hasMany(Expanse::class);
    }

}
