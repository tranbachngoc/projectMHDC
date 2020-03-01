<?php

namespace App\Http\Middleware;
use Closure;

class CheckUserType {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type) {
        $user = auth()->user();
        if (!$user || (String)$user->getType() !== (String)$type) {
            return response([
                'msg' => 'UNAUTHORIZE'
            ], 401);
        }

        return $next($request);
    }
}
