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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id=auth()->user()->id;
        $x=Expert::all();
        $info=$x->where('users_id',$id)->first();
        return $info;


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id=auth()->user()->id;
        $x=Expert::all();
        $info=$x->where('users_id',$id)->first();

        $validator = Validator::make($request->all(),[
           'name'=> 'required',
           'address'=>'required',
           'tel'=> 'required',
           'price'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $info->name = $request->name;
        $info->address = $request->address;
        $info->tel = $request->tel;
        $info->price = $request->price;

        if($request->image !== null){
            $validator=Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            if($validator->fails()){
                return response()->json($validator->errors(),400);
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
            'message' => 'Update Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
