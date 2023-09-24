<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Http\Requests\UserRequest;
use App\Models\AcceptanceForm;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class accountPatientController extends Controller
{



    public function index()
    {
        $patient = Patient::with('user_roles')->get();
        return response()->json(['message'=>'ok','data'=>$patient],200);
    }


    public  function store(PatientRequest $request){
        try {

            $patient=new Patient();
            $userRole=new UserRole();
            $patient=$this->process($patient,$userRole,$request);
            if ($patient) {
                // $user = $user->with('user_roles')->first();
                return response(["message"=>"ok",'data'=>$patient],201);
            } else
                return response(["message"=>"error in validation"],404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }}


    public  function update($id,PatientRequest $request){
        try {
            $patient=Patient::where('id',$id)->with('user_roles')->first();
            $userRole=$patient->user_roles;
            $patient = $this->process($patient,$userRole, $request);
            if ($patient) {


                return response(['data'=>$patient,'message'=>'ok'],200);

            } else
                return response(['message'=>'not found'],404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }


    }


    protected function process(Patient $patient,$userRole,PatientRequest $request){

        $patient->fullName=$request->fullName;
        $patient->motherName=$request->motherName;
        $patient->age=$request->age;
        $patient->gender=$request->gender;
        $patient->address=$request->address;


        //  $userRole=$user->user_roles;
        $userRole->phoneNum=$request->phoneNum;
        $userRole->email=$request->email;
        $userRole->password=Hash::make($request->password);
        $userRole->role_id=3;
        $userRole->save();
        $userRole->patients()->save($patient);
        $patient= $patient->with('user_roles')->first();

        return $patient;
    }

    public function delete($id){
        try {
            $patient=Patient::find($id);


            if ($patient) {
                $userRole = $patient->user_roles;

                if ($userRole) {
                    // $user->user_roles()->delete($userRole);
                    $userRole->delete();

                }
                $patient->delete();

                return Response(["message" => "ok"], 200,);
            }
            else
                return response("patient not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }


    }
    public function search($phoneNum){
        try{
            $patient=UserRole::where(['phoneNum'=>$phoneNum])->with('patients')->get();


            if ($patient) {

                return Response(["message"=>"ok",'data'=>$patient],200);
            } else
                return response("patient not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }
    }



}
