<?php

namespace App\Http\Controllers;


use App\Models\AcceptanceForm;
use App\Models\AcceptForm;
use App\Models\Role;

use Exception;
use http\Message;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


class acceptFormController extends Controller
{
    public function index()
    {
        $acceptForm = AcceptForm::get();
        return response($acceptForm);
    }



public  function addCol(Request $req){


    $acceptForm=AcceptForm::where(['lable'=>$req->lable])->first();

    if($acceptForm ){



            return response(["message" => "find already."]);
        }
        else{
            $this->addColumn($req);

            $acceptForm=AcceptForm::create([
                'lable'=>$req->lable,
                'type'=>$req->type,



            ]);
            if ($acceptForm) {

                return response(["message" => "done add success."],201);
            } else
                return response(["message"=>"error in validation "],404);

          //  return response(["message" => "done add success."],201);
        }
    }



    public  function addColumn( Request $req ){


        $name=$req->lable;

       //  $property=$req->property;
        Schema::table('acceptanceforms', function (  Blueprint $table) use ($name) {

            $table->text($name)->nullable();
        });


    }
    public function deleteColumnSmall($id){
        try {
            $acceptForm=AcceptForm::find($id);
            //  $user = $this->process(new User(), $request);

            if ($acceptForm) {
               // $data=AcceptanceForm::get();

                $this->delColumnBig($acceptForm);
                $acceptForm->delete();

                return Response(["message"=>"ok"],200);
            } else
                return response("Column not found in AcceptanceForm ",404);
        }catch (Exception $ex){
            // return $ex;
            return response("رسالة خطأ",400);
        }


    }
    public  function delColumnBig( AcceptForm $acceptForm){


        $name=$acceptForm->lable;

            Schema::table('acceptanceforms', function($table)  use ($name){
                $table->dropColumn($name);

            });

    }


    public  function updateColumnAcceptForm($id,Request $req){
        try {


            $acceptForm=AcceptForm::find($id);

            if ($acceptForm) {

               $Newname=$req->lable;

               $Newtype=$req->type;

               $Oldname= $acceptForm->lable;
               $OldType=$acceptForm->type;
               if(strcmp($OldType,$Newtype)==0) {
                   Schema::table('acceptanceforms', function ($table) use ($Newname, $Oldname) {
                       $table->renameColumn($Oldname, $Newname);
                   });
                   $acceptForm->lable=$req->lable;
                   $acceptForm->save();
                   return Response(["data"=>$acceptForm,"message"=>"ok"],201);
               }
                else{
                    return response(['message'=>'cant update type of column because data has found with another type']);
                }


            } else
                return response(" Column not Found in AcceptanceForm",404);
        }catch (Exception $ex){
            return response($ex->getMessage(),404);

        }
    }



}
