<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AcceptForm extends Model
{
    protected $table="acceptforms";
    protected $fillable=['lable','type','id'];
    protected $hidden =[];
    public $timestamps=false;

}
