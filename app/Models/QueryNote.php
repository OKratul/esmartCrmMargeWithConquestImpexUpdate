<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryNote extends Model
{
    use HasFactory;

    protected $guarded = [''];


    public function users(){
        return $this->hasMany(User::class,'id');
    }

}
