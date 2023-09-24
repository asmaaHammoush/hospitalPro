<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class UserRole extends Model
{
    protected $table="user_roles";

    protected $hidden =[];
    public $timestamps=false;
    public $fillable=['id','phoneNum','email','password','role_id'];



    function users(){

      return  $this->hasOne(User::class,'userRole_id','id');
    }




    function patients(){

        return  $this->hasOne(Patient::class,'userRole_id','id');
    }


    function doctors(){

        return  $this->hasOne(Doctor::class,'userRole_id','id');
    }






//    function users(){
//
//        $this->hasMany(User::class,'user_id','id');
//    }
//
//
    function roles(){

      return  $this->belongsTo(Role::class,'role_id','id');
    }


}
