<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\Expertcategorie;
use App\Models\Expert;
use App\Models\User;
use Exception;

class ExpertcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      try{
        $name=$request->name;
        $x=User::where('name',$name)->first();
        $u=array();
        if($x->is_expert==1)
        {
            $y=Expert::where('users_id',$x->id)->first();
            array_push($u,$y);
            array_push($u,$y->categorie);
            array_push($u,$y->user);
            return $u;
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
    public function show($id)
    {
       $categorie=Categorie::find($id);
       $expert=array();
      foreach($categorie->expert as $cats)
      {
        array_push($expert,$cats);
      }
      return $expert;
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
