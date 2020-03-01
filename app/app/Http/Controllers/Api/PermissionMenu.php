<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Category;
use Lang;
use App\Helpers\Commons;
use App\Models\User;
use App\Models\Manufacture;
use App\Models\Shop;
use App\Models\DetailProduct;
use DB;
use App\Models\BranchConfig;
use App\Models\ProductPromotion;
use App\Models\PackageDailyUser;
use App\Models\Package;
use App\Models\PackageUser;
use App\Models\PackageDaily;
use App\Models\PackageInfo;
use App\Models\PackageService;
use App\Models\ServiceGroup;
use App\Models\PackageUserService;
use App\Models\Service;
use App\Models\PackageDailyPrice;
use App\Models\Wallet;
use App\Models\PackageDailyContent;
use App\Models\Permission;
use App\Models\Content;

/**
 * @SWG\Get(
 *     path="/api/v1/me/permission/menu-create-staff",
 *     operationId="allow-see-menu-create-staff",
 *     description="Gói package cũa user Branch StaffStoreUser StaffUser được quyền tạo thành viên hay không",
 *     produces={"application/json"},
 *     tags={"Permission"},
 *     summary="Kiểu trả được quyền tạo thành viên hay không",
 *     @SWG\Response(
 *         response=200,
 *         description="trả về allow : false - Ko cho phép"
 *     )
 * )
 */
class PermissionMenu extends ApiController {
    function createStaff(Request $req) {
        $user = $req->user();
        $allow = ['allow'=>false];

        if ($user->use_group != User::TYPE_BranchUser) {
            
            if ($user->use_group == User::TYPE_StaffStoreUser || $user->use_group == User::TYPE_StaffUser) {
                $sho_user = $user->parent_id;
            } else {
                $sho_user = $user->use_id;
            }
      
            $shop = Shop::where('sho_user', $sho_user)->first();

            $allow['shop'] = $shop;
//            if (empty($shop)) {
//                return response([
//                    'msg' => Lang::get('response.success'),
//                    'data' => $allow
//                ]);
//            }
           
            $currentPackage = PackageUser::getCurrentPackage($sho_user)->first();
         
           
            if (!empty($currentPackage) && $currentPackage->id >= 4) {
                $allow = ['allow' => true];
                $allow['package'] = $currentPackage;
            }
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $allow
            ]);
        } else {
            $parent = $user->parentActiveInfo;
            $package = PackageUser::getCurrentPackage($user->parent_id)->first();
            if (!empty($package) && $package->id >= 4) {
                $allow = ['allow' => true,
                    'package' => $package];
            }
            if (!empty($parent) && $parent->use_group == User::TYPE_StaffStoreUser) {
                $package = PackageUser::getCurrentPackage($parent->parent_id)->first();
                if (!empty($package) && $package->id >= 4) {
                     $allow = ['allow' => true,
                    'package' => $package];
                }
            }
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $allow
            ]);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/permissions",
     *     operationId="list-permission",
     *     description="Danh sách quyền",
     *     produces={"application/json"},
     *     tags={"Permission"},
     *     summary="Danh sách quyền",
     *     @SWG\Response(
     *         response=200,
     *         description="Danh sách quyền"
     *     )
     * )
     */
    public function index(Request $req) {
        return Permission::orderBy('id', 'ASC')->get();
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/permissions/{not_id}",
     *     operationId="update-permission",
     *     description="Cập nhật quyền quyền",
     *     produces={"application/json"},
     *     tags={"Permission"},
     *     summary="Cập nhật quyền quyền",
     *     @SWG\Parameter(
     *         name="not_id",
     *         in="path",
     *         description="Id của news",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="permission_id",
     *         in="body",
     *         description="Id quyền",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Danh sách quyền"
     *     )
     * )
     */
    public function updatePermission($not_id, Request $req) {
        $new = Content::find($not_id);
        if (!$new || !$req->permission_id) {
            return response([
                'msg' => Lang::get('response.news_not_found')
            ], 404);
        }

        if (!$new->hasPermission($req->user(), true)) {
            return response([
                'msg' => Lang::get('response.permission_denied')
            ], 400);
        }

        $new->not_permission = $req->permission_id;

        $new->save();
        return response([
            'msg' => Lang::get('response.success')
        ]);
    }
}