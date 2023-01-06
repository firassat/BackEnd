<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Star;
use Ramsey\Uuid\Type\Integer;

class StarController extends Controller
{

    public function create($id,$num)
    {
        $iduser=auth()->user()->id;
        $x=Star::where('user_id',$iduser);
        if($x->where('expert_id',$id)->first())
        {
            return response()->json([
                'massege'=>'the user have already give star for this expert'
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

    public function show($id)
    {
        $n=0;
        $y=0;
        foreach(Star::all() as $u){
            if($u->expert_id==$id){
                $n+=$u->numberofstars;
                $y++;
            }}
        if($n==0)
        {
            return 0;
        }
        $n1=$n/$y;
        return (Integer)$n1;
    }

}
