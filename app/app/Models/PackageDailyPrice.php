<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\BaseModel;

/**
 * Description of PackageDailyUser
 *
 * @author hoanvu
 */
class PackageDailyPrice extends BaseModel {

    protected $table = 'tbtt_package_daily_price';
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_package_daily_price';
    }

    /* Lấy tổng số kệ hàng  */
}
