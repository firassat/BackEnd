<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Exception;
use Illuminate\Http\Request;

class FavoriteexpertController extends Controller
{

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
