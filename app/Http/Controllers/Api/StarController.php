<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Star;

class StarController extends Controller
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
    public function create($id,$num)
    { 
        $iduser=auth()->user()->id;
       // $x=Star::all();
        if($x=Star::where('user_id',$iduser)->first()&&$x=Star::where('expert_id',$id)->first())
        {
            return response()->json([
                'massege'=>'the user have already '
            ]);
        }
        else{
            $star=Star::create([
                'user_id'=>$iduser,
                'expert_id'=>$id,
                'numberofstars'=>$num
    
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Successfully'
            ]);


        }
        
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
    public function show($id)
    {
        $n=0;
        $y=0;
       // $x=Star::all();
        foreach(Star::all() as $u){
       //while($x=Star::where('expert_id',$id)->first()){
        if($u->expert_id==$id){
            $n+=$u->numberofstars;
            $y++;
        }
        if($n==0)
        {
            return response()->json([
                'mass'=>0
            ]);
        }
        $n1=$n/$y;
       /* return response()->json([
            //'stars'=>$y
            'mass'=>$u->id
        ]);*/
   // echo $u->expert_id;
    }
       return response()->json([
            //'stars'=>$y
            'mass'=>$n
        ]);
    
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
    public function update(Request $request, $id)
    {
        //
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
