<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Province;
use App\Models\District;
use Lang;

class GeoController extends ApiController {

    /**
     * @SWG\Get(
     *     path="/api/v1/provinces",
     *     operationId="provinces",
     *     description="get list provinces",
     *     produces={"application/json"},
     *     tags={"Areas"},
     *     summary="Lấy danh sách tỉnh thành",
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function provinces(Request $req) {
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Province::orderBy('pre_name', 'asc')->get()
        ]);
    }


    /**
     * @SWG\Get(
     *     path="/api/v1/districts",
     *     operationId="districts",
     *     description="get list districts",
     *     produces={"application/json"},
     *     tags={"Areas"},
     *     summary="Lấy danh sách quận huyện",
     *     @SWG\Parameter(
     *         name="provinceId",
     *         in="path",
     *         description="provinceId",
     *         required=false,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/Driver")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public trips"
     *     )
     * )
     */
    public function districts(Request $req) {
        $query = District::where([]);
        if ($req->provinceId) {
            $query->where('ProvinceCode', $req->provinceId);
        }
        $query->orderBy('DistrictName', 'asc');

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $query->get()
        ]);
    }
}