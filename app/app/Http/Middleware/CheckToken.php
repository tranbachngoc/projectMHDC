<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use JWTAuth;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Utils;
use Illuminate\Support\Facades\Lang;

class CheckToken {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        try {
            $token = JWTAuth::getToken();
            $payload = JWTAuth::getPayload($token);

            //now load user and bind to laravel user via user token and type
            if (!isset($payload['token'])) {
                return response(['msg' => 'INVALID_TOKEN'], 401);
            }

            //now try to find user and set to auth class
            //then we can access user via $request->user() or Auth::user()
//            $user = Cache::rememberForever(Utils::createAuthCacheKey($payload), function () use ($payload) {
//                return User::findByToken($payload['token']);
//            });
            $user = User::findByToken($payload['token']);
            
           
            //TODO - check user is valid such as user is locked or something similar it
            if (!$user) {
                return response(['msg' => 'INVALID_TOKEN'], 401);
            }
            if ($user->use_status == User::STATUS_INACTIVE) {
                return response([
                    'msg' => Lang::get('auth.account_in_active')
                    ], 400);
            }
            //TODO - for driver have to resitrct access if his wallet is too low
            Auth::login($user);

            return $next($request);
        } catch (TokenInvalidException $e) {
            return response(['msg' => 'INVALID_TOKEN'], 401);
        } catch (JWTException $e) {
            return response(['msg' => 'INVALID_TOKEN'], 401);
        }
    }
}
