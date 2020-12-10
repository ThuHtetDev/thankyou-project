<?php

namespace App\Http\Controllers\API\Transition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;

class SettingController extends Controller
{
       // Member Change password
       public function changePassword(Request $request){
        $authUser = User::find(Auth::user()->id);
        $current_password = $authUser->password;
        if(Hash::check($request['oldPass'], $current_password))
        {
            $authUser->password =  Hash::make($request['newPass']);
            $authUser->save();
            return response()->json(['success'=>true],200);
        }else{
            return response()->json(['success'=>false],200);
        }
    }

    public function changeProPic(Request $request){
      
        $proPic = preg_replace('#^data:image/\w+;base64,#i', '',$request['propic']);
        $proPic = str_replace(' ', '+', $proPic);
     
        $pp_file_name = 'pp_'.time().'.png';
        if($proPic != ""){
            \Storage::disk('public')->put('profile_images/'.$pp_file_name,base64_decode($proPic));
        }
        $authUser = User::find(Auth::user()->id);
        $authUser->image = $pp_file_name;
        $authUser->save();
        return response()->json(['success'=>true],200);
    }
}
