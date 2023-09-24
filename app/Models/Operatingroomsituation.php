<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Operatingroomsituation extends Model
{
    protected $table="operatingroomsituations";
    protected $fillable=['operatingRoom','type','day','date'];
    protected $hidden =['calendar_id'];
    public $timestamps=false;

    public function daily_calendars()
    {
        return $this->belongsTo(Daily_calendar::class,'calendar_roles','id');
    }

    public function reservation_calendar()
    {
        return $this->hasMany(Reservation_calendar::class,'operatingRoom_id','id');
    }


}
