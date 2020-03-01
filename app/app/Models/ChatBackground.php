<?php

namespace App\Models;

use App\BaseModel;
use DB;
use DateTime;
use App\Models\User;
use App\Models\ChatUserBackground;


/**
 * Category model
 *
 */
class ChatBackground extends BaseModel {

    protected $table = 'chatbackground';
    protected $fillable = [
        'name',
        'userId'
      ];

    public static function getList($params) {
        $userId = $params['userId'];
        $list = ChatBackground::where(function ($query)  use ($userId) {
                            $query->where('userId', '=', 0)
                                  ->orWhere('userId', '=', $userId);
                        })
                      ->select("name")->orderby('id', 'desc')->get()->toArray();
        return $list;

        /*$userId = $params['userId'];
        $list = ChatBackground::select("name")->get()->toArray();
        $arrExist = [];
        if($list) {
          foreach ( $list as $k => $v ){
            $arrExist[] = $v['name'];
          }
        }
        $backgroundUser = ChatUserBackground::where("userId", $userId)
                      ->whereNotIn("background", $arrExist)
                      ->where("background", "<>", "")
                      ->orderby("id",'desc')->offset(0)->limit(1)->select("background as name")->get();
        if($backgroundUser) {
            $backgroundUser = $backgroundUser->toArray();
            $list = array_merge($backgroundUser, $list);
        }
        return $list;*/
    }

    public static function saveBackground($arrData) {
        $userId = $arrData['userId'];
        $background = $arrData['name'];
        $info =  DB::table('chatbackground')
            ->where('userId', $userId)->first();
        if($info) {
          $arrData['updatedAt'] = date('Y-m-d h:i:s');
          return DB::table('chatbackground')
            ->where('userId', $userId)->update($arrData);
        }
        else {
          $arrData['createdAt'] = date('Y-m-d h:i:s');
          $arrData['updatedAt'] = date('Y-m-d h:i:s');
          $id = DB::table('chatbackground')->insertGetId($arrData);
          return $id;
        }
    }

}
