<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\AcceptanceForm;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class accountController extends Controller
{
    public function csrf(Request $request)
    {
      $token=$request->session()->token();
        return response()->json(['message'=>'ok','data'=>$token],200);
    }

    public function index()
    {
        $users = User::with('user_roles')->get();
        return response()->json(['message'=>'ok','data'=>$users],200);
    }

    public function indexId($id)
    {
        $users = User::find($id)->with('user_roles')->get();
        return response()->json(['message'=>'ok','data'=>$users],200);
    }
//    public function indexId($id)
//    {
//        $users = User::find($id);
//        return response()->json(['message'=>'ok','data'=>$users],200);
//    }


//    public function index()
//    {
//
//
//        $users = User::latest()->where('id','<>',auth()->id())->get();
//
//       return response()->json($users,200,["success"]);
//    }

    public  function store(UserRequest $request){
     try {

                 $user=new User();
                 $userRole=new UserRole();
               $user=$this->process($user,$userRole,$request);
       if ($user) {
          // $user = $user->with('user_roles')->first();
           return response(["message"=>"ok",'data'=>$user],201);
         } else
           return response(["message"=>"error in validation"],404);
       }catch (Exception $ex){

       return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}}


 public  function update($id,UserRequest $request){
      try {
          $user=User::where('id',$id)->with('user_roles')->first();
          $userRole=$user->user_roles;
         $user = $this->process($user,$userRole, $request);
         if ($user) {


             return response(['data'=>$user,'message'=>'ok'],200);

           } else
             return response(['message'=>'not found'],404);
      }catch (Exception $ex){

           return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
   }


  }


   protected function process(User $user,$userRole,UserRequest $request){



                 $user->fullName=$request->fullName;
                  $user->motherName=$request->motherName;
                  $user->address=$request->address;

       $userRole->phoneNum=$request->phoneNum;
       $userRole->email=$request->email;
       $userRole->password=Hash::make($request->password);
      $userRole->role_id=$request->role_id;
       $userRole->save();
       $userRole->users()->save($user);
       $user =$user->with('user_roles')->first();
        return $user;
   }

    public function delete($id){
        try {
            $user=User::find($id);


            if ($user) {
                $userRole = $user->user_roles;

                if ($userRole) {
                   // $user->user_roles()->delete($userRole);
                    $userRole->delete();

                }
                $user->delete();

                return Response(["message" => "ok"], 200,);
            }
             else
                return response("User not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }


    }
    public function search($phoneNum){
        try{
        $user=UserRole::where(['phoneNum'=>$phoneNum])->with('users')->get();


        if ($user) {

            return Response(["message"=>"ok",'data'=>$user],200);
        } else
            return response("User not found",404);
    }catch (Exception $ex){

return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}
    }


}
