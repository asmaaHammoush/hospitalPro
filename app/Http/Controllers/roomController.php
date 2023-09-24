<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;

use App\Models\Room;

use Exception;


class roomController extends Controller
{
    public function index()
    {
        $room= Room::get();
        return response()->json(['message'=>'ok','data'=>$room],200);
    }


//    public function index()
//    {
//
//
//        $users = User::latest()->where('id','<>',auth()->id())->get();
//
//       return response()->json($users,200,["success"]);
//    }

    public  function store(RoomRequest $request){
     try {

         $room=new Room();
         $room=$this->process($room,$request);
       if ($room) {
           return response(["message"=>"ok"],201);
         } else
           return response(["message"=>"error in validation"],404);
       }catch (Exception $ex){

       return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
}}


 public  function update($id,RoomRequest $request){
      try {
      $room=Room::findOrFail($id);
          $room = $this->process($room, $request);
         if ($room) {
             return response(['data'=>$room,'message'=>'ok'],200);

           } else
             return response(['message'=>'not found'],404);
      }catch (\Exception $ex){

           return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
   }


  }
   protected function process(Room $room,RoomRequest $request){
       $room->type=$request->type;
       $room->available_bed=$request->available_bed;
       $room->classification=$request->classification;
       $room->save();
        return $room;
   }

    public function delete($id){
        try {
            $room=Room::find($id);

            if ($room) {
                $room->delete();
                return Response(["message"=>"ok"],200);
            } else
                return response("User not found",404);
        }catch (Exception $ex){

            return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
        }


    }
//    public function search($type){
//        try{
//            $room=Room::where(['type'=>$type])->first();
//        if ($room) {
//
//            return Response(["message"=>"ok",'data'=>$room],200);
//        } else
//            return response("User not found",404);
//    }catch (Exception $ex){
//
//return response(['data'=>$ex->getMessage(),'message'=>'error'],400);
//}
//    }





}
