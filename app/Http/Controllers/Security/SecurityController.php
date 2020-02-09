<?php

namespace App\Http\Controllers\Security;

use App\Dtos\ResponseDto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class SecurityController extends Controller {

    public function authenticate(Request $request) {
        $credentials = $request->only('user', 'password');
        $response = new ResponseDto;
        if (Auth::attempt($credentials)) {
            $token = $this->update($request);
            $user = Auth::user();
            $response->message = 'Login correcto';
            $response->fields = array('user' => $user, 'token' => $token, 'csrf' => csrf_token());
        } else {
            $response->status = 0;
            $response->code = 403;
            $response->message = 'Credenciales incorrectas';
        }
        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

    public function update(Request $request) {
        $token = Str::random(80);
        $hash = hash('sha256', $token);
        $request->user()->forceFill([
            'api_token' => $hash,
        ])->save();
        return $hash;
    }

    public function createUser(Request $request) {
        $token = Str::random(80);
        $user = User::forceCreate([
                    'name' => 'edgar',
                    'user' => 'edgar.rangel',
                    'email' => 'edgar.rangel@mexicocss.com',
                    'customer' => 1,
                    'password' => Hash::make('password'),
                    'api_token' => hash('sha256', $token),
                    'profiles' => "{}",
                    'status' => 99,
        ]);

        return response()->json($user);
    }

}
