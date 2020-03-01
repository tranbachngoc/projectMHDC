<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Version;
use Lang;
use App\Helpers\Utils;

class SettingController extends ApiController {

    /**
     * @SWG\Get(
     *     path="settings",
     *     operationId="settings",
     *     description="getSetting",
     *     tags={"Settings"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="success"
     *     )
     * )
     */
    public function index(Request $req) {

        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'REGULAR_RETAIL_ONLINE' => env('APP_URL') . '/webapp/news/391',
                'MAX_PRODUCT_CART' => 20
            ]
        ]);
    }

     /**
     * @SWG\Put(
     *     path="/api/v1/update-version-app",
     *     operationId="Complaints",
     *     description="Cập nhật phiên bản hiện tại của app ",
     *     produces={"application/json"},
     *     tags={"Complaints"},
     *     summary="Complain ",
     *  @SWG\Parameter(
     *         name="os",
     *         in="body",
     *         description="Platform",
     *         required=false,
     *         type="string",
     *     ),
     *    @SWG\Parameter(
     *         name="version",
     *         in="query",
     *         description="phiên bản",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function updateVersion(Request $req) {
        $version = Version::where('os', $req->os)->first();
        if (empty($version)) {
            $version = new Version([
                'os' => $req->os,
                'version' => $req->version,
                'lastversion' => 1
            ]);
            $version->save();
        } else {
            $lastVersion = $version->lastversion;
            $version->version = $req->version;
            $version->lastversion = $lastVersion;
            $version->save();
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $version
        ]);
    }
 /**
     * @SWG\Put(
     *     path="/api/v1/version-app",
     *     operationId="Complaints",
     *     description="Chi tiet cua ticket nay ",
     *     produces={"application/json"},
     *     tags={"Setting"},
     *     summary="Lấy phiên bản hiện tại của app ",
     *  @SWG\Parameter(
     *         name="os",
     *         in="query",
     *         description="Platform",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function checkCurrentVersion(Request $req) {
        $result = Version::where('os', $req->os)->first();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $result
        ]);
    }

}