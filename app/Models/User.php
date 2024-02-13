<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\QueryNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function code(){
        return $this->hasOne(UserVerificationCode::class);
    }
    public function queries(){
        return $this->hasMany(Query::class,);
    }
    public function quotations(){
        return $this->hasMany(Quotation::class);
    }
    public function invoices(){
        return $this->hasMany(Invoice::class,'user_id');
    }
    public function payments(){
        return $this->hasMany(Payment::class);
    }
    public function histories(){
        return $this->hasMany(QuotationHistory::class);
    }

    public function Profiles(){

        return $this->hasOne(UserProfile::class);
    }

    public function emailAccounts(){
        return $this->hasMany(MailAccount::class);
    }

    public function assignReqes(){
        return $this->hasMany(AssignReq::class,'user_id');
    }

    public function assignTo(){
        return $this->hasOne(AssignReq::class,'request_id');
    }

    public function attendances(){
        return $this->hasMany(UserActivityLog::class);
    }

    public function tasks(){
        return $this->hasMany(AssignTask::class,);
    }

    public function notes(){
        return $this->hasMany(CustomerNotes::class);
    }

//    public function notifications(){
//
////        return $this->
//    }

}
