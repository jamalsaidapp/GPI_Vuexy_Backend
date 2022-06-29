<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

         $user = User::where('email', $request->email)->first();

        if (! $user || ! \Hash::check($request->password, $user->password)) {

            return response(['message' => "Les informations d'identification fournies sont incorrectes."], 403);
        }

            $full_name = $user->getUserFullName();
            $email = $user->email;
            $role = $user->getRoleNames()->first();
            $ability = $user->getAllPermissions();
            $userData = compact('full_name', 'email', 'role' , 'ability');
            $accessToken = $user->createToken('accessToken')->plainTextToken;

        return response(compact('userData', 'accessToken'), 200);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
       return response()->json([
           'message' => 'successful-logout'
       ]);
    }

    public function refresh()
    {
        // if ($user = auth()->user()) {
        //     $role = $user->getRoleNames();
        //     $ability = $user->getAllPermissions();
        //     $userData = compact('user', 'role' , 'ability');
        // }
        // $refreshToken = auth()->refresh();

        // return response(compact('userData', 'accessToken'), 200) ;

    }

}
