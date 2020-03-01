<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use App\Models\Contact;
use App\Helpers\Commons;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Lang;
use App\Models\User;

/**
 * Description of ContactController
 *
 * @author hoanvu
 */
class ContactController extends ApiController {
     /**
     * @SWG\Post(
     *     path="/api/v1/contacts",
     *     operationId="contacts",
     *     description="Gửi tin nhắn",
     *     produces={"application/json"},
     *     tags={"Contact"},
     *  @SWG\Parameter(
     *         name="con_title",
     *         in="body",
     *         description="Tiêu đề",
     *         required=true,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="con_detail",
     *         in="body",
     *         description="Nội dung",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="con_user_recieve",
     *         in="body",
     *         description="Gửi cho thành viên hay ban quản trị , 1: thành viên , 0: quản trị",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="user_name_recive",
     *         in="body",
     *         description="User name người muốn gửi nếu con_user_recieve =1",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="con_position",
     *         in="body",
     *         description="Vị trí của ban quản trị 1: kinh doanh , 2 : kĩ thuật",
     *         enum={1,2},
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public contact"
     *     )
     * )
     */
    public function send(Request $req){
        $input = $req->all();
        $validatorAttr = [
                'con_title' => 'required',
                'con_detail' => 'required|min:10|max:1000',
                'con_user_recieve' => 'required'
        ];
        if($req->con_user_recieve == 0){
            $validatorAttr['con_position'] = 'required';
        }else{
            $validatorAttr['user_name_recive'] = 'required';
        }
        $validator = Validator::make($input, $validatorAttr);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $helper = new Commons();
      
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $txtContent = '[fieldset][legend][i][red]' . $req->user()->use_username . '[/red][/i][/legend]' . $req->con_detail . '[/fieldset]';
        $dataAdd = [
            'con_title' => trim($helper->injection_html($req->con_title)),
            'con_detail' => $txtContent,
            'con_date_contact' => $currentDate,
            'con_date_reply' => 0,
            'con_view' => 0,
            'con_reply' => 0,
            'con_status' => 1,
            'con_out_usend' => 1
            
        ];
        $contact = new Contact($dataAdd);
        $contact->con_user_recieve = 0;
        if ($req->con_user_recieve == 1) {
            $userRecive = User::where(['use_username' => $req->user_name_recive])->first();
            if (empty($userRecive)) {
                return response([
                    'msg' => Lang::get('response.user_not_found')
                    ], 404);
            }
            $contact->con_in_urecei = 1;
            $contact->con_user_recieve = $userRecive->use_id;
        }else{
            $contact->con_position =$req->con_position;
        }
       
        try {
            $contact->con_user = $req->user()->use_id;
            $contact->save();

            return response([
                'msg' => Lang::get('response.success'),
                'data' => $contact
            ]);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        } 
    }
    
      /**
     * @SWG\Put(
     *     path="/api/v1/contacts/{id}/reply",
     *     operationId="contactsReply",
     *     description="Gửi tin nhắn trả lời",
     *     produces={"application/json"},
     *     tags={"Contact"},
     *    @SWG\Parameter(
     *         name="con_detail",
     *         in="body",
     *         description="Nội dung",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public contact"
     *     )
     * )
     */
    public function reply($id,Request $req){
         $validatorAttr = [
                'con_detail' => 'required|min:10|max:1000',

        ];
        $validator = Validator::make($req->all(), $validatorAttr);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $currentDate = date('H:m:i, d-m-Y');

        $username_login = $req->user()->use_username;
        $query = Contact::where(['con_status' => 1, 'con_id' => $id]);
        $query->where(function($q) use ($req) {
            $q->orWhere(['con_user' => $req->user()->use_id]);
            $q->orWhere(['con_user_recieve' => $req->user()->use_id]);
        });
        $detail = $query->first();
        if (empty($detail)) {
            return response([
                'msg' => Lang::get('response.contact_not_found'),
                ], 404);
        }

        $txtContent = $detail->con_detail . '[fieldset][legend]' . $username_login . '[/legend][i]' . $currentDate . '[/i]' . $req->con_detail . '[/fieldset]';
        $detail->con_detail = $txtContent;
        if ($req->user()->id == $detail->con_user) {

            $detail->con_out_usend = 1;
            $detail->con_in_urecei = $detail->con_in_urecei + 1;
        }
        if ($req->user()->id == $detail->con_user_recieve) {
            $detail->con_reply = 1;
            $detail->con_out_urecei = 1;
            $detail->con_in_usend = $detail->con_in_usend + 1;
        }
        $detail->save();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $detail
        ]);
    }
    /**
     * @SWG\Get(
     *     path="/api/v1/contacts",
     *     operationId="contacts",
     *     description="Danh sách tin nhắn",
     *     produces={"application/json"},
     *     tags={"Contact"},
     *     summary="danh sách tin nhắn outbox/inbox",
     *     @SWG\Parameter(
     *         name="filterBy",
     *         in="query",
     *         description="filterBy: inbox, outbox",
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
     *         name="keywords",
     *         in="query",
     *         description="keywords",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="orderBy",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public"
     *     )
     * )
     */
    public function index(Request $req) {
        $query = null;
        if ($req->filterBy == 'inbox') {
            $query = $this->inbox($req);
        } else {
            $query = $this->outbox($req);
        }
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        if (!empty($req->orderBy)) {
            $req->orderBy = explode(',', $req->orderBy);
            $key = $req->orderBy[0];
            $value = $req->orderBy[1] ? $req->orderBy[1] : 'DESC';
            $query->orderBy($key, $value);
        }
        if($req->keywords){
            $query->where('con_title', 'LIKE', '%' . $req->keywords . '%');
        }
        $query->with('userRecieve');
        $query->with('userSended');
        $results = $query->paginate($limit, ['*'], 'page', $page);
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }

    protected function outbox(Request $req) {

        $query = Contact::where(['con_status' => 1]);
        $query->where(function($q) use($req) {
            $q->where(['con_user' => $req->user()->use_id]);
            $q->orWhere(['con_user_recieve' => $req->user()->use_id, 'con_reply' => 1]);
        });
        return $query;
    }
 
    protected function inbox(Request $req) {
        $query = Contact::where(['con_status' => 1]);
        $query->where(function($q) use($req) {
            $q->where(['con_user_recieve' => $req->user()->use_id]);
            $q->orWhere(['con_user' => $req->user()->use_id, 'con_reply' => 1]);
        });
        return $query;
    }
    /**
     * @SWG\Get(
     *     path="/api/v1/contacts/{id}/detail",
     *     operationId="contacts",
     *     description="Xem chi tiet  tin nhắn",
     *     produces={"application/json"},
     *     tags={"Contact"},
     *     summary="Xem chi tiet  tin nhắn",
     *     @SWG\Response(
     *         response=200,
     *         description="public"
     *     )
     * )
     */
    public function detail($id, Request $req) {

        $query = Contact::where(['con_status' => 1, 'con_id' => $id]);
        $query->where(function($q) use ($req) {
            $q->orWhere(['con_user' => $req->user()->use_id]);
            $q->orWhere(['con_user_recieve' => $req->user()->use_id]);
        });
        $query->with('userRecieve');
        $detail = $query->first();
        if (empty($detail)) {
            return response([
                'msg' => Lang::get('response.contact_not_found'),
                ], 404);
        }
        $detail->con_view = 1;
        
        $detail->save();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $detail
        ]);
    }

}
