<?php

namespace App\Models;

use App\BaseModel;
use DB;
use DateTime;
use App\Models\User;
use App\Models\ChatThreadUser;


/**
 * Category model
 *
 */
class ChatUserBackground extends BaseModel {

    protected $table = 'chatuserbackground';
    protected $fillable = [
        'userId',
        'groupChatId',
        'background',
        'side'
      ];


    public static function tableName() {
        return 'chatuserbackground';
    }



    public static function updateBackground($arrData) {
        $tablename = ChatUserBackground::tableName();
        $info =  DB::table($tablename)
                    ->where('userId', $arrData['userId'])
                    ->where('groupChatId', $arrData['groupChatId'])
                    ->first();
        if($info) {
          $arrData['updatedAt'] = date('Y-m-d h:i:s');
          if( $arrData['side'] == 1) {
            return DB::table($tablename)
             ->where('userId', $arrData['userId'])
               ->where('groupChatId', $arrData['groupChatId'])->update($arrData);
          }
          else {
             DB::table($tablename)
             ->where('userId', $arrData['userId'])
               ->where('groupChatId', $arrData['groupChatId'])->update($arrData);
             return DB::table($tablename)
                   ->where("userId", "<>", $arrData['userId'])
                   ->where('groupChatId', $arrData['groupChatId'])->update(['background' => $arrData['background']]);
          }

        }
        else {
          $arrData['createdAt'] = date('Y-m-d h:i:s');
          $arrData['updatedAt'] = date('Y-m-d h:i:s');
          if($arrData['side'] == 1) {
              $id = DB::table($tablename)->insertGetId($arrData);
              return $id;
          }
          else {
              $id = DB::table($tablename)->insertGetId($arrData);
              return DB::table($tablename)
                   ->where("userId", "<>", $arrData['userId'])
                   ->where('groupChatId', $arrData['groupChatId'])->update(['background' => $arrData['background']]);
          }

        }
    }

    public static function getListUser($groupChatId, $userId) {
        /*$listUserHasBackground = ChatUserBackground::where("groupChatId", $groupChatId)
                                ->where("userId", '<>', $userId)
                                ->select("userId")->get();
        $arr = [];
        if($listUserHasBackground) {
            foreach( $listUserHasBackground as $k => $v ) {
                $arr[] = $v['userId'];
            }
        }*/
        /*$listUser =  ChatThreadUser::where("chatthreaduser.threadId", "=", $groupChatId )
                                    ->whereNotIn("chatthreaduser.userId", $arr)->select("userId")->get();*/
        $listUser =  ChatThreadUser::where("chatthreaduser.threadId", "=", $groupChatId )
                                    ->select("userId")->get();
        return $listUser;
    }

    public static function getBackgroundUser($params) {
        $groupChatId = $params['groupChatId'];
        $userId = $params['userId'];
        if( $userId == "") {
          $info = ChatUserBackground::where(['groupChatId' => $groupChatId, 'side' => 2])->first();
          if($info) {
            return $info['background'];
          }
          else {
            return "";
          }
        }
        $info = ChatUserBackground::where(['groupChatId' => $groupChatId, 'userId' => $userId])->first();
        if($info) {
          return $info['background'];
        }
        else {
          $info1 = ChatUserBackground::where(['groupChatId' => $groupChatId, 'side' => 2])->first();
          if($info1) {
              return $info1['background'];
          }
          return '';
        }

    }



}
