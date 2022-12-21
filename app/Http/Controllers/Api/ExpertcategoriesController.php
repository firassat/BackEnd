<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expertcategorie;
use App\Models\Expert;

class ExpertcategoriesController extends Controller
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
    public function create(Request $request)
    {
        $id=auth()->user()->id;
        $x=Expert::all();
        $expert=$x->where('users_id',$id)->first();
        $cate=Expertcategorie::create([
            'categories_id'=>$request->categories_id,
            'experiance'=>$request->experiance,
            'experiance_details'=>$request->details,
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
    public function show()
    {
       //
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
        $x=Expertcategorie::find($id);
        $x->delete();
        return response()->json([
            'status' => true,
            'message' => 'deleted Successfully'
        ]);
    }
   
}
