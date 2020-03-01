<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\PackageUser;
use App\Models\PackageService;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Lang;
/**
 * Description of ToolMarketingController
 *
 * @author hoanvu
 */
class ToolMarketingController extends ApiController {
    
    
    /**
     * @SWG\Get(
     *     path="/api/v1/me/check-access-email-marketing",
     *     operationId="check-allow-access-email-marketing",
     *     description="Kiểm tra có được quyền truy cập -email-marketing sau khi kiểm tra thành công gọi api /me/wallet",
     *     produces={"application/json"},
     *     tags={"ToolMarketing"},
     *     summary="Thông tin",
     *     @SWG\Response(
     *         response=200,
     *         description="Kiểm tra có được quyền truy cập -email-marketing"
     *     )
     * )
     */
    public function checkEmailMarketing(Request $req) {
        $user = $req->user();
        $pack = PackageUser::getCurrentPackage($user->use_id)->first();

        if ($user->use_group == User::TYPE_BranchUser) {
            $parent = $user->parentActiveInfo;
            if ($user) {
                $pack = PackageUser::getCurrentPackage($user->parent_id)->first();
                if ($parent->use_group == User::TYPE_StaffUser) {
                    $user_parent = $parent->parentActiveInfo;
                    if (!empty($user_parent)) {
                        $pack = PackageUser::getCurrentPackage($user_parent->parent_id)->first();
                    }
                }
            }
        }
        if (empty($pack)) {
            return response(['msg' => 'error'], 402);
        }
        $service = PackageService::where(['package_id' => $pack->id])
                ->join('tbtt_service', 'tbtt_service.id', 'tbtt_package_service.service_id')->get();

        $group = [];
        foreach ($service as $item) {
            if ($item['id'] == 5) {
                $group[] = $item['id'];
            }
        }
        if (empty($group)) {
            return response(['msg' => 'error'], 402);
        }
        return response(['msg' => 'success', 'data' => ['result' => true]], 200);
    }
    
    /**
     * @SWG\Get(
     *     path="/api/v1/me/landing-page",
     *     operationId="landing-page",
     *     description="",
     *     produces={"application/json"},
     *     tags={"ToolMarketing"},
     *     summary="Thông tin",
     *     @SWG\Response(
     *         response=200,
     *         description="lading page của người dùng"
     *     )
     * )
     */
    
    public function landingPage(Request $req) {
        $user = $req->user();
        $ids = [$user->use_id];
        if ($user && in_array($user->use_group, [User::TYPE_AffiliateUser, User::TYPE_BranchUser])) {
            $ids[] = $user->parent_id;
        }
        $query = LandingPage::whereIn('user_id', $ids);
        $query->select('id', 'name', 'user_id', 'template_id', 'list_id', 'list_name', 'created_date', 'status');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $data = [];
        $user = $req->user();
        if ($user->use_id == 3996) {
            $data = [
                [
                    "id" => 0,
                    "name" => "Tuyển dụng CTV Karamat",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 3996,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://appbanhang.net/tuyen-dung-ctv-karamat/"
                ],
                [
                    "id" => 0,
                    "name" => "Bộ sưu tập nội thất 2016",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 3996,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://appbanhang.net/decor/"
                ], [
                    "id" => 0,
                    "name" => "Thời trang cao cấp",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 3996,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://appbanhang.net/fashion/"
                ], [
                    "id" => 0,
                    "name" => "Giải pháp thương mại AZIBAI",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 3996,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://appbanhang.net/giai-phap-cho-doanh-nghiep/"
                ],
                [
                    "id" => 0,
                    "name" => "Hợp tác doanh nghiệp Hàn Quốc",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 3996,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://appbanhang.net/partner/"
                ]
            ];
        }
        
         if ($user->use_id == 4734) {
            $data = [
                [
                    "id" => 0,
                    "name" => "HOVENIA",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 4734,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://vinacacao.azibai.com/demo-vinacacao/"
                ]
            ];
        }
        if ($user->use_id == 4356) {
            $data = [
                [
                    "id" => 0,
                    "name" => "Azibai Presentation",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 4356,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://socials.azibai.com/azibai-presentation/"
                ]
            ];
        }
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        
        foreach($paginate->items() as $item){
            $item->url();
            $data[] = $item;
        }
        
        $landings = $paginate->toArray();
        $landings['data'] = $data;
        if ($req->user()->use_id == 3996) {
            $landings['total'] = $landings['total'] + 5;
            if ($landings['current_page'] === 1) {
                $landings['to'] = $landings['to'] + 5;
            }
        }
        if($user->use_id == 4356 || $user->use_id = 4734 ){
            if(empty($landings['from'])){
                $landings['from'] = 1;
            }
            $landings['total'] = $landings['total'] + 1;
            if ($landings['current_page'] === 1) {
                $landings['to'] = $landings['to'] + 1;
            }
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $landings
        ]);
    }
    
        /**
     * @SWG\Get(
     *     path="/api/v1/user/{id}/landing-page",
     *     operationId="landing-page",
     *     description="",
     *     produces={"application/json"},
     *     tags={"ToolMarketing"},
     *     summary="Thông tin",
     *     @SWG\Response(
     *         response=200,
     *         description="lading page của người dùng"
     *     )
     * )
     */
    
       public function userLandingPage($id,Request $req) {
        $user = User::find($id);
        $ids = [$id];
        if ($user && in_array($user->use_group, [User::TYPE_AffiliateUser, User::TYPE_BranchUser])) {
            $ids[] = $user->parent_id;
        }
        $query = LandingPage::whereIn('user_id', $ids);
        $query->select('id', 'name', 'user_id', 'template_id', 'list_id', 'list_name', 'created_date', 'status');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
        $data = [];
        if ($id == 3996) {
            $data = [
                [
                    "id" => 0,
                    "name" => "Tuyển dụng CTV Karamat",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 3996,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://appbanhang.net/tuyen-dung-ctv-karamat/"
                ],
                [
                    "id" => 0,
                    "name" => "Bộ sưu tập nội thất 2016",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 3996,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://appbanhang.net/decor/"
                ], [
                    "id" => 0,
                    "name" => "Thời trang cao cấp",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 3996,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://appbanhang.net/fashion/"
                ], [
                    "id" => 0,
                    "name" => "Giải pháp thương mại AZIBAI",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 3996,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://appbanhang.net/giai-phap-cho-doanh-nghiep/"
                ],
                [
                    "id" => 0,
                    "name" => "Hợp tác doanh nghiệp Hàn Quốc",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 3996,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://appbanhang.net/partner/"
                ]
            ];
        }
        if ($id == 4734) {
            $data = [
                [
                    "id" => 0,
                    "name" => "HOVENIA",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 4734,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://vinacacao.azibai.com/demo-vinacacao/"
                ]
            ];
        }
        if ($id == 4356) {
            $data = [
                [
                    "id" => 0,
                    "name" => "Azibai Presentation",
                    "template_id" => 5,
                    "content" => "",
                    "html" => "",
                    "user_id" => 4356,
                    "list_id" => "",
                    "list_name" => "",
                    "created_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "url" => "http://socials.azibai.com/azibai-presentation/"
                ]
            ];
        }
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        
        foreach($paginate->items() as $item){
            $item->url();
            $data[] = $item;
        }
        
        $landings = $paginate->toArray();
        $landings['data'] = $data;
        if ($id == 3996) {
            $landings['total'] = $landings['total'] + 5;
            if ($landings['current_page'] === 1) {
                $landings['to'] = $landings['to'] + 5;
            }
        }
        if ($id == 4356 || $id = 4734) {
            if(empty($landings['from'])){
                $landings['from'] = 1;
            }
            $landings['total'] = $landings['total'] + 1;
            if ($landings['current_page'] === 1) {
                $landings['to'] = $landings['to'] + 1;
            }
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $landings
        ]);
    }
    /**
     * @SWG\Delete(
     *     path="/api/v1/me/landing-page/{id}",
     *     operationId="landing-page-delete",
     *     description="",
     *     produces={"application/json"},
     *     tags={"ToolMarketing"},
     *     summary="Delete landing page",
     *     @SWG\Response(
     *         response=200,
     *         description="Delete lading page"
     *     )
     * )
     */
    public function deleteLandingPage($id, Request $req) {
        $query = LandingPage::where(['user_id' => $req->user()->use_id, 'id' => $id]);
        $query->select('id', 'name', 'user_id', 'template_id', 'list_id', 'list_name', 'created_date', 'status');
        $landing = $query->first();
        if (empty($landing)) {
            return response([
                'msg' => Lang::get('response.landing_not_found'),
                ], 404);
        }
        $landing->delete();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $landing
        ]);
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/me/landing-page/{id}/status",
     *     operationId="landing-page-status",
     *     description="Thay đổi trạng thái landing page",
     *     produces={"application/json"},
     *     tags={"ToolMarketing"},
     *     summary="Thay đổi trạng thái landing page",
     *  @SWG\Parameter(
     *         name="status",
     *         in="query",
     *         description="status = 1 là active , 0 là ngược lại",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Thay đổi trạng thái landing page"
     *     )
     * )
     */
     public function changeStatusLanding(Request $req) {
        $query = LandingPage::where(['user_id' => $req->user()->use_id]);
        $query->select('id', 'name', 'user_id', 'template_id', 'list_id', 'list_name', 'created_date', 'status');
        $landing = $query->first();
        if (empty($landing)) {
            return response([
                'msg' => Lang::get('response.landing_not_found'),
                ], 404);
        }
        $landing->status = $req->status;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $landing
        ]);
    }
    
     /**
     * @SWG\Get(
     *     path="/api/v1/me/landing-share",
     *     operationId="landing-share",
     *     description="Danh sách tời rơi điện tử của nhân viên",
     *     produces={"application/json"},
     *     tags={"ToolMarketing"},
     *     summary="Danh sách tời rơi điện tử của nhân viên",
     *  @SWG\Parameter(
     *         name="keywords",
     *         in="query",
     *         description="keywords",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="list landing page"
     *     )
     * )
     */
     function listShare(Request $req) {
        $user = $req->user();
        $parent = $user->parentInfo;
        if (!empty($parent)) {
            $parent2 = $parent->parentInfo;
            if (!empty($parent2)) {
                $parent3 = $parent2->parentInfo;
            }
        }

        $use_landding = [];
        switch ($user->use_group) {
            case User::TYPE_AffiliateStoreUser:
                $use_landding[] = $user->use_id;
                break;
            case User::TYPE_StaffStoreUser:
                $use_landding[] = $user->parent_id;
                break;
            case User::TYPE_BranchUser:
                if (!empty($parent)) {
                    $use_landding[] = $parent->use_id;
                    if (!empty($parent2)) {
                        $use_landding[] = $parent2->use_id;
                    }
                }
                $use_landding[] = $user->use_id;
                break;
            case User::TYPE_StaffUser:
                $use_landding[] = $user->parent_id;

                if (!empty($parent)) {
                    $use_landding[] = $parent->parent_id;
                    if (!empty($parent2)) {
                        $use_landding[] = $parent2->parent_id;
                    }
                }

                break;
            case User::TYPE_AffiliateUser:
                $use_landding[] = $user->parent_id;
                if (!empty($parent)) {
                    $use_landding[] = $parent->parent_id;
                    if (!empty($parent2)) {
                        $use_landding[] = $parent2->parent_id;
                        if (!empty($parent3)) {
                            $use_landding[] = $parent3->parent_id;
                        }
                    }
                }

                break;
        }

        $query = LandingPage::where([])->orderBy('id', 'DESC');
        
        if (empty($req->test)) {

            $query->whereIn('user_id', $use_landding);
        }
        $query->where('status', 1);

        if ($req->keywords) {
            $query->where('name', 'LIKE', '%' . $req->keywords . '%');
        }
        $query->select('id', 'name', 'user_id', 'template_id', 'list_id', 'list_name', 'created_date', 'status');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;
       
        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        $data = [];
        foreach ($paginate->items() as $item) {
            $item->url();
            $data[] = $item;
        }

        $landings = $paginate->toArray();
        $landings['data'] = $data;

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $landings
        ]);
    }

    //put your code here
}
