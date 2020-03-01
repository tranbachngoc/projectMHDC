<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\BaseModel;

/**
 * Description of lCommissionAff
 *
 * @author hoanvu
 */
class Delivery extends BaseModel {

    //put your code here
    protected $table = 'tbtt_changedelivery';

    const TYPE_CANCEL_PRODUCT = 2; //Trả hàng
    const TYPE_CHANGE_PRODUCT = 1; //Đổi hàng
    const STATUS_NEW = 1;//Yêu cầu khiếu nại Mới
    const STATUS_WAIT_USER = 2; // Chờ thành viên gởi mẫu vận chuyển
    const STATUS_REFUND = 3; // Xác nhận và hoàn tiền cho thành viên
    const STATUS_DONE = 4;

    public $timestamps = false;

//    protected $casts = [
//        'min' => 'integer',
//        'max' => 'integer',
//        'percent' => 'integer'
//    ];
}
