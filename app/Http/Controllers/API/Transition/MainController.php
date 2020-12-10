<?php

namespace App\Http\Controllers\API\Transition;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Color;
use App\UserColor;
use Auth;
use App\User;

class MainController extends Controller
{
    public function sendColor(Request $request){
        // color id // auth user id
        // if color id is already exist in database
        // already exist condition // its date == today date => return taken by other message
        // if not, Save in userColor table
        // if auth id is already exist in today date chosen color, return already chosen one
        $id = $request->color_id;
        $item = Color::where('id',$id)->first();
        $itsType = $item->type;

        $userColor = new UserColor();
        $isAvailableColor = $userColor->IsAvailableColorForToday($id);
        if(!$isAvailableColor) return response()->json(['message' => $item->name.' is taken by other, Please choose another color','success'=>false],200);
       
        $isAlreadyChosen = $userColor->IsAlreadyChosen(Auth::user()->id);
        if($isAlreadyChosen) return response()->json(['message' =>'You already choose Color','success'=>false],200);

        $userColor->user_id = Auth::user()->id;
        $userColor->color_id = $id;
        $userColor->type =  $itsType;
        $userColor->save();

        return response()->json(['message' => 'Successfully Send','success' => true],200);
    }

    public function randomSendColor(Request $request){
        $colorType = [
            'green',
            'yellow',
            'orange',
            'red',
            'blue'
        ];
        // Get two random items from the input array.
        $randomType = Arr::random($colorType);
        $userColor = new UserColor();
        $getMatchedColors = $userColor->findMatchedRandomColorInGroup($randomType);
        if(count($getMatchedColors) > 0){
            return response()->json(['data'=> $getMatchedColors,'type'=>$randomType,'success'=>true],200);
        }
            return response()->json(['message'=>'not found','type'=>$randomType,'success'=>false],200);
    }

    public function currentColors(){
        $colors = new Color;
        $getAvailableColors = $colors->chooseAvailableColors();
        return response()->json($getAvailableColors,200);
    }

    public function selectedColor(){
        $selectedColor = \App\UserColor::where('is_selected','1')
        ->whereDate('created_at', \Carbon\Carbon::today())
        ->first();
        if(is_null($selectedColor)){
            return response()->json(['data'=>'','success'=>false],200);
        }
            return response()->json(['data' => $selectedColor->type,'success'=>true],200);
    }

    public function getPlayers(){
        $userColor = new UserColor();
        $getTodayPlayers = $userColor->getTodayPlayers();
        if(count($getTodayPlayers) > 0){
            return response()->json(['success'=>true,'data'=> $getTodayPlayers],200);
        }else{
            return response()->json(['success'=>false],200);
        }
    }

    public function getTodayMatchedPlayers(){
        $userColor = new UserColor();
        $getTodayMatchPlayers = $userColor->getTodayMatchPlayers();
        $authUser = Auth::user();
        if(count($getTodayMatchPlayers) > 0){
            return response()->json(['success'=>true,'data'=> $getTodayMatchPlayers,'user'=>$authUser ],200);
        }else{
            return response()->json(['success'=>false,'user'=>$authUser ],200);
        }
    }

    public function getPositiveThinking()
    {
        $groups = \App\PositiveThink::all();
        return response()->json($groups,200);
    }
    
    public function donePositiveThinking()
    {
        $isSelected = \App\PositiveThink::where('is_selected','1')->first();
        $isSelectedId = $isSelected->id;

        if($isSelectedId < 5){
            $isSelectedNxt = $isSelectedId + 1;
        }else{
            $isSelectedNxt = 1;
        }
        $findNxt = \App\PositiveThink::find($isSelectedNxt);
        $findNxt->is_selected = '1';
        $findNxt->save(); // save next 

        $isSelected->is_selected = '0';
        $isSelected->save(); // reset previous 

        return response()->json($findNxt,200);
    }

    public function getUsers(){
        $users = User::orderBy('created_at','asc')->get();
        return response()->json($users,200);
    }
}
