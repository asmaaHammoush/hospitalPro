<?php

namespace App\Http\Controllers;


use App\Models\AcceptanceForm;
use App\Models\AcceptForm;
use App\Models\Folder;
use App\Models\FolderForm;
use App\Models\Role;

use Exception;
use http\Message;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


class internalFolderFormController extends Controller
{
    public function index()
    {
        $folderForm = FolderForm::get();
        return response($folderForm);
    }

//    public function indexId($id)
//    {
//        $folderForm = FolderForm::find($id);
//        return response($folderForm);
//    }
//



    public  function addCol(Request $req){


    $folderForm=FolderForm::where(['lable'=>$req->lable])->first();

    if($folderForm ){



            return response(["message" => "find already."]);
        }
        else{
            $this->addColumn($req);

            $folderForm=FolderForm::create([

                'lable'=>$req->lable,
                'type'=>$req->type,

            ]);
            if ($folderForm) {

                return response(["message"=>"تم الاضافة بنجاح"],201);
            } else
                return response(["message"=>"رسالة خطأ"],404);

          //  return response(["message" => "done add success."],201);
        }


   }
    public  function addColumn( Request $req ){


        $name=$req->lable;
      //  $type=$req->type;

        Schema::table('folders', function (  Blueprint $table) use ($name) {

            $table->text($name)->nullable();
        });


    }
    public function deleteColumnSmall($id){
        try {
            $folderForm=FolderForm::find($id);


            if ($folderForm) {
                $this->delColumnBig($folderForm);
                $folderForm->delete();

                return Response(["message"=>"ok"],200);
            } else
                return response("Column not found in AcceptanceForm ",404);
        }catch (Exception $ex){
            // return $ex;
            return response("رسالة خطأ",400);
        }


    }
    public  function delColumnBig( FolderForm $folderForm){


        $name=$folderForm->lable;

            Schema::table('folders', function($table)  use ($name){
                $table->dropColumn($name);

            });

    }


    public  function updateColumnFolderForm($id,Request $req){
        try {

            $folder=FolderForm::find($id);
            if ($folder) {

                $Newname=$req->lable;

                $Newtype=$req->type;

                $Oldname= $folder->lable;
                $OldType=$folder->type;
                if(strcmp($OldType,$Newtype)==0) {
                    Schema::table('folders', function ($table) use ($Newname, $Oldname) {
                        $table->renameColumn($Oldname, $Newname);
                    });
                    $folder->lable=$req->lable;
                    $folder->save();
                    return Response(["data"=>$folder,"message"=>"ok"],201);
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
