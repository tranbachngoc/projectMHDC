<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Content;
use App\Models\ContentComment;
use Lang;
use App\Services\Search;
use DB;

class SearchController extends ApiController {

	/**
     * @SWG\Get(
     *     path="/api/v1/search",
     *     operationId="news",
     *     description="Danh sach news",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach news",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public"
     *     )
     * )
     */
    public function all(Request $req) {
        //populate user
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchAll($req->user(), $req->search)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/search/new",
     *     operationId="news",
     *     description="Danh sach news",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach news",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public"
     *     )
     * )
     */
    public function allNew(Request $req) {
        //populate user
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchAllNew($req->user(), $req->search)
        ]);
    }


    /**
     * @SWG\Get(
     *     path="/api/v1/search/news",
     *     operationId="news",
     *     description="Danh sach news",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach news",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function news(Request $req) {
        $result = [];
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchByNews($req->user(), $req->search, true, $page, $limit)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/search/affiliates",
     *     operationId="affiliates",
     *     description="Danh sach cộng tác viên",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach cộng tác viên",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public"
     *     )
     * )
     */
    public function affiliates(Request $req) {
        $result = [];
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchByAffiliates($req->user(), $req->search, true, $page, $limit)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/search/landing_pages",
     *     operationId="landing_pages",
     *     description="Danh sach Bộ sưu tập",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach Bộ sưu tập",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function landingPages(Request $req) {
        $result = [];
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchByLandingPages($req->user(), $req->search, true, $page, $limit)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/search/domains",
     *     operationId="domains",
     *     description="Danh sach Websites",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach Websites",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function domains(Request $req) {
        $result = [];
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchByDomains($req->user(), $req->search, true, $page, $limit)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/search/shops",
     *     operationId="shops",
     *     description="Danh sach gian hàng",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach gian hàng",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function shops(Request $req) {
        $result = [];
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchByShops($req->user(), $req->search, true, $page, $limit)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/search/pictures",
     *     operationId="pictures",
     *     description="Danh sach ảnh",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach ảnh",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function pictures(Request $req) {
        $result = [];
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchByPictures($req->user(), $req->search, true, $page, $limit)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/search/videos",
     *     operationId="videos",
     *     description="Danh sach video",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach video",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function videos(Request $req) {
        $result = [];
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchByVideos($req->user(), $req->search, true, $page, $limit)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/search/categories",
     *     operationId="category",
     *     description="Danh sach nhóm",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach nhóm",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function categories(Request $req) {
        $result = [];
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchByCategories($req->user(), $req->search, true, $page, $limit)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/search/products",
     *     operationId="products",
     *     description="Danh sach sản phẩm",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach sản phẩm",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="sho_id",
     *         in="query",
     *         description="sho_id",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function products(Request $req) {
        $result = [];
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchByProducts($req->sho_id, $req->search, true, $page, $limit)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/search/shops/products",
     *     operationId="productsShops",
     *     description="Danh sach shop sản phẩm",
     *     produces={"application/json"},
     *     tags={"Search"},
     *     summary="Danh sach shop sản phẩm",
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function shopsProducts(Request $req) {
        $result = [];
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => Search::searchByShopsProducts($req->search, $page, $limit)
        ]);
    }
}