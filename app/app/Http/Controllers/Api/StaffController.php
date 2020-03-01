<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\Task;
use Lang;
use App\Helpers\Commons;
use App\Helpers\Hash;
use App\Models\Contact;
use DB;
use App\Models\TaskComment;
class StaffController extends ApiController {

	  /**
     * @SWG\Post(
     *     path="/api/v1/staffs",
     *     operationId="register",
     *     description="Tạo nhân viên",
     *     tags={"Staff"},
     *     summary="Tạo nhân viên cho shop",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="use_username",
     *         in="body",
     *         description="User usernamer",
     *         required=true,
     *         type="string",
     *         @SWG\Schema(ref="#/definitions/Authenticated"),
     *     ),
    *      @SWG\Parameter(
     *         name="use_fullname",
     *         in="body",
     *         description="User usernamer",
     *         required=true,
     *         type="string",
     *         @SWG\Schema(ref="#/definitions/Authenticated"),
     *     ),
     *     @SWG\Parameter(
     *         name="use_password",
     *         in="body",
     *         description="use_password",
     *         required=true,
     *         type="string",
     *         @SWG\Schema(ref="#/definitions/Authenticated"),
     *     ),
     *     @SWG\Parameter(
     *         name="re_use_password",
     *         in="body",
     *         description="re_use_password",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="use_email",
     *         in="body",
     *         description="email",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="use_mobile",
     *         in="body",
     *         description="dien thoai",
     *         required=true,
     *         type="string",
     *     ),
     *      @SWG\Parameter(
     *         name="use_address",
     *         in="body",
     *         description="dia chi",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="use_message",
     *         in="body",
     *         description="Đường dẫn chat facebook or social",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="use_province",
     *         in="body",
     *         description="use_province",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="use_district",
     *         in="body",
     *         description="use_district",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="tax_type",
     *         in="body",
     *         description="Loại thuế  : 1 -  Mã số thuế doanh nghiệp  , 0 - Mã số thuế cá nhân",
     *         required=true,
     *         type="integer",
     *     ),
	*     @SWG\Parameter(
     *         name="id_card",
     *         in="body",
     *         description="CMND",
     *         required=true,
     *         type="integer",
     *     ),
     * 	   @SWG\Parameter(
     *         name="addbranch",
     *         in="body",
     *         description="Tạo brranch thì truyền 1",
     *         required=false,
     *         type="integer",
     *     ),
     * 	   @SWG\Parameter(
     *         name="openCN",
     *         in="body",
     *         description="Nếu nhân viên này là tài khoản mở chi nhánh tích gán =1 không thì không truyền lên",
     *         required=false,
     *         type="integer",
     *     ),
	*     @SWG\Parameter(
     *         name="tax_code",
     *         in="body",
     *         description="Ma thue",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="success",
     *         @SWG\Schema(ref="#/definitions/Authenticated/logout")
     *     )
     * )
     */
    public function index(Request $req) {
        $validator = Validator::make($req->all(), [
                'use_username' => 'required|without_spaces|string|min:6|unique:tbtt_user',
                'use_password' => 'required',
             //   'use_fullname'=>'required',
                're_use_password' => 'required|same:use_password',
                'use_email' => 'required|email|unique:tbtt_user',
                'id_card' => 'required',
                'use_address' => 'required',
                'tax_code' => 'required',
                'use_mobile' => 'required',
                'use_province' => 'required',
               // 'use_district' => 'required',
                'tax_type' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
     
        $helper = new Commons();
        $salt = User::randomSalt();

        $group = User::TYPE_StaffUser;
        if(isset($req->openCN) && $req->openCN == 1){
            $group = User::TYPE_StaffStoreUser;
        }
        if(isset($req->addbranch)){
            $group = User::TYPE_BranchUser;
        }
        $enddate = 0;
        $active = 1;

        $key = Hash::create($req->use_username, $req->use_email, 'sha256md5');
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $dataRegister = array(
            'use_username' => trim(strtolower($helper->injection_html($req->use_username))),
            'use_password' => User::hashPassword($req->use_password, $salt),
            'use_salt' => $salt,
            'use_email' => trim(strtolower($helper->injection_html($req->use_email))),
            'use_fullname' => trim($helper->injection_html($req->use_fullname)),
            'use_sex' => isset($req->use_sex) ? $req->use_sex : 0,
            'use_address' => trim($helper->injection_html($req->use_address)),
            'use_province' => $req->use_province,
            'user_district' => $req->use_district,
            'use_phone' => trim($helper->injection_html($req->use_phone)),
            'use_mobile' => trim($helper->injection_html($req->use_mobile)),
            'id_card' => trim($helper->injection_html($req->id_card)),
            'tax_code' => trim($helper->injection_html($req->tax_code)),
            'tax_type' => $req->tax_type,
            'use_message'=>trim($helper->injection_html($req->use_message)),
//            'bank_name' => trim($helper->injection_html($req->('namebank_regis'))),
//            'bank_add' => trim($helper->injection_html($req->('addbank_regis'))),
//            'account_name' => trim($helper->injection_html($req->('accountname_regis'))),
//            'num_account' => $req->('accountnum_regis'),
//            'style_id' => trim($helper->injection_html($req->('style_id'))),
//            'use_yahoo' => trim($helper->injection_html($req->('yahoo_regis'))),
//            'use_skype' => trim($helper->injection_html($req->('skype_regis'))),
            'use_group' => $group,
            'use_status' => $active,
            'use_regisdate' => $currentDate,
            'use_enddate' => $enddate,
            'use_key' => $key,
            'use_lastest_login' => $currentDate,
            'member_type' => 0,
            'active_code' => trim($req->active_code),
            'parent_id' => $req->user()->use_id
        );
        $user = new User($dataRegister);
        $user->save();
        return response(['msg' => Lang::get('response.success'), 'data' => $user], 200);
    }
    	/**
     * @SWG\Put(
     *     path="/api/v1/staffs/{id}/update",
     *     operationId="profile",
     *     description="profile",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="Thông tin",
     *  @SWG\Parameter(
     *         name="use_fullname",
     *         in="body",
     *         description="tên",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="use_province",
     *         in="body",
     *         description="Tĩnh",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="use_district",
     *         in="body",
     *         description="Quận",
     *         required=true,
     *         type="integer",
     *     ),
      *  @SWG\Parameter(
     *         name="use_address",
     *         in="body",
     *         description="Quận",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="use_message",
     *         in="body",
     *         description="Social link",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="use_phone",
     *         in="body",
     *         description="Số điện thoại",
     *         required=false,
     *         type="integer",
     *     ),
      *  @SWG\Parameter(
     *        name="avatar",
     *         in="body",
     *         description="Avatar nhân viên",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="use_email",
     *         in="body",
     *         description="Số điện thoại di động",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="use_mobile",
     *         in="body",
     *         description="Số điện thoại di động",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="avatar",
     *         in="body",
     *         description="Avatar",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="use_sex",
     *         in="body",
     *         description="Giới tính",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="use_birthday",
     *         in="body",
     *         description="Ngày sinh",
     *         required=true,
     *         type="timestamp",
     *     ),
     *  @SWG\Parameter(
     *         name="tax_type",
     *         in="body",
     *         description="Loại thuế  : 1 -  Mã số thuế doanh nghiệp  , 0 - Mã số thuế cá nhân",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="cập nhật profile"
     *     )
     * )
     */
    public function update($id, Request $req) {
        $user = User::where(['use_id' => $id, 'parent_id' => $req->user()->use_id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.user_not_found')
                ], 404);
        }
        $validatorFiled = [
            'use_fullname' => 'required|string',
            'use_address' => 'required|string',
            'use_province' => 'required',
            'use_district' => 'required',
            'use_birthday' => 'required',
            'tax_type'=>'required',
//            'use_password'=>'required',
//            're_use_password'=>'required',
            'use_mobile' => [
                'required',
                'regex:' . Commons::isPhone(),
            ],
            'use_phone' => [
                'regex:' . Commons::isPhone(),
            ],
        ];
        $input = $req->all();
        $validator = Validator::make($req->all(), $validatorFiled);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        foreach ($input as $key => $value) {
            if (!in_array($key, (new User)->allowUpdate($req->user()->use_group))) {
                unset($input[$key]);
            }
        }
        $user->user_district = $req->use_district;
        $user->fill($input);
        if(!empty($req->avatar)){
            $user->avatar = $req->avatar;
        }
        
//        $salt = User::randomSalt();
//        $user->use_password = User::hashPassword($req->use_password, $salt);
        $user->save();
        
  
        return response(['msg' => Lang::get('response.success'), 'data' => $user->publicProfile()], 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/staffs",
     *     operationId="staffs",
     *     description="Danh sách nhân viên",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="Danh sach nhân viên",
     *  @SWG\Parameter(
     *         name="countAff",
     *         in="query",
     *         description="Thống kê đại lý bán lẻ",
     *         required=false,
     *         type="integer",
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
     *     @SWG\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="orderBy",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="keywords",
     *         in="query",
     *         description="keywords",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="showAll",
     *         in="query",
     *         description="lấy luôn cả nhãn hàng ( User group = 11 )",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function listUser(Request $req) {
        return response([
            'msg' => Lang::get('response.success'), 
            'data' => $this->_listUser($req->user(), $req)
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/staffs",
     *     operationId="userStaffs",
     *     description="Danh sách nhân viên Bởi User",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="Danh sách nhân viên Bởi User",
     *  @SWG\Parameter(
     *         name="countAff",
     *         in="query",
     *         description="Thống kê đại lý bán lẻ",
     *         required=false,
     *         type="integer",
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
     *     @SWG\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="orderBy",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="keywords",
     *         in="query",
     *         description="keywords",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="showAll",
     *         in="query",
     *         description="lấy luôn cả nhãn hàng ( User group = 11 )",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function userListUser($id, Request $req) {
        $user = User::find($id);
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.user_not_found')
            ], 404);
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $this->_listUser($user, $req)
        ]);
    }

    public function _listUser($user, $req) {
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $group = [User::TYPE_StaffUser,User::TYPE_StaffStoreUser];
        if($req->showAll){
            $group[] = User::TYPE_BranchUser;
        }
        $query = User::where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $user->use_id])
            ->whereIn('use_group', $group);
        $query->withCount('affNumber')->withCount('branchNumber');
        if(!empty($req->keywords)){
             $query->where(function($q) use ($req) {
                $q->orWhereRaw('LOWER(use_fullname) like ?', array('%' . mb_strtolower($req->keywords) . '%'));
                $q->orWhereRaw('LOWER(use_username) like ?', array('%' . mb_strtolower($req->keywords) . '%'));
                $q->orWhereRaw('LOWER(use_fullname) like ?', array('%' . mb_strtolower($req->keywords) . '%'));
                $q->orWhereRaw('LOWER(use_mobile) like ?', array('%' . mb_strtolower($req->keywords) . '%'));
                $q->orWhereRaw('LOWER(use_phone) like ?', array('%' . mb_strtolower($req->keywords) . '%'));
            });
        }
        if (!empty($req->orderBy)) {
            $req->orderBy = explode(',', $req->orderBy);
            $key = $req->orderBy[0];
            $value = $req->orderBy[1] ? $req->orderBy[1] : 'DESC';
            $query->orderBy($key, $value);
        }else{
            $query->orderBy('use_regisdate','DESC');
        }
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        $data = [];
        foreach ($paginate->items() as $item) {
            $result = $item->publicProfile();
            $result['shop'] = $item->shop;
           // $result['branch_number_count'] = $item->branch_number_count;
            $result['aff_number_count'] = $item->aff_number_count;
            $result['staff_of_user'] = $item->getAllStaffOfUser();
            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;

        return $results;
    }

    /**
     * @SWG\Post(
     *     path="/api/v1/staffs/{id}/tasks",
     *     operationId="staffs",
     *     description="Phân công công việc cho nhân viên",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="Phân công công việc cho nhân viên",
     *  @SWG\Parameter(
     *         name="name",
     *         in="body",
     *         description="Tên công việc",
     *         required=true,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="detail",
     *         in="body",
     *         description="Nội dung",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="added_date",
     *         in="body",
     *         description="Ngày phân công - định dạng kiểu 1497373200",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="note",
     *         in="body",
     *         description="Ghi chú",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="status",
     *         in="body",
     *         description="Trạng thái",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="dir_image",
     *         in="body",
     *         description="Tên ngày upload file",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="image1",
     *         in="body",
     *         description="Hình một",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="image2",
     *         in="body",
     *         description="Hình hai",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="image3",
     *         in="body",
     *         description="Hình hai",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="file1",
     *         in="body",
     *         description="File pdf1 . Tương tự cho các params file2,file3",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    
    public function addTask($id,Request $req){
        $validator = Validator::make($req->all(), [
                'name' => 'required',
                'detail' => 'required|min:10|max:1000',
                'added_date' => 'required',
                'note' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $user = User::where(['use_id'=>$id,'parent_id'=>$req->user()->use_id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.user_not_found')
                ], 404);
        }
        $helper = new Commons();
        
        $title = trim($helper->injection_html($req->name));
//        if (Contact::where('con_title', $title)->count() > 0) {
//            return response([
//                'msg' => Lang::get('response.task_name_exist')
//                ], 422);
//        }
        $addedDate = strtotime(date('Y-m-d',$req->added_date));
        $dataAdd = [
            'name' => $title,
            'detail' => $req->detail,
            'note' => $req->note,
            'created_date' => time(),
            'updated_date' => 0,
            'added_date' => $addedDate,
            'asigned_user' => $id,
            'store_id' => $req->user()->use_id,
            'status' => $req->status? $req->status:0,
            'date_img' => isset($req->dir_image) ? $req->dir_image : '',
            'images1' => isset($req->image1) ? $req->image1 : '',
            'images2' => isset($req->image2) ? $req->image2 : '',
            'images3' => isset($req->image3) ? $req->image3 : '',
            'file1' => isset($req->file1) ? $req->file1 : '',
            'file2' => isset($req->file2) ? $req->file2 : '',
            'file3' => isset($req->file3) ? $req->file3 : '',
        ];
        $hasTask = Task::where([
                'added_date' => $req->added_date,
                'store_id' => $req->user()->use_id,
                'asigned_user' => $id
            ])->count();
        if ($hasTask > 0) {
            return response([
                'msg' => Lang::get('response.task_assgined')
                ], 404);
        }
        try{
            $task = new Task($dataAdd);
            $task->save();
            $task->puclicInfo();
            return response(['msg' => Lang::get('response.success'), 'data' => $task], 200);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
    }
         /**
     * @SWG\Put(
     *     path="/api/v1/staffs/{id staff}/tasks/{idtask}",
     *     operationId="staffs",
     *     description="Cập nhật lại công việc cho nhân viên",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="Cập nhật lại công việc cho nhân viên",
     *  @SWG\Parameter(
     *         name="name",
     *         in="body",
     *         description="Tên công việc",
     *         required=true,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="detail",
     *         in="body",
     *         description="Nội dung",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="note",
     *         in="body",
     *         description="Ghi chú",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="dir_image",
     *         in="body",
     *         description="Tên ngày upload file",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="image1",
     *         in="body",
     *         description="Hình một",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="image2",
     *         in="body",
     *         description="Hình hai",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="image3",
     *         in="body",
     *         description="Hình hai",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="file1",
     *         in="body",
     *         description="File pdf1 . Tương tự cho các params file2,file3",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public task"
     *     )
     * )
     */
    public function updateTask($staffId, $taskId, Request $req) {
         $input = $req->all();
         $validator = Validator::make($input, [
                'name' => 'required',
                'detail' => 'required|min:10|max:1000',
                'note' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
   
        $user = User::where(['use_id' => $staffId, 'parent_id' => $req->user()->use_id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.user_not_found')
                ], 404);
        }
        $task = Task::where(['id' => $taskId])->first();
        if (empty($task)) {
            return response([
                'msg' => Lang::get('response.task_not_found')
                ], 404);
        }
        unset($input['asgined_user']);
        unset($input['store_id']);
        unset($input['added_date']);
        $task->fill($input);
        $task->date_img = $input['dir_image'];

        try{
            $task->save();
            $task->puclicInfo();
            return response(['msg' => Lang::get('response.success'), 'data' => $task], 200);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
    }
    
            /**
     * @SWG\Put(
     *     path="/api/v1/staffs/{id staff}/tasks/{idtask}/update-status",
     *     operationId="staffs",
     *     description="Cập nhật lại công việc cho nhân viên",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="Cập nhật lại công việc cho nhân viên",
     *  @SWG\Parameter(
     *         name="status",
     *         in="body",
     *         description="Trạng thái , 0 : Chưa hoàn thành , 1: Cấp trên đang xem, 2: Hoàn thành",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public task"
     *     )
     * )
     */
    public function updateStatus($staffId, $taskId, Request $req) {
        $input = $req->all();
        $validator = Validator::make($input, [
                'status' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }

        $user = User::where(['use_id' => $staffId, 'parent_id' => $req->user()->use_id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.user_not_found')
                ], 404);
        }
        $task = Task::where(['id' => $taskId])->first();
        if (empty($task)) {
            return response([
                'msg' => Lang::get('response.task_not_found')
                ], 404);
        }

        $task->status = (int)$req->status;

        try {
            $task->save();
            return response(['msg' => Lang::get('response.success'), 'data' => $task], 200);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/staffs/{id}/tasks",
     *     operationId="staffs",
     *     description="Danh sách công việc trong khoảng thời gian 1 tháng ",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="Danh sách công việc trong khoảng thời gian",
     *  @SWG\Parameter(
     *         name="month",
     *         in="body",
     *         description="Tháng ( exmple:month=1)",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Danh sách task của nhân viên"
     *     )
     * )
     */
    public function listTask($id, Request $req) {
        $validator = Validator::make($req->all(), [
                'month' => 'min:1|max:12',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $from = strtotime('first day of this month');
        $to = strtotime('last day of this month');
        if (isset($req->month)) {
            $from = strtotime(date('Y-' . $req->month . '-1'));
            $to = strtotime(date('Y-' . $req->month . '-t 23:59:59'));
        }

        $user = User::where(['use_id' => $id, 'parent_id' => $req->user()->use_id]);
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.user_not_found')
                ], 404);
        }
        $query = Task::where(['asigned_user' => $id, 'store_id' => $req->user()->use_id]);
        $query->where('added_date', '>=', $from)->where('added_date','<=',$to);

        $tasks = $query->get();
        foreach ($tasks as $task) {
            $task->puclicInfo();
        }
        return response(['msg' => Lang::get('response.success'), 'data' => $tasks], 200);
    }
    
     /**
     * @SWG\Get(
     *     path="/api/v1/tasks/{id}",
     *     operationId="staffs",
     *     description="Chi tiết task ",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="Chi tiết task",
     *     @SWG\Response(
     *         response=200,
     *         description="Chi tiết task"
     *     )
     * )
     */
     public function detailTask($id, Request $req) {
        $query = Task::where(['id' => $id]);
        $task = $query->where(function($q) use ($req){
           $q->where('store_id',$req->user()->use_id);
           $q->orWhere('asigned_user',$req->user()->use_id);
        })->first();
        
        if (empty($task)) {
            return response([
                'msg' => Lang::get('response.task_not_found')
                ], 404);
        }
        $task->puclicInfo();
        $results  = $task->toArray();
        $results['user'] = $task->user->publicProfile();
        
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }
        /**
     * @SWG\Get(
     *     path="/api/v1/me/tasks",
     *     operationId="staffs",
     *     description="Danh sách công việc trong khoảng thời gian 1 tháng ",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="Danh sách công việc trong khoảng thời gian",
     *  @SWG\Parameter(
     *         name="month",
     *         in="body",
     *         description="Tháng ( exmple:month=1)",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Danh sách task của"
     *     )
     * )
     */

    
    
    public function mytask(Request $req) {

        $validator = Validator::make($req->all(), [
                'month' => 'min:1|max:12',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $d = strtotime('first day of this month');

        if (isset($req->month)) {
            $d = strtotime(date('Y-' . $req->month . '-1'));
        }
        if(isset($req->day)){
            $d = $req->day;
        }
        $query = Task::where(['asigned_user' => $req->user()->use_id]);
        $tasks = $query->where('added_date', '>=', $d)->get();
        return response(['msg' => Lang::get('response.success'), 'data' => $tasks], 200);
    }
    
          /**
     * @SWG\Get(
     *     path="/api/v1/me/tree-tasks",
     *     operationId="staffs",
     *     description="Nhân viên - Phân công từ gian hàng ",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="[Nhân viên] Phân công từ gian hàng",
     *  @SWG\Parameter(
     *     name="day",
     *         in="body",
     *         description="Ngày từ 1-31",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="1 task"
     *     )
     * )
     */
    public function treeTasks(Request $req) {
        $validator = Validator::make($req->all(), [
                'day' => 'min:1|max:31',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        
        $d =  mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        if ($req->day) {
            $d = mktime(0, 0, 0, date('m'), $req->day, date('Y'));
        
        }
        
        $query = Task::where(['asigned_user' => $req->user()->use_id]);
        if($req->test){
            $task = $query->first();
        }else{
            $task = $query->where('created_date', '=', $d)->first();
        }
        return response(['msg' => Lang::get('response.success'), 'data' => $task], 200);
    }

//    public function countAff(Request $req){
//        $query = User::where([
//            'parent_id'=>$req->user()->use_id,
//            'use_status'=>User::STATUS_ACTIVE,
//            'use_group'=>User::TYPE_StaffUser])->withCount('affNumber');
//       // $query->select('use_id, use_username, use_fullname, use_email, use_mobile',DB::raw('(SELECT COUNT(*) FROM tbtt_user u1 WHERE u1.parent_id = u.use_id and u1.use_status = '.User::STATUS_ACTIVE.' and u1.use_group = '.User::TYPE_AffiliateUser.' ) as sl'));
//
//        $limit = $req->limit ? (int) $req->limit : 10;
//        $page = $req->page ? (int) $req->page : 0;
//
//        if (!empty($req->orderBy)) {
//            $req->orderBy = explode(',', $req->orderBy);
//            $key = $req->orderBy[0];
//            $value = $req->orderBy[1] ? $req->orderBy[1] : 'DESC';
//            $query->orderBy($key, $value);
//        }
//
//        $results = $query->paginate($limit, ['*'], 'page', $page);
//        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
//    }
    
    
           /**
     * @SWG\Get(
     *     path="/api/v1/staffs/{id}/commissions   ",
     *     operationId="commissions-id",
     *     description="Chi tiết commision của nhân viên",
     *     produces={"application/json"},
     *     tags={"Staff"},
     *     summary="Chi tiết commision của nhân viên",
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    function commission($id, Request $req) {
//        $user = User::where(['use_id' => $id, 'parent_id' => $req->user()->use_id])->first();
//        if (empty($user)) {
//            return response([
//                'msg' => Lang::get('response.user_not_found')
//                ], 404);
//        }
        $result = CommisionUserAff::where('aff_id', $id)->fitst();

        return response(['msg' => Lang::get('response.success'), 'data' => $result], 200);
    }
           /**
     * @SWG\Post(
     *     path="/api/v1/staffs/{id staff}/tasks/{idtask}/comment",
     *     operationId="commissions-id",
     *     description="Comment 1 task",
     *     produces={"application/json"},
     *     tags={"Staff-Task"},
     *     summary="Comment 1 task",
     *  @SWG\Parameter(
     *         name="comment",
     *         in="body",
     *         description="comment",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    

    function commentTask($staffId, $taskId, Request $req) {
        $input = $req->all();
        $validator = Validator::make($input, [
                'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }

        $user = User::where(['use_id' => $staffId, 'parent_id' => $req->user()->use_id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.user_not_found')
                ], 404);
        }
        $task = Task::where(['id' => $taskId])->first();
        if (empty($task)) {
            return response([
                'msg' => Lang::get('response.task_not_found')
                ], 404);
        }
        $comment = new TaskComment([
            'comment' => $req->comment,
            'created_date' => time()
        ]);
        $comment->id_user = $req->user()->use_id;
        $comment->task_id = $taskId;
        $comment->save();
        return response(['msg' => Lang::get('response.success'), 'data' => $comment], 200);
    }
    
    
     /**
     * @SWG\Get(
     *     path="/api/v1/staffs/{id staff}/tasks/{idtask}/comments",
     *     operationId="commissions-id",
     *     description="Danh sách comment của task",
     *     produces={"application/json"},
     *     tags={"Staff-Task"},
     *     summary="Danh sách comment của task",
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    function listCommentTaskUser($staffId,$taskId, Request $req) {
        $user = User::where(['use_id' => $staffId, 'parent_id' => $req->user()->use_id])->first();
        if (empty($user)) {
            return response([
                'msg' => Lang::get('response.user_not_found')
                ], 404);
        }
        $task = Task::where(['id' => $taskId])->first();
        if (empty($task)) {
            return response([
                'msg' => Lang::get('response.task_not_found')
                ], 404);
        }
        return $this->listCommentTask($taskId, $req);
    }
    
        /**
     * @SWG\Get(
     *     path="/me/tasks/{taskId}/comments",
     *     operationId="comment",
     *     description="[Nhân viên]Danh sách comment 1 task của tôi",
     *     produces={"application/json"},
     *     tags={"Staff-Task"},
     *     summary="Danh sách comment  1 task của tôi",
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    function myListCommentTask($taskId, Request $req) {

        $task = Task::where(['id' => $taskId, 'asigned_user' => $req->user()->use_id])->first();
        if (empty($task)) {
            return response([
                'msg' => Lang::get('response.task_not_found')
                ], 404);
        }
        return $this->listCommentTask($taskId, $req);
    }

    protected function listCommentTask($taskId,Request $req) {
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $query = TaskComment::where(['task_id' => $taskId])->orderBy('created_date', 'ASC');
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        $data = [];
        foreach ($paginate->items() as $item) {
            $result = $item;
            $result['user'] = $item->user->publicProfile();

            $data[] = $result;
        }
        $results = $paginate->toArray();
        $results['data'] = $data;
        return response(['msg' => Lang::get('response.success'), 'data' => $results], 200);
    }
     /**
     * @SWG\Post(
     *     path="/api/v1/me/tasks/{taskId}/comment",
     *     operationId="commissions-id",
     *     description="Nhân viên bình luận task",
     *     produces={"application/json"},
     *     tags={"Staff-Task"},
     *     summary="Nhân viên bình luận task",
     *     @SWG\Response(
     *         response=200,
     *         description="result"
     *     )
     * )
     */
    function staffCommentTask($taskId,Request $req){
         $input = $req->all();
        $validator = Validator::make($input, [
                'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        
   
        $task = Task::where(['id' => $taskId,'asigned_user'=>$req->user()->use_id])->first();
        if (empty($task)) {
            return response([
                'msg' => Lang::get('response.task_not_found')
                ], 404);
        }
        $comment = new TaskComment([
            'comment' => $req->comment,
            'created_date' => time()
        ]);
        $comment->id_user = $req->user()->use_id;
        $comment->task_id = $taskId;
        $comment->save();
        return response(['msg' => Lang::get('response.success'), 'data' => $comment], 200);
    }

}