<?php

namespace App\Http\Controllers;


use App\Models\AcceptanceForm;
use App\Models\AcceptForm;
use App\Models\Permission;
use App\Models\Role;


use Illuminate\Support\Facades\Auth;

use Exception;
use http\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


class acceptController extends Controller
{


    public function index()
    {
        $accept= AcceptanceForm::get();
        return response()->json(['message'=>'ok','data'=>$accept],200);

//        $permission = Permission::select('Title')->get();
//        foreach ($permission as $ability)
//        {
//     //       return response()->json(['message'=>'ok','data'=>$ability->Title],200);
//            Gate::define($ability,function ($auth)use($ability){
//                return $auth->hasability($ability);
//            });
//            }
//        return response()->json(['message'=>'ok','data'=>$permission],200);

    }

    public function indexId($id)
    {
        $accept= AcceptanceForm::Find($id);
        return response()->json(['message'=>'ok','data'=>$accept],200);

    }



    public  function store(Request $request){
//        $user=Auth::user();
//
//        $role= $user->with('user_role');
//        return response($role);


     try {




         $acceptanceForm = $this->process(new AcceptanceForm, $request);
       if ($acceptanceForm) {
           return Response(["message"=>"ok","data"=>$acceptanceForm],201);
         } else
           return response(["message"=>"error in validation"],404);
       }catch (Exception $ex){

         return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}}


 public  function update(Request $request,$id){
      try {

     $accept=AcceptanceForm::find($id);
          $accept = $this->process($accept, $request);
         if ($accept) {

             return Response(["data"=>$accept,"message"=>"ok"],201);
           } else
             return response(["message"=>"error in validation"],404);
      }catch (Exception $ex){
          return response(['data'=>$ex->getMessage(),'message'=>'error'],400);

   }
  }
   public function delete($id){
       try {
           $accept=AcceptanceForm::find($id);

           if ($accept) {
               $accept->delete();
               return Response(["message"=>"ok done delete"],200);
           } else
               return response(["message"=>"acceptanceForm not Found"],404);
       }catch (Exception $ex){
           return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
       }


   }

   protected function process(AcceptanceForm $accept,Request $request){

        foreach ($accept->fillable as  $fillables){

       $accept->$fillables=$request->$fillables;

   }
        $accept->save();
        return $accept;
    }
    public function search($id){
        try{
            $acceptanceForm=AcceptanceForm::where(['id'=>$id])->first();

            if ($acceptanceForm) {

                return Response(["message"=>"ok",'data'=>$acceptanceForm],200);
            } else
                return response("User not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }
    }

}
