<?php

namespace App\Http\Controllers;

use App\Http\Requests\dailyCalendarRequest;
use App\Http\Requests\UserRequest;
use App\Models\AcceptanceForm;
use App\Models\Daily_calendar;
use App\Models\Doctor;
use App\Models\Doctor_time;
use App\Models\Operatingroomsituation;
use App\Models\Role;
use App\Models\User;
use Exception;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class dailyCalendarController extends Controller
{
    public function index()
    {
     //   $daily_calendar= Daily_calendar::with('reservation_calendars')->get();
        $daily_calendar= Daily_calendar::get();
        return response()->json(['message'=>'ok','data'=>$daily_calendar],200);
    }


//    public function index()
//    {
//
//
//        $users = User::latest()->where('id','<>',auth()->id())->get();
//
//       return response()->json($users,200,["success"]);
//    }

    public  function store(dailyCalendarRequest $request){
     try {

                 $daily_calendar=new Daily_calendar();
         $daily_calendar=$this->process($daily_calendar,$request);
       if ($daily_calendar) {
           return response(["message"=>"ok"],201);
         } else
           return response(["message"=>"error in validation"],404);
       }catch (Exception $ex){

       return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}}


 public  function update($id,dailyCalendarRequest $request){
      try {
          $daily_calendar=Daily_calendar::findOrFail($id);
          $daily_calendar = $this->process($daily_calendar, $request);
         if ($daily_calendar) {
             return response(['data'=>$daily_calendar,'message'=>'ok'],200);

           } else
             return response(['message'=>'not found'],404);
      }catch (\Exception $ex){

           return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
   }


  }
   protected function process(Daily_calendar $daily_calendar,dailyCalendarRequest $request){

       $daily_calendar->day=$request->day;
       $daily_calendar->date=$request->date;
       $daily_calendar->save();
        return $daily_calendar;
   }

    public function delete($id){
        try {
            $daily_calendar=Daily_calendar::find($id);

            if ($daily_calendar) {
                $daily_calendar->delete();
                return Response(["message"=>"ok"],200);
            } else
                return response("User not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }


    }
    public function showOperationDate($id){
        try{
            $daily_calendar=Daily_calendar::where(['id'=>$id])->first();

           $reservation_calendar= $daily_calendar->reservation_calendar;
        if ($reservation_calendar) {

            return Response(["message"=>"ok",'data'=>$reservation_calendar],200);
        } else
            return response(" no operations ",404);
    }catch (Exception $ex){

return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}
    }

    public function showDoctorWithDay($date){
        try{
            $operatingRoomSit=Operatingroomsituation::where(['date'=>$date])->first();
          //  $daily_calendar=Daily_calendar::where(['id'=>$id])->first();
           //
            $doctorTime=Doctor_time::where([$operatingRoomSit->day=>1])->select('doctor_id')->get();
            foreach ($doctorTime as $doctorTimes){
                $doctorTimes->doctors;

            }

            if ($doctorTime) {

                return Response(["message"=>"ok",'doctor'=> $doctorTime],200);
            } else
                return response(" no operations ",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }
    }


}
