<?php

namespace App\Http\Controllers;

use View;
use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BackendController extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function __construct() {
        //get the admin user then pass jwt token to all layout
        $this->middleware(function ($request, $next) {
            $user = Auth::guard('admin')->user();
            View::share('jwtToken', $user->generateJwt());

            return $next($request);
        });
    }
}
