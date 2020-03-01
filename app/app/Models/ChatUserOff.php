<?php

namespace App\Models;
use App\BaseModel;
use App\Models\User;
use DB;
use DateTime;

/**
 * ChatUser model
 *
 */
class ChatUserOff extends BaseModel {

    protected $table = 'chatuseroffline';
    protected static $table_name = 'chatuseroffline';
    protected $fillable = [
        'userId',
        'timeTs',
        'timeDate'
    ];


    public static function updateTime($arrData) {
        $userId = $arrData['userId'];
        $info =  DB::table('chatuseroffline')
            ->where('userId', $userId)->first();
        if($info) {
          return DB::table('chatuseroffline')
            ->where('userId', $userId)->update($arrData);
        }
        else {
          $id = DB::table('chatuseroffline')->insertGetId($arrData);
          return $id;
        }
    }

    public static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'năm',
            'm' => 'tháng',
            'w' => 'tuần',
            'd' => 'ngày',
            'h' => 'giờ',
            'i' => 'phút',
            's' => 'giây',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' trước' : 'vừa mới truy cập';
    }


}
