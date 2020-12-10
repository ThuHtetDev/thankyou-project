<?php

namespace App\Http\Controllers\API\Transition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Chat;
use Auth;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function userChatInfos(Request $request){
        $chatId = $request->id;
        $isUserExist = User::find($chatId);

        if(is_null($isUserExist)) return response()->json(['success'=>false,'data'=>'not_found_chat_id'],200);

        $chats = Chat::where('to_user_id',$chatId)->orderBy('created_at','desc')->get();
        $toUser = User::where('id',$chatId)->first()->name;
        if(!count($chats) > 0) return response()->json(['success'=>false,'data'=>'not_found_chat','to_user'=>$toUser],200);
        $data = [];
        foreach($chats as $chat){
            $fromUserName = User::where('id',$chat->user_id)->first()->name;
            $data[] = [
                'from_user_name' =>  $fromUserName,
                'from_user_message' => $chat->message,
                'created_at' => Carbon::parse($chat->created_at)->format('Y-m-d')
            ];
        }
        return response()->json(['success'=>true,'data'=>$data,'to_user'=>$toUser],200);
    }
    public function sendMessage(Request $request){
        
        $toUser = $request->to_user;
        $message = $request->message;
        $isUserExist = User::find($toUser);
        if(is_null($isUserExist)) return response()->json(['success'=>false],200);

        $newMessage = new Chat;
        $newMessage->message = $message;
        $newMessage->user_id = Auth::user()->id;
        $newMessage->to_user_id = $toUser;
        $newMessage->save();

        return response()->json(['success'=>true],200);
    }
}
