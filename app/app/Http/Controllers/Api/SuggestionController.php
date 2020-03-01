<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Product;
use Lang;

class SuggestionController extends ApiController {

	/**
     * @SWG\Get(
     *     path="/api/v1/suggestion/eating",
     *     operationId="eating",
     *     description="Danh sach ăn gì",
     *     produces={"application/json"},
     *     tags={"Suggestion"},
     *     summary="Danh sach ăn gì",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function eating(Request $req) {

        return response([
            'msg' => Lang::get('response.success'),
            'data' => Product::suggest($req->user(), Product::P_TYPE_EAT)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/suggestion/buys",
     *     operationId="eating",
     *     description="Danh sach mua gì",
     *     produces={"application/json"},
     *     tags={"Suggestion"},
     *     summary="Danh sach mua gì",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function buys(Request $req) {
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Product::suggest($req->user(), Product::P_TYPE_BUY)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/suggestion/places",
     *     operationId="eating",
     *     description="Danh sach ăn gì",
     *     produces={"application/json"},
     *     tags={"Suggestion"},
     *     summary="Danh sach ở đâu",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function places(Request $req) {
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Product::suggest($req->user(), Product::P_TYPE_PLACE)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/suggestion/news",
     *     operationId="eating",
     *     description="Danh sach ăn gì",
     *     produces={"application/json"},
     *     tags={"Suggestion"},
     *     summary="Danh sach bài viết",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function news(Request $req) {
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Product::news()
        ]);
    }
}