<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use Validator;
use Illuminate\Http\Request;
use App\Models\ProductFavorite;
use Lang;
/**
 * Description of WishListController
 *
 * @author hoanvu
 */
class WishListController  extends ApiController  {
    //put your code here
    /**
     * @SWG\Get(
     *     path="/api/v1/products/{id}/favorite",
     *     operationId="products",
     *     description="Yêu thích sản phẩm",
     *     produces={"application/json"},
     *     tags={"Products"},
     *     summary="Yêu thích sản phẩm",
     *  @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="id của sản phẩm",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="user và sản phẩm yêu thích"
     *     )
     * )
     */
    public function add(Request $req){
        
        $has = ProductFavorite::where(['prf_product' => $req->id, 'prf_user' => $req->user()->use_id])->count();
        if ($has > 0) {
            //To Do translate here
            return response([
                'msg' => 'Bạn đã thích sản phẩm này rồi.',
                ], 402);
        }

        $favorite = new ProductFavorite([
            'prf_product' => $req->id,
            'prf_user' => $req->user()->use_id,
            'prf_date' => time()
        ]);
        $favorite->save();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $favorite
        ]);
    }
}
