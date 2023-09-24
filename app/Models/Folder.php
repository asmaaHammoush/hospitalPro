<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Folder extends Model
{
    protected $table="folders";
     public $fillable=[];
    protected $hidden =[];
    public $timestamps=false;


    public function __construct()
    {
        $this->setFillable();
    }


    public function setFillable()
    {
        $fields = Schema::getColumnListing("folders");



            $this->fillable = $fields;



    }
    public function reservation_calendars(){

        $this->hasMany(Reservation_calendar::class,'folder_id','id');

    }


}
