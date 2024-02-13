<?php

namespace App\Models\conquest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConquestHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'historable_id',
        'historable_type',
        'previous_stock',
        'updated_stock',
    ];

    public function historable()
    {
        return $this->morphTo();
    }
}
