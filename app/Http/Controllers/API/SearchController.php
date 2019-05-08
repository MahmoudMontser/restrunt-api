<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Place;
use App\Rating;
class SearchController extends Controller
{
    //
    public function search(Request $request){


        if(Place::count()>=1) {
            $places = Place::where('name','LIKE','%'.$request['input'].'%')->get();

            $data = [];
            if($places->count()>=1) {
                foreach ($places as $place) {
                    $arr['id'] = $place->id;
                    $rate = null;
                    $rat_num = Rating::where('place_id', $place->id)->count();
                    if ($rat_num >= 1) {
                        $rate = (Rating::where('place_id', $place->id)->sum('rate')) / $rat_num;
                    }
                    $arr['name'] = $place->name;
                    $arr['logo'] = $place->logo;
                    $arr['rate'] = $rate;
                    $arr['category'] = $place->Category->name;
                    $data[] = $arr;
                }
                return response()->json(['value' => true, 'data' => $data]);
            }else return response()->json(['value'=>false,'msg'=>'there is no matched result']);
        }else return response()->json(['value'=>false,'msg'=>'there is no places yet']);

    }
}
