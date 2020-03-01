<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;
    /**
     *  @SWG\Swagger(
     * 		basePath="/v1",
     * 		schemes={"http"},
     * 		produces={"application/json"},
     * 		consumes={"application/json"},
     * 		@SWG\Info(
     * 			title="API",
     * 			description="REST API",
     * 			version="1.0",
     * 			termsOfService="terms",
     * 		)
     * )
     * 
     */
    
    function __construct(Request $req) {
        $lang = $req->header('Content-lang');        
        App::setLocale($lang ? $lang : 'en');
    }
}
