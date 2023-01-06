<?php

namespace App\Http\Controllers\Api;
use App\Models\Expert;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class PersonController extends Controller
{


    public function show(Request $request)
    {
        $id=auth()->user()->id;
        $info=Expert::where('users_id',$id)->first();
        return $info;


    }


    public function update(Request $request)
    {
        $id=auth()->user()->id;
        $x=Expert::where('users_id',$id)->first();
        $y=User::find($id);

        $validator = Validator::make($request->all(),[
           'name'=> 'required',
           'address'=>'required',
           'tel'=> 'required',
           'price'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),200);
        }

        $y->name = $request->name;
        $x->address = $request->address;
        $x->tel = $request->tel;
        $x->price = $request->price;
        $x->save();

        return response()->json([
            'status' => true,
            'message' => trans('message.updateS'),
        ], 200);
    }

    public function updatePhoto(Request $request)
    {
        $id=auth()->user()->id;
        $x=Expert::all();
        $info=$x->where('users_id',$id)->first();

        if($request->image !== null){
            $validator=Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            if($validator->fails()){
                return response()->json($validator->errors(),200);
            }
            $file = $request->file('image');
            $filename = uniqid() . "_" . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $url = URL::to('/') . '/images/' . $filename;
            $info->image = $url ;
        }
        $info->save();
        return response()->json([
            'status' => true,
            'message' =>trans('message.updateS'),
        ], 200);
    }


}
