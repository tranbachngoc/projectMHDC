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
class ProductFavorite  extends BaseModel{
    //put your code here

    protected $table = 'tbtt_product_favorite';
    protected $primaryKey = 'prf_id';
    public $timestamps = false;
    protected $fillable = [
        'prf_product',
        'prf_user',
        'prf_date'
    ];

}
