<?php

namespace App\Models\conquest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConquestAccount extends Model
{
    use HasFactory;

    protected $guarded;

    public function transections(){

        return $this->hasMany(ConquestTransection::class,'account_id');

    }
}
