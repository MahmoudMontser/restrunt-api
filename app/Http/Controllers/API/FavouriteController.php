<?php

namespace App\Http\Controllers\API;

use App\Favourite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class FavouriteController extends Controller
{
    //
    public function add(Request $request){
$validator=Validator::make($request->all(),[

    'place_id'=>'exists:places,id|unique:favourites'
]);
if($validator->passes()) {
    $fav = new Favourite();
    $fav->user_id = Auth()->user()->id;
    $fav->place_id = $request['place_id'];
    $fav->save();
    return response()->json(['value'=>true,'msg'=>'added successfully ']);
}else return response()->json(['value'=>false,'msg'=>$validator->errors()]);
    }


    public function my_favourites(){

        $favourites=Favourite::where('user_id',Auth()->user()->id)->get();
        if ($favourites->count()>=1){
            $data=[];
            foreach ($favourites as $favourite){
                $arr['id']=$favourite->id;
                $arr['place_id']=$favourite->place_id;
                $arr['place_name']=$favourite->Place->name;

                $data[]=$arr;
            }
            return response()->json(['value'=>true,'data'=>$data]);

        }else return response()->json(['value'=>false,'msg'=>'there is no favourites']);
    }
    public function delete($id){

        $target=Favourite::destroy($id);
        return response()->json(['value' => true, 'msg' => 'deleted successfully']);



    }
}

