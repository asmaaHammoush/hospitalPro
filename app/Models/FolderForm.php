<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FolderForm extends Model
{
    protected $table="folderForms";
    protected $fillable=['lable','type','id'];
    protected $hidden =[];
    public $timestamps=false;

}
