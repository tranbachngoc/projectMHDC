<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use App\Models\Wallet;
use Illuminate\Http\Request;
/**
 * Description of WalletController
 *
 * @author hoanvu
 */
class WalletController extends ApiController{
    
     /**
     * @SWG\Get(
     *     path="/api/v1/me/wallet",
     *     operationId="Mywallet",
     *     description="Lấy thông tin tiền trong ví",
     *     produces={"application/json"},
     *     tags={"Wallet"},
     *     summary="Thông tin",
     *     @SWG\Response(
     *         response=200,
     *         description="Lấy thông tin tiền trong ví"
     *     )
     * )
     */
    public function getMyWallet(Request $req) {
        $query = Wallet::where('user_id', $req->user()->use_id);
        $total = $query->sum('amount');
        return response([
            'msg' => 'success',
            'data' => [
                'total' => $total
            ]
            ], 200);
    }

    //put your code here
}
