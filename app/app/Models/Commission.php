<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;

/**
 * @SWG\Tag(
 *   name="Commission",
 *   description="Hoa hồng",
 * )
 */
/**
 * Description of CommissionStore
 *
 * @author hoanvu
 */
class Commission extends BaseModel {

    //put your code here
    protected $table = 'tbtt_commission';
    public $timestamps = false;
    protected $casts = [
    ];

    public static function tableName() {
        return 'tbtt_commission';
    }
}
