<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Models\UserRole;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;



class loginController extends Controller
{


//    public function doctorLogin(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'phoneNum' => 'required',
//            'password' => 'required',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json(['error' => $validator->errors()->all()]);
//        }
//
//        if (auth()->guard('doctor')->attempt(['phoneNum' => request('phoneNum'), 'password' => request('password')])) {
//
//         //   config(['auth.guards.api.provider' => 'doctor']);
//
//          //  $user = Doctor::select('doctors.*')->find(auth()->guard( 'doctor')->user()->id);
//            $user=auth()->guard( 'doctor')->user();
//            $success = $user;
//            $success['token'] = $user->createToken('MyApp', ['doctor'])->accessToken;
//
//            return response()->json(['data'=>$success,'token'=> $success['token']], 200);
//        } else {
//            return response()->json(['error' => ['phoneNum and Password are Wrong.']], 200);
//        }
//    }



    public function  loginUser(LoginRequest $request)
    {


      //  $user = UserRole::where('phoneNum', $request->phoneNum)->first();


          // $userRole=UserRole::where()
        $userRole = UserRole::where('phoneNum', $request->phoneNum)->first();

        if(!$userRole || !Hash::check($request->password,$userRole->password)) {
            return response(["message" => "fail login"], 404);
        }

        // return $userRole->role_id;
        if($userRole->role_id==1){
           $user =$userRole->users;
            $user=$user->with('user_roles')->first();
            $token = $user->createToken('my-app-token',['user'])->accessToken;
            return response(["user" => $user, "token" => $token], 201);
        }
        elseif($userRole->role_id==2){

            $doctor =$userRole->doctors;
            $doctor=$doctor->with('user_roles')->first();
            $token = $doctor->createToken('my-app-token',['doctor'])->accessToken;
            return response(["user" => $doctor, "token" => $token], 201);

        }
        elseif ($userRole->role_id==3){
            $patient =$userRole->patients;
            $patient=$patient->with('user_roles')->first();
            $token=$patient->createToken('my-app-token',['patient'])->accessToken;
            return response(["user" => $patient, "token" => $token], 201);

        }

    }





    public function logoutUser(Request $request){

        if (Auth::guard('user-api')->user()) {
            Auth::guard('user-api')->user()->tokens()->delete();
        }


        return response()->json(['massage'=>'thank you for using our application']);
    }




    public function logoutDoctor(Request $request){

        if (Auth::guard('doctor-api')->user()) {
            Auth::guard('doctor-api')->user()->tokens()->delete();
        }

        return response()->json(['massage'=>'thank you for using our application']);
    }



    public function logoutPatient(){


        if (Auth::guard('patient-api')->user()) {
            Auth::guard('patient-api')->user()->tokens()->delete();
        }

        return response()->json(['massage'=>'thank you for using our application']);
    }



}
