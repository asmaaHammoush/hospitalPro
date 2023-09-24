<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Daily_calendar extends Model
{
    protected $table="daily_calendars";
    protected $fillable=['id','day','date'];
    protected $hidden =['id'];
    public $timestamps=false;


    public function reservation_calendar()
    {
        return $this->hasMany(Reservation_calendar::class,'calendar_id','id');
    }

    public function operatingroomsituations()
    {
        return $this->hasMany(Operatingroomsituation::class,'calendar_id','id');
    }
}
