<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Category;
use Lang;
use App\Models\User;

class CategoryController extends ApiController {

    /**
     * @SWG\Get(
     *     path="/api/v1/categories/level1",
     *     operationId="categoriesLevel1",
     *     description="get list category level1",
     *     produces={"application/json"},
     *     tags={"Categories"},
     *     @SWG\Parameter(
     *         name="cate_type",
     *         in="body",
     *         description="0 là product , 1 là dịch vụ ,2 là coupon",
     *         required=true,
     *         type="integer",
     *     ),
     *      @SWG\Parameter(
     *         name="cat_status",
     *         in="body",
     *         description="1 active , 0 la không active",
     *         required=true,
     *         type="integer",
     *     ),
     *     summary="Lấy danh sách category level 1",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function level1(Request $req) {
        $condition = ['parent_id' => 0, 'cate_type' => 0];
        if($req->cate_type){
            $condition['cate_type'] = $req->cate_type;
        }
        if($req->cat_status){
             $condition['cat_status'] = $req->cat_status;
        }
        
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Category::where($condition)
            ->select('cat_id', 'cat_name','cat_level')
            ->orderBy('cat_name', 'asc')
            ->get()
        ]);
    }


    /**
     * @SWG\Get(
     *     path="/api/v1/me/categories",
     *     operationId="categories",
     *     description="get list categories",
     *     produces={"application/json"},
     *     tags={"Categories"},
     *     summary="Lấy danh sách category của tôi",
     *     @SWG\Parameter(
     *         name="cate_type",
     *         in="body",
     *         description="0 là product , 1 là dịch vụ ,2 là coupon",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function me(Request $req) {
        if (empty($req->user()->shop)) {
            return response([
                'msg' => Lang::get('response.shop_not_found')
                ], 404);
        }
        $sho_category = $req->user()->shop->sho_category;
        $condition = ['cat_id' => $sho_category];
        if ($req->showAll) {
           $condition = ['parent_id' => 0, 'cate_type' => 0];
        }
        if ($req->cate_type) {
            $condition['cate_type'] = $req->cate_type;
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Category::where($condition)
            ->select('cat_id', 'cat_name','cat_level')
            ->orderBy('cat_name', 'asc')
            ->get()
        ]);
    }
    
    /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/categories",
     *     operationId="userCategories",
     *     description="get list categories of user",
     *     produces={"application/json"},
     *     tags={"Categories"},
     *     summary="Lấy danh sách category của người dùng",
     *     @SWG\Parameter(
     *         name="cate_type",
     *         in="body",
     *         description="0 là product , 1 là dịch vụ ,2 là coupon",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public category"
     *     )
     * )
     */
    public function user($id, Request $req) {
        //  $sho_category = $req->user()->shop->sho_category;
        $user = User::where(['use_id' => $id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.user_not_found'),
                ], 404);
        }
        if (empty($user->shop)) {
            return response([
                'msg' => Lang::get('response.success'),
                'data' => []]);
        }
        $sho_category = $user->shop->sho_category;
        $condition = ['cat_id' => $sho_category];
        if($req->showAll){
            $condition = [];
        }
        if ($req->cate_type) {
            $condition['cate_type'] = $req->cate_type;
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Category::where($condition)
                ->select('cat_id', 'cat_name','cat_level')
                ->orderBy('cat_name', 'asc')
                ->get()
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/categories/level1/{id}/level2",
     *     operationId="categoriesLevel1",
     *     description="get list category level2",
     *     produces={"application/json"},
     *     tags={"Categories"},
     *     @SWG\Parameter(
     *         name="cate_type",
     *         in="body",
     *         description="0 là product , 1 là dịch vụ ,2 là coupon",
     *         required=true,
     *         type="integer",
     *     ),
     *      @SWG\Parameter(
     *         name="cate_type",
     *         in="body",
     *         description="1 active , 0 la không active",
     *         required=true,
     *         type="integer",
     *     ),
     *     summary="Lấy danh sách category level 2",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function level2($id, Request $req) {
         $condition = ['parent_id' => $id, 'cate_type' => 0];
        if ($req->cate_type) {
            $condition['cate_type'] = $req->cate_type;
        }
        if ($req->cat_status) {
            $condition['cat_status'] = $req->cat_status;
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Category::where($condition)
            ->select('cat_id', 'cat_name','cat_level')
            ->orderBy('cat_name', 'asc')
            ->get()
        ]);
    }
     /**
     * @SWG\Get(
     *     path="/api/v1/categories/{id}/parent",
     *     operationId="categoriesLevel1",
     *     description="get list parent",
     *     produces={"application/json"},
     *     tags={"Categories"},
     *     summary="Product-Lấy danh sách category từ category cha",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function getParentCategory($id, Request $req){
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Category::where(['parent_id' => $id, 'cat_status' => Category::STATUS_ACTIVE])
            ->select('cat_id', 'cat_name','parent_id','cat_level')
            ->orderBy('cat_name', 'asc')
            ->get()
        ]);
    }
}