<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table="roles";
    protected $fillable=['id','name'];
    protected $hidden =[];
    public $timestamps=false;
//
//    public function users()
//    {
//        return $this->belongsToMany(User::class,'user_roles','role_id','user_id','id','id');
//    }
//
    public function permission()
    {
        return $this->belongsToMany(Permission::class,'permission_roles','role_id','permission_id','id','id');
    }


    function userRole(){

       return $this->hasMany(UserRole::class,'role_id','id');
    }


//public function getPermission($permission){
//    return json_decode($permission,true);
//
//}



}
