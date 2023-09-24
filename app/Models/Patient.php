<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;


class Patient extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table="patients";
    protected $fillable=['fullName','address','id','age','motherName','gender','userRole_id'];
    protected $hidden =[];
    public $timestamps=false;

    public function acceptanceForms()
    {
        return $this->hasMany(AcceptanceForm::class,'patient_id','id');
    }

    public function internalAccepts()
    {
        return $this->hasMany(InternalAccept::class,'patient_id','id');
    }

    public function folders()
    {
        return $this->hasOne(Folder::class,'patient_id','id');
    }

    public function reservation_calendars()
    {
        return $this->hasMany(Reservation_calendar::class,'patient_id','id');
    }

    function user_roles(){

        return $this->belongsTo(UserRole::class,'userRole_id','id');
    }



}
