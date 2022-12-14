<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Expert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'is_expert'=>'required',
                'name'=>'required'
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => trans('message.ve'),
                    'errors' => $validateUser->errors()
                ], 200);
            }
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'is_expert'=>$request->is_expert,
            ]);

            if($request->is_expert == 1){
                Expert::create([
                    'users_id'=>$user->id,
                    'address' => $request->address,
                    'tel' => $request->tel
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => trans('message.reS'),
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => trans('message.reF')
            ], 200);
        }
    }
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => trans('message.ve'),
                    'errors' => $validateUser->errors()
                ], 200);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => trans('message.emailF'),
                ], 200);
            }

            $user = User::where('email', $request->email)->first();
            if($user->is_expert==1){
                $id=auth()->user()->id;
                $x=Expert::all();
                $info=$x->where('users_id',$id)->first();
                if($info->image !== null){
                return response()->json([
                    'status' => true,
                    'isexpert'=>true,
                    'message' => trans('message.logS'),
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'image'=>$info->image
                 ], 200);
                }
                else{
                    return response()->json([
                        'status' => true,
                        'isexpert'=>true,
                        'message' => trans('message.logS'),
                        'token' => $user->createToken("API TOKEN")->plainTextToken
                     ], 200);
                }
        }
            else{
                return response()->json([
                    'status' => true,
                    'name'=>$user->name,
                    'cash'=>$user->cash,
                    'isexpert'=>false,
                    'message' => trans('message.logS'),
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ], 200);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => trans('message.logF')
            ], 200);
        }
    }
    public function logout(Request $request)
    {
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);
        $token->delete();
        return response()->json([
            'status'=>'true',
            'message'=>trans('message.logout')
        ]);
    }
}
