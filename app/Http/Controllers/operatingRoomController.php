<?php

namespace App\Http\Controllers;

use App\Http\Requests\dailyCalendarRequest;
use App\Http\Requests\operatingRoomRequest;

use App\Http\Requests\UserRequest;
use App\Models\AcceptanceForm;
use App\Models\Daily_calendar;
use App\Models\Doctor_time;
use App\Models\Operatingroomsituation;
use App\Models\Reservation_calendar;
use App\Models\Role;
use App\Models\User;
use Exception;
use http\Env\Response;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class operatingRoomController extends Controller
{
    public function index()
    {
                  //  $daily_calendar=Daily_calendar::find($id);
     //   $daily_calendar= Daily_calendar::with('reservation_calendars')->get();

      //  $operatingRoom =$daily_calendar->operatingroomsituations;

        $operatingRoom= Operatingroomsituation::get();

        return response()->json(['message'=>'ok','data'=>$operatingRoom],200);
    }


//    public function index()
//    {
//
//
//        $users = User::latest()->where('id','<>',auth()->id())->get();
//
//       return response()->json($users,200,["success"]);
//    }

    public  function store(operatingRoomRequest $request){
     try {

         $operatingRoom=new Operatingroomsituation();
         $operatingRoom=$this->process($operatingRoom,$request);
       if ($operatingRoom) {
           return response(["message"=>"ok"],201);
         } else
           return response(["message"=>"error in validation"],404);
       }catch (Exception $ex){

       return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}}


 public  function update($id,operatingRoomRequest $request){
      try {
          $operatingRoom=Operatingroomsituation::findOrFail($id);
//          $operatingRoom->operatingRoom=$request->operatingRoom;
//          $operatingRoom->green=$request->green;
//          $operatingRoom->red=$request->red;
//          $operatingRoom->orange=$request->orange;
//          $operatingRoom->save();
          $operatingRoom = $this->process($operatingRoom, $request);
         if ($operatingRoom) {
             return response(['data'=>$operatingRoom,'message'=>'ok'],200);

           } else
             return response(['message'=>'not found'],404);
      }catch (\Exception $ex){

           return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
   }
  }
   protected function process(Operatingroomsituation $operatingRoom,operatingRoomRequest $request){
         //$daily_calendar=Daily_calendar::find($id);
       $operatingRoom->operatingRoom=$request->operatingRoom;
       $operatingRoom->type=$request->type;
       $operatingRoom->day=$request->day;
       $operatingRoom->date=$request->date;
      // $operatingRoom->calendar_id=$daily_calendar->id;
       $operatingRoom->save();
        return $operatingRoom;
   }

    public function delete($id){
        try {
            $operatingRoom=Operatingroomsituation::find($id);

            if ($operatingRoom) {
                $operatingRoom->delete();
                return Response(["message"=>"ok"],200);
            } else
                return response("User not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }


    }
//    public function showOperationDate($id){
//        try{
//            $daily_calendar=Daily_calendar::where(['id'=>$id])->first();
//
//           $reservation_calendar= $daily_calendar->reservation_calendar;
//        if ($reservation_calendar) {
//
//            return Response(["message"=>"ok",'data'=>$reservation_calendar],200);
//        } else
//            return response(" no operations ",404);
//    }catch (Exception $ex){
//
//return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
//}
 //   }

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
