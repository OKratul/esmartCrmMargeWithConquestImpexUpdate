<?php

namespace App\Models\conquest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConquestProduct extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function stocks(){
        return $this->hasOne(ConquestProductStock::class,'product_id');
    }

    public function histories()
    {
        return $this->morphMany(ConquestHistory::class, 'historable');
    }
}
