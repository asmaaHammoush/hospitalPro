<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table="rooms";
    protected $fillable=['id','type','available_bed','classification'];
    protected $hidden =[];
    public $timestamps=false;

    public function reservation_calendar()
    {
        return $this->hasMany(Reservation_calendar::class,'room_id','id');
    }




}
