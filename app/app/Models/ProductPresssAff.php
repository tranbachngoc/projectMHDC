<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\BaseModel;

/**
 * Description of ProductFavorite
 *
 * @author hoanvu
 */
class ProductPresssAff extends BaseModel {

    //put your code here

    protected $table = 'tbtt_product_press_af';
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_product_press_af';
    }

}
