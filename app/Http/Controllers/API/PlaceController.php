<?php

namespace App\Http\Controllers\API;

use App\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Place;
use Validator;

class PlaceController extends Controller
{
    //
    public function index(){


        if(Place::count()>=1) {
            $places = Place::all();
            $data = [];
            foreach ($places as $place) {
                $rate=null;
                $rat_num=Rating::where('place_id',$place->id)->count();
                if($rat_num>=1){
                $rate=(Rating::where('place_id',$place->id)->sum('rate'))/$rat_num;
                }
                $arr['id'] = $place->id;
                $arr['name'] = $place->name;
                $arr['logo'] = asset('images/place_profile/'.$place->logo);
                $arr['rate']=$rate;
                $arr['category'] = $place->Category->name;
                $data[] = $arr;
            }
            return response()->json(['value' => true, 'data' => $data]);
        }else return response()->json(['value'=>false,'msg'=>'there is no places yet']);

    }



    public function get_place($id){

        $place=Place::find($id);
        if($place) {
            $place->views++;
            $place->update();
            $arr['id'] = $place->id;
            $arr['name'] = $place->name;
            $arr['logo'] = asset('images/place_profile/'.$place->logo);
            $arr['cover'] = asset('images/place_profile/'.$place->cover);
            $arr['views']=$place->views;
            $arr['open_time'] = $place->open;
            $arr['close_time'] = $place->close;
            $data[] = $arr;
            return response()->json(['value' => true, 'data' => $data]);
        }else return response()->json(['value'=>false,'msg'=>'place dosnt exist']);

    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required',
            'open' => 'required', 'close' => 'required',
            'cate_id'=>'exists:categories,id',
            'logo'=> 'mimes:jpg,png',
            'cover'=> 'mimes:jpg,png',


        ]);
        if ($validator->passes()) {
            $p = new Place();
            $p->name = $request['name'];
            $p->cate_id = $request['cate_id'];

            if ($request->hasFile('logo')){
                $logo = md5($request['logo']->getClientOriginalName()).'.'.$request['logo']->getClientOriginalExtension();
                $request['logo']->move(public_path('images/place_profile'),$logo);}else{
                return response()->json(['value'=>false,'msg'=>'select a correct logo file']);
            }

            $p->logo= $logo;

            if ($request->hasFile('cover')){
                $cover = md5($request['cover']->getClientOriginalName()).'.'.$request['cover']->getClientOriginalExtension();
                $request['cover']->move(public_path('images/place_profile'),$cover);}else{
                return response()->json(['value'=>false,'msg'=>'select a correct cover file']);
            }

            $p->cover = $cover;
            $p->open = $request['open'];
            $p->close = $request['close'];
            $p->save();
            return response()->json(['value' => true, 'msg' => 'created successfully','data'=>$p->name ."-----".$p->category->name]);
        }else return response()->json(['value'=>false,'msg'=>$validator->errors()]);
    }



    public function update(Request $request,$id ){
        $p=Place::find($id)->frist();
        $validator = Validator::make($request->all() , [
            'name' => 'required',
            'open' => 'required', 'close' => 'required',
            'cate_id'=>'exists:categories,id',
            'logo'=> 'mimes:jpg,png',
            'cover'=> 'mimes:jpg,png',

        ]);
        if ($validator->passes()) {
            $p->name = $request['name'];
            $p->cate_id = $request['cate_id'];

            if ($request->hasFile('logo')){
                $logo = md5($request['logo']->getClientOriginalName()).'.'.$request['logo']->getClientOriginalExtension();
                $request['logo']->move(public_path('images/place_profile'),$logo);}else{
                return response()->json(['value'=>false,'msg'=>'select a correct logo file']);
            }

            $p->logo= $logo;

            if ($request->hasFile('cover')){
                $cover = md5($request['cover']->getClientOriginalName()).'.'.$request['cover']->getClientOriginalExtension();
                $request['cover']->move(public_path('images/place_profile'),$cover);}else{
                return response()->json(['value'=>false,'msg'=>'select a correct cover file']);
            }

            $p->cover = $cover;
            $p->open = $request['open'];
            $p->close = $request['close'];
            $p->update();
            return response()->json(['value' => true, 'msg' => 'updated successfully','data'=>$p->name ."-----".$p->category->name]);
        }else return response()->json(['value'=>false,'msg'=>$validator->errors()]);



    }

    public function delete($id){

        $target=Place::destroy($id);
        return response()->json(['value' => true, 'msg' => 'deleted successfully']);



    }




}
