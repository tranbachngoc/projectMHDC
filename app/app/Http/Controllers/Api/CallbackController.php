<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use DB;
use App\Models\Notify;
use Validator;
use App\Models\ContentComment;

/**
 * Description of CallbackController
 *
 * @author hoanvu
 */
class CallbackController extends ApiController {

    /**
     * @SWG\Post(
     *     path="/api/v1/callback/notification",
     *     summary="Đẩy push gọi ở web",
     *     tags={"Callback"},
     *     operationId="push_notification",
     *     description="aff - Add sãn phẩm đăng bán cho tài khoản aff",
     *     produces={"application/json"},
     *    @SWG\Parameter(
     *         name="not_title",
     *         in="body",
     *         description="not_title",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="link_share",
     *         in="body",
     *         description="link_share",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="not_group",
     *         in="body",
     *         description="not_group",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="not_degree",
     *         in="body",
     *         description="not_degree",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="not_detail",
     *         in="body",
     *         description="not_detail",
     *         required=true,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="not_status",
     *         in="body",
     *         description="not_status",
     *         required=true,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="not_user",
     *         in="body",
     *         description="not_user",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="category",
     *         in="body",
     *         description="category",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Kết quả thu được sau khi add",
     *         @SWG\Schema(ref="#/definitions/Trip")
     *     )
     * )
     */
    public function pushNotification(Request $req) {

        $comment = new ContentComment([
            'noc_comment' => 'Testing',
            'noc_name' => 'le van son',
            'noc_email' => 'lvson1087@gmail.com',
            'noc_phone' => '0123123123123',
            'noc_user' => 784,
            'noc_date' => date('Y-m-d H:i:s'),
            'noc_content' => 323,
            'noc_avatar' => '',
            'noc_reply' => 0
        ]);
        $comment->save();

        return $comment;
        $validator = Validator::make($req->all(), [
            'not_title' => 'required|string',
            'link_share' => 'string',
            'not_group' => 'integer',
            'not_degree' => 'integer',
            'not_detail' => 'required|string',
            'not_status' => 'integer',
            'not_user' => 'integer',
            'category' => 'integer',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $notify = new Notify([
            'not_begindate' => $req->not_begindate ? $req->not_begindate : time(),
            'not_enddate' => $req->not_enddate ? $req->not_enddate : time(),
        ]);

        $notify->fill($req->all());

        try {
            $notify->save();

            return response([
                'msg' => Lang::get('response.success'),
                'data' => $notify
            ]);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
    }
}
