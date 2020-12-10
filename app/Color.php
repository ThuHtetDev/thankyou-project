<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Color extends Model
{
    protected $table = 'colors';
    
    public function colorUsers()
    {
        return $this->hasMany('App\UserColor');
    }

    public function chooseAvailableColors(){

    //    $todayChosenColors = \App\UserColor::whereDate('created_at', \Carbon\Carbon::today())->get();
    //    if(!count($todayChosenColors) > 0) return Color::all();

        // ! Return Only Available Colors for today
        $availableColors =  DB::table("colors")->select('*')
                            ->whereNOTIn('id',function($query){
                            $query->select('color_id')->from('user_colors')->whereDate('created_at', \Carbon\Carbon::today());
                            })->get();
        return $availableColors;
    }
}
