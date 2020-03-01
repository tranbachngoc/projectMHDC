<?php
namespace App\Http\Controllers\Api;
use App\Jobs\SendChatNotification;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\ChatThreads;
use App\Models\ChatMessages;
use App\Models\ChatThreadUser;
use App\Models\HistoryCall;
use App\Models\ChatUserOff;
use App\Models\ChatCall;
use App\Helpers\Commons;
use Lang;
use DB;
class ChatCallController extends ApiController {

    public function updateInfoThread(Request $req){
        $threadId = $req->groupChatId;
        $arrData = [
            'isStreaming' => $req->isStreaming,
            'virtualId' => $req->virtualId,
            'lastStreamingTime' => $req->lastStreamingTime,
          ];
        $update = DB::table('chatthreads')->where(['id' => $threadId])->update($arrData);
        if( $update) {
            return response([
                'msg' => Lang::get('response.success'),
                'status' => 200,
                'data' => $update
            ]);
        }
        else {
            return response([
                'msg' => Lang::get('response.failed'),
                'status' => 400,
            ]);
        }

     }

    public function updateInfoThreadUser(Request $req) {
        $threadId = $req->groupChatId;
        $user = $req->user();
        $userId = $user['use_id'];
        $arrData = [
            'isStreaming' => $req->isStreaming,
            'lastStreamingTime' => $req->lastStreamingTime,
          ];
        $update = DB::table('chatthreaduser')->where(['threadId' => $threadId, 'userId' => $userId])->update($arrData);
        if( $update) {
            return response([
                'msg' => Lang::get('response.success'),
                'status' => 200,
                'data' => $update
            ]);
        }
        else {
            return response([
                'msg' => Lang::get('response.failed'),
                'status' => 400,
            ]);
        }
     }

    public function createDataCall(Request $req) {
        $user = $req->user();
        $threadId = $req->groupChatId;
        $detailThread = ChatThreadUser::where('threadId', $threadId)->first();
        $threadInfo = ChatThreads::where('id', $threadId)->first();
        $lastStreamingTime  = $detailThread->lastStreamingTime;
        $time_streaming = ChatUserOff::time_elapsed_string($lastStreamingTime);
        $userId = $user['use_id'];
        $arrData = ['type' => $threadInfo->type,
                    'threadId' => $threadId,
                    'text' => $req->text,
                    'typedata' => $req->typedata,
                    'ownerId' => $userId ,
                    'time_streaming' => (string)$time_streaming,
                    'updatedAt' => date('Y-m-d h:i:s'),
                    'createdAt' => date('Y-m-d h:i:s'),
                  ];

        //$create = ChatMessages::insert($arrData);
        $create = $arrData;
        if( $create) {
            return response([
                'msg' => Lang::get('response.success'),
                'status' => 200,
                'data' => $create,
                'groupChatId' => $threadId
            ]);
        }
        else {
            return response([
                'msg' => Lang::get('response.failed'),
                'status' => 400,
            ]);
        }
     }


    public function setCountCall(Request $req) {
        $user = $req->user();
        $update = ChatCall::updateCountCall('miss-call', $user->use_id);
        return response([
                'msg' => Lang::get('response.success'),
                'status' => 200,
                'data' => ''
            ]);

    }

    public function listCall(Request $req){
        $user = $req->user();
        $search = "";
        $type = "all";
        if( isset($req->search)) {
            $search = $req->search;
        }
        if( isset($req->type)) {
            $type = $req->type;
        }
        $params = ['userLogin' => $user->use_id, 'search' =>  $search, 'type' => $type];
        $page = $req->page;
        $pageSize = $req->limit;
        $list = ChatCall::getListCall($page, $pageSize, $params);
        ChatCall::updateCountCall($type, $user->use_id);
        $list = $list->paginate($pageSize);
        if (sizeof($list->items()) > 0) {
            foreach ($list->items() as $val) {
                switch ($val['type']) {
                    case 'video-call':
                    case 'call':
                        $arrUser = explode(',', $val['userReceive']);
                        $userCall = $val['userCall'];
                        $infoUser = ChatThreads::infoDetailUser($arrUser, $user['use_id'], $userCall);
                        //$infoUser = ChatThreads::infoDetailUser([$val['userCall']], $user['use_id']);
                        if(count($infoUser) > 0)  {
                            $val['use_fullname'] = $infoUser[0]['use_fullname'];
                            $val['use_username'] = $infoUser[0]['use_username'];
                            $val['use_id'] = $infoUser[0]['use_id'];
                            $val['avatar'] = $infoUser[0]['avatar'];
                            $val['use_id'] = $infoUser[0]['use_id'];
                            $detailThreadUser = ChatThreadUser::where(['userId' => $infoUser[0]['use_id'], 'threadId' => $val['threadId']])->first();
                            if($detailThreadUser) {
                                $val['blocked'] = $detailThreadUser->blocked;
                                $val['blockedNotify'] = $detailThreadUser->blockedNotify;
                                $val['alias_secret'] = $detailThreadUser->alias_secret;
                                $val['avatar_secret'] = $detailThreadUser->avatar_secret;
                            } else {
                                $val['blocked'] = 0;
                                $val['blockedNotify'] = 0;
                                $val['alias_secret'] = null;
                                $val['avatar_secret'] = null;
                            }
                        }
                        else {
                            $val['blocked'] = 0;
                            $val['blockedNotify'] = 0;
                            $val['alias_secret'] = null;
                            $val['avatar_secret'] = null;
                        }


                        $val['created_ts'] = Commons::convertDateTotime($val['created_at']);
                        $val['updated_ts'] = Commons::convertDateTotime($val['updated_at']);


                        //$val['user'] = $infoUser;
                        // get infoUser Receive
                        break;

                    case 'comming-video-call':
                    case 'comming-call':
                        $arrUser = explode(',', $val['userCall']);
                        $infoUser = ChatThreads::infoDetailUser($arrUser, $user['use_id']);
                        //$val['user'] = $infoUser;
                        if(count($infoUser) > 0)  {
                            $val['use_fullname'] = $infoUser[0]['use_fullname'];
                            $val['use_id'] = $infoUser[0]['use_id'];
                            $val['use_username'] = $infoUser[0]['use_username'];
                            $val['avatar'] = $infoUser[0]['avatar'];
                            $detailThreadUser = ChatThreadUser::where(['userId' => $infoUser[0]['use_id'], 'threadId' => $val['threadId']])->first();
                            if($detailThreadUser) {
                                $val['blocked'] = $detailThreadUser->blocked;
                                $val['blockedNotify'] = $detailThreadUser->blockedNotify;
                                $val['alias_secret'] = $detailThreadUser->alias_secret;
                                $val['avatar_secret'] = $detailThreadUser->avatar_secret;
                            } else {
                                $val['blocked'] = 0;
                                $val['blockedNotify'] = 0;
                                $val['alias_secret'] = null;
                                $val['avatar_secret'] = null;
                            }
                        }
                        else {
                             $val['blocked'] = 0;
                            $val['blockedNotify'] = 0;
                            $val['alias_secret'] = null;
                            $val['avatar_secret'] = null;
                        }

                        $val['created_ts'] = Commons::convertDateTotime($val['created_at']);
                        $val['updated_ts'] = Commons::convertDateTotime($val['updated_at']);


                        break;

                    case 'miss-video-call':
                    case 'miss-call':
                        $arrUser = explode(',', $val['userCall']);
                        $infoUser = ChatThreads::infoDetailUser($arrUser, $user['use_id']);
                        //$val['user'] = $infoUser;
                        if(count($infoUser) > 0)  {
                            $val['use_fullname'] = $infoUser[0]['use_fullname'];
                            $val['use_username'] = $infoUser[0]['use_username'];
                            $val['use_id'] = $infoUser[0]['use_id'];
                            $val['avatar'] = $infoUser[0]['avatar'];
                            $detailThreadUser = ChatThreadUser::where(['userId' => $infoUser[0]['use_id'], 'threadId' => $val['threadId']])->first();
                            if($detailThreadUser) {
                                $val['blocked'] = $detailThreadUser->blocked;
                                $val['blockedNotify'] = $detailThreadUser->blockedNotify;
                                $val['alias_secret'] = $detailThreadUser->alias_secret;
                                $val['avatar_secret'] = $detailThreadUser->avatar_secret;
                            }
                            else {
                                $val['blocked'] = 0;
                                $val['blockedNotify'] = 0;
                                $val['alias_secret'] = null;
                                $val['avatar_secret'] = null;
                            }
                        }
                        else {
                             $val['blocked'] = 0;
                                $val['blockedNotify'] = 0;
                                $val['alias_secret'] = null;
                                $val['avatar_secret'] = null;
                        }
                        $val['created_ts'] = Commons::convertDateTotime($val['created_at']);
                        $val['updated_ts'] = Commons::convertDateTotime($val['updated_at']);

                        break;

                    default:
                        # code...
                        break;
                }
            }
        }
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $list,
            'status' => 200
        ]);
    }

    public function countCall(Request $req){
        $type = 'miss-call';
        $user = $req->user();
        $count = ChatCall::countCall(['userLogin' => $user['use_id'], 'type' =>'miss-call']);
        return response([
            'msg' => Lang::get('response.success'),
            'data' => ['count' => $count],
            'status' => 200
        ]);

    }

    public function updateInfoCall(Request $req) {
        $user = $req->user();
        $threadId = $req->groupChatId;
        $userCall = $req->userCall;
        $userReceive = $req->userReceive;
        $type = $req->type;
        $message = $req->message;
        $arrData = [
                'threadId' => $threadId,
                'userCall' => $userCall,
                'userReceive' => $userReceive,
                'type' => $type,
                'message' => $message,
            ];
        $create = ChatCall::create($arrData);
        $type_chat = 'private';
        $detailMes = null;
        switch ($type) {
            case 'miss-call':
                $arrData = ['type' => $type_chat,
                    'ownerId' => $userCall,
                    'threadId' => $threadId,
                    'text' => "",
                    'typedata' => "miss-call",
                    'messageId' => 0,
                    'user_receive' => $userReceive,
                    'createdAt' => date('Y-m-d H:i:s'),
                    'updatedAt' => date('Y-m-d H:i:s')
                ];
                $messageId  = ChatMessages::sendMessage($arrData);
                $detailMes = ChatMessages::getDetailMesssage($messageId, $user['use_id']);
                break;

            case 'miss-video-call':
                $arrData = ['type' => $type_chat,
                    'ownerId' => $userCall,
                    'threadId' => $threadId,
                    'user_receive' => $userReceive,
                    'text' => "",
                    'typedata' => "miss-video-call",
                    'messageId' => 0,
                    'createdAt' => date('Y-m-d H:i:s'),
                    'updatedAt' => date('Y-m-d H:i:s')
                ];
                $messageId  = ChatMessages::sendMessage($arrData);
                $detailMes = ChatMessages::getDetailMesssage($messageId, $user['use_id']);
                break;

            default:

                break;
        }
        //$count = ChatCall::countCall(['userLogin' => $userReceive, 'type' =>'miss-call']);
        $count = 1;
        if( $create) {
            if($type == 'call' || $type == 'video-call' || $type == 'miss-call' || $type == 'miss-video-call' ) {
                //pushNotification
                $userReceive = explode(',', $userReceive);
                $groupChatTime = $req->groupChatTime;
                $isAudio = $req->isAudio;
                $groupChatTimeTs = $req->groupChatTimeTs;
                $dataPushnotification = [
                    'userIds' => $userReceive,
                    'time_call' => Commons::convertDateTotime($create->created_at),
                    'use_id' =>  $user['use_id'],
                    'groupChatId' => $threadId,
                    'use_fullname' => $user['use_fullname'],
                    'linkAvatar' => $user['avatar'],
                    'use_id' =>  $user['use_id'],
                    'groupChatTime'=> $groupChatTime,
                    'groupChatTimeTs'=> $groupChatTimeTs,
                    'arrAllUserGroup' => $userReceive,
                    'isAudio' => $isAudio,
                    'action-type' => 'init-call'
                ];
                /*$notification = new SendChatNotification('init-call',$dataPushnotification);
                $notification->pushNotificationInitCall();*/
                if($type == 'miss-call' || $type == 'miss-video-call') {
                    dispatch(new SendChatNotification('usercancel-call',$dataPushnotification));
                }
                else {
                    dispatch(new SendChatNotification('init-call',$dataPushnotification));
                }


            }
            return response([
                'msg' => Lang::get('response.success'),
                'status' => 200,
                'data' => $create,
                'groupChatId' => $threadId,
                'userReceive' => $userReceive,
                'countCall' => ['count' => $count],
                'detailMes' => $detailMes
            ]);
        }
        else {
            return response([
                'msg' => Lang::get('response.failed'),
                'status' => 400,
            ]);
        }
    }

    public function deleteHistoryCall(Request $req) {
        $id = $req->id;
        $user = $req->user();
        $delete = HistoryCall::create(['callId' => $id, 'userDelete' => $user['use_id']]);
        if($delete) {
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $delete,
                'status' => 200
            ]);
        }
        else {
            return response([
                'msg' => Lang::get('response.failed'),
                'status' => 400,
            ]);
        }




    }

    public function sendMessPush(Request $req) {
        $userIds = $req->userIds;
        $dataPushnotification = [
            'userIds' => [$userIds],
            'groupChatId' => intval( $req->groupChatId),
            'linkAvatar' => $req->linkAvatar,
            'use_fullname' => $req->use_fullname,
            'use_id' => intval($req->use_id),
            'groupChatTime' => $req->groupChatTime,
            'isAudio' => $req->isAudio,
            'action-type' => 'init-call'
        ];
        $object = new SendChatNotification('init-call',$dataPushnotification);
        return $object->pushNotificationInitCall();
        //return dispatch(new SendChatNotification('init-call',$dataPushnotification));

    }

}

?>