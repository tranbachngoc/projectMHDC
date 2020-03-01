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
use App\Models\Delivery;
use App\Models\DeliveryComment;
use App\Models\Shop;
use Lang;
/**
 * Description of WishListController
 *
 * @author hoanvu
 */
class ComplaintController  extends ApiController  {
    
    /**
     * @SWG\Get(
     *     path="/api/v1/me/complaints-orders",
     *     operationId="Complaints",
     *     description="DANH SÁCH ĐƠN HÀNG KHIẾU NẠI",
     *     produces={"application/json"},
     *     tags={"Complaints"},
     *     summary="DANH SÁCH ĐƠN HÀNG KHIẾU NẠI",
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page trips",
     *         required=false,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="status",
     *         in="query",
     *         description="cách nhau bởi dấu , vd:1,2,3 - 1:Yêu cầu khiếu nại mới ,2:hờ thành viên gởi mẫu vận chuyển, 3: // Xác nhận và hoàn tiền cho thành viên, 4: là complaint đã xữ lý",
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
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function index(Request $req) {
        $status = ['01', '02', '03'];
        if ($req->status) {
            $status = explode(',', $req->status);
        }
        $query = Delivery::whereIn('status_id', $status)->orderBy('id', 'DESC');
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
     *     path="/api/v1/me/complaints-orders/{id}",
     *     operationId="Complaints",
     *     description="Chi tiết ticket khiếu nại ",
     *     produces={"application/json"},
     *     tags={"Complaints"},
     *     summary="Chi tiết ticket khiếu nại  ",
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
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function complaintsOrdersForm($id,Request $req) {
        $query = DeliveryComment::where(['id_request',$id]);
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $paginated = $query->paginate($limit, ['*'], 'page', $page);
        $data = [];
        foreach ($paginated->items() as $vals) {
            
            $item = $vals->toArray();
            $item['name'] = '';
            $item['logo'] = '';
            $item['link'] = '';
            $item['bill'] = '';
            if (in_array($vals->status_changedelivery, array("01", "03"))) {
                if ($vals->user_id > 0) {
                    $user = $vals->user;
                    $item['name'] = $user->use_fullname;
                    $item['logo'] = $user->avatar;
                }
                if ($vals->bill) {
                    $item['bill'] = env('APP_URL') . 'media/images/mauvandon/' . $vals->bill;
                }
            } else {
                $shop = Shop::where('sho_user', $vals->user_id)->first();
                $shop->publicInfo();
                $item['name'] = $shop->sho_name;
                $item['logo'] = env('APP_URL') . 'media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo;
                $item['link'] =  $shop->domainLink;
                $item['bill'] = '';
            }
            $data[] = $item;
        }
        $results = $paginated->toArray();
        $results['data'] = $data;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);

    
    }
     /**
     * @SWG\Get(
     *     path="/api/v1/me/complaints-orders/{id}/comment",
     *     operationId="Complaints",
     *     description="Khiếu nại đơn hàng ",
     *     produces={"application/json"},
     *     tags={"Complaints"},
     *     summary="Khiếu nại đơn hàng - Đang phát triển",
     *  @SWG\Parameter(
     *         name="status",
     *         in="body",
     *         description="Trạng thái khiếu nại 4: Hủy",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="status_comment",
     *         in="query",
     *         description="Trạng thai comment",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="content",
     *         in="query",
     *         description="Nội dung comment",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function submitComplaintsOrdersForm($id,Request $req) {
        
        $delivery = Delivery::where(['id' => $id])->first();
        if (empty($delivery)) {
            
        }
        if ($req->status == 04) {
            if ($delivery->type_id == 2) {
                $order = Order::where('id', $delivery->order_id)->first();
                $order->order_status = "06";
                $order->change_status_date = time();
                $order->save();
                $oderDetail = \App\Models\OrderDetail::where('shc_orderid', $delivery->order_id);
                $oderDetail->shc_change_status_date = time();
                $oderDetail->shc_status = "06";
                $oderDetail->save();
            }
        }
        $delivery->status_id = $req->status;
        $delivery->lastupdated = date("Y-m-d H:i:s", time());
        $delivery->save();
        $comments = new DeliveryComment([
            'id_request' => $id,
            'status_changedelivery' => $req->status,
            'user_id' => $req->user()->use_id,
            'content' => $req->content,
            'status_comment' => $req->status_comment,
            'lastupdated' => date("Y-m-d H:i:s", time())
        ]);
        $comments->save();


        return response([
            'msg' => Lang::get('response.success'),
            'data' => $comments
        ]);
    }

}