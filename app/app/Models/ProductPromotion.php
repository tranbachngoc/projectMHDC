<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
/**
 * Description of ProductPromotion
 *
 * @author hoanvu
 */
class ProductPromotion extends BaseModel{

    //put your code here
    protected $table = 'tbtt_product_promotion';
    protected $primaryKey = 'id';
    public $timestamps = false;
    const TYPE_QTY = 1;
    const TYPE_MONEY = 2;
    const TYPE_AMOUNT_PERCENT = 2;
    const TYPE_AMOUNT_MONEY = 1;
    public static function tableName() {
        return 'tbtt_product_promotion';
    }
     protected $fillable = array(
        'pro_id ',
        'limit_from',
        'limit_to',
        'limit_type',
        'dc_rate',
        'dc_amt',
    );

}
