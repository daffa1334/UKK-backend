<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTExceptions;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username','password');

        try{
            if(! $token = JWTAuth::attempt($credentials)){
                return response()-> json(['error' => 'invalid_credentials'], 400);    
            }
        } catch (JWTException $e){
            return response()-> json(['error'=>'could_not_create_token']);
        }
    

    // $data = [
    //     'token' => $token,
    //     'user'  => JWTAuth::user()
    // ];

    // return response()->json([
    //     'message' => 'login sukses',
    //     'data'    => $data
    // ]);

$user = JWTAuth::user();
        $outlet = DB::table('outlet')->where('id', $user->id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Login Sukses',
            'token' =>$token,
            'user' => $user,
            'outlet' => $outlet 
        ]);
    }
    public function loginCheck()
    {
        try {
            if(! $user = JWTAuth::parseToken()->authenticate()) {
                return response()-> json(['message' => 'Invalid Token']);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return response()-> json(['message' => 'Token expired']);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return response()-> json(['message' => 'Invalid Token']);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()-> json(['message' => 'Token absent']);
        }

        return response()-> json([
            'success' => true,
            'message' => 'Success']);
    }
    public function logout(Request $request)
    {
        if(JWTAuth::invalidate(JWTAuth::getToken())) {
            return response()->json(['message' => 'Anda sudah logout']);
        } else {
            return response()->json(['message' => 'Gagal logout']);
        }
    }
}