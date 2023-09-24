<?php

namespace App\Http\Controllers;


use App\Http\Requests\internalAcceptRequest;
use App\Models\AcceptanceForm;
use App\Models\InternalAccept;
use App\Models\Role;

use App\Models\Room;
use Exception;


class internalAcceptController extends Controller
{
    public function index()
    {
        $internalAccept = InternalAccept::get();
        return response()->json(['message'=>'ok','data'=>$internalAccept],200);
    }


    public function indexId($id)
    {
        $internalAccept = InternalAccept::find($id);
        return response()->json(['message'=>'ok','data'=>$internalAccept],200);
    }



//    public function index()
//    {
//
//
//        $users = User::latest()->where('id','<>',auth()->id())->get();
//
//       return response()->json($users,200,["success"]);
//    }

    public  function store(internalAcceptRequest $request){
     try {


         $internalAccept=new InternalAccept();

         if($request->room_id){

         $room=Room::find($request->room_id);
        if( $room->available_bed==0){
            return response(["message"=>"This room is full"],201);
        }}
         $internalAccept=$this->process($internalAccept,$request);

       if ($internalAccept) {
           return response(["message"=>"ok"],201);
         } else
           return response(["message"=>"error in validation"],404);
       }catch (Exception $ex){

       return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}
    }


 public  function update($id,internalAcceptRequest $request){
      try {

          $internalAccept=InternalAccept::findOrFail($id);

          if((!$internalAccept->internalDate) && ($request->internalDate)){
              $room=Room::find($request->room_id);
          if( $room->available_bed==0){
              return response(["message"=>"This room is full"],201);
          }}
          $internalAccept = $this->process($internalAccept, $request);
         if ($internalAccept) {
             return response(['data'=>$internalAccept,'message'=>'ok'],200);

           } else
             return response(['message'=>'not found'],404);
      }catch (\Exception $ex){

           return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
   }


  }
   protected function process(InternalAccept $internalAccept,internalAcceptRequest $request){

       $internalAccept->department=$request->department;
       $internalAccept->doctor=$request->doctor;
       $internalAccept->operation=$request->operation;
       if( ( !$internalAccept->internalDate )&&   ( $request->internalDate)){
           $room=Room::find($request->room_id);
           $room->available_bed--;
           $room->save();
       }
       $internalAccept->internalDate=$request->internalDate;
       if( ( !$internalAccept->externalDate )&&   ( $request->externalDate)){
           $room=Room::find($request->room_id);
           $room->available_bed++;
           $room->save();

       }

       $internalAccept->externalDate=$request->externalDate;


       $internalAccept->patient=$request->patient;
       $internalAccept->folder_id=$request->folder_id;
       $internalAccept->room_id=$request->room_id;

       $internalAccept->save();


        return $internalAccept;
   }

    public function delete($id){
        try {
            $internalAccept=InternalAccept::find($id);

            if ($internalAccept) {
                $internalAccept->delete();
                return Response(["message"=>"ok"],200);
            } else
                return response("User not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }


    }
//    public function search($fullName,$phoneNum){
//        try{
//        $user=User::where(['fullName'=>$fullName,'phoneNum'=>$phoneNum])->first();
//        if ($user) {
//
//            return Response(["message"=>"ok",'data'=>$user],200);
//        } else
//            return response("User not found",404);
//    }catch (Exception $ex){
//
//return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
//}
//    }


}
