<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Doctor_time extends Model
{
    protected $table="doctor_times";
    protected $fillable=['id','doctor_id','Sun','Mon','Tue','Wed','Thu'];
    protected $hidden =['doctor_id'];
    public $timestamps=false;

    public function doctors()
    {
        return $this->belongsTo(Doctor::class,'doctor_id','id');
    }



}
