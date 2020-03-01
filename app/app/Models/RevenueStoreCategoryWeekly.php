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
class RevenueStoreCategoryWeekly  extends BaseModel{
    protected $table = 'tbtt_revenue_store_category_weekly';

    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_revenue_store_category_weekly';
    }
}
