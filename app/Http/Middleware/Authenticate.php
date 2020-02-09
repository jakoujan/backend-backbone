<?php

namespace App\Http\Middleware;

use App\Dtos\ResponseDto;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware {

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request) {
        if ($request->expectsJson()) {
            $response = new ResponseDto;
            $response->status = 0;
            $response->code = 401;
            $response->message = 'Credenciales incorrectas';
            return response()->json($response);
        } else {
            return route('login');
        }
    }

}
