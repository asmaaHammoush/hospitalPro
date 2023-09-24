<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table='users';
    protected $fillable = ['id','fullName','motherName','address','userRole_id'];
    protected $hidden = [];
    public $timestamps=false;
   // protected $casts = ['email_verified_at' => 'datetime',];

//    public function roles()
//    {
//        return $this->belongsToMany(Role::class,'user_roles','user_id','role_id','id','id');
//    }

    function user_roles(){

       return $this->belongsTo(UserRole::class,'userRole_id','id');
    }



    public function hasability($permisionss)
    {
        $role = $this->user_roles;
        if (!$role->role_id) {
            return false;
        }
        $role = Role::where('id', $role->role_id)->first();
        $permisions = $role->permission;
        foreach ($permisions as $permission) {
            if (strcmp($permission, $permisionss) == 0) {


                return true;

            }

            return false;
        }

    }

}
