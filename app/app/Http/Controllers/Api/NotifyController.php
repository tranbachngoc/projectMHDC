<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Notification;
use App\Models\Notify;
use Lang;

class NotifyController extends ApiController {

    /**
     * @SWG\Get(
     *     path="/api/v1/me/notifies",
     *     operationId="notifies",
     *     description="get list notifies",
     *     produces={"application/json"},
     *     tags={"Notifies"},
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page trips",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit trips",
     *         required=false,
     *         type="integer",
     *     ),
     *     summary="Lấy danh sách category level 1",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function index(Request $req) {
        $query = Notification::where(['userId' => $req->user()->use_id])
            ->orderBy('createdAt', 'DESC');
        //$query->whereRaw('FIND_IN_SET(' . $req->user()->use_group . ',not_group ) ');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $results = $query->paginate($limit, ['*'], 'page', $page);

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }
    
    /**
     * @SWG\Get(
     *     path="/api/v1/me/sharelist",
     *     operationId="sharelist",
     *     description="Danh sách link cần chia sẻ",
     *     produces={"application/json"},
     *     tags={"Notifies"},
     *     summary="Danh sách link cần chia sẻ",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function shareList(Request $req) {
        $user = $req->user();
        $query = Notify::where(['not_status' => Notify::STATUS_ACTIVE, 'category' => Notify::TYPE_SHARE]);

        $query->whereIn('not_id', function($q) use($user) {
            $q->select('not_id');
            $q->from(Notify::tableName());
            $q->where('not_group', '<>', '');
            $q->where('not_status', Notify::STATUS_ACTIVE);
            $q->whereRaw('FIND_IN_SET(' . $user->use_group . ',not_group ) ');
        });
        $query->orWhere(['not_user' => $req->user()->use_id]);
        // $query->whereNotIn('not_id',[null]);
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $results = $query->paginate($limit, ['*'], 'page', $page);

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/sharelist/{id}",
     *     operationId="sharelist",
     *     description="Chi tiết link cần chia sẽ",
     *     produces={"application/json"},
     *     tags={"Notifies"},
     *     summary="Chi tiết link cần chia sẽ",
     *     @SWG\Response(
     *         response=200,
     *         description="public notify"
     *     )
     * )
     */
    public function detailShareLink($id, Request $req) {
        $notify = Notify::where(['not_id' => $id, 'not_status' => Notify::STATUS_ACTIVE])->first();
        if (empty($notify)) {
            return response([
                'msg' => Lang::get('response.notify_not_found')
                ], 404);
        }
        if (trim($notify->not_view) == '' || (trim($notify->not_view) != '' && !stristr($notify->not_view, "[$userID]"))) {
            $notify->not_view = $notify->not_view . "[$userID]";
            $notify->save();
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $notify
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/me/notifies/{id}",
     *     operationId="notifies-view",
     *     description="get list notifies",
     *     produces={"application/json"},
     *     tags={"Notifies"},
     *     summary="Thông báo detail",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function view($id, Request $req) {
        $notify = Notification::where(['id' => $id, 'userId' => $req->user()->use_id])->first();
        if (!$notify) {
            return response([
                'msg' => Lang::get('response.notify_not_found')
            ], 404);
        }

        $notify->read = true;

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