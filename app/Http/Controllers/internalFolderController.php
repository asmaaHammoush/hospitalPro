<?php

namespace App\Http\Controllers;


use App\Models\AcceptanceForm;
use App\Models\AcceptForm;
use App\Models\Folder;
use App\Models\Role;

use Exception;
use http\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


class internalFolderController extends Controller
{


    public function index()
    {
        $folder= Folder::get();
        return response()->json($folder,200);

    }


    public function indexId($id)
    {
        $folder= Folder::find($id);
        return response()->json($folder,200);

    }

    public  function store(Request $request){
     try {

         $folder = $this->process(new Folder(), $request);
       if ($folder) {
           return Response(["message"=>"ok","data"=>$folder],201);
         } else
           return response(["message"=>"error in validation"],404);
     }catch (Exception $ex){

         return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}}


 public  function updateFolder(Request $request,$id){
      try {

          $folder=Folder::find($id);
          $folder = $this->process($folder, $request);
         if ($folder) {

             return Response(["data"=>$folder,"message"=>"ok"],201);
           } else
             return response("Folder not found ",404);
      }catch (Exception $ex){
          return response(['data'=>$ex->getMessage(),'message'=>'error'],400);

   }
  }
   public function deleteFolder($id){
       try {
           $folder=Folder::find($id);


           if ($folder) {
               $folder->delete();
               return Response(["message"=>"ok  delete done"],200);
           } else
               return response("Folder not found",404);
       }catch (Exception $ex){

           return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
       }


   }


    protected function process(Folder $folder,Request $request){

        foreach ($folder->fillable as  $fillables){

            $folder->$fillables=$request->$fillables;

        }
        $folder->save();
        return $folder;
    }

    public function search($id){
        try{
            $folder=Folder::where(['id'=>$id])->first();

            if ($folder) {

                return Response(["message"=>"ok",'data'=>$folder],200);
            } else
                return response("Folder not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }
    }

}
