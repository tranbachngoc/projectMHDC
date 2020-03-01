<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use JWTAuth;
use App\Models\BaseUser;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class CheckAccessKey {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        try {

            $key = $request->header('Access-key');

            if ($key !== env('ACCESS_KEY')) {
                return response(['msg' => 'INVALID_ACCESS_KEY'], 401);
            }

            return $next($request);
        } catch (TokenInvalidException $e) {
            return response(['msg' => 'INVALID_ACCESS_KEY'], 401);
        } catch (JWTException $e) {
            return response(['msg' => 'INVALID_ACCESS_KEY'], 401);
        }
    }
}
