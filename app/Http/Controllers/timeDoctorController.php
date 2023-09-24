<?php

namespace App\Http\Controllers;

use App\Http\Requests\timeDoctorRequest;
use App\Http\Requests\UserRequest;
use App\Models\AcceptanceForm;
use App\Models\Doctor;
use App\Models\Doctor_time;
use App\Models\Role;
use App\Models\User;
use Exception;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class timeDoctorController extends Controller
{
    public function index()
    {
        $doctorTime= Doctor::with('doctor_times')->get();
          //  $q->select('sunday','monday','tuesday','wednesday','thursday');



        return response()->json(['message'=>'ok','data'=>$doctorTime],200);
    }


//    public function index()
//    {
//
//
//        $users = User::latest()->where('id','<>',auth()->id())->get();
//
//       return response()->json($users,200,["success"]);
//    }

    public  function store(timeDoctorRequest $request){

     try {

         $doctorTime=new Doctor_time();
         $doctorTime=$this->process($doctorTime,$request);
       if ($doctorTime) {
           return response(["message"=>"ok",'data'=>$doctorTime],201);
         } else
           return response(["message"=>"error in validation"],404);
       }catch (Exception $ex){

       return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}}


 public  function update($id,timeDoctorRequest $request){
      try {
          $doctorTime=Doctor_time::findOrFail($id);
          $doctorTime = $this->process($doctorTime, $request);
         if ($doctorTime) {
             return response(['data'=>$doctorTime,'message'=>'ok'],200);

           } else
             return response(['message'=>'not found'],404);
      }catch (\Exception $ex){

           return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
   }


  }
   protected function process(Doctor_time $doctorTime,timeDoctorRequest $request){
        $doctor=Auth::guard('doctor-api')->user();
      $doctorTime->doctor_id=$doctor->id;
       $doctorTime->Sun=$request->Sun;
       $doctorTime->Mon=$request->Mon;
       $doctorTime->Tue=$request->Tue;
       $doctorTime->Wed=$request->Wed;
       $doctorTime->Thu=$request->Thu;
       $doctorTime->save();
        return $doctorTime;
   }

    public function delete($id){
        try {
            $doctorTime=Doctor_time::find($id);

            if ($doctorTime) {
                $doctorTime->delete();
                return Response(["message"=>"ok"],200);
            } else
                return response("User not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }


    }
    public function showTimeDoctor($fullName){
        try{
        $doctor=Doctor::where(['fullName'=>$fullName])->first();
         $name =$doctor->fullName;
            $doctorTime=$doctor->doctor_times;
        if ($doctorTime) {

            return Response(["message"=>"ok",'doctorName'=>$name,'data'=>$doctorTime],200);
        } else
            return response("User not found",404);
    }catch (Exception $ex){

return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}
    }


}
