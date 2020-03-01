<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use App\Models\CommissionStore;
use App\Models\CommisionUserAff;
use App\Models\DetailCommissionAff;
use Illuminate\Http\Request;
use Lang;
use DB;
use Validator;
use App\Helpers\Commons;
/**
 * Description of CommissionController
 *
 * @author hoanvu
 */
class CommissionController extends ApiController {
    //put your code here
     /**
     * @SWG\Put(
     *     path="/api/v1/commissions/{id}",
     *     operationId="commissions-id",
     *     description="Cập nhật commission",
     *     produces={"application/json"},
     *     tags={"Commission"},
     *     summary="Cập nhật commission",
     *    @SWG\Parameter(
     *         name="min",
     *         in="body",
     *         description="Thưởng tối thiểu",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="max",
     *         in="body",
     *         description="Thưởng tối đa",
     *         required=true,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="max",
     *         in="percent",
     *         description="Phần trăm hoa hồng nhận được",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    public function update($id, Request $req) {
        $input = $req->all();
        $validator = Validator::make($req->all(), [
                'min' => 'required|min:0',
                'max' => 'required|min:0',
                'percent' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $com = CommissionStore::where(['id'=> $id,'sho_user'=>$req->user()->use_id])->first();
        if (empty($com)) {
             return response([
                'msg' => Lang::get('response.commision_not_found'),
                ], 404);
        }
        $com->fill($input);
        try {
            $com->save();

            return response([
                'msg' => Lang::get('response.success'),
                'data' => $com
            ]);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/api/v1/shop/{userId}/commissions",
     *     operationId="commissions-id",
     *     description="Danh sách commission",
     *     produces={"application/json"},
     *     tags={"Commission"},
     *     summary="Danh sách commission",
     *    @SWG\Parameter(
     *         name="userId",
     *         in="path",
     *         description="userId",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    public function getCommisions($id, Request $req) {
        $list_commiss_sho = CommissionStore::where(['sho_user'=> $req->user()->use_id])->get();
        $check_commiss_aff = DetailCommissionAff::where('aff_id', $id)->first();
        $L_Array1 = array();
        if ($check_commiss_aff) {
            $a_com = explode(',', $check_commiss_aff->commissid_percent);
            foreach ($list_commiss_sho as $key => $value) {
                    $tick = true;
                    for ($i = 0; $i < count($a_com); $i++) { 
                        $b_com = explode(':', $a_com[$i]);                        
                        if($value->id == $b_com["0"]){
                            $L_Array1[] = array(
                                'id' => $value->id,
                                'shop_user' => $value->sho_user,
                                'min' => $value->min,
                                'max' => $value->max,
                                'percent' => $b_com["1"]
                            );                            
                            $tick = true;
                            break;
                        }else{
                            $tick = false;
                            continue;
                        }                        
                    }
                    if($tick == false){
                        $L_Array1[] = array(
                            'id' => $value->id,
                            'shop_user' => $value->sho_user,
                            'min' => $value->min,
                            'max' => $value->max,
                            'percent' => $value->percent
                        );  
                    }
                }    
        } else {
            foreach ($list_commiss_sho as $key => $value) {
                $L_Array1[] = array(
                    'id' => $value->id,
                    'shop_user' => $value->sho_user,
                    'min' => $value->min,
                    'max' => $value->max,
                    'percent' => $value->percent
                );
            }
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $L_Array1
        ]);
    }

    /**
     * @SWG\PUT(
     *     path="/api/v1/shop/{userId}/commissions/{id}",
     *     operationId="commissions-id",
     *     description="Danh sách commission",
     *     produces={"application/json"},
     *     tags={"Commission"},
     *     summary="Danh sách commission",
     *    @SWG\Parameter(
     *         name="userId",
     *         in="path",
     *         description="userId",
     *         required=true,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Commisions id",
     *         required=true,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="percent",
     *         in="body",
     *         description="percent",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    public function updateCommisions($userId, $id, Request $req) {
        $validator = Validator::make($req->all(), [
                'percent' => 'required'
        ]);
        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }
        $commission = $req->percent;
        $check_commiss_aff = DetailCommissionAff::where('aff_id', $userId)->first();                        
        if($check_commiss_aff){
            $str = '';              
            $a_com = explode(',', $check_commiss_aff->commissid_percent);
            for($i = 0; $i < count($a_com); $i++){
                $b_com = explode(':', $a_com[$i]);
                if((int)$b_com["0"] == $id){                                           
                } else{
                    $str .= $a_com[$i].',';
                }
            }
            $string = $str . $id .':'.$commission;
            $check_commiss_aff->commissid_percent = $string;
            $check_commiss_aff->save();
        } else {
            DetailCommissionAff::create([
                'aff_id' => $userId,
                'commissid_percent' => $id.':'.$commission,
                'note' => strtotime(date('Y/m/d', time())).' commission'
            ]);
        }

        return response([
            'msg' => Lang::get('response.success')
        ]);
    }

    /**
     * @SWG\Delete(
     *     path="/api/v1/commissions/{id}",
     *     operationId="commissions-id",
     *     description="Xóa comission",
     *     produces={"application/json"},
     *     tags={"Commission"},
     *     summary="Cập nhật commission",
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    public function delete($id, Request $req) {
        $com = CommissionStore::where(['id'=> $id,'sho_user'=>$req->user()->use_id])->first();
        if (empty($com)) {
              return response([
                'msg' => Lang::get('response.commision_not_found'),
                ], 404);
        }
        $com->delete();
         return response([
            'msg' => Lang::get('response.success'),
            'data' => $com
        ]);
    }
          /**
     * @SWG\Post(
     *     path="/api/v1/commissions",
     *     operationId="commissions-id",
     *     description="Thêm commission",
     *     produces={"application/json"},
     *     tags={"Commission"},
     *     summary="Cập nhật commission",
     *    @SWG\Parameter(
     *         name="min",
     *         in="body",
     *         description="Thưởng tối thiểu",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="max",
     *         in="body",
     *         description="Thưởng tối đa",
     *         required=true,
     *         type="integer",
     *     ),
    *    @SWG\Parameter(
     *         name="percent",
     *         in="body",
     *         description="Phần trăm hoa hồng nhận được",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    public function add(Request $req) {
        $validator = Validator::make($req->all(), [
                'min' => 'required|min:0',
                'max' => 'required|min:0',
                'percent' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $helper = new Commons();
        $com = new CommissionStore([
            'desc' => 'Thưởng doanh số',
            'min' => $helper->injection_html($req->min),
            'max' => $req->max,
            'percent' => $req->percent
        ]);
        $com->createdate = strtotime(date('Y/m/d', time()));
        $com->sho_user = $req->user()->use_id;
        try {
            $com->save();

            return response([
                'msg' => Lang::get('response.success'),
                'data' => $com
            ]);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
    }
    
         /**
     * @SWG\Get(
     *     path="/api/v1/commissions/{id}",
     *     operationId="commissions-id",
     *     description="Cập nhật commission",
     *     produces={"application/json"},
     *     tags={"Commission"},
     *     summary="Cập nhật commission",
     *    @SWG\Parameter(
     *         name="min",
     *         in="body",
     *         description="Thưởng tối thiểu",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="max",
     *         in="body",
     *         description="Thưởng tối đa",
     *         required=true,
     *         type="integer",
     *     ),
    *    @SWG\Parameter(
     *         name="max",
     *         in="percent",
     *         description="Phần trăm hoa hồng nhận được",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    public function index(Request $req) {
        $query = CommissionStore::where(['sho_user'=> $req->user()->use_id]);
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $results = $query->paginate($limit, ['*'], 'page', $page);
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }
    
    /**
     * @SWG\Post(
     *     path="/api/v1/staff/{id}/commissions",
     *     operationId="commissions-id",
     *     description="Thêm commission or Cap nhat commissions của nhân viên",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="Cập nhật commission",
     *    @SWG\Parameter(
     *         name="commissionId",
     *         in="body",
     *         description="commission id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="commission",
     *         in="body",
     *         description="Hoa hồng",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    protected function updateAff($commissionId,$commission, Request $req) {
        $str = '';
        $commissid_percent = explode(',', $commission->commissid_percent);
        for ($i = 0; $i < count($commissid_percent); $i++) {
            $item = explode(':', $commissid_percent[$i]);
            if ((int) $item[0] != $commissionId) {
                $str .= $commissid_percent[$i] . ',';
            }
        }

        $string = $str . $commissionId . ':' . $req->commission;

        $commission->commissid_percent = $string;
        $commission->save();
        return $commission;
    }
    
    protected function createAff($userId, $commissionId,Request $req) {
        $dataAd = array(
            'commissid_percent' => $commissionId . ':' . $req->commission,
            'note' => strtotime(date('Y/m/d', time())) . ' commission'
        );
        $comission = new CommisionUserAff($dataAd);
        $comission->aff_id = $userId;
        $comission->save();
        return $comission;
    }

    public function updateorCreateAff($id, Request $req) {
          $validator = Validator::make($req->all(), [
                'commissionId' => 'required',
                'commission' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $commissionId = $req->commissionId;
        $hasConmmision = CommissionStore::where(['sho_user'=>$req->user()->use_id,'id'=>$commissionId])->count();
        if($hasConmmision == 0){
            return response([
                'msg' => Lang::get('response.commision_not_found'),
                ], 404);
        }
        $condb = (new CommissionStore)->getTable();
        $conaffdb = (new CommisionUserAff)->getTable();
        //$query = CommissionStore::where(['sho_user' => $req->user()->use_id])->join($conaffdb, $conaffdb . '.commiss_id', $condb . '.id');
      //  $query->select($conaffdb . '.commissid_percent');
        $commission = CommisionUserAff::where([$conaffdb . '.aff_id' => $id])->first();
//        dump($commission);die;  
        if (empty($commission)) {
            $result = $this->createAff($id, $commissionId, $req);
            return response(['msg' => Lang::get('response.success'), 'data' => $result], 200);
        }
        
        $result = $this->updateAff($commissionId, $commission, $req);
        return response(['msg' => Lang::get('response.success'), 'data' => $result], 200);
    }


    /**
     * @SWG\Get(
     *     path="/api/v1/commissions/types",
     *     operationId="commissions-id",
     *     description="Loại thu nhập",
     *     produces={"application/json"},
     *     tags={"Commission"},
     *     summary="Loại thu nhập",
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    public function commissionTypes(Request $req) {
        return response([
            'msg' => Lang::get('response.success'), 
            'data' => $req->user()->getCommissionType()
        ], 200);
    }

}
