<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Authenticate a user and return an access token.
     *
     * Validates credentials, logs in the user, and provides a token with optional expiration.
     *
     * @param \Illuminate\Http\Request $request The request instance.
     * @return \Illuminate\Http\JsonResponse JSON response with the token or error message.
    */
    public function login(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me) {
                $token->expires_at = now()->addWeeks(1);
            }

            $token->save();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => $tokenResult->token->expires_at->toDateTimeString(),
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
