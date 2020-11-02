<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
class UserTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $msg = 'The email or password does not exist in our database';
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);
        /** @var User $user */
        $user = User::where('email', $request->get('email'))->first();

        if(!$user) {
            throw ValidationException::withMessages([
                'msg'=>$msg
            ]);
        }

        if (!Hash::check($request->get('password'), $user->getAuthPassword())) {
            throw ValidationException::withMessages([
                'msg'=>$msg
            ]);
        }
        return response()->json([
            'token' => $user->createToken($request->get('device_name'))->plainTextToken
        ]);
    }
}
