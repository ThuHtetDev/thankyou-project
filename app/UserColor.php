<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserColor extends Model
{
    protected $table = 'user_colors';

    public function color()
    {
        return $this->belongsTo('App\Color');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function IsAvailableColorForToday($id){
        $today  = \Carbon\Carbon::now()->toDateString();
        $findColors = \App\UserColor::where('color_id',$id)->get();
        $checkin = true;
        foreach($findColors as $find){
            if(\Carbon\Carbon::parse($find->created_at)->format('Y-m-d') ==  $today){
                $checkin = false;
            }
        }
        return $checkin;
    }

    public function IsAlreadyChosen($authId){
        $isExist = \App\UserColor::where('user_id',$authId)
                    ->whereDate('created_at', \Carbon\Carbon::today())
                    ->first();
        if(is_null($isExist)) return false;
        return true;
    }

    public function findMatchedRandomColorInGroup($randomType){
      
        $findMatchedColors = \App\UserColor::where('type',$randomType)
                            ->whereDate('created_at', \Carbon\Carbon::today())
                            ->get();
        if(count($findMatchedColors) > 0){
            foreach($findMatchedColors as $color){
                $color->is_selected = '1';
                $color->save();
            }
        }
        return $findMatchedColors;
    }

    public function getTodayPlayers(){
        $findToday  = \App\UserColor::whereDate('created_at', \Carbon\Carbon::today())
                    ->get();
        $data = [];
        foreach($findToday as $ft){
            $data[] = [
                'player_info' => $ft->user,
                'color_info'  => $ft->color,
                'created'     => \Carbon\Carbon::parse($ft->created_at)->format('Y-m-d h:i:s')
            ];
        }
        return $data;
    }

    public function getTodayMatchPlayers(){
        $findTodayMatched  = \App\UserColor::where('is_selected','1')
                                            ->whereDate('created_at', \Carbon\Carbon::today())
                                            ->get();
        $data = [];
        foreach($findTodayMatched as $ft){
            $data[] = [
                'player_info' => $ft->user,
                'color_info'  => $ft->color,
                'created'     => \Carbon\Carbon::parse($ft->created_at)->format('Y-m-d h:i:s')
            ];
        }
        return $data;
    }
}
