<?php

namespace App\Http\Middleware;
use Closure;

class CheckUserTypes {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$params) {
        $user = auth()->user();
        if (!$user || !in_array($user->getType(), $params)) {
            return response([
                'msg' => 'UNAUTHORIZE'
            ], 401);
        }

        return $next($request);
    }
}
