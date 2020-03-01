<?php

namespace App\Models;

use App\BaseModel;
use DB;
use DateTime;
use App\Models\User;
use App\Models\ChatThreadUser;
use App\Models\ChatThreads;
use App\Models\ChatUserRead;
use App\Models\ChatMessageRead;
use App\Models\Product;
use App\Models\ChatMessageEmoij;
use Carbon\Carbon;
use App\Jobs\SendChatNotification;
use Illuminate\Support\Facades\Log;
use DispatchesJobs;
/**
 * Category model
 *
 */
class ChatMessages extends BaseModel {

    protected $table = 'chatmessages';
    protected $fillable = [
        'type',
        'ownerId',
        'threadId',
        "text",
        'typedata',
        'createdAt',
        'updatedAt',
        'userDelete',
        'messageId',
        'width',
        'height',
        'size',
        'listImage',
        'productId',
        'public',
        'caption',
        'timeDelete',
        'time_streaming',
        'subjectName',
        'pin',
        'parentMessId',
        'user_receive',
        'message_repeat',
        "content_repeat",
        "time_repeat",
        "share_lat",
        "share_lng",
        "share_time",
        "time_stop_share",
        "time_set_repeat",
        "parentIdRepeat",
        "userIdShowRepeat",
        "element"
      ];

    public static function getList($page, $pageSize, $params) {
        $threadId = $params['threadId'];
        $offset = ($page - 1) * $pageSize;
        $userLogin = $params['userLogin'];
        $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->where("chatmessages.threadId","=", $threadId)
                ->where("chatmessages.userDelete","<>", $userLogin)
                ->orderBy('chatmessages.id','desc')
                ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "chatmessages.*" )
               ;
        return $list;

    }

    public static function getListAlias($page, $pageSize, $params) {
        $threadId = $params['threadId'];
        $offset = ($page - 1) * $pageSize;
        $userLogin = $params['userLogin'];
        $lastIdMessage = 0;
        $idDelete = 0;
        if(isset($params['lastIdMessage'])) {
            $lastIdMessage = $params['lastIdMessage'];
        }
        if(isset($params['idDelete'])) {
            $idDelete = $params['idDelete'];
        }
        $detailThread = ChatThreads::where("id", $threadId)->first();
        $ownerThread = $detailThread->ownerId;
        $typeThread = $detailThread->type;
        if( $typeThread == 'private' || ($userLogin == $ownerThread ) ) {
            if( $idDelete == $userLogin) {
                $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                    ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                             $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                    })
                    ->where("chatmessages.threadId","=", $threadId)
                    ->where("chatmessages.userDelete","<>", $userLogin)
                    ->where("chatmessages.id",">", $lastIdMessage)
                    ->orderBy('chatmessages.id','desc')
                    ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*" )
                   ;
            }
            else {
                $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                    ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                             $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                    })
                    ->where("chatmessages.threadId","=", $threadId)
                    ->where("chatmessages.userDelete","<>", $userLogin)
                    //->where("chatmessages.id",">", $lastIdMessage)
                    ->orderBy('chatmessages.id','desc')
                    ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*" )
                   ;
            }
        }
        else {
            if( $idDelete == $userLogin) {
                $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                    ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                             $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                    })
                    ->where("chatmessages.threadId","=", $threadId)
                    ->where("chatmessages.userDelete","<>", $userLogin)
                    ->where("chatmessages.id",">", $lastIdMessage)
                    ->where(function ($query) use ($userLogin) {
                        $query->where('public', '=', 1)
                            ->orWhere('chatmessages.ownerId', '=', $userLogin);
                    })
                    ->orderBy('chatmessages.id','desc')
                    ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*" )
                   ;
            }
            else {
                $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                    ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                             $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                    })
                    ->where("chatmessages.threadId","=", $threadId)
                    ->where("chatmessages.userDelete","<>", $userLogin)
                    ->where(function ($query) use ($userLogin) {
                        $query->where('public', '=', 1)
                            ->orWhere('chatmessages.ownerId', '=', $userLogin);
                    })
                    //->where("chatmessages.id",">", $lastIdMessage)
                    ->orderBy('chatmessages.id','desc')
                    ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*" )
                   ;
            }
        }
        return $list;

    }

    public static function getListAlias_V2($page, $pageSize, $params) {
        $threadId = $params['threadId'];
        $offset = ($page - 1) * $pageSize;
        $userLogin = $params['userLogin'];
        $lastIdMessage = 0;
        $idDelete = 0;
        if(isset($params['lastIdMessage'])) {
            $lastIdMessage = $params['lastIdMessage'];
        }
        if(isset($params['idDelete'])) {
            $idDelete = $params['idDelete'];
        }
        $detailThread = ChatThreads::where("id", $threadId)->first();
        $ownerThread = $detailThread->ownerId;  
        $typeThread = $detailThread->type;
        $sql = "(select chatmessages.*, (CASE WHEN chatmessages.messageId  <> 0  THEN  (select COUNT(parentMessId) from chatmessages as tablecount where tablecount.id > chatmessages.id and tablecount.element = chatmessages.element  and tablecount.parentMessId = chatmessages.parentMessId  and  tablecount.threadId = ".$threadId." )  ELSE 0 END) as countChild from chatmessages where chatmessages.threadId = ".$threadId." ) as chatmessages";
        if( $typeThread == 'private' || ($userLogin == $ownerThread ) ) {

            if( $idDelete == $userLogin) {
                $list = DB::table(DB::raw($sql))->join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                    ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                             $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                    })
                    ->leftJoin(DB::raw("(select * from chatmessages_pin where userId = $userLogin and threadId = $threadId) as chatmessages_pin"), function($join) {
                                     $join->on('chatmessages.id', '=', 'chatmessages_pin.messageId');
                            })
                    ->where("chatmessages.threadId","=", $threadId)
                    ->where("chatmessages.userDelete","<>", $userLogin)
                    ->where("chatmessages.id",">", $lastIdMessage)
                    ->where(function ($query)  {
                        $query->where('chatmessages.countChild', '=', 0)
                            ->orWhere('chatmessages.countChild', '=', 1);
                    })
                    ->where(function ($query) use ($userLogin)  {
                        /*$query->where('chatmessages.userIdShowRepeat', '=', 0)
                            ->orWhere('chatmessages.userIdShowRepeat', '=', $userLogin);*/
                        $query->where(['chatmessages.userIdShowRepeat' => 0, 'chatmessages.parentIdRepeat' => 0])
                            ->orWhere(function ($query1) use ($userLogin)  {
                                 $query1->where('chatmessages.userIdShowRepeat', 0)
                                        ->where('chatmessages.parentIdRepeat', '<>',0)
                                        ->where('chatmessages.ownerId', '<>',$userLogin);
                            })
                            ->orWhere('chatmessages.userIdShowRepeat', '=', $userLogin);
                    })
                    ->orderBy('chatmessages.id','desc')
                    ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*", "chatmessages_pin.pin as pin_new" )
                   ;
            }
            else {

                $list = DB::table(DB::raw($sql))->join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                    ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                             $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                    })
                    ->leftJoin(DB::raw("(select * from chatmessages_pin where userId = $userLogin and threadId = $threadId) as chatmessages_pin"), function($join) {
                                     $join->on('chatmessages.id', '=', 'chatmessages_pin.messageId');
                            })
                    ->where("chatmessages.threadId","=", $threadId)
                    ->where("chatmessages.userDelete","<>", $userLogin)
                    ->where(function ($query)  {
                        $query->where('chatmessages.countChild', '=', 0)
                            ->orWhere('chatmessages.countChild', '=', 1);
                    })
                    ->where(function ($query) use ($userLogin)  {
                        /*$query->where('chatmessages.userIdShowRepeat', '=', 0)
                            ->orWhere('chatmessages.userIdShowRepeat', '=', $userLogin);*/
                            $query->where(['chatmessages.userIdShowRepeat' => 0, 'chatmessages.parentIdRepeat' => 0])
                            ->orWhere(function ($query1) use ($userLogin)  {
                                 $query1->where('chatmessages.userIdShowRepeat', 0)
                                        ->where('chatmessages.parentIdRepeat', '<>',0)
                                        ->where('chatmessages.ownerId', '<>',$userLogin);
                            })
                            ->orWhere('chatmessages.userIdShowRepeat', '=', $userLogin);
                    })
                    //->where("chatmessages.id",">", $lastIdMessage)
                    ->orderBy('chatmessages.id','desc')
                    ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*", "chatmessages_pin.pin as pin_new" )
                   ;
            }
        }
        else {
            if( $idDelete == $userLogin) {
                $list = DB::table(DB::raw($sql))->join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                    ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                             $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                    })
                    ->leftJoin(DB::raw("(select * from chatmessages_pin where userId = $userLogin and threadId = $threadId) as chatmessages_pin"), function($join) {
                                     $join->on('chatmessages.id', '=', 'chatmessages_pin.messageId');
                            })
                    ->where("chatmessages.threadId","=", $threadId)
                    ->where("chatmessages.userDelete","<>", $userLogin)
                    ->where("chatmessages.id",">", $lastIdMessage)
                    ->where(function ($query)  {
                        $query->where('chatmessages.countChild', '=', 0)
                            ->orWhere('chatmessages.countChild', '=', 1);
                    })
                    ->where(function ($query) use ($userLogin) {
                        $query->where('public', '=', 1)
                            ->orWhere('chatmessages.ownerId', '=', $userLogin);
                    })
                    ->where(function ($query) use ($userLogin)  {
                        /*$query->where('chatmessages.userIdShowRepeat', '=', 0)
                            ->orWhere('chatmessages.userIdShowRepeat', '=', $userLogin);*/
                        $query->where(['chatmessages.userIdShowRepeat' => 0, 'chatmessages.parentIdRepeat' => 0])
                            ->orWhere(function ($query1) use ($userLogin)  {
                                 $query1->where('chatmessages.userIdShowRepeat', 0)
                                        ->where('chatmessages.parentIdRepeat', '<>',0)
                                        ->where('chatmessages.ownerId', '<>',$userLogin);
                            })
                            ->orWhere('chatmessages.userIdShowRepeat', '=', $userLogin);
                    })
                    ->orderBy('chatmessages.id','desc')
                    ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*", "chatmessages_pin.pin as pin_new" )
                   ;
            }
            else {
                $list = DB::table(DB::raw($sql))->join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                    ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                             $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                    })
                    ->leftJoin(DB::raw("(select * from chatmessages_pin where userId = $userLogin and threadId = $threadId) as chatmessages_pin"), function($join) {
                                     $join->on('chatmessages.id', '=', 'chatmessages_pin.messageId');
                            })
                    ->where("chatmessages.threadId","=", $threadId)
                    ->where("chatmessages.userDelete","<>", $userLogin)
                    ->where(function ($query)  {
                        $query->where('chatmessages.countChild', '=', 0)
                            ->orWhere('chatmessages.countChild', '=', 1);
                    })
                    ->where(function ($query) use ($userLogin) {
                        $query->where('public', '=', 1)
                            ->orWhere('chatmessages.ownerId', '=', $userLogin);
                    })
                    ->where(function ($query) use ($userLogin)  {
                        /*$query->where('chatmessages.userIdShowRepeat', '=', 0)
                            ->orWhere('chatmessages.userIdShowRepeat', '=', $userLogin);*/
                            $query->where(['chatmessages.userIdShowRepeat' => 0, 'chatmessages.parentIdRepeat' => 0])
                            ->orWhere(function ($query1) use ($userLogin)  {
                                 $query1->where('chatmessages.userIdShowRepeat', 0)
                                        ->where('chatmessages.parentIdRepeat', '<>',0)
                                        ->where('chatmessages.ownerId', '<>',$userLogin);
                            })
                            ->orWhere('chatmessages.userIdShowRepeat', '=', $userLogin);
                    })
                    //->where("chatmessages.id",">", $lastIdMessage)
                    ->orderBy('chatmessages.id','desc')
                    ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*", "chatmessages_pin.pin as pin_new" )
                   ;
            }
        }
        return $list;

    }



    public static function deleteMessSecret($userLogin, $threadId) {
        $deleteMessage  = ChatMessages::join("chatmessageread","chatmessageread.messageId", "=", "chatmessages.id")
        ->where(function ($query) use ($userLogin) {
             $query->whereRaw(" chatmessageread.statusRead = 1 and chatmessages.timeDelete > 0  and
                    (chatmessageread.updated_at) <= (DATE_SUB(current_timestamp, INTERVAL (select timeDelete from chatmessages where chatmessages.id = chatmessageread.messageId ) SECOND)) ");
        })
        ->where("chatmessages.type","=","secret")
        ->where("chatmessages.threadId","=", $threadId)
        ->selectRaw("chatmessages.id, count(chatmessageread.messageId) as countMes, sum(chatmessageread.statusRead) as sumRead")->groupby("chatmessages.id")->get();
        $arrDelete = [];
        foreach($deleteMessage as $k => $v) {
            if($v['countMes'] == 2 && $v['sumRead'] == 2) {
                $arrDelete[] = $v['id'];
            }

        }
        ChatMessages::whereIn('id', $arrDelete)->delete();

    }

    public static function getListSecretAlias($page, $pageSize, $params) {
        //xoa di nhung message 2 ben deu doc het rui
        $submius = Carbon::now()->subSeconds(5);
        $threadId = $params['threadId'];
        $offset = ($page - 1) * $pageSize;
        $userLogin = $params['userLogin'];
        $lastIdMessage = 0;
        $idDelete = 0;
        self::deleteMessSecret($userLogin,$threadId);
        if(isset($params['lastIdMessage'])) {
            $lastIdMessage = $params['lastIdMessage'];
        }
        if(isset($params['idDelete'])) {
            $idDelete = $params['idDelete'];
        }
        $detailThread = ChatThreads::where("id", $threadId)->first();
        $ownerThread = $detailThread->ownerId;
        $typeThread = $detailThread->type;
        if( $idDelete == $userLogin) {
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->join("chatmessageread","chatmessageread.messageId", "=", "chatmessages.id")
                ->join("chatthreaduser","chatthreaduser.userId", "=", "chatmessages.ownerId")
                /*->where(function ($query) use ($userLogin) {
                     $query->where(['chatmessageread.statusRead' => 0, 'chatmessageread.userId' => $userLogin])
                        ->orWhere("chatmessages.timeDelete","<=",0)
                        ->orWhereRaw(" chatmessageread.userId = $userLogin and chatmessageread.statusRead = 1 and  (chatmessageread.updated_at) > (DATE_SUB(current_timestamp, INTERVAL (select timeDelete from chatmessages where chatmessages.id = chatmessageread.messageId ) SECOND)) ");

                })*/
                ->where("chatmessages.type","=","secret")
                ->where("chatmessageread.userId","=", $userLogin)
                //->where("chatmessageread.statusRead","=",0)
                ->where("chatmessages.threadId","=", $threadId)
                ->where("chatthreaduser.threadId","=", $threadId)
                ->where("chatmessages.userDelete","<>", $userLogin)
                ->where("chatmessages.id",">", $lastIdMessage)
                ->orderBy('chatmessages.id','desc')
                ->groupby("chatmessages.id")
                ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*", "chatthreaduser.alias_secret", "chatthreaduser.avatar_secret" )
               ;
        }
        else {
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->join("chatmessageread","chatmessageread.messageId", "=", "chatmessages.id")
                ->join("chatthreaduser","chatthreaduser.userId", "=", "chatmessages.ownerId")
                /*->where(function ($query) use ($userLogin) {
                     $query->where(['chatmessageread.statusRead' => 0, 'chatmessageread.userId' => $userLogin])
                        ->orWhere("chatmessages.timeDelete","<=",0)
                        ->orWhereRaw(" chatmessageread.userId = $userLogin and chatmessageread.statusRead = 1 and  (chatmessageread.updated_at) > (DATE_SUB(current_timestamp, INTERVAL (select timeDelete from chatmessages where chatmessages.id = chatmessageread.messageId ) SECOND)) ");

                })*/
                ->where("chatmessages.type","=","secret")
                ->where("chatmessages.threadId","=", $threadId)
                ->where("chatthreaduser.threadId","=", $threadId)
                ->where("chatmessageread.userId","=", $userLogin)
                ->where("chatmessages.userDelete","<>", $userLogin)
                //->where("chatmessages.id",">", $lastIdMessage)
                ->orderBy('chatmessages.id','desc')
                ->groupby("chatmessages.id")
                ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*" , "chatthreaduser.alias_secret", "chatthreaduser.avatar_secret")
               ;
        }

        return $list;

    }


    public static function sendMessage($arrData) {
        $id = DB::table('chatmessages')->insertGetId($arrData);
        return $id;

    }

    public static function convertDateTotime($date) {
        return (new DateTime($date))->getTimestamp();

    }


    public static function getDetailMesssage($messageId, $userLogin = "") {
        if( $userLogin == "") {
            $info = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->where("chatmessages.id","=", $messageId)
                ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "chatmessages.*" )->first();
        }
        else {
            $info = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                            $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                    })
                ->where("chatmessages.id","=", $messageId)
                ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*" )->first();
        }

        if( $info) {
            $info['created_ts'] = ChatMessages::convertDateTotime($info['createdAt']);
            $info['updated_ts'] = ChatMessages::convertDateTotime($info['updatedAt']);
            if($info['typedata'] =='multiImage') {
                $info['listImage'] = json_decode($info['listImage'], true);
            }
            else {
                $info['listImage'] = [];
            }
            if($info['typedata'] =='product') {
                $infoProduct = self::getDetailProduct($info['productId']);
                $info['infoProduct'] = $infoProduct;
            }
            else {
                $info['infoProduct'] = null;
            }

            $info['share_lat'] = doubleval($info['share_lat']);
            $info['share_lng'] = doubleval($info['share_lng']);

            if($info['typedata'] == 'share_location' ) {
                $created_share = $info['createdAt'];
                $share_time = $info['share_time'];
                if($share_time == 0) {
                    $info['stop_share'] = true;
                    $info['text'] = "Chia sẻ vị trí đã kết thúc";
                }
                else {
                    $time_submius = Carbon::now()->subMinutes($share_time);
                    if($created_share < $time_submius) {
                        $info['stop_share'] = true;
                        $info['stop_share'] = "Chia sẻ vị trí đã kết thúc";
                    }
                    else {
                        $info['stop_share'] = false;
                    }
                }

            }

            $messageId = $info['messageId'];
            if($messageId != 0) {
                $infoMessage = ChatMessages::getDetailMesssage($messageId);
                $info['parentMessage'] = $infoMessage;
            }
            else {
                $info['parentMessage'] = null;
            }
            $info['emoij'] = ChatMessageEmoij::getEmoijMessage($info['id']);
            $info['countElement'] = 0;
            if($info['element'] != null  && $info['element'] != "") {
                $info['element'] = json_decode($info['element'], true);
            }

            if($messageId != 0) {
                $info['parentMessageArr'] = ChatMessages::getArrayMessageParent($messageId, "", $info['element'] );
                if(count($info['parentMessageArr']) >= 2 && $info['element'] != null ) {
                    $info['countElement'] = 1;    
                }      
               
            }
            else {
                $info['parentMessageArr'] = null;
            }
            $user_receive = $info['user_receive'];
            $info['user_receive_name'] = null;
            if($user_receive != 0) {
                $info_user_receive = ChatThreadUser::getInfoUserAlias($user_receive, $userLogin);
                if($info_user_receive) {
                    $info['user_receive_name'] = $info_user_receive['use_fullname'];
                }
            }
            $info['groupChatId'] = $info['threadId'];
            if($info['message_repeat'] == 1) {
                if($info['ownerId'] == $userLogin && $info['parentIdRepeat'] == 0 ) {
                    $info['status_repeat'] = 0;
                }
                else {
                    if($info['parentIdRepeat'] != 0) {
                        $info['status_repeat'] = 1;
                    }
                    else {
                        $info['status_repeat'] = 0;
                    }

                }
            }
            else {
                $info['status_repeat'] = 0;
            }
            

            $parentMessId  = $info['parentMessId'];
            if($parentMessId != 0) {
                $infoSubname = ChatMessages::where("id", $parentMessId)->pluck("subjectName")->first();
                if($infoSubname) {
                    $info['subjectName'] = $infoSubname;
                }

            }



        }
        return $info;

    }

     public static function getDetailMesssageSecret($messageId, $userLogin = "", $threadId) {
        if( $userLogin == "") {
            $info = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->join("chatthreaduser","chatthreaduser.userId","=","chatmessages.ownerId")
                ->where("chatmessages.id","=", $messageId)
                ->where("chatthreaduser.threadId","=", $threadId)
                ->select("tbtt_user.avatar", "chatthreaduser.alias_secret","chatthreaduser.avatar_secret","tbtt_user.use_username","tbtt_user.use_fullname", "chatmessages.*" )->first();
        }
        else {
            $info = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->join("chatthreaduser","chatthreaduser.userId","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                            $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                    })
                ->where("chatmessages.id","=", $messageId)
                ->where("chatthreaduser.threadId","=", $threadId)
                ->select("tbtt_user.avatar","chatthreaduser.alias_secret","chatthreaduser.avatar_secret","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*" )->first();
        }

        if( $info) {
            $info['created_ts'] = ChatMessages::convertDateTotime($info['createdAt']);
            $info['updated_ts'] = ChatMessages::convertDateTotime($info['updatedAt']);
            if($info['typedata'] =='multiImage') {
                $info['listImage'] = json_decode($info['listImage'], true);
            }
            else {
                $info['listImage'] = [];
            }
            if($info['typedata'] =='product') {
                $infoProduct = self::getDetailProduct($info['productId']);
                $info['infoProduct'] = $infoProduct;
            }
            else {
                $info['infoProduct'] = null;
            }

            if($info['typedata'] == 'share_location' ) {
                $created_share = $info['createdAt'];
                $share_time = $info['share_time'];
                $time_submius = Carbon::now()->subMinutes($share_time);
                if($created_share < $time_submius) {
                    $info['stop_share'] = true;
                }
                else {
                    $info['stop_share'] = false;
                }
            }



            $messageId = $info['messageId'];
            if($messageId != 0) {
                $infoMessage = ChatMessages::getDetailMesssage($messageId);
                $info['parentMessage'] = $infoMessage;
            }
            else {
                $info['parentMessage'] = null;
            }
            $info['emoij'] = ChatMessageEmoij::getEmoijMessage($info['id']);
            if($messageId != 0) {
                $info['parentMessageArr'] = ChatMessages::getArrayMessageParent($messageId);
            }
            else {
                $info['parentMessageArr'] = null;
            }

            if($info['message_repeat'] == 1) {
                if($info['ownerId'] == $userLogin && $info['parentIdRepeat'] == 0 ) {
                    $info['status_repeat'] = 0;
                }
                else {
                    $info['status_repeat'] = 1;
                }
            }
            else {
                $info['status_repeat'] = 0;
            }
            $parentMessId  = $info['parentMessId'];
            if($parentMessId != 0) {
                $infoSubname = ChatMessages::where("id", $parentMessId)->pluck("subjectName")->first();
                if($infoSubname) {
                    $info['subjectName'] = $infoSubname;
                }

            }

        }
        return $info;

    }


    public static function getDetailMesssageParent($messageId, $userLogin = "", $element = null) {
        if( $userLogin == "") {
            $info = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->where("chatmessages.id","=", $messageId)
                ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "chatmessages.*" )->first();
        }
        else {
            $info = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                            $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                    })
                ->where("chatmessages.id","=", $messageId)
                ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*" )->first();
        }
        if( $info) {
            $info['created_ts'] = ChatMessages::convertDateTotime($info['createdAt']);
            $info['updated_ts'] = ChatMessages::convertDateTotime($info['updatedAt']);
            if($info['typedata'] =='multiImage') {
                $info['listImage'] = json_decode($info['listImage'], true);
            }
            else {
                $info['listImage'] = [];
            }
            if($info['typedata'] =='product') {
                $infoProduct = self::getDetailProduct($info['productId']);
                $info['infoProduct'] = $infoProduct;
            }
            else {
                $info['infoProduct'] = null;
            }

            $info['share_lat'] = doubleval($info['share_lat']);
            $info['share_lng'] = doubleval($info['share_lng']);
            if($info['typedata'] == 'share_location' ) {
                $created_share = $info['createdAt'];
                $share_time = $info['share_time'];
                $time_submius = Carbon::now()->subMinutes($share_time);
                if($created_share < $time_submius) {
                    $info['stop_share'] = true;
                }
                else {
                    $info['stop_share'] = false;
                }
            }

            if($info['element'] != null  && $info['element'] != "") {
                $info['element'] = json_decode($info['element'], true);
            }
            $info['countElement'] = 0;
            if($element != null) {
                if($info['messageId'] == 0) {
                    $info['element'] = $element;  
                    $info['countElement'] = 1; 
                }
                   
            } 

            /*$messageId = $info['messageId'];
            if($messageId != 0) {
                $infoMessage = ChatMessages::getDetailMesssage($messageId);
                $info['parentMessage'] = $infoMessage;
            }
            else {
                $info['parentMessage'] = null;
            }*/
            $info['emoij'] = ChatMessageEmoij::getEmoijMessage($info['id']);
            /*$lastListMessage = ChatThreads::getListLastMessage($info['threadId'], $userLogin);
            $lastMessage = (object)[];
            if(count($lastListMessage) > 0) {
                //count($lastListMessage)-1
                $lastMessage = ChatThreads::returnInfoLast($lastListMessage[0]);
            }
            $info['lastMessage'] = $lastMessage;
            $info['lastListMessage'] = $lastListMessage;*/


            /*if($messageId != 0) {
                $info['parentMessageArr'] = ChatMessages::getArrayMessageParent($messageId);
            }
            else {
                $info['parentMessageArr'] = null;
            }*/
        }
        return $info;

    }

    public static function getDetailMesssageEmoij($messageId, $userLogin) {
        $info = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin ) as chatuseralias"), function($join) {
                             $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                    })
                ->where("chatmessages.id","=", $messageId)
                ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*" )->first();
        if( $info) {
            $info['created_ts'] = ChatMessages::convertDateTotime($info['createdAt']);
            $info['updated_ts'] = ChatMessages::convertDateTotime($info['updatedAt']);
            if($info['typedata'] =='multiImage') {
                $info['listImage'] = json_decode($info['listImage'], true);
            }
            else {
                $info['listImage'] = [];
            }
            if($info['typedata'] =='product') {
                $infoProduct = self::getDetailProduct($info['productId']);
                $info['infoProduct'] = $infoProduct;
            }
            else {
                $info['infoProduct'] = null;
            }
            if($info['typedata'] == 'share_location' ) {
                $created_share = $info['createdAt'];
                $share_time = $info['share_time'];
                $time_submius = Carbon::now()->subMinutes($share_time);
                if($created_share < $time_submius) {
                    $info['stop_share'] = true;
                }
                else {
                    $info['stop_share'] = false;
                }
            }



            $info['emoij'] = ChatMessageEmoij::getEmoijMessage($info['id']);
            $infoEmoi = ChatMessageEmoij::infoChooseEmoij($info['id'], $userLogin);
            if(count($infoEmoi) > 0) {
                $info['chooseEmoij'] = 1;
                $info['typeEmoij'] = $infoEmoi['emoij'];
                $info['emoijId'] = $infoEmoi['emoijId'];
            }
            else {
                $info['chooseEmoij'] = 0;
                $info['typeEmoij'] = "";
                $info['emoijId'] = 0;
            }
            if($info['messageId'] != 0) {
                $info['parentMessageArr'] = ChatMessages::getArrayMessageParent($info['messageId'], $userLogin);
            }
            else {
                $info['parentMessageArr'] = null;
            }
            $infoGroup = ChatThreads::where("id", $info['threadId'])->first();
            if($infoGroup) {
                if($infoGroup['type'] != 'private') {
                    $statusLastChat = ChatMessages::statusReadOfMessage($infoGroup, $messageId);
                    $info['statusRead'] = $statusLastChat;
                }

            }
            if($info['message_repeat'] == 1) {
                if($info['ownerId'] == $userLogin && $info['parentIdRepeat'] == 0 ) {
                    $info['status_repeat'] = 0;
                }
                else {
                    $info['status_repeat'] = 1;
                }
            }
            else {
                $info['status_repeat'] = 0;
            }

            $parentMessId  = $info['parentMessId'];
            if($parentMessId != 0) {
                $infoSubname = ChatMessages::where("id", $parentMessId)->pluck("subjectName")->first();
                if($infoSubname) {
                    $info['subjectName'] = $infoSubname;
                }

            }

        }
        return $info;

    }

    public static function getArrayMessageParent($messageId, $userLogin = "", $element = null) {
        $arrId = [];
        self::getMessageParentRecurise($messageId, $arrId, $userLogin, $element);
        $arrId = array_reverse($arrId);
        return $arrId;
    }

    public static function getArrayIDMessageParent($messageId) {
        $valuereturn = 0;
        self::getArrIdParentRecurise($messageId, $valuereturn);
        if($messageId == $valuereturn) {
            return 0;
        }
        return $valuereturn;

    }

    public static function getArrIdParentRecurise($messageId, &$valuereturn) {
        $info =  ChatMessages::where("id",$messageId)->select("messageId", "id")->first();
        if($info) {
            $info = $info->toArray();
            $valuereturn = $info['id'];
            if($info['messageId'] != 0) {
                self::getArrIdParentRecurise($info['messageId'], $valuereturn);
            }

        }
    }



    public static function getMessageParentRecurise($messageId, &$arrId, $userLogin = "", $element = null) {
        $info =  ChatMessages::getDetailMesssageParent($messageId, $userLogin, $element);
        if($info) {
            $info = $info->toArray();
            $arrId[] = $info;
            if($info['messageId'] != 0) {
                self::getMessageParentRecurise($info['messageId'], $arrId, $userLogin, $element);
            }
        }
    }

    public static function getMessageParentRecuriseLevel($arrId, $userLogin = "") {
        $arrReturn = [];
        foreach ( $arrId as $k => $v ) {
            $arrReturn[] = ChatMessages::getDetailMesssageParent($v, $userLogin);
        }
        return $arrReturn;


    }


    public static function getArrIdMesRecurise($messageId, &$arrId) {
        $info =  ChatMessages::getDetailMesssageParent($messageId);
        if($info) {
            $info = $info->toArray();
            $arrId[] = $info['id'];
            if($info['messageId'] != 0) {
                self::getArrIdMesRecurise($info['messageId'], $arrId);
            }
        }
    }

    public static function getArrayMessageParentId($messageId) {
        $arrId = [];
        self::getArrIdMesRecurise($messageId, $arrId);
        $arrId = array_reverse($arrId);
        return $arrId;
    }

    public static function getLinkProduct($pro_category, $pro_id, $pro_name) {
        return env('APP_FONTEND_URL', 'http://') . '/' . $pro_category . '/' . $pro_id . '/' . str_slug($pro_name);

    }

    public static function getDetailProduct($productId) {
        $info = Product::where("pro_id", "=", $productId)->select("pro_cost","pro_name","pro_descr","pro_image", "pro_id", "pro_dir","pro_category")->first();
        if( $info) {
            $info = $info->toArray();
            $info['pro_url'] = self::getLinkProduct($info['pro_category'], $info['pro_id'], $info['pro_name']);
            return $info;
        }
        return null;
    }



    public static function getListMessageDeleted($one_week_ago) {
        return false;
        $data = ChatMessages::where("createdAt","<", $one_week_ago)->first();
        if($data) {
            $delete = ChatMessages::where("createdAt","<", $one_week_ago)->delete();
            if( $delete) {
                return 'Xóa dữ liệu message chat thành công';
            }
            else {
                return 'Xóa dữ liệu message chat không thành công';
            }
        }
        else {
            return 'Không có dữ liệu để xóa';
        }

    }

    public static function deleteMessageSecret($timeDelete) {
        $data = ChatMessages::where("createdAt","<", $timeDelete)->where("type","=","secret")->first();
        if($data) {
            $delete = ChatMessages::where("createdAt","<", $one_week_ago)->where("type","=","secret")->delete();
            if( $delete) {
                return 'Xóa dữ liệu message chat bi mat  thành công';
            }
            else {
                return 'Xóa dữ liệu message chat bi mat không thành công';
            }
        }
        else {
            return 'Không có dữ liệu để xóa';
        }

    }


    public static function statusReadOfGroup($infoThread) {
        $count = ChatThreadUser::where(['threadId' => $infoThread['id'], 'accept_request' => 1, 'statusRead' => 0])->count();
        if($count > 0 ) {
            return 0;
        }
        return 1;

    }

    public static function statusReadOfMessage($infoThread, $messageId) {
        $sum = ChatMessageRead::where(['threadId' => $infoThread['id'], 'messageId' => $messageId])->count();
        $count = ChatMessageRead::where(['threadId' => $infoThread['id'], 'messageId' => $messageId, 'statusRead' => 0])->count();
        if($count > 0) {
            if( $count == ($sum -1 )) {
                return 0;
            }
            else {
                return 1;
            }
        }
        else {
            return 2;
        }


    }

    public static function statusReadOfUser($infoThread, $messageId, $userId) {
        $info = ChatMessageRead::where(['threadId' => $infoThread['id'], 'messageId' => $messageId, 'userId' => $userId])->first();
        if($info){
            $info->timeRead = (new DateTime($info['updated_at']))->getTimestamp();
            return $info;
        }
        return null;




    }

    public static function statusLastChat($infoThread) {
        $infoLast = ChatMessages::where(['threadId' => $infoThread['id']])->orderby('createdAt','desc')->limit(0,1)->first();
        $userId = $infoLast['ownerId'];
        if($infoThread['ownerId'] == $userId) {
            $infoStatus = ChatThreadUser::where(['threadId' => $infoThread['id'],'userId' => $infoThread['requesterId']])->first();

            return $infoStatus['statusRead'];
        }
        else {
            $infoStatus = ChatThreadUser::where(['threadId' => $infoThread['id'],'userId' => $infoThread['ownerId']])->first();
            return $infoStatus['statusRead'];
        }
    }

    public static function getTimeReadOfUser($userId, $threadId) {
        $info = ChatMessageRead::where(['userId' => $userId, 'threadId' => $threadId, 'statusRead' => 1])->orderby('updated_at','desc')->first();
        if($info) {
            return (new DateTime($info['updated_at']))->getTimestamp();
        }
        return 0;
    }

    public static function showChildMessage($parent_id, $userLogin, &$arrReturn, $page, $pageSize, $cond)
    {

        if( $cond == 0) {

            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatmessages.messageId", $parent_id)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->select("tbtt_user.use_id as use_id","chatmessages.id as messageId","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("messageId",'asc')
                ->get()->toArray();
        }
        else {
            $offset = ($page - 1 ) * $pageSize;
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatmessages.messageId", $parent_id)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->select("tbtt_user.use_id as use_id","chatmessages.id as messageId","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("messageId",'desc')
                ->offset($offset)
                ->limit($pageSize)
                ->get()->toArray();
        }
        if($list) {
            foreach ($list as $key => $item)
            {
                $arrReturn[] = $item;
                unset($list[$key]);
                self::showChildMessage( $item['messageId'], $userLogin, $arrReturn, $page, $pageSize, 0);
            }
        }

    }

    public static function showChildMessage1($parent_id, $userLogin, $userId, &$arrReturn, $page, $pageSize, $cond, $threadId)
    {
        if( $cond == 0) {
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatmessages.messageId", $parent_id)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->whereIn('chatmessages.ownerId', [$userLogin,$userId])
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") {
                        $query->where('chatmessages.threadId', '=', $threadId);

                    }

                })
                ->select("tbtt_user.use_id as use_id", "chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'asc')
                ->get()->toArray();
        }
        else {
            $offset = ($page - 1 ) * $pageSize;
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatmessages.messageId", $parent_id)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->whereIn('chatmessages.ownerId', [$userLogin,$userId])
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") {
                        $query->where('chatmessages.threadId', '=', $threadId);

                    }

                })
                ->select("tbtt_user.use_id as use_id","chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'desc')
                ->offset($offset)
                ->limit($pageSize)
                ->get()->toArray();
        }
        if($list) {
            foreach ($list as $key => $item)
            {
                $arrReturn[] = $item;
                self::showChildMessage1( $item['id'], $userLogin, $userId, $arrReturn, $page, $pageSize, 0, $threadId);
                //unset($list[$key]);
            }
        }

    }

    public static function showChildMessageAll($parent_id, $userLogin, $userId, &$arrReturn, $page, $pageSize, $cond, $threadId = "")
    {
        if( $cond == 0) {
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatmessages.messageId", $parent_id)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") {
                        $query->where('chatmessages.threadId', '=', $threadId);

                    }

                })
                ->select("tbtt_user.use_id as use_id", "chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'asc')
                ->get()->toArray();
        }
        else {
            $offset = ($page - 1 ) * $pageSize;
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatmessages.messageId", $parent_id)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") {
                        $query->where('chatmessages.threadId', '=', $threadId);

                    }

                })
                ->select("tbtt_user.use_id as use_id","chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'desc')
                ->offset($offset)
                ->limit($pageSize)
                ->get()->toArray();
        }
        if($list) {
            foreach ($list as $key => $item)
            {
                $arrReturn[] = $item;
                self::showChildMessageAll( $item['id'], $userLogin, $userId, $arrReturn, $page, $pageSize, 0, $threadId);
                //unset($list[$key]);
            }
        }

    }

    public static function detailUserReplyImageMessage($userLogin, $parent_id, $threadId, $element) {
        $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where(function ($query) use ($parent_id) {
                    $query->where("chatmessages.parentMessId", $parent_id)
                            ->orWhere("chatmessages.id", $parent_id);
                })
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") {
                        $query->where('chatmessages.threadId', '=', $threadId);
                    }
                })
                ->where(function ($query) use ($element, $parent_id) {
                    if($element != "") { 
                        $query->where('chatmessages.id', '=', $parent_id)
                                ->orWhere('chatmessages.element', 'like', '%' . $element . '%'); 

                    } 

                })
                //->where('chatmessages.element', 'like', '%' . $element . '%')
                ->select("tbtt_user.use_id as use_id", "chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'asc');
        return $list; 
    }

    public static function detailUserReplymessage($userLogin, $parent_id, $threadId) {
        $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where(function ($query) use ($parent_id) {
                    $query->where("chatmessages.parentMessId", $parent_id)
                            ->orWhere("chatmessages.id", $parent_id);
                })
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") {
                        $query->where('chatmessages.threadId', '=', $threadId);
                    }
                }) 
                ->where("chatmessages.element", null)
                ->select("tbtt_user.use_id as use_id", "chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'asc');
        return $list;
    }

    public static function detailUserReplymessagePrivate($userLogin, $userId, $parent_id, $threadId, $cond) {
        if( $cond == 0) {
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                        $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where(function ($query) use ($parent_id) {
                    $query->where("chatmessages.parentMessId", $parent_id)
                            ->orWhere("chatmessages.id", $parent_id);
                })
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->whereIn('chatmessages.ownerId', [$userLogin,$userId])
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") {
                        $query->where('chatmessages.threadId', '=', $threadId);

                    }

                })
                ->where("chatmessages.element", null)
                ->select("tbtt_user.use_id as use_id", "chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'asc');

        }
        else {
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where(function ($query) use ($parent_id) {
                    $query->where("chatmessages.parentMessId", $parent_id)
                            ->orWhere("chatmessages.id", $parent_id);
                })
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->whereIn('chatmessages.ownerId', [$userLogin,$userId])
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") {
                        $query->where('chatmessages.threadId', '=', $threadId);
                    }
                })
                ->where("chatmessages.element", null)
                ->select("tbtt_user.use_id as use_id","chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'desc');

        }
        return $list;
    }

    public static function detailUserReplymessageImagePrivate($userLogin, $userId, $parent_id, $threadId, $cond, $element) {
        if( $cond == 0) {
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                        $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where(function ($query) use ($parent_id) {
                    $query->where("chatmessages.parentMessId", $parent_id)
                            ->orWhere("chatmessages.id", $parent_id);
                })
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->whereIn('chatmessages.ownerId', [$userLogin,$userId])
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") { 
                        $query->where('chatmessages.threadId', '=', $threadId);

                    }

                })
                ->where(function ($query) use ($element, $parent_id) {
                    if($element != "") { 
                        $query->where('chatmessages.id', '=', $parent_id)
                                ->orWhere('chatmessages.element', 'like', '%' . $element . '%'); 

                    } 

                })
                
                ->select("tbtt_user.use_id as use_id", "chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'asc');

        }
        else {
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where(function ($query) use ($parent_id) {
                    $query->where("chatmessages.parentMessId", $parent_id)
                            ->orWhere("chatmessages.id", $parent_id);
                })
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->whereIn('chatmessages.ownerId', [$userLogin,$userId])
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") {
                        $query->where('chatmessages.threadId', '=', $threadId);
                    }
                })
                ->where(function ($query) use ($element, $parent_id) {
                    if($element != "") { 
                        $query->where('chatmessages.id', '=', $parent_id)
                                ->orWhere('chatmessages.element', 'like', '%' . $element . '%'); 

                    } 

                })
                //->where('chatmessages.element', 'like', '%' . $element . '%')
                ->select("tbtt_user.use_id as use_id","chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'desc');

        }
        return $list;
    }


    public static function showChildMessageP2P($parent_id, $userLogin, $userMesOrigin, $userId, &$arrReturn, $page, $pageSize, $cond)
    {
        if( $cond == 0) {
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatmessages.messageId", $parent_id)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->whereIn('chatmessages.ownerId', [$userMesOrigin,$userId])
                ->select("tbtt_user.use_id as use_id", "chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'asc')
                ->get()->toArray();
        }
        else {
            $offset = ($page - 1 ) * $pageSize;
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatmessages.messageId", $parent_id)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->whereIn('chatmessages.ownerId', [$userMesOrigin,$userId])
                ->select("tbtt_user.use_id as use_id","chatmessages.*","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->orderby("chatmessages.id",'desc')
                ->offset($offset)
                ->limit($pageSize)
                ->get()->toArray();
        }
        if($list) {
            foreach ($list as $key => $item)
            {
                $arrReturn[] = $item;
                self::showChildMessageP2P( $item['id'], $userLogin, $userMesOrigin, $userId, $arrReturn, $page, $pageSize, 0);
                //unset($list[$key]);
            }
        }

    }


    public static function listUserAnswerMessage1($page, $pageSize,$messageId, $userLogin) {
        $arrReturn = [];
        $cond = 1;
        self::showChildMessage($messageId, $userLogin, $arrReturn, $page, $pageSize, $cond);
        return $arrReturn;


    }

    public static function sumUserAnswerMessage($messageId, $userLogin) {
        $count = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->where("chatmessages.messageId", $messageId)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->count();
        return $count;

    }


    public static function listUserAnswerMessage($page, $pageSize,$messageId, $userLogin, $arrIdRecu = null) {
        $detailMessage = ChatMessages::where("id", $messageId)->first();
        $threadId = $detailMessage->threadId;
        $detailThread = ChatThreads::where("id", $threadId)->first();
        $ownerThread = $detailThread->ownerId;
        $ownerMessage = $detailMessage->ownerId;
        $offset = ($page - 1) * $pageSize;
        if($arrIdRecu == null) {
            $arrIdRecu = self::getArrayMessageParentId($messageId);
        }

        if( ($userLogin == $ownerThread) || ($userLogin == $ownerMessage) )  {
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                /*->where("chatmessages.messageId", $messageId)*/
                ->whereIn("chatmessages.messageId", $arrIdRecu)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->offset($offset)
                ->limit($pageSize)
                ->select("tbtt_user.use_id as use_id","chatmessages.threadId","chatmessages.id as messageId","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->groupby("tbtt_user.use_id");

        }
        else {
            $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                /*->where("chatmessages.messageId", $messageId)*/
                ->whereIn("chatmessages.messageId", $arrIdRecu)
                ->where(function ($query) use ($userLogin) {
                    $query->where('public', '=', 1)
                            ->orWhere('chatmessages.ownerId', '=', $userLogin);
                })
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->offset($offset)
                ->limit($pageSize)
                ->select("tbtt_user.use_id as use_id" ,"chatmessages.threadId","chatmessages.id as messageId","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->groupby("tbtt_user.use_id");
        }
        return $list;

    }

    public static function listUserAnswerMessageCond($page, $pageSize,$messageId, $userLogin) {
        $detailMessage = ChatMessages::where("id", $messageId)->first();
        $offset = ($page - 1) * $pageSize;
        $mesId = $detailMessage->messageId;
        $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatmessages.id", $mesId)
                ->where(function ($query) use ($userLogin) {
                    $query->where('public', '=', 1)
                            ->orWhere('chatmessages.ownerId', '=', $userLogin);
                })
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->offset($offset)
                ->limit($pageSize)
                ->select("tbtt_user.use_id as use_id","chatmessages.threadId","chatmessages.id as messageId","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->groupby("tbtt_user.use_id");
        return $list;

    }

    public static function listReplyMessage($page, $pageSize,$messageId, $userId, $userLogin) {
        $offset = ($page - 1) * $pageSize;
        $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                                         $join->on('chatmessages.ownerId', '=', 'chatuseralias.userId_alias');
                                })
                            ->where(['messageId' => $messageId])
                            ->where("chatmessages.userDelete",'<>', $userLogin)
                            //->where("chatmessages.ownerId",'=', $userId)
                            ->offset($offset)
                            ->limit($pageSize)
                            ->select("chatmessages.*", "tbtt_user.use_id as use_id","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                            ;
        return $list;
    }

    public static function listReplyMessage1($page, $pageSize,$messageId, $userId, $userLogin, $threadId = "") {
        $arrReturn = [];
        self::getMessageParentRecurise($messageId, $arrReturn);
        $arrReturn = array_reverse($arrReturn);
        $cond = 0;
        self::showChildMessage1($messageId, $userLogin, $userId, $arrReturn, $page, $pageSize, $cond, $threadId);
        return $arrReturn;
    }

    public static function listReplyMessageAll($page, $pageSize,$messageId, $userId, $userLogin, $threadId = "") {
        $arrReturn = [];
        self::getMessageParentRecurise($messageId, $arrReturn);
        $arrReturn = array_reverse($arrReturn);
        $cond = 0;
        self::showChildMessageAll($messageId, $userLogin, $userId , $arrReturn, $page, $pageSize, $cond, $threadId);
        return $arrReturn;
    }


    public static function listReplyMessageP2P($page, $pageSize,$messageId, $userId, $userMesOrigin, $userLogin) {
        $info =  ChatMessages::getDetailMesssageParent($messageId);
        $arrReturn = [$info];
        $cond = 0;
        self::showChildMessageP2P($messageId, $userLogin, $userMesOrigin, $userId, $arrReturn, $page, $pageSize, $cond);
        return $arrReturn;
    }

    public static function countReplyMessage1($messageId, $userId, $userLogin, $threadId = "") {
        $count = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->where("chatmessages.messageId", $messageId)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->whereIn('ownerId', [$userLogin,$userId])
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") {
                        $query->where('chatmessages.threadId', '=', $threadId);

                    }

                })
                ->count();
        return $count;
    }

    public static function countReplyMessage($messageId, $userId, $userLogin, $threadId = "") {
        $count = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->where("chatmessages.messageId", $messageId)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->where(function ($query) use ($threadId) {
                    if($threadId != "") {
                        $query->where('chatmessages.threadId', '=', $threadId);

                    }

                })
                //->whereIn('ownerId', [$userLogin,$userId])
                ->count();
        return $count;
    }

     public static function countReplyMessageP2P($messageId, $userId,$userMesOrigin, $userLogin) {
        $count = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->where("chatmessages.messageId", $messageId)
                ->where("chatmessages.userDelete",'<>', $userLogin)
                ->whereIn('ownerId', [$userMesOrigin,$userId])
                ->count();
        return $count;
    }

    public static function getLastTimeAnswer($messageId, $userId, $userLogin) {
        $info = ChatMessages::where(['messageId' => $messageId])
                            ->where("chatmessages.userDelete",'<>', $userLogin)
                            ->where("chatmessages.ownerId",'=', $userId)
                            ->orderby('id', 'desc')->first();
        if($info) {
            return $info['createdAt'];
        }
        else {
            return "";
        }


    }

    public static function idGroupInforward($userOwnId, $userId, $arrData) {
        $thread = ChatThreads::where(function ($query) use ($userOwnId, $userId)  {
                     $query->where(['chatthreads.ownerId' => $userOwnId, 'chatthreads.requesterId' => $userId])
                                ->orWhere(['chatthreads.ownerId' => $userId, 'chatthreads.requesterId' => $userOwnId]);
                })
                ->where("chatthreads.type","=", 'private')->first();
        if( $thread) {
            DB::table('chatthreads')->where("id", "=", $thread->id )->update(['userDeleteGroup' => 0]);
            return $thread->id;
        }
        else {
            $id = DB::table('chatthreads')->insertGetId($arrData);
            $arr = [$userOwnId, $userId];
            ChatThreadUser::addUserToGroup($id, $arr, 1 );
            return $id;
        }

    }

    public static function forwardMessage($infoMessage, $userForward, $userSend, $element = "") {
        $arrThread = [
            'type'=> 'private',
            'ownerId' => $userForward,
            'requesterId' => $userSend,
            'typechat'  => 2,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s'),
        ];
        $threadId = self::idGroupInforward($userForward, $userSend, $arrThread);
        if($element == "") {
            $arrData = [
                    'type' => 'private',
                    'ownerId' => $userForward,
                    'threadId' => $threadId,
                    'text' => $infoMessage->text,
                    'typedata' => $infoMessage->typedata,
                    'width' => $infoMessage->width,
                    'height' => $infoMessage->height,
                    'size' => $infoMessage->size,
                    'productId' => $infoMessage->productId,
                    'listImage' => $infoMessage->listImage,
                    'caption' =>$infoMessage->caption

                ];
        }
        else {
            $element_width = 0;
            $element_height = 0;
            $element_size = "";
            $element_caption = "";
            $element_text = "";
            if(isset($element['width'])) {
                $element_width = $element['width'];
            }
            if(isset($element['height'])) {
                $element_height = $element['height'];
            }
            if(isset($element['size'])) {
                $element_size = $element['size'];
            }
            if(isset($element['caption'])) {
                $element_caption = $element['caption'];
            }
            if(isset($element['image'])) {
                $element_text = $element['image'];
            }
            $arrData = [
                    'type' => 'private',
                    'ownerId' => $userForward,
                    'threadId' => $threadId,
                    'text' => $element_text,
                    'typedata' => 'image',
                    'width' => $element_width,
                    'height' => $element_height,
                    'size' => $element_size,
                    'productId' => 0,
                    'listImage' => null,
                    'caption' => $element_caption
                ];
        }

        $id = DB::table('chatmessages')->insertGetId($arrData);
        ChatUserRead::updateCountMessageUnreadUser($threadId, $userSend);
        ChatMessageRead::createRowMessageUser(['messageId' => $id, 'threadId' => $threadId, 'userId' => $userSend ]);
        $detail = ChatMessages::getDetailMesssage($id);
        $detail['reload'] = 1;
        $info = ChatThreads::where("id", "=", $threadId)->first();
        if($info) {
            $info = $info->toArray();
            $detail['groupChatId'] = $info['id'];

        }
        $infoA = ChatThreadUser::where(['userId' => $userForward, 'threadId' => $threadId])->first();
        if($infoA) {
            $infoA =  $infoA->toArray();
            $detail['blocked'] = $infoA['blocked'];
            $detail['blockedNotify'] = $infoA['blockedNotify'];

        }
        if($info['requesterId'] != $userForward) {
            $infoB = ChatThreadUser::where(['userId' => $info['requesterId'] , 'threadId' => $threadId])->first();
            if($infoB) {
                $infoB =  $infoB->toArray();
                $detail['blocked_B'] = $infoB['blocked'];
                $detail['blockedNotify_B'] = $infoB['blockedNotify'];
            }
            $userGroup = User::where(['use_id' => $info['requesterId'] ])->select("use_fullname")->first();
                $detail['namegroup'] = $userGroup['use_fullname'];

        }
        else {
            $infoB = ChatThreadUser::where(['userId' => $info['ownerId'] , 'threadId' => $threadId])->first();
            if($infoB) {
                $infoB =  $infoB->toArray();
                $detail['blocked_B'] = $infoB['blocked'];
                $detail['blockedNotify_B'] = $infoB['blockedNotify'];

            }
            $userGroup = User::where(['use_id' => $info['ownerId'] ])->select("use_fullname")->first();
                $detail['namegroup'] = $userGroup['use_fullname'];

        }
        return $detail;
    }

    public static function forwardMessageInGroup($infoMessage, $userForward, $threadId, $element = "") {
        if( $element == "" ) {
            $arrData = [
                    'type' => 'group',
                    'ownerId' => $userForward,
                    'threadId' => $threadId,
                    'text' => $infoMessage->text,
                    'typedata' => $infoMessage->typedata,
                    'width' => $infoMessage->width,
                    'height' => $infoMessage->height,
                    'size' => $infoMessage->size,
                    'listImage' => $infoMessage->listImage,
                    'productId' => $infoMessage->productId,
                    'caption' =>$infoMessage->caption
                ];
        }
        else {
            $element_width = 0;
            $element_height = 0;
            $element_size = "";
            $element_caption = "";
            $element_text = "";
            if(isset($element['width'])) {
                $element_width = $element['width'];
            }
            if(isset($element['height'])) {
                $element_height = $element['height'];
            }
            if(isset($element['size'])) {
                $element_size = $element['size'];
            }
            if(isset($element['caption'])) {
                $element_caption = $element['caption'];
            }
            if(isset($element['image'])) {
                $element_text = $element['image'];
            }
            $arrData = [
                    'type' => 'group',
                    'ownerId' => $userForward,
                    'threadId' => $threadId,
                    'text' => $element_text,
                    'typedata' => 'image',
                    'width' => $element_width,
                    'height' => $element_height,
                    'size' => $element_size,
                    'listImage' => null,
                    'productId' => 0,
                    'caption' => $element_caption
                ];
        }

        $id = DB::table('chatmessages')->insertGetId($arrData);
        $detail = ChatMessages::getDetailMesssage($id);
        $detail['reload'] = 1;
        $info = ChatThreads::where("id", "=", $threadId)->first();
        if($info) {
            $info = $info->toArray();
            $detail['groupChatId'] = $info['id'];
        }
        $infoA = ChatThreadUser::where(['userId' => $userForward, 'threadId' => $threadId])->first();
        if($infoA) {
            $infoA =  $infoA->toArray();
            $detail['blocked'] = $infoA['blocked'];
            $detail['blockedNotify'] = $infoA['blockedNotify'];

        }
        if($info['requesterId'] != $userForward) {
            $infoB = ChatThreadUser::where(['userId' => $info['requesterId'] , 'threadId' => $threadId])->first();
            if($infoB) {
                $infoB =  $infoB->toArray();
                $detail['blocked_B'] = $infoB['blocked'];
                $detail['blockedNotify_B'] = $infoB['blockedNotify'];
            }
            $userGroup = User::where(['use_id' => $info['requesterId'] ])->select("use_fullname")->first();
                $detail['namegroup'] = $userGroup['use_fullname'];
        }
        else {
            $infoB = ChatThreadUser::where(['userId' => $info['ownerId'] , 'threadId' => $threadId])->first();
            if($infoB) {
                $infoB =  $infoB->toArray();
                $detail['blocked_B'] = $infoB['blocked'];
                $detail['blockedNotify_B'] = $infoB['blockedNotify'];
            }
            $userGroup = User::where(['use_id' => $info['ownerId'] ])->select("use_fullname")->first();
                $detail['namegroup'] = $userGroup['use_fullname'];
        }
        return $detail;

    }

    public static function checkMessageHasReply($messageId) {
        $check = ChatMessages::where("messageId", "=", $messageId)->first();
        if($check) {
            return true;
        }
        return false;

    }

    public static function getOriginMesRecurise($messageId, &$arrId) {
        $info =  ChatMessages::getDetailMesssageParent($messageId);
        if($info) {
            $info = $info->toArray();
            $arrId[] = $info['id'];
            if($info['messageId'] != 0) {
                self::getArrIdMesRecurise($info['messageId'], $arrId);
            }
        }
    }


    public static function getArrChildMessage($parent_id, $userLogin, &$arrReturn)
    {

        $list = ChatMessages::where("chatmessages.messageId", $parent_id)
                ->select("chatmessages.id as messageId")
                ->where("chatmessages.userDelete","<>", $userLogin)
                ->orderby("messageId",'asc')
                ->select("id")
                ->get()->toArray();
        if($list) {
            foreach ($list as $key => $item)
            {
                $arrReturn[] = $item['id'];
                self::getArrChildMessage( $item['id'], $userLogin, $arrReturn);
                unset($list[$key]);
            }
        }

    }

    public static function getArrElementChild($parent_id, $userLogin, $cond = 0, $value_loop = 2) {
        $arrReturn = [];
        ChatMessages::getArrChildMessage($parent_id, $userLogin, $arrReturn);
        arsort($arrReturn);
        if($cond == 1) {
            return $arrReturn;
        }
        $arr = [];
        $i = 0;
        foreach( $arrReturn as $k => $v) {
            $arr[] = $v;
            $i++;
            if($i == $value_loop) {
                break;
            }
        }
        return $arr;
    }




    public static function getArrElementUserChild($parent_id, $userLogin, $cond = 0, $value_loop = 2) {
        $arrReturn = [];
        ChatMessages::getArrUserChildMessage($parent_id, $userLogin, $arrReturn);
        arsort($arrReturn);
        if($cond == 1) {
            return $arrReturn;
        }
        $arr = [];
        $i = 0;
        foreach( $arrReturn as $k => $v) {
            $arr[] = $v;
            $i++;
            if($i == $value_loop) {
                break;
            }
        }
        return $arr;
    }

    public static function getArrUserChildMessage($parent_id, $userLogin, &$arrReturn)
    {

        $list = ChatMessages::where("chatmessages.messageId", $parent_id)
                ->select("chatmessages.id as messageId")
                ->where("chatmessages.userDelete","<>", $userLogin)
                ->orderby("messageId",'asc')
                ->select("ownerId", "id")
                ->get()->toArray();
        if($list) {
            foreach ($list as $key => $item)
            {
                $arrReturn[] = $item['ownerId'];
                self::getArrUserChildMessage( $item['id'], $userLogin, $arrReturn);
                unset($list[$key]);
            }
        }

    }

    public static function pushNotiRepeatConversation_v1() {

        $date_time_now = date('Y-m-d H:i:00');
        //$date_time_now = "2018-06-06 15:04:00";
        $listMessages = ChatMessages::where("message_repeat", "=", 1)
                                    ->where("time_repeat", "<>", 0)
                                    ->where("time_set_repeat", "=", $date_time_now)
                                    ->select("id", 'threadId', 'ownerId', 'time_repeat','createdAt')
                                    ->get()->toArray();



        foreach($listMessages as $k => $v ) {
            $id = $v['id'];
            $threadId = $v['threadId'];
            $ownerId = $v['ownerId'];
            $userLogin = $ownerId;
            $listUserOfThread = ChatThreadUser::where(['threadId' => $threadId, 'accept_request' => 1])
                ->where("userId", "<>", $ownerId)
                ->select("userId")->pluck("userId")->toArray();
            $listUser = ChatMessages::where(function ($query) use ($id) {
                            $query->where('parentMessId', '=', $id)
                                    ->orWhere("parentIdRepeat", "=", $id);

                        })
                        ->where("chatmessages.ownerId", "<>", $userLogin)
                        ->distinct("ownerId")->pluck("ownerId");

            if($listUser) {
                $listUser = $listUser->toArray();
                $arr_dif=array_diff($listUserOfThread,$listUser);
                // created new message;

                if(count($arr_dif) > 0) {
                    $detailCreate = ChatMessages::where("id", $id)->first()->toArray();
                    foreach ( $arr_dif as $kk => $vv ) {
                        $detailCreate['parentIdRepeat']  = $id;
                        $detailCreate['userIdShowRepeat']  = $vv;
                        $detailCreate['time_set_repeat'] = null;
                        $detailCreate['time_repeat'] = 0;
                        $detailCreate['createdAt'] = date('Y-m-d H:i:s');
                        $detailCreate['updatedAt'] = date('Y-m-d H:i:s');

                        unset($detailCreate['id']);
                        $idcreate = ChatMessages::insertGetId($detailCreate);
                        $data_Created = ChatMessages::getDetailMesssage($idcreate, $userLogin);
                        $dataPushnotification = [
                            "use_id" => $userLogin,
                            "userIds" => [$vv],
                            "detail" => $data_Created
                        ];
                        Log::info(json_encode($data_Created));
                        dispatch(new SendChatNotification('repeat-conversation',$dataPushnotification));

                    }


                }

            }
            else {
                if(count($listUserOfThread) > 0) {

                    foreach ( $listUserOfThread as $kk => $vv ) {
                        $detailCreate['parentIdRepeat']  = $id;
                        $detailCreate['userIdShowRepeat']  = $vv;
                        $detailCreate['time_set_repeat'] = null;
                        $detailCreate['time_repeat'] = 0;
                        $detailCreate['createdAt'] = date('Y-m-d H:i:s');
                        $detailCreate['updatedAt'] = date('Y-m-d H:i:s');
                        unset($detailCreate['id']);
                        $idcreate = ChatMessages::insertGetId($detailCreate);
                        $data_Created = ChatMessages::getDetailMesssage($idcreate, $userLogin);
                        $dataPushnotification = [
                            "use_id" => $userLogin,
                            "userIds" => [$vv],
                            "detail" => $data_Created
                        ];
                        Log::info(json_encode($dataPushnotification));
                        dispatch(new SendChatNotification('repeat-conversation',$dataPushnotification));


                    }


                }

            }

        }
    }

    public static function pushNotiRepeatConversation() {

        $date_time_now = date('Y-m-d H:i:00');
        //$date_time_now = "2018-06-06 15:04:00";
        $listMessages = ChatMessages::where("message_repeat", "=", 1)
                                    ->where("time_repeat", "<>", 0)
                                    ->where("time_set_repeat", "=", $date_time_now)
                                    ->select("id", 'threadId', 'ownerId', 'time_repeat','createdAt')
                                    ->get()->toArray();



        foreach($listMessages as $k => $v ) {
            $id = $v['id'];
            $threadId = $v['threadId'];
            $ownerId = $v['ownerId'];
            $userLogin = $ownerId;
            $listUserOfThread = ChatThreadUser::where(['threadId' => $threadId, 'accept_request' => 1])
                ->where("userId", "<>", $ownerId)
                ->select("userId")->pluck("userId")->toArray();

            if($listUserOfThread) {
                $arr_dif= $listUserOfThread;
                // created new message;

                if(count($arr_dif) > 0) {
                    $detailCreate = ChatMessages::where("id", $id)->first()->toArray();
                    $detailCreate['parentIdRepeat']  = $id;
                    $detailCreate['userIdShowRepeat']  = 0;
                    $detailCreate['time_set_repeat'] = null;
                    $detailCreate['time_repeat'] = 0;
                    $detailCreate['createdAt'] = date('Y-m-d H:i:s');
                    $detailCreate['updatedAt'] = date('Y-m-d H:i:s');
                    unset($detailCreate['id']);
                    $idcreate = ChatMessages::insertGetId($detailCreate);
                    $data_Created = ChatMessages::getDetailMesssage($idcreate, $userLogin);
                    $dataPushnotification = [
                        "use_id" => $userLogin,
                        "userIds" => $listUserOfThread,
                        "detail" => $data_Created
                    ];
                    dispatch(new SendChatNotification('repeat-conversation',$dataPushnotification));

                }

            }
            else {
                if(count($listUserOfThread) > 0) {

                    $detailCreate['parentIdRepeat']  = $id;
                    $detailCreate['userIdShowRepeat']  = 0;
                    $detailCreate['time_set_repeat'] = null;
                    $detailCreate['time_repeat'] = 0;
                    $detailCreate['createdAt'] = date('Y-m-d H:i:s');
                    $detailCreate['updatedAt'] = date('Y-m-d H:i:s');
                    unset($detailCreate['id']);
                    $idcreate = ChatMessages::insertGetId($detailCreate);
                    $data_Created = ChatMessages::getDetailMesssage($idcreate, $userLogin);
                    $dataPushnotification = [
                        "use_id" => $userLogin,
                        "userIds" => $listUserOfThread,
                        "detail" => $data_Created
                    ];
                    dispatch(new SendChatNotification('repeat-conversation',$dataPushnotification));
                }
            }

        }
    }

    public static function getListAnswerImage($userLogin, $threadId, $linkImage) {
        $list = ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                    ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                             $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                    })
                    ->where("chatmessages.threadId","=", $threadId)
                    ->where("chatmessages.userDelete","<>", $userLogin) 
                    ->where('chatmessages.element', 'like', '%' . $linkImage . '%')
                    ->orderBy('chatmessages.id','desc')
                    ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*" )
                   ;
        return $list;  
    }

}
