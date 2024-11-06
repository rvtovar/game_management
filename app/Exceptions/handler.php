<?php

namespace App\Exceptions;

use Exception;

class handler extends Exception
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'You are not authenticated'], 401);
        }

        return redirect()->guest(route('login'));

    }
}
