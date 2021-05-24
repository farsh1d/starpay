<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
 
class AuthController extends Controller
{
    public function register(UserRequest $request){

        $params = $request->all();

        $params['password'] = bcrypt($params['password']);
        
        $user = User::create(  $params);

        $token = $user->createToken('starpaytoken')->plainTextToken;

        return response()->json([

            'status' => 201,
            'data'   => [
                'user'  => $user,
                'token' => $token
            ]
        ]);
        
    }

    public function login( UserRequest $request ) {
      
        // Check email
        $user = User::where('email', $request->email )->first();

        // Check password
        if(!$user || !Hash::check($request->password, $user->password)) {           

            return response()->json([

                'status' => 401,
                'data'   => [ 'message' => 'Login Failed' ]
            ]);

        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([

            'status' => 201,
            'data'   => [
                'user'  => $user,
                'token' => $token
            ]
        ]);
        
    }

    public function logout() {
        
        auth()->user()->tokens()->delete();

        return response()->json([

            'status' => 201,
            'data'   => [ 'message' => 'Success Loged out :)' ]
        ]);

    }

    public function user() {

        return response()->json([

            'status' => 200,
            'data'   => auth()->user()
        ]);
    }
}
