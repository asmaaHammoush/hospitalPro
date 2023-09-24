<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Reservation_calendar extends Model
{
    protected $table="reservation_calendars";
    protected $fillable=['doctor','patient','motherName','opration','specialization','narcosis','medical_diagnosis','room_id','date','doctor_id','operatingRoom_id','internalAccept_id','confirm','hourNum','timeStart','folder_id'];
    protected $hidden =['doctor_id','patient_id','operatingRoom_id'];
    public $timestamps=false;
    public function daily_calendars()
    {
        return $this->belongsTo(Daily_calendar::class,'calendar_id','id');
    }

    public function rooms()
    {
        return $this->belongsTo(Room::class,'room_id','id');
    }

    public function folders()
    {
        return $this->belongsTo(Folder::class,'folder_id','id');
    }
    public function doctors()
    {
        return $this->belongsTo(Doctor::class,'doctor_id','id');
    }
    public function patients()
    {
        return $this->belongsTo(Patient::class,'patient_id','id');
    }

    public function operatingRoomSituations()
    {
        return $this->belongsTo(Operatingroomsituation::class,'operatingRoom_id','id');
    }

    public function internalAccepts()
    {
        return $this->belongsTo(InternalAccept::class,'internalAccept_id','id');
    }


}
