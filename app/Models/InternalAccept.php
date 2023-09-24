<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class InternalAccept extends Model
{
    protected $table="internalAccepts";
    protected $fillable=['id','department','doctor','operation','internalDate','externalDate','patient','folder_id','room_id'];
    protected $hidden =[];
    public $timestamps=false;


    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient','FullName');
    }

    public function reservation_calendars()
    {
        return $this->hasOne(Reservation_calendar::class,'internalAccept_id','id');
    }
}
