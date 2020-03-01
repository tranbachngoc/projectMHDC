<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
/**
 * Description of DetailProduct
 *
 * @author hoanvu
 */
class DetailProduct extends BaseModel{

    //put your code here
    protected $table = 'tbtt_detail_product';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['dp_images',  'dp_size', 'dp_color', 'dp_material', 'dp_code', 'dp_cost', 'dp_instock', 'dp_note'];

    public static function tableName() {
        return 'tbtt_detail_product';
    }

}
