<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class CrmAdmin extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $guarded = [];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function quotationHistories(){

        return $this->hasMany(QuotationHistory::class);

    }

    public function invoice() {
        return $this->hasMany(Invoice::class);
    }

    public function mails(){
        return $this->hasMany(AdminMail::class);
    }

    public function attendances(){

        return $this->hasMany(UserActivityLog::class,'id');

    }

    public function notes(){
        return $this->hasMany(CustomerNotes::class);
    }

}
