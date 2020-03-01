<?php

namespace App\Models;

use App\BaseModel;
use DB;
use DateTime;
use App\Models\User;
use App\Models\ChatCountCall;


/**
 * Category model
 *
 */
class ChatCall extends BaseModel {

    protected $table = 'chatcall';
    protected $fillable = [
        'threadId',
        'userCall',
        'userReceive',
        'type',
        'message',
        'time_call'
    ];

    public static function getListCall($page, $pageSize, $params) {
        $userLogin = $params['userLogin'];
        $type = $params['type'];
        $search = $params['search'];
        switch ($type) {
          case 'all':
            $list = ChatCall::where(function ($query) use ($userLogin) {
                    $query->where(['userCall' => $userLogin, 'type' => 'call'])
                           ->orWhere(['userCall' => $userLogin, 'type' => 'video-call'])
                           ->orWhere(function ($query1) use ($userLogin) {
                              $query1->where(function ($query2) use ($userLogin) {
                                  $query2->where('userReceive', '=', $userLogin)
                                    ->orWhere('userReceive', 'like', $userLogin.',%')
                                    ->orWhere('userReceive', 'like', '%,'.$userLogin.',%')
                                    ->orWhere('userReceive', 'like', '%,'.$userLogin);
                              })->whereIn('type',['comming-call','comming-video-call','miss-call', 'miss-video-call']);
                           })
                          ;

            })->whereNotIn('id', function($query) use ($userLogin) {
                $query->select('callId')->where("userDelete", $userLogin)
                      ->from('chat_history_call');
            })
            ;
            break;
          case 'call':
            $list = ChatCall::where(function ($query) use ($userLogin) {
                  $query->where('userCall', '=', $userLogin);

               })->whereIn("type", ['call','video-call'])
            ->whereNotIn('id', function($query) use ($userLogin) {
                $query->select('callId')->where("userDelete", $userLogin)
                      ->from('chat_history_call');
            });
            break;

          case 'miss-call':
            $list = ChatCall::where(function ($query) use ($userLogin) {
                  $query->where('userReceive', '=', $userLogin)
                    ->orWhere('userReceive', 'like', $userLogin.',%')
                    ->orWhere('userReceive', 'like', '%,'.$userLogin.',%')
                    ->orWhere('userReceive', 'like', '%,'.$userLogin);

               })->whereIn("type", ['miss-call','miss-video-call'])
            ->whereNotIn('id', function($query) use ($userLogin) {
                $query->select('callId')->where("userDelete", $userLogin)
                      ->from('chat_history_call');
            });
            break;

          case 'comming-call':
            $list = ChatCall::where(function ($query) use ($userLogin) {
                  $query->where('userReceive', '=', $userLogin)
                    ->orWhere('userReceive', 'like', $userLogin.',%')
                    ->orWhere('userReceive', 'like', '%,'.$userLogin.',%')
                    ->orWhere('userReceive', 'like', '%,'.$userLogin);

               })->whereIn("type", ['comming-call', 'comming-video-call'])->whereNotIn('id', function($query) use ($userLogin) {
                $query->select('callId')->where("userDelete", $userLogin)
                      ->from('chat_history_call');
            });
            break;


          default:
            $list = ChatCall::where(function ($query) use ($userLogin) {
                    $query->where(['userCall' => $userLogin, 'type' => 'call'])
                           ->orWhere(['userCall' => $userLogin, 'type' => 'video-call'])
                           ->orWhere(function ($query1) use ($userLogin) {
                              $query1->where(function ($query2) use ($userLogin) {
                                  $query2->where('userReceive', '=', $userLogin)
                                    ->orWhere('userReceive', 'like', $userLogin.',%')
                                    ->orWhere('userReceive', 'like', '%,'.$userLogin.',%')
                                    ->orWhere('userReceive', 'like', '%,'.$userLogin);
                              })->whereIn('type',['comming-call','comming-video-call','miss-call', 'miss-video-call']);
                           })
                          ;})->whereNotIn('id', function($query) use ($userLogin) {
                $query->select('callId')->where("userDelete", $userLogin)
                      ->from('chat_history_call');
            });
            break;
        }
        $list->orderby("id","desc");
        return $list;

    }

    public static function countCall($params, $minus = true) {
      $type = $params['type'];
      $userLogin = $params['userLogin'];
      $count = ChatCall::where(function ($query) use ($userLogin) {
                  $query->where('userReceive', '=', $userLogin);
                    //->orWhere('userReceive', 'like', $userLogin.',%')
                    //->orWhere('userReceive', 'like', '%,'.$userLogin.',%')
                    //->orWhere('userReceive', 'like', '%,'.$userLogin);

               })->whereIn("type", ['miss-call','miss-video-call'])
            ->whereNotIn('id', function($query) use ($userLogin) {
                $query->select('callId')->where("userDelete", $userLogin)
                      ->from('chat_history_call');
            })->count();
      if($count != 0) {
         if($minus == true) {
           $dataRead =  ChatCountCall::where("userId" , $userLogin)->first();
           if($dataRead) {
              $count = $count - ($dataRead->count);
           }
         }

      }
      return $count;
    }

    public static function updateCountCall($type, $userId) {
      switch ($type) {
        case 'miss-call':

          $count = self::countCall(['type' => $type, 'userLogin' => $userId], false);
          $item = ChatCountCall::where("userId" , $userId)->first();
          if($item) {

            ChatCountCall::where("userId", $userId)->update(['count' => $count]);
          }
          else {
            ChatCountCall::create(['userId' => $userId, 'count' => $count]);

          }
          break;

        default:
          $count = self::countCall(['type' => 'miss-call', 'userLogin' => $userId], false);
          $item = ChatCountCall::where("userId" , $userId)->first();
          if($item) {

            ChatCountCall::where("userId", $userId)->update(['count' => $count]);
          }
          else {
            ChatCountCall::create(['userId' => $userId, 'count' => $count]);

          }
          break;
      }
    }
}
