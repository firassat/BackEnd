<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AvailableTime;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\Expertcategorie;
use App\Models\Expert;
use App\Models\User;
use Exception;
use PHPUnit\Framework\MockObject\OriginalConstructorInvocationRequiredException;

use function PHPUnit\Framework\isEmpty;

class ExpertcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchexpertroute1(Request $request)
    {   
        $iduser=auth()->user()->id;
     try{
        $x=User::where('name',$request->name)->first();
        if($x->is_expert==1)
        {
           $y=Expert::where('users_id',$x->id)->first();
           $star= (new StarController)->show($y->id);
           $isinfavorite=(new FavoriteexpertController)->show($y->id,$iduser);
           $experiance=Expertcategorie::where('experts_id',$y->id)->pluck('experiance');   
           return response()->json([
            "id"=>$y->id,
            "name"=>$x->name,
            "image"=>$y->image,
            "numberofstars"=>$star,
            "isfavorite"=>$isinfavorite,
            "experiance"=>$experiance
          ]);
        }
        else{
            return response()->json([
                'massege'=>'expert not found'
            ]);
        }
      }
        catch(Exception){
            return response()->json([
                'massege'=>'expert not found'
            ]);
        }
    }   

    public function searchexpertroute2(Request $request)
    {   $iduser=auth()->user()->id;
        $expert=Expert::where('id',$request->id)->first();
        $expert1=User::where('id',$expert->users_id)->get();
        $name=$expert1->value('name');
        $email=$expert1->value('email');
        $image=$expert->value('image');
        $star= (new StarController)->show($request->id);
        $isinfavorite=(new FavoriteexpertController)->show($request->id,$iduser);
        $tel=$expert->value('tel');
        $price=$expert->value('price');
        $time=(new TimeController)->availableTimeForExpert($request);
        $categorie=Expertcategorie::where('experts_id',$request->id)->get();
        return response()->json([
              "name"=>$name,
              "image"=>$image,
              "email"=>$email,
              "numberofstars"=>$star,
              "isfavorite"=>$isinfavorite,
              "tel"=>$tel,
              "price"=>$price,
              "jop"=>$categorie,
              "availabletime"=>$time
            ]);  
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id=auth()->user()->id;
        $x=Expert::all();
        $expert=$x->where('users_id',$id)->first();
        $cate=Expertcategorie::create([
            'categories_id'=>$request->categories_id,
            'experiance'=>$request->experiance,
            'experiance_details'=>$request->experiance_details,
            'experts_id'=>$expert->id

        ]);
        return response()->json([
            'status' => true,
            'message' => 'added Successfully'
        ]);
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
       $categorie=Categorie::find($request->id);
       $expert=array();
      foreach($categorie->expert as $cats)
     {  
        $userid=$cats->users_id;  
        $nn=User::where('id',$userid)->value('name');
        $request->merge(["name"=>$nn]); 
       
        $ex=(new ExpertcategoriesController)->searchexpertroute1($request);
        $ex1=$ex->original;
        array_push($expert,$ex1);
     }
        return response()->json($expert);
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
   
     public function update(Request $request,$id)
    {
        $x=Expertcategorie::find($id);
        $idexpert=$x->experts_id;
        $x->delete();
       $cate=Expertcategorie::create([
            'categories_id'=>$request->categories_id,
            'experiance'=>$request->experiance,
            'experiance_details'=>$request->experiance_details,
            'experts_id'=>$idexpert

        ]);
        return response()->json([
            'status' => true,
            'message' => 'updated Successfully',
            'newer categories information'=>$cate
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $x=Expertcategorie::find($id);
        $x->delete();
        return response()->json([
            'status' => true,
            'message' => 'deleted Successfully'
        ]);
    }
   
}
