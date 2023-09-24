<?php

namespace App\Http\Controllers;


use App\Http\Requests\DoctorRequest;
use App\Models\AcceptanceForm;
use App\Models\Doctor;
use App\Models\InternalAccept;
use App\Models\Reservation_calendar;
use App\Models\Role;

use App\Models\UserRole;
use Exception;
use http\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class accountDoctorController extends Controller
{
    public function index()
    {
        $doctor = Doctor::with('user_roles')->get();
        return response()->json(['message'=>'ok','data'=>$doctor],200);
    }

    public  function store(DoctorRequest $request){
        try {
            $doctor=new Doctor();
            $userRole=new UserRole();
            $doctor=$this->process($doctor,$userRole,$request);
            if ($doctor) {
               // $user = $user->with('user_roles')->first();
                return response(["message"=>"ok",'data'=>$doctor],201);
            } else
                return response(["message"=>"error in validation"],404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }}


    public  function update($id,DoctorRequest $request){
        try {
            $doctor=Doctor::where('id',$id)->with('user_roles')->first();
            $userRole=$doctor->user_roles;
            $doctor = $this->process($doctor,$userRole, $request);
            if ($doctor) {


                return response(['data'=>$doctor,'message'=>'ok'],200);

            } else
                return response(['message'=>'not found'],404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }


    }


    protected function process(Doctor $doctor,$userRole,DoctorRequest $request){

        $doctor->fullName=$request->fullName;
        $doctor->motherName=$request->motherName;
        $doctor->specialization=$request->specialization;
        $doctor->address=$request->address;


        //  $userRole=$user->user_roles;
        $userRole->phoneNum=$request->phoneNum;
        $userRole->email=$request->email;
        $userRole->password=Hash::make($request->password);
        $userRole->role_id=2;
        $userRole->save();
        $userRole->doctors()->save($doctor);
       $doctor= $doctor->with('user_roles')->first();

        return $doctor;
    }

    public function delete($id){
        try {
            $doctor=Doctor::find($id);


            if ($doctor) {
                $userRole = $doctor->user_roles;

                if ($userRole) {
                    // $user->user_roles()->delete($userRole);
                    $userRole->delete();

                }
                $doctor->delete();

                return Response(["message" => "ok"], 200,);
            }
            else
                return response("doctor not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }


    }
    public function search($phoneNum){
        try{
            $doctor=UserRole::where(['phoneNum'=>$phoneNum])->with('doctors')->get();


            if ($doctor) {

                return Response(["message"=>"ok",'data'=>$doctor],200);
            } else
                return response("doctor not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }
    }


    public function  showListConfirmReservation($id){
        try{
        $operation=Reservation_calendar::where(['doctor_id'=>$id,'confirm'=>'null'])->get();
        if ($operation) {

            return Response(["message"=>"ok",'data'=>$operation],200);
        } else
            return response("User not found",404);
    }catch (Exception $ex){

return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}

    }


    public function confirmReservation(Request $request,$id){
         try{
          $operation=Reservation_calendar::find($id);
        $operation->confirm=$request->confirm;
        $operation->save();
        if ($operation) {
            return response(['data'=>$operation,'message'=>'ok'],200);

        } else
            return response(['message'=>'not found'],404);
    }catch (\Exception $ex){

return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}



    }

    public function  showListConfirmInternalAccept($id){
        try{
            $internalAccept=InternalAccept::where(['doctor'=>$id,'confirm'=>'null'])->get();
            if ($internalAccept) {

                return Response(["message"=>"ok",'data'=>$internalAccept],200);
            } else
                return response("internalAccept not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }

    }


    public function confirmInternalAccept(Request $request,$id){
        try{
            $internalAccept=InternalAccept::find($id);
            $internalAccept->confirm=$request->confirm;
            $internalAccept->save();
            if ($internalAccept) {
                return response(['data'=>$internalAccept,'message'=>'ok'],200);

            } else
                return response(['message'=>'not found'],404);
        }catch (\Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }



    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////



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








}
