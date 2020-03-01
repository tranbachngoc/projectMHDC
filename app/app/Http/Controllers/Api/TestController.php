<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;

class TestController extends ApiController {

    function putTest() {
        return response(['msg' => Lang::get('response.success'), 'data' => 'updated'], 200);
    }

}
