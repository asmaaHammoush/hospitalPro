<?php

namespace App\Http\Controllers;



use App\Models\Doctor;
use App\Http\Requests\reservationRequest;
use App\Models\Folder;
use App\Models\InternalAccept;
use App\Models\Reservation_calendar;
use App\Models\Operatingroomsituation;
use Exception;



class operationController extends Controller
{
    public function index($date, $specification)
    {
        $operation = Reservation_calendar::where(['specialization' => $specification, 'date' => $date])->first();
        return response()->json(['message' => 'ok', 'data' => $operation], 200);
    }


    public function indexId($id)
    {
        $operation = Reservation_calendar::find($id);
        return response()->json(['message' => 'ok', 'data' => $operation], 200);
    }

    public function store(reservationRequest $request)
    {
        try {

            $operation = new Reservation_calendar();
           //$operation = $this->process($operation, $request);
            $doctor = Doctor::where(['fullName' => $request->doctor, 'specialization' => $request->specialization])->first();
            $folder=Folder::where(['fullName'=>$request->patient,'motherName'=>$request->motherName])->first();

            //  $patient=Patient::where(['fullName'=>$request->patient,'motherName'=>$request->motherName])->first();
            $operation->doctor = $request->doctor;
            $operation->specialization = $request->specialization;
            $operation->patient = $request->patient;
            $operation->motherName = $request->motherName;
            $operation->opration = $request->opration;
            $operation->narcosis = $request->narcosis;
            $operation->medical_diagnosis = $request->medical_diagnosis;
            $operation->room_id = $request->room_id;


            // $operation->patient_id=$patient->id;
            //$operation->operatingRoom_id=$operatingRoom->id;
            $operation->internalAccept_id = $request->internalAccept_id;
            $operation->confirm = $request->confirm;
            $operation->date = $request->date;
            $operation->hourNum = $request->hourNum;

            $operation->timeStart = $request->timeStart;
            $operation->folder_id=$folder->id;
            $operation->doctor_id = $doctor->id;

            $operations = Reservation_calendar::where(['specialization' => $request->specialization, 'date' => $request->date])->get();

            $total=$operations == null? 0 :$operations->sum('hourNum'); // this var some time may be a null so you need to check it first before any operation in it

            $sum= $total+$operation->hourNum;
       //   return $sum;
            if($sum <=8) {
                $operation->save();
            }
            else{

                return response( ['message'=>"CAN NOT SAVE BECAUSE OPERATIONS ARE FULL"]);
            }
           //operatingRoom=new Operatingroomsituation();
            $operatingRoom=Operatingroomsituation::where(['operatingRoom'=>$request->specialization,'date'=>$request->date])->first();
             //return $operatingRoom->type;
             //  echo $request->specialization,$request->date;
            if($sum==8){
                $operatingRoom->type="red";
$operatingRoom->save();

            }
            if ($operation) {
                return response(["message" => "ok"], 201);
            } else
                return response(["message" => "error in validation"], 404);
        } catch (Exception $ex) {

            return response(['data' => $ex->getMessage(), 'message' => 'error'], 400);
        }
    }


    public function update($id, reservationRequest $request)
    {
        try {
            $operation=Reservation_calendar::find($id);
            $hourNum=$operation->hourNum;
            $doctor = Doctor::where(['fullName' => $request->doctor, 'specialization' => $request->specialization])->first();
            $folder=Folder::where(['fullName'=>$request->patient,'motherName'=>$request->motherName])->first();

            //  $patient=Patient::where(['fullName'=>$request->patient,'motherName'=>$request->motherName])->first();
            $operation->doctor = $request->doctor;
            $operation->specialization = $request->specialization;
            $operation->patient = $request->patient;
            $operation->motherName = $request->motherName;
            $operation->opration = $request->opration;
            $operation->narcosis = $request->narcosis;
            $operation->medical_diagnosis = $request->medical_diagnosis;
            $operation->room_id = $request->room_id;


            // $operation->patient_id=$patient->id;
            //$operation->operatingRoom_id=$operatingRoom->id;
            $operation->internalAccept_id = $request->internalAccept_id;
            $operation->confirm = $request->confirm;
            $operation->date = $request->date;
            $operation->hourNum = $request->hourNum;

            $operation->timeStart = $request->timeStart;
            $operation->folder_id=$folder->id;
            $operation->doctor_id = $doctor->id;

            $operations = Reservation_calendar::where(['specialization' => $request->specialization, 'date' => $request->date])->get();

            $total=$operations == null? 0 :$operations->sum('hourNum'); // this var some time may be a null so you need to check it first before any operation in it

            $sum= $total+$operation->hourNum-$hourNum;
            //   return $sum;
            $operatingRoom=Operatingroomsituation::where(['operatingRoom'=>$request->specialization,'date'=>$request->date])->first();

            if($sum <=8) {
                $operation->save();
                if($sum<8) {
                    $operatingRoom->type = "green";
                    $operatingRoom->save();
                }
            }
            else{

                return response( ['message'=>"CAN NOT SAVE BECAUSE OPERATIONS ARE FULL"]);
            }
            //operatingRoom=new Operatingroomsituation();
            //return $operatingRoom->type;
            //  echo $request->specialization,$request->date;
            if($sum==8){
                $operatingRoom->type="red";
                $operatingRoom->save();

            }
            if ($operation) {
                return response(['data' => $operation, 'message' => 'ok'], 200);

            } else
                return response(['message' => 'not found'], 404);
        } catch (\Exception $ex) {

            return response(['data' => $ex->getMessage(), 'message' => 'error'], 400);
        }


    }

//    protected function process(Reservation_calendar $operation, reservationRequest $request)
//    {
//
//        $doctor = Doctor::where(['fullName' => $request->doctor, 'specialization' => $request->specialization])->first();
//         $folder=Folder::where(['fullName'=>$request->patient,'motherName'=>$request->motherName])->first();
//
//        //  $patient=Patient::where(['fullName'=>$request->patient,'motherName'=>$request->motherName])->first();
//        //    $operatingRoom=Operatingroomsituation::where(['operatingRoom'=>$request->specialization,'date'=>$request->date])->first();
//        $operation->doctor = $request->doctor;
//        $operation->specialization = $request->specialization;
//        $operation->patient = $request->patient;
//        $operation->motherName = $request->motherName;
//        $operation->opration = $request->opration;
//        $operation->narcosis = $request->narcosis;
//        $operation->medical_diagnosis = $request->medical_diagnosis;
//        $operation->room_id = $request->room_id;
//
//
//        // $operation->patient_id=$patient->id;
//        //$operation->operatingRoom_id=$operatingRoom->id;
//        $operation->internalAccept_id = $request->internalAccept_id;
//        $operation->confirm = $request->confirm;
//        $operation->date = $request->date;
//        $operation->hourNum = $request->hourNum;
//
//        $operation->timeStart = $request->timeStart;
//        $operation->folder_id=$folder->id;
//        $operation->doctor_id = $doctor->id;
//
//        $operations = Reservation_calendar::where(['specialization' => $request->specialization, 'date' => $request->date])->get();
//        $total=$operations->sum('hourNum');
//       $sum= $total+$operation->hourNum;
//        if($sum <=8){
//            $operation->save();
//        }
//
//        return $operation;
//
//    }

    public function delete($id)
    {
        try {
            $operation = Reservation_calendar::find($id);

            if ($operation) {

                $operatingRoom=Operatingroomsituation::where(['operatingRoom'=>$operation->specialization,'date'=>$operation->date])->first();
                if(Strcmp($operatingRoom->type,"red")==0) {
                    $operatingRoom->type = "green";
                    $operatingRoom->save();
                }
                $operation->delete();
                return Response(["message" => "ok"], 200);
            } else
                return response("User not found", 404);
        } catch (Exception $ex) {

            return response(['data' => $ex->getMessage(), 'message' => 'error'], 400);
        }


    }

    public function showOperationForSpecialDoctorAndDate($id,$date)
    {
try{

    $operation = Reservation_calendar::where(['doctor_id'=>$id,'date' => $date,'confirm'=>1])->get();


    if ($operation) {

                return Response(['message' => 'oK', 'data' => $operation], 200);
            } else
                return response(" no operation ", 404);
        } catch (Exception $ex) {

            return response(['data' => $ex->getMessage(), 'message' => 'error'], 400);
        }









    }













    public function operationForSpecialFolder( $id )
    {

    try {


        $operation = Reservation_calendar::where(['folder_id'=> $id])->get();


       // $operation=$internalAccept->reservation_calendars();


        if ($operation) {

            return Response(["message" => "eeok", 'data' => $operation], 200);
        } else
           return response("operation not found for folders",404);
    }catch (Exception $ex){

                return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
    }
    }





}


//    public function search($patient,$operation){
//        try{
//        $operation=Reservation_calendar::where(['patient'=>$patient,'operation'=>$operation])->first();
//        if ($operation) {
//
//            return Response(["message"=>"ok",'data'=>$operation],200);
//        } else
//            return response("User not found",404);
//    }catch (Exception $ex){
//
//return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
//}
//    }




