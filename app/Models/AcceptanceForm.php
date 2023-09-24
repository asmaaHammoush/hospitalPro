<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class AcceptanceForm extends Model
{
    protected $table="acceptanceForms";

    protected $hidden =[];
    public $timestamps=false;
    public $fillable=[];

    public function __construct()
    {
        $this->setFillable();
    }


    public function setFillable()
    {
        $fields = Schema::getColumnListing("acceptanceforms");
         $this->fillable=$fields;

    }


}
