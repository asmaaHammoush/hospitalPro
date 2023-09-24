<?php

namespace App\Http\Controllers;

use App\Http\Requests\rolesRequest;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $Roles = Role::get();
        return response()->json($Roles);
    }


  public  function storeRole(rolesRequest  $request){

     try {

         $role = Role::create([
          'name' => $request->name,
          'permission'=>$request->permission,


        ]);

       if ($role) {
           return response(["message"=>"تم الاضافة بنجاح"],200);
         } else
           return response(["message"=>"رسالة خطأ"],401);

       }catch (Exception $ex) {


         return response(['message'=>$ex->getMessage()]);
     }
     }


 public  function updateRole($id,rolesRequest $request){
      try {
      $role=Role::findOrFail($id);
         $role = $this->process($role, $request);
         if ($role) {
             return response($role,200,["تم الاضافة بنجاح"]);
           } else
             return response(null,404,["رسالة خطأ"]);
      }catch (Exception $ex){
         return $ex;
        //  return response(null,404,["رسالة خطأ"]);

   }


  }
   protected function process(Role $role,rolesRequest $request){
        $role->name=$request->name;
       $role->permission=$request->permission;
      $role->save();
        return $role;
   }

}
