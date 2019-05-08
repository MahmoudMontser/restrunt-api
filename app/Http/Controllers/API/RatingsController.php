<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Rating;

class RatingsController extends Controller
{
    //

    public function rate(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'place_id' => 'exists:places,id'

        ]);


        $target = Rating::where('place_id',$request['place_id'])->first();

        if ($target!=null) {

            if ($validator->passes()) {

                $target->user_id = Auth()->user()->id;
                $target->place_id = $request['place_id'];
                $target->rate = $request['rate'];
                $target->update();
                return response()->json(['value' => true, 'msg' => 'rated successfully', 'data' => ['place' => $target->Place->name, 'rate' => $target->rate]]);
            } else return response()->json(['value' => false, 'msg' => $validator->errors()]);


        } if ($target==null) {
            if ($validator->passes()) {
                $rate = new Rating();
                $rate->user_id = Auth()->user()->id;
                   $rate->place_id = $request['place_id'];
                $rate->rate = $request['rate'];
                $rate->save();
                return response()->json(['value' => true, 'msg' => 'rated successfully', 'data' => ['place' => $rate->Place->name, 'rate' => $rate->rate]]);
            } else return response()->json(['value' => false, 'msg' => $validator->errors()]);
        }
    }
}
