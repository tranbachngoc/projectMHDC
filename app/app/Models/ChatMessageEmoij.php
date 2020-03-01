<?php

namespace App\Models;

use App\BaseModel;
use DB;
use DateTime;
use App\Models\User;



/**
 * Category model
 *
 */
class ChatMessageEmoij extends BaseModel {

    protected $table = 'chatmessageemoij';
    protected static $table_name = 'chatmessageemoij';
    protected $fillable = [
        'messageId',
        'emoijId',
        'userId',
        'count'

      ];

    public static function setMessage($params) {
        $check = ChatMessageEmoij::where(['messageId' => $params['messageId'], 'userId' => $params['userId']])->first();
        if( $check) {
          return  DB::table(ChatMessageEmoij::$table_name)->where(['messageId' => $params['messageId'], 'userId' => $params['userId']])->update(['count' => $params['count'], 'emoijId' => $params['emoijId']]);
        }
        else{
            return DB::table(ChatMessageEmoij::$table_name)->insert($params);
        }

    }

    public static function getCountEmoijMessage($params) {
       $count = ChatMessageEmoij::where(['messageId' => $params['messageId'], 'emoijId' => $params['emoijId'], 'count' => 1])->count();
       return $count;
    }

    public static function getTotalEmoij($messageId) {
       $count = ChatMessageEmoij::where(['messageId' => $messageId])->count();
       return $count;
    }



    public static function getEmoijMessage($messageId) {
      $list = ChatMessageEmoij::join("chatemoij","chatemoij.id","=","chatmessageemoij.emoijId")
                ->where(['messageId' => $messageId, 'count' => 1])->groupby('emoijId')
                ->selectRaw('count(userId) as countEmoij, chatemoij.emoij, chatemoij.id as emoijId')->get();
      if(count($list) > 0 ) {
        return  $list;
        /*$arr = [];
        foreach( $list as $k => $v) {
          $arr[$v['emoij']] = $v['countEmoij'];
        }
        return $arr;*/

      }
      else {
        return null;
      }

    }

    public static function checkChooseEmoij($messageId, $userId) {
      $check = ChatMessageEmoij::where(['messageId' => $messageId,  'userId' => $userId])->first();
      if($check) {
        return 1;
      }
      return 0;

    }


    public static function infoChooseEmoij($messageId, $userId) {
      $info = ChatMessageEmoij::join("chatemoij","chatemoij.id","=","chatmessageemoij.emoijId")
            ->where(['chatmessageemoij.messageId' => $messageId,  'chatmessageemoij.userId' => $userId])->select("chatmessageemoij.*","chatemoij.emoij", "chatemoij.id as emoijId")->first();
      if($info) {
        return $info->toArray();
      }
      return $info;

    }

    public static function getDetail($page, $limit, $params) {
      $offset = ($page-1)* $limit;
      $userLogin =  $params['userLogin'];
      $messageId = $params['messageId'];
      $list =  ChatMessageEmoij::join("tbtt_user","chatmessageemoij.userId","=", "tbtt_user.use_id")
                  ->join("chatemoij","chatemoij.id","=","chatmessageemoij.emoijId")
                  ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                             $join->on('chatmessageemoij.userId', '=', 'chatuseralias.userId_alias');
                    })
                  ->where("chatmessageemoij.messageId", "=", $messageId)
                  ->offset($offset)
                  ->limit($limit)
                  ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatemoij.id", "chatemoij.emoij");
      return $list;


    }



}
