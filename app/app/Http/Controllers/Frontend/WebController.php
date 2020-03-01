<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;

class WebController extends Controller {

    public function newsDetail($id) {
        $content = Content::find($id);
        if (!$content) {
            return view('errors.404');
        }
        return view('frontend.news', compact('content'));
    }
}
