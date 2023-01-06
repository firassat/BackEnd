<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Exception;
use Illuminate\Http\Request;

class FavoriteexpertController extends Controller
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
    public function create($id)
    {
        $iduser=auth()->user()->id;
        $fav = Favorite::create([
            'user_id'=>$iduser,
            'expert_id'=>$id
        ]);
        return response()->json([
            'status' => true,
            'message' => 'added to favorite list Successfully'
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
    public function show($idexpert,$iduser)
    {
        $x=Favorite::where('user_id',$iduser);
        if($x->where('expert_id',$idexpert)->first())
        {
           return true;
        }
        else{
            return false;
        }
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
        $iduser=auth()->user()->id;
        $x=Favorite::where('user_id',$iduser);
        if($x->where('expert_id',$id)->first())
        {
            $x->delete();
            return response()->json([
                'status' => true,
                'message' => 'deleted from favorite list Successfully'
            ]);
        }
    }
}
