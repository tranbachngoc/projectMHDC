<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
use App\Models\Product;
/**
 * Description of PackageDailyUser
 *
 * @author hoanvu
 */
class PackageDailyUser  extends BaseModel{
     protected $table = 'tbtt_package_daily_user';

    const TYPE_KE_HANG = '09';

    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_package_daily_user';
    }
/* Lấy tổng số kệ hàng  */

    public static function getTotalAfCate($userId) {
        $query = self::where(['p_type' => self::TYPE_KE_HANG, 'user_id' => $userId]);
        $query->whereDate('begined_date', '<', date('Y-m-d'))
            ->whereDate('ended_date', '>',  date('Y-m-d'));
        return (int)$query->sum('content_num');
    }

    function get_max_pos_num($date, $pack_id, $position) {
        $query = selft::where(['package_id' => $pack_id, 'position' => $position]);
        $query->whereDate('begined_date', $date);
        $query->select(DB::raw('IF(
                    MAX(`pos_num`) IS NULL,
                    1,
                    MAX(`pos_num`) + 1
                  ) AS max_num'));


        return $query->first();
    }

}
