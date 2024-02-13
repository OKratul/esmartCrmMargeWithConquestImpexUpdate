<?php

namespace App\Models\conquest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConquestProductStock extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function products(){

        return $this->belongsTo(ConquestProduct::class);

    }

    public function histories()
    {
        return $this->morphMany(ConquestHistory::class, 'historable');
    }
}
