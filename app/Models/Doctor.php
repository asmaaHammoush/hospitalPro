<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class Doctor extends Authenticatable
{

    use HasApiTokens , HasFactory, Notifiable;
    protected $table="doctors";
    protected $fillable=['id','fullName','motherName','specialization','address','userRole_id'];
    protected $hidden =[];
    public $timestamps=false;

    public function doctor_times()
    {
        return $this->hasOne(Doctor_time::class,'doctor_id','id');
    }
    public function reservation_calendars ()
    {
        return $this->hasmany(Reservation_calendar::class,'doctor_id','id');
    }

    function user_roles(){

        return $this->belongsTo(UserRole::class,'userRole_id','id');
    }




}
