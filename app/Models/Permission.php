<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table="permissions";
    protected $fillable=['Title','id'];
    protected $hidden =[];
    public $timestamps=false;

    public function role()
    {
        return $this->belongsToMany(Role::class,'permission_roles','permission_id','role_id','id','id');
    }




}
