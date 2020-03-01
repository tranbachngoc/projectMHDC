<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Manufacturer;
use App\Models\District;
use Lang;

class ManufacturerController extends ApiController {

    /**
     * @SWG\Get(
     *     path="/api/v1/manufactures",
     *     operationId="Manufacture",
     *     description="get list Manufacture",
     *     produces={"application/json"},
     *     tags={"Manufacturer"},
     *     summary="Lấy danh sách nhà sản xuất",
     *     @SWG\Response(
     *         response=200,
     *         description="public nhà sản xuất"
     *     )
     * )
     */
    public function index(Request $req) {
        return response([
            'msg' => Lang::get('response.success'),
            'data' => Manufacturer::orderBy('man_id', 'DESC')->get()
        ]);
    }


}