<?php

namespace App\Models;

use App\BaseModel;
use App\Models\ChatThreadUser;
use App\Models\ChatMessages;
use App\Models\ChatUserBackground;
use App\Models\ChatMessageRead;
use App\Models\ChatUserRead;
use App\Models\ChatMessageEmoij;
use App\Models\User;
use DB;
use App\Helpers\Commons;
use Carbon\Carbon;
/**
 * ChatThreads model
 *
 */
class ChatThreads extends BaseModel {

    protected $table = 'chatthreads';
    protected $fillable = [
        'type',
        'namegroup',
        'avatar',
        'ownerId',
        'requesterId',
        'typegroup',
        'typechat',
        'createdAt',
        'updatedAt',
        'alias',
        'idGroupDefault',
        'userDeleteGroup',
        'idDelete'
      ];

    public static function getList($page, $pageSize, $params) {
        $userId = $params['userId'];
        $offset = ($page - 1) * $pageSize;
        $filterSearch = $params['search'];
        $type= $params['type'];
        $arrThreads = [];
        if( $type == 'group') {
            $listUserThread = ChatThreadUser::where("userId", "=", $userId)
            ->where("accept_request", "=", 1)->select("threadId")->get();
            if( count($listUserThread) > 0) {
                foreach( $listUserThread as $k => $v) {
                    $arrThreads[] = $v['threadId'];
                }
            }
        }
        if( $type == 'group') {
            $list = ChatThreads::where(function ($query) use ($userId, $arrThreads)  {
                     $query->whereIn('chatthreads.id', $arrThreads);
                })
                ->join('tbtt_user', function($join) use ( $userId){
                    $join->on('tbtt_user.use_id','=','chatthreads.ownerId');
                    $join->orOn('tbtt_user.use_id','=','chatthreads.requesterId');
                })
                ->where(function ($query) use ($filterSearch) {
                    if( $filterSearch != '') {
                        /*$query->where('chatthreads.namegroup', 'like', '%'.$filterSearch.'%');*/
                        $query->where('tbtt_user.use_username', 'like', '%'.$filterSearch.'%')
                                ->orWhere('tbtt_user.use_fullname', 'like', '%'.$filterSearch.'%')
                                ->orWhere('tbtt_user.use_mobile', 'like', '%'.$filterSearch.'%')
                                ->orWhere('tbtt_user.use_username', 'like', '%'.$filterSearch.'%')
                                ->orWhere('tbtt_user.use_email', 'like', '%'.$filterSearch.'%')
                                ->orWhere('chatthreads.namegroup', 'like', '%'.$filterSearch.'%')
                                ->orWhere('tbtt_user.use_phone', 'like', '%'.$filterSearch.'%');
                    }
                })
                //->where("tbtt_user.use_id","<>", $userId)
                ->where("chatthreads.type","=", $type)
                ->offset($offset)
                ->limit($pageSize)
                ->orderBy('chatthreads.namegroup','asc')
                ->select("tbtt_user.use_id","tbtt_user.use_username","tbtt_user.use_fullname","tbtt_user.avatar","tbtt_user.use_email","tbtt_user.use_phone","tbtt_user.use_mobile","tbtt_user.use_group","tbtt_user.company_name", "chatthreads.id as groupChatId", "chatthreads.namegroup as namegroup","chatthreads.avatar as avatarGroupChat", "chatthreads.type", "chatthreads.typechat")
                ->distinct("groupChatId");
        }
        else {
            $list = ChatThreads::where(function ($query) use ($userId)  {
                     $query->where('chatthreads.ownerId',"=", $userId )
                                ->orWhere('chatthreads.requesterId',"=", $userId);
                })
                ->join(
                    DB::raw("
                        (
                        SELECT max(createdAT) as maxcreated, threadId FROM `chatmessages` group by threadId
                        ) `bins`
                    "), 'chatthreads.id', '=', 'bins.threadId'
                )
                ->join("tbtt_user",function($join){
                    $join->on("tbtt_user.use_id","=","chatthreads.ownerId")
                        ->orOn("tbtt_user.use_id","=","chatthreads.requesterId");
                })
                ->where(function ($query) use ($filterSearch, $userId) {
                    if( $filterSearch != '') {
                        $query->where("tbtt_user.use_id", "<>", $userId)
                            ->where(function ($query1) use ($userId, $filterSearch) {
                                 $query1->where('tbtt_user.use_username', 'like', '%'.$filterSearch.'%')
                                    ->orWhere('tbtt_user.use_fullname', 'like', '%'.$filterSearch.'%')
                                    ->orWhere('tbtt_user.use_phone', 'like', '%'.$filterSearch.'%')
                                    ->orWhere('tbtt_user.use_username', 'like', '%'.$filterSearch.'%')
                                    ->orWhere('tbtt_user.use_email', 'like', '%'.$filterSearch.'%')
                                    ->orWhere('tbtt_user.use_mobile', 'like', '%'.$filterSearch.'%');

                            });
                    }
                })
                ->where("chatthreads.type","=", $type)
                ->where("tbtt_user.use_id","<>", $userId)
                ->orderBy('bins.maxcreated','desc')
                ->groupby("chatthreads.id")
                ->offset($offset)
                ->limit($pageSize)
                ->select("chatthreads.id as groupChatId","chatthreads.namegroup as namegroup",  "chatthreads.ownerId",  "chatthreads.requesterId","chatthreads.avatar as avatarGroupChat", "chatthreads.type", "chatthreads.typechat", "chatthreads.idGroupDefault")
                ;
        }
        return $list;

    }


    public static function getListAlias($page, $pageSize, $params) {
        $userId = $params['userId'];
        $offset = ($page - 1) * $pageSize;
        $filterSearch = $params['search'];
        $type= $params['type'];
        $arrThreads = [];
        if( $type == 'group') {
            $listUserThread = ChatThreadUser::join("chatthreads","chatthreads.id","=","chatthreaduser.threadId")
            ->where("chatthreaduser.userId", "=", $userId)
            ->where("chatthreads.type", "=", 'group')
            ->where("chatthreaduser.accept_request", "=", 1)->select("chatthreaduser.threadId")->get();
            if( count($listUserThread) > 0) {
                foreach( $listUserThread as $k => $v) {
                    $arrThreads[] = $v['threadId'];
                }
            }
        }
        if( $type == 'group') {
            $list = ChatThreads::where(function ($query) use ($userId, $arrThreads)  {
                     $query->whereIn('chatthreads.id', $arrThreads);
                })
                ->join('tbtt_user', function($join) use ( $userId){
                    $join->on('tbtt_user.use_id','=','chatthreads.ownerId');
                    $join->orOn('tbtt_user.use_id','=','chatthreads.requesterId');

                })
                ->leftJoin(
                    DB::raw("
                        (
                        SELECT max(createdAT) as maxcreated, threadId FROM `chatmessages` group by threadId
                        ) `bins`
                    "), 'chatthreads.id', '=', 'bins.threadId'
                )
                ->leftJoin(DB::raw("(select * from chatuserread where userId = $userId) as chatuserread"), function($join) {
                         $join->on('chatthreads.id', '=', 'chatuserread.threadId');
                })
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userId) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->where(function ($query) use ($filterSearch) {
                    if( $filterSearch != '') {
                        /*$query->where('chatthreads.namegroup', 'like', '%'.$filterSearch.'%');*/
                        $query->where('tbtt_user.use_username', 'like', '%'.$filterSearch.'%')
                                ->orWhere('tbtt_user.use_fullname', 'like', '%'.$filterSearch.'%')
                                ->orWhere('tbtt_user.use_mobile', 'like', '%'.$filterSearch.'%')
                                ->orWhere('tbtt_user.use_username', 'like', '%'.$filterSearch.'%')
                                ->orWhere('tbtt_user.use_email', 'like', '%'.$filterSearch.'%')
                                ->orWhere('chatthreads.namegroup', 'like', '%'.$filterSearch.'%')
                                ->orWhere('tbtt_user.use_phone', 'like', '%'.$filterSearch.'%');
                    }
                })
                //->where("tbtt_user.use_id","<>", $userId)
                ->where("chatthreads.type","=", $type)
                ->offset($offset)
                ->limit($pageSize)
                ->orderBy('maxcreated','desc')
                ->select("tbtt_user.use_id","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'),"tbtt_user.avatar","tbtt_user.use_email","tbtt_user.use_phone","tbtt_user.use_mobile","tbtt_user.use_group","tbtt_user.company_name", "chatthreads.id as groupChatId", "chatthreads.namegroup as namegroup","chatthreads.avatar as avatarGroupChat", "chatthreads.type", "chatthreads.typechat", DB::raw('(CASE WHEN chatuserread.countUnread is null THEN 0 ELSE chatuserread.countUnread END) AS countMessage'))
                ->distinct("groupChatId");
        }
        else {
            $sql = "select * from  (select  table1.*, ( CASE WHEN table1.`idGroupDefault` = 1 THEN (select count('*') from chatmessages where chatmessages.ownerId <> $userId and chatmessages.threadId = table1.id and (chatmessages.type = 'private' or chatmessages.type = 'secret') ) ELSE 1 END ) as countDefault  from chatmessages inner join (SELECT id , `ownerId`, requesterId ,idGroupDefault
                        FROM `chatthreads` where ( chatthreads.type='private' or chatthreads.type = 'secret') and (chatthreads.ownerId = $userId or chatthreads.requesterId = $userId)) as table1
                         on chatmessages.threadId = table1.id group by chatmessages.threadId) as abc  where countDefault > 0";
            $list = ChatThreads::where(function ($query) use ($userId)  {
                    $query->where('chatthreads.ownerId',"=", $userId )
                                ->orWhere('chatthreads.requesterId',"=", $userId);

                })
                ->join(DB::raw("($sql) AS abc"),  'chatthreads.id', '=', 'abc.id')
                ->join(
                    DB::raw("
                        (
                        SELECT max(createdAT) as maxcreated, threadId FROM `chatmessages` group by threadId
                        ) `bins`
                    "), 'chatthreads.id', '=', 'bins.threadId'
                )
                ->join("tbtt_user",function($join){
                    $join->on("tbtt_user.use_id","=","chatthreads.ownerId")
                        ->orOn("tbtt_user.use_id","=","chatthreads.requesterId");
                })
                ->leftJoin(DB::raw("(select * from chatuserread where userId = $userId) as chatuserread"), function($join) {
                         $join->on('chatthreads.id', '=', 'chatuserread.threadId');
                })
                ->where(function ($query) use ($filterSearch, $userId) {
                    if( $filterSearch != '') {
                        $query->where("tbtt_user.use_id", "<>", $userId)
                            ->where(function ($query1) use ($userId, $filterSearch) {
                                 $query1->where('tbtt_user.use_username', 'like', '%'.$filterSearch.'%')
                                    ->orWhere('tbtt_user.use_fullname', 'like', '%'.$filterSearch.'%')
                                    ->orWhere('tbtt_user.use_phone', 'like', '%'.$filterSearch.'%')
                                    ->orWhere('tbtt_user.use_username', 'like', '%'.$filterSearch.'%')
                                    ->orWhere('tbtt_user.use_email', 'like', '%'.$filterSearch.'%')
                                    ->orWhere('tbtt_user.use_mobile', 'like', '%'.$filterSearch.'%');

                            });
                    }
                })
                //->where("chatthreads.type","=", $type)
                ->where("tbtt_user.use_id","<>", $userId)
                ->where("chatthreads.userDeleteGroup","<>", $userId)
                ->orderBy('bins.maxcreated','desc')
                ->groupby("chatthreads.id")
                ->offset($offset)
                ->limit($pageSize)
                ->select("chatthreads.id as groupChatId","chatthreads.namegroup as namegroup",  "chatthreads.ownerId",  "chatthreads.requesterId","chatthreads.avatar as avatarGroupChat", "chatthreads.type", "chatthreads.typechat", "chatthreads.idGroupDefault",DB::raw('(CASE WHEN chatuserread.countUnread is null THEN 0 ELSE chatuserread.countUnread END) AS countMessage'))
                ;
        }
        return $list;
    }


    public static function getDetailUserJoinGroup($type,$groupChatId, $userId) {
        if( $type == 'group') {
            $info = ChatThreads::where("id","=", $groupChatId)
                        ->select("chatthreads.id as groupChatId", "chatthreads.namegroup as namegroup","chatthreads.avatar as avatarGroupChat", "chatthreads.type", "chatthreads.typechat","chatthreads.ownerId")
                        ->first()->toArray();
            $ownerId = $info['ownerId'];
            $infoUser = User::where("use_id","=", $ownerId)
                        ->select("tbtt_user.use_id","tbtt_user.use_username","tbtt_user.use_fullname","tbtt_user.avatar","tbtt_user.use_email","tbtt_user.use_phone","tbtt_user.use_mobile","tbtt_user.use_group","tbtt_user.company_name")->first()->toArray();
            $info['background'] = ChatUserBackground::getBackgroundUser(['groupChatId' => $groupChatId, 'userId' => $ownerId]);
            $infoAdmin  = ChatThreads::getInfoIsAdmin($ownerId, $groupChatId);
            $info['admin'] = $infoAdmin['admin'];
            $lastMessage = ChatThreads::getLastMessage($groupChatId);
            $info = array_merge($info, ['lastMessage' => $lastMessage ]);
            $arr = array_merge($info,$infoUser);
            return $arr;

        }
        else {
            $info = ChatThreads::where("id","=", $groupChatId)
                ->select("chatthreads.id as groupChatId","chatthreads.namegroup as namegroup",  "chatthreads.ownerId",  "chatthreads.requesterId","chatthreads.avatar as avatarGroupChat", "chatthreads.type", "chatthreads.typechat", "chatthreads.idGroupDefault")->first()->toArray();
            if( $info['ownerId'] == $userId) {
                $infoUser = ChatThreadUser::getInfoUser($info['requesterId']);
                $info['background'] = ChatUserBackground::getBackgroundUser(['groupChatId' => $groupChatId, 'userId' => $info['requesterId']]);
            }
            else {
                $infoUser = ChatThreadUser::getInfoUser($info['ownerId']);
                $info['background'] = ChatUserBackground::getBackgroundUser(['groupChatId' => $groupChatId, 'userId' => $info['ownerId']]);
            }
            $infoUser['statusRead'] = ChatThreadUser::getStatusReadThreadUser($userId, $info['groupChatId']);
            $threadId = $groupChatId;
            $ownerId = $info['ownerId'];
            $info['show'] = 1;


            if( $info['ownerId'] == $userId && $info['idGroupDefault'] == 1) {
                $check = ChatMessages::where(['threadId' => $threadId, 'ownerId' => $info['requesterId']])->first();
                if(!$check) {
                    $info['show'] = 0;
                }
            }
            $info = array_merge($info, $infoUser);
            $lastMessage = ChatThreads::getLastMessage($info['groupChatId']);
            $info = array_merge($info, ['lastMessage' => $lastMessage ]);
            return $info;

        }
    }

    public static function getDetailUserJoinGroupAlias($type,$groupChatId, $userId, $userLogin) {
        if( $type == 'group') {
            $info = ChatThreads::where("chatthreads.id","=", $groupChatId)
                        ->leftJoin(DB::raw("(select * from chatuserread where userId = $userLogin) as chatuserread"), function($join) {
                                 $join->on('chatthreads.id', '=', 'chatuserread.threadId');
                        })
                        ->select("chatthreads.id as groupChatId", "chatthreads.namegroup as namegroup","chatthreads.avatar as avatarGroupChat", "chatthreads.type", "chatthreads.typechat","chatthreads.ownerId", DB::raw('(CASE WHEN chatuserread.countUnread is null THEN 0 ELSE chatuserread.countUnread END) AS countMessage'))
                        ->first()->toArray();
            $ownerId = $info['ownerId'];
            $infoUser = User::leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin and userId_alias = $userId) as chatuseralias"), function($join) {
                                 $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                        })
                        ->where("use_id","=", $ownerId)
                        ->select("tbtt_user.use_id","tbtt_user.use_username",  DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname') ,"tbtt_user.avatar","tbtt_user.use_email","tbtt_user.use_phone","tbtt_user.use_mobile","tbtt_user.use_group","tbtt_user.company_name")->first()->toArray();
            $info['background'] = ChatUserBackground::getBackgroundUser(['groupChatId' => $groupChatId, 'userId' => $ownerId]);
            /*$infoAdmin  = ChatThreads::getInfoIsAdmin($ownerId, $groupChatId);*/
            $infoAdmin  = ChatThreads::getInfoIsAdmin($userLogin, $groupChatId);
            $info['admin'] = $infoAdmin['admin'];
            /*$lastMessage = ChatThreads::getLastMessage($groupChatId);*/
            //$lastMessage = ChatThreads::getLastMessageAlias($groupChatId, $userLogin);
            $lastListMessage = ChatThreads::getListLastMessage($groupChatId,$userLogin);
            $lastMessage = (object)[];
            if(count($lastListMessage) > 0) {
                $lastMessage = ChatThreads::returnInfoLast($lastListMessage[count($lastListMessage)-1]);
            }

            $info = array_merge($info, ['lastMessage' => $lastMessage ]);
            $info = array_merge($info, ['lastListMessage' => $lastListMessage ]);
            $arr = array_merge($info,$infoUser);

            return $arr;

        }
        else {
            $info = ChatThreads::where("chatthreads.id","=", $groupChatId)
                ->leftJoin(DB::raw("(select * from chatuserread where userId = $userId and threadId = $groupChatId) as chatuserread"), function($join) {
                        $join->on('chatthreads.id', '=', 'chatuserread.threadId');
                })
                ->select("chatthreads.id as groupChatId","chatthreads.namegroup as namegroup",  "chatthreads.ownerId",  "chatthreads.requesterId","chatthreads.avatar as avatarGroupChat", "chatthreads.type", "chatthreads.typechat", "chatthreads.idGroupDefault", DB::raw('(CASE WHEN chatuserread.countUnread is null THEN 0 ELSE chatuserread.countUnread END) AS countMessage'))->first()->toArray();
            if( $info['ownerId'] == $userId) {
                /*$infoUser = ChatThreadUser::getInfoUser($info['requesterId']);*/
                $infoUser = ChatThreadUser::getInfoUserAlias($info['requesterId'], $userLogin);
                $info['background'] = ChatUserBackground::getBackgroundUser(['groupChatId' => $groupChatId, 'userId' => $info['requesterId']]);
                $infoUser['statusRead'] = ChatThreadUser::getStatusReadThreadUser($info['requesterId'], $info['groupChatId']);
            }
            else {
                /*$infoUser = ChatThreadUser::getInfoUser($info['ownerId']);*/
                $infoUser = ChatThreadUser::getInfoUserAlias($info['ownerId'], $userLogin);
                $info['background'] = ChatUserBackground::getBackgroundUser(['groupChatId' => $groupChatId, 'userId' => $info['ownerId']]);
                $infoUser['statusRead'] = ChatThreadUser::getStatusReadThreadUser($info['ownerId'], $info['groupChatId']);
            }

            $threadId = $groupChatId;
            $ownerId = $info['ownerId'];
            $info['show'] = 1;


            if( $info['ownerId'] == $userId && $info['idGroupDefault'] == 1) {
                $check = ChatMessages::where(['threadId' => $threadId, 'ownerId' => $info['requesterId']])->first();
                if(!$check) {
                    $info['show'] = 0;
                }
            }
            $info = array_merge($info, $infoUser);
            /*$lastMessage = ChatThreads::getLastMessage($info['groupChatId']);*/
            //$lastMessage = ChatThreads::getLastMessageAlias($groupChatId, $userLogin);
            $lastListMessage = ChatThreads::getListLastMessage($groupChatId,$userLogin);
            $lastMessage = (object)[];
            if(count($lastListMessage) > 0) {
                $lastMessage = ChatThreads::returnInfoLast($lastListMessage[count($lastListMessage)-1]);
            }

            $info = array_merge($info, ['lastMessage' => $lastMessage ]);
            $info = array_merge($info, ['lastListMessage' => $lastListMessage ]);
            return $info;

        }
    }


    public static function getArrUserPrivate($userId) {
        $list = ChatThreads::where(function ($query) use ($userId)  {
                     $query->where('chatthreads.ownerId',"=", $userId )
                                ->orWhere('chatthreads.requesterId',"=", $userId);
                })
                ->where("chatthreads.type","=", 'private')
                ->select("chatthreads.ownerId", "chatthreads.requesterId")->get();
        $arrId = [];
        if($list) {
            foreach( $list as $k => $v ){
                if($v['ownerId'] == $userId) {
                    $arrId[] = $v['requesterId'];
                }
                else {
                    $arrId[] = $v['ownerId'];
                }
            }
        }
        return $arrId;
    }


    public static function detailGroupPrivate($userId,$groupChatId) {

        $list = ChatThreads::where("chatthreads.id","=", $groupChatId)
                ->select("chatthreads.id as groupChatId", "chatthreads.namegroup as namegroup",  "chatthreads.ownerId",  "chatthreads.requesterId","chatthreads.avatar as avatarGroupChat", "chatthreads.type", "chatthreads.typechat" )->first();

        if($list) {
            $list = $list->toArray();
            if( $list['ownerId'] == $userId) {
                $infoUser = User::where(['use_id' => $list['requesterId'] ])->first()->toArray();
            }
            else {
                $infoUser = User::where(['use_id' => $list['ownerId']])->first()->toArray();
            }

            $list['statusRead'] = ChatThreadUser::getStatusReadThreadUser($userId, $groupChatId);
            $lastMessage = ChatThreads::getLastMessage($groupChatId);
            $list = array_merge($list, $infoUser);
            $list['lastMessage'] = $lastMessage;

        }
        return $list;

    }

    public static function detailGroupPrivateAlias($userId,$groupChatId) {
        $list = ChatThreads::where("chatthreads.id","=", $groupChatId)
                ->select("chatthreads.id as groupChatId", "chatthreads.namegroup as namegroup",  "chatthreads.ownerId",  "chatthreads.requesterId","chatthreads.avatar as avatarGroupChat", "chatthreads.type", "chatthreads.typechat" )->first();
        if($list) {
            $list = $list->toArray();
            if( $list['ownerId'] == $userId) {
                /*$infoUser = User::where(['use_id' => $list['requesterId'] ])->first()->toArray();*/
                $infoUser = ChatThreadUser::getInfoUserAlias($list['requesterId'], $userId);
            }
            else {
                /*$infoUser = User::where(['use_id' => $list['ownerId']])->first()->toArray();*/
                $infoUser = ChatThreadUser::getInfoUserAlias($list['ownerId'], $userId);
            }

            $list['statusRead'] = ChatThreadUser::getStatusReadThreadUser($userId, $groupChatId);
            //$lastMessage = ChatThreads::getLastMessageAlias($groupChatId, $userId);
            $lastListMessage = ChatThreads::getListLastMessage($groupChatId, $userId);
            $lastMessage = (object)[];
            if(count($lastListMessage) > 0) {
                $lastMessage = ChatThreads::returnInfoLast($lastListMessage[count($lastListMessage)-1]);
            }
            $list = array_merge($list, $infoUser);
            $list['lastMessage'] = $lastMessage;
            $list['lastListMessage'] = $lastListMessage;

        }
        return $list;

    }



    public static function getLastMessage($threadId){
        $info = ChatMessages::join('tbtt_user','tbtt_user.use_id',"=","chatmessages.ownerId")
                        ->where('threadId',"=", $threadId)
                        ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "chatmessages.*")->orderby("chatmessages.id","desc")->first();

        if($info) {
            $info = $info->toArray();
            $info['created_ts'] = Commons::convertDateTotime($info['createdAt']);
            $info['updated_ts'] = Commons::convertDateTotime($info['updatedAt']);
            switch ($info['typedata']) {
                case 'product':
                    $info['text'] = $info['use_fullname'] . ' đã gửi 1 sản phẩm';
                    break;

                case 'image':
                    $info['text'] = $info['use_fullname'] . ' đã gửi 1 ảnh';
                    break;

                case 'file':
                    $info['text'] = $info['use_fullname'] . ' đã gửi 1 tập tin';
                    break;

                case 'multiImage':
                    $info['text'] = $info['use_fullname'] . ' đã gửi 1 album';
                    break;

                case 'miss-call':
                    $info['text'] = "Bạn có cuộc gọi nhỡ";
                    break;

                case 'miss-video-call':
                    $info['text'] = "Bạn có cuộc gọi video nhỡ";
                    break;


                default:
                    # code...
                    break;
            }
        }
        else {
            return (object)[];
        }
        return $info;

    }


    public static function getListLastMessage($threadId, $userLogin = 0,$limit  = 10){
        $infoGroup = ChatThreads::where("id", $threadId)->select("id","requesterId", "ownerId", "lastIdMessage", "idDelete")->first()->toArray();
        if($userLogin == $infoGroup['idDelete'] ) {
            $listInfo = ChatMessages::join('tbtt_user','tbtt_user.use_id',"=","chatmessages.ownerId")
                        ->where('threadId',"=", $threadId)
                        ->where("chatmessages.userDelete","<>", $userLogin)
                        ->where("chatmessages.id",">", $infoGroup['lastIdMessage'])
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
                        ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "chatmessages.*")->orderby("chatmessages.id","desc")
                        ->limit($limit)
                        ->get();
        }
        else {
            $listInfo = ChatMessages::join('tbtt_user','tbtt_user.use_id',"=","chatmessages.ownerId")
                        ->where('threadId',"=", $threadId)
                        ->where("chatmessages.userDelete","<>", $userLogin)
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
                        ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "chatmessages.*")->orderby("chatmessages.id","desc")
                        ->limit($limit)
                        ->get();
        }

        if($listInfo) {
            foreach ( $listInfo as $k => $info) {
                $info['created_ts'] = Commons::convertDateTotime($info['createdAt']);
                $info['updated_ts'] = Commons::convertDateTotime($info['updatedAt']);
                if($info['typedata'] == 'multiImage') {
                    $info['listImage'] = json_decode($info['listImage'], true);
                }
                else {
                    $info['listImage'] = [];
                }
                if($info['typedata'] == 'product') {
                    $infoProduct = ChatMessages::getDetailProduct($info['productId']);
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
                        $info['text'] = "Chia sẻ vị trí đã kết thúc";
                    }
                    else {
                        $info['stop_share'] = false;
                    }
                }

                if($info['ownerId'] == $infoGroup['ownerId']) {
                    $statusLastChat = ChatMessages::statusReadOfUser($infoGroup, $info['id'],$infoGroup['requesterId']);
                }
                else {
                    $statusLastChat = ChatMessages::statusReadOfUser($infoGroup, $info['id'], $infoGroup['ownerId']);
                }
                if($statusLastChat){
                    $info['statusRead'] = $statusLastChat['statusRead'];
                    $info['timeRead'] = $statusLastChat['timeRead'];
                }
                $info['emoij'] = ChatMessageEmoij::getEmoijMessage($info['id']);
                $infoEmoi = ChatMessageEmoij::infoChooseEmoij($info['id'], $userLogin);
                if(count($infoEmoi) > 0) {
                    $info['chooseEmoij'] = 1;
                    $info['typeEmoij'] = $infoEmoi['emoij'];
                }
                else {
                    $info['chooseEmoij'] = 0;
                    $info['typeEmoij'] = "";
                }

                $user_receive = $info['user_receive'];
                $info['user_receive_name'] = null;
                if($user_receive != 0) {
                    $info_user_receive = ChatThreadUser::getInfoUserAlias($user_receive, $userLogin);
                    if($info_user_receive) {
                        $info['user_receive_name'] = $info_user_receive['use_fullname'];
                    }
                }

                if($info['messageId'] != 0) {
                    $info['parentMessageArr'] = ChatMessages::getArrayMessageParent($info['messageId'], $userLogin);

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

                if($info['element'] != null  && $info['element'] != "") {
                    $info['element'] = json_decode($info['element'], true);
                }

                $parentMessId  = $info['parentMessId'];
                if($parentMessId != 0) {
                    $infoSubname = ChatMessages::where("id", $parentMessId)->pluck("subjectName")->first();
                    if($infoSubname) {
                        $info['subjectName'] = $infoSubname;
                    }

                }


            }

        }
        else {
            return [];
        }
        $listInfo = $listInfo->toArray();
        //$listInfo = array_reverse($listInfo);
        return $listInfo;

    }


    public static function returnInfoLast($info) {
        switch ($info['typedata']) {
            case 'product':
                $info['text'] = $info['use_fullname'] . ' đã gửi 1 sản phẩm';
                break;

            case 'image':
                $info['text'] = $info['use_fullname'] . ' đã gửi 1 ảnh';
                break;

            case 'file':
                $info['text'] = $info['use_fullname'] . ' đã gửi 1 tập tin';
                break;

            case 'multiImage':
                $info['text'] = $info['use_fullname'] . ' đã gửi 1 album';
                break;

            case 'miss-call':
                $info['text'] = "Bạn có cuộc gọi nhỡ";
                break;

            case 'miss-video-call':
                $info['text'] = "Bạn có cuộc gọi video nhỡ";
                break;
            default:
                # code...
                break;
        }
        return $info;
    }

    public static function getLastMessageAlias($threadId, $userLogin){
        $info = ChatMessages::join('tbtt_user','tbtt_user.use_id',"=","chatmessages.ownerId")
                        ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                                $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                        })
                        ->where('threadId',"=", $threadId)
                        ->select("tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "chatmessages.*")->orderby("chatmessages.id","desc")->first();
        if($info) {
            $info = $info->toArray();
            $info['created_ts'] = Commons::convertDateTotime($info['createdAt']);
            $info['updated_ts'] = Commons::convertDateTotime($info['updatedAt']);
        }
        else {
            return (object)[];
        }
        return $info;

    }


    public static function getListThreadDefault($ownerId) {
        $list = ChatThreads::where(['typegroup' => 'default', 'ownerId' => $ownerId])
                    ->select("chatthreads.id as groupChatId", "chatthreads.namegroup as namegroup","chatthreads.typegroup",  "chatthreads.ownerId",  "chatthreads.requesterId","chatthreads.avatar as avatarGroupChat", "chatthreads.type", "chatthreads.typechat" )
                    ->get();
        if(count($list) > 0 ) {
            foreach( $list as $k => &$v ) {
                $lastListMessage = ChatThreads::getListLastMessage($v['groupChatId'], $ownerId);
                $lastMessage = (object)[];
                if(count($lastListMessage) > 0) {
                    //count($lastListMessage)-1
                    $lastMessage = ChatThreads::returnInfoLast($lastListMessage[0]);
                }
                $v['lastMessage'] = $lastMessage;
                $v['lastListMessage'] = $lastListMessage;
            }
        }

        return $list;

    }

    public static function createGroup($arrData) {
        //return ChatThreads::create(['namegroup' => '1231']);
        $id = DB::table('chatthreads')->insertGetId($arrData);
        return $id;

    }

    public static function getDetailThread($threadId, $userLogin = "") {

        $info = ChatThreads::join('tbtt_user',"tbtt_user.use_id","=","chatthreads.ownerId")
                        ->where("chatthreads.id","=",$threadId)
                        ->select("tbtt_user.use_id","tbtt_user.use_username","tbtt_user.use_fullname","tbtt_user.avatar","tbtt_user.use_email","tbtt_user.use_phone","tbtt_user.use_mobile","tbtt_user.use_group","tbtt_user.company_name", "chatthreads.id as groupChatId", "chatthreads.namegroup as namegroup","chatthreads.avatar as avatarGroupChat","chatthreads.type", "chatthreads.typechat")
                        ->first();
        if($info) {
            if( $userLogin != "") {
                $info['background'] = ChatUserBackground::getBackgroundUser(['groupChatId' => $threadId, 'userId' => $userLogin]);
            }
            $lastMessage = ChatThreads::getLastMessage($info['groupChatId']);
            $info['lastMessage'] = $lastMessage;
        }
        return $info;
    }

    public static function getDetailThreadAlias($threadId, $userLogin = "") {
        $info = ChatThreads::join('tbtt_user',"tbtt_user.use_id","=","chatthreads.ownerId")
                        ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                                 $join->on('chatthreads.ownerId', '=', 'chatuseralias.userId_alias');
                        })
                        ->leftJoin(DB::raw("(select * from chatuserread where userId = $userLogin and threadId = $threadId) as chatuserread"), function($join) {
                                     $join->on('chatthreads.id', '=', 'chatuserread.threadId');
                        })
                        ->where("chatthreads.id","=",$threadId)
                        ->select("tbtt_user.use_id","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'),"tbtt_user.avatar","tbtt_user.use_email","tbtt_user.use_phone","tbtt_user.use_mobile","tbtt_user.use_group","tbtt_user.company_name", "chatthreads.id as groupChatId", "chatthreads.namegroup as namegroup","chatthreads.avatar as avatarGroupChat","chatthreads.type", "chatthreads.typechat","chatthreads.typegroup", DB::raw('(CASE WHEN chatuserread.countUnread is null THEN 0 ELSE chatuserread.countUnread END) AS countMessage'))
                        ->first();
        if($info) {
            if( $userLogin != "") {
                $info['background'] = ChatUserBackground::getBackgroundUser(['groupChatId' => $threadId, 'userId' => $userLogin]);
            }
            $lastMessage = ChatThreads::getLastMessageAlias($info['groupChatId'], $userLogin);
            $info['lastMessage'] = $lastMessage;
            $infoadmin = ChatThreads::getInfoIsAdmin($userLogin, $threadId);
            $info['admin'] = $infoadmin['admin'];
        }
        return $info;
    }


    public static function getDetailThreadBackground($threadId, $userLogin = "") {
        $info = ChatThreads::where("chatthreads.id","=",$threadId)
                        ->select("chatthreads.id as groupChatId", "chatthreads.namegroup as namegroup","chatthreads.avatar as avatarGroupChat","chatthreads.type", "chatthreads.typechat")
                        ->first();
        if($info) {
            $info = $info->toArray();
            $user = User::where("use_id", "=", $userLogin)->select("tbtt_user.use_id","tbtt_user.use_username","tbtt_user.use_fullname","tbtt_user.avatar","tbtt_user.use_email","tbtt_user.use_phone","tbtt_user.use_mobile","tbtt_user.use_group","tbtt_user.company_name")->first();
            if($user) {
                $user = $user->toArray();
                $info = array_merge($info, $user);
            }
            if( $userLogin != "") {
                $info['background'] = ChatUserBackground::getBackgroundUser(['groupChatId' => $threadId, 'userId' => $userLogin]);
            }
            $lastMessage = ChatThreads::getLastMessage($info['groupChatId']);
            $info['lastMessage'] = $lastMessage;
        }
        return $info;
    }


    public static function getDetailThreadStatus($threadId, $userId) {
        $info = ChatThreads::where("chatthreads.id","=",$threadId)
                        ->select("chatthreads.id as groupChatId", "chatthreads.namegroup as namegroup","chatthreads.avatar as avatarGroupChat","chatthreads.type", "chatthreads.typechat")
                        ->first()->toArray();
        if($info) {
            /*$user = User::where("use_id","=", $userId)->first()->toArray();*/
            $user = ChatThreadUser::getInfoUser($userId);
            $info = array_merge($info, $user);
            $lastMessage = ChatThreads::getLastMessage($info['groupChatId']);
            $info['lastMessage'] = $lastMessage;
        }
        return $info;
    }

    public static function getUserOfThread($threadId, $type) {
        if( $type == 'private') {
            $infoThread = ChatThreads::where("id","=", $threadId)->first();
            return  [$infoThread['ownerId'], $infoThread['requesterId']];
        }
        else {
            $listUserThread = ChatThreadUser::where("threadId", "=", $threadId)->select("userId")->get();
            $arrUser = [];
            if( count($listUserThread) > 0) {
                foreach( $listUserThread as $k => $v) {
                    $arrUser[] = $v['userId'];
                }
            }
            return $arrUser;
        }
    }

    public static function getInfoThread($threadId) {
        $info = ChatThreads::where("chatthreads.id","=",$threadId)
                        ->first();
        return $info;
    }

    public static function updateInfo() {

    }

    public static function createGroupForDefault($typedefault, $listUser, $infoGroupDefault, $infoUserOwn) {
        $arr = [
          "afflliate" => "icon_default/ic_gianhang_menu.png",
          "staff" => "icon_default/ic_nhanvien.png",
          "agent" => "icon_default/ic_search_group.png",
          "customer_bought" => "icon_default/cart.png",
          "customer_sell" => "icon_default/ic_search_all_product.png",
        ];
        foreach( $listUser as $k => $v ) {
            $userId = $v['use_id'];
            $checkExist = ChatThreads::where(['ownerId' => $userId,'idGroupDefault' =>$infoGroupDefault['id']])->first();
            if(!$checkExist) {
                $namegroup = "Nhóm " . $infoGroupDefault['namegroup'] . " " . $infoUserOwn['use_fullname'];
                $avatar = $arr[$typedefault];
                $typechat = 1;
                $arrData = ['type' => 'group',
                         'ownerId' =>  $userId,
                         'namegroup' => $namegroup,
                         'avatar' => $avatar,
                         'typegroup' => '' ,
                         'typechat' => $typechat,
                         'requesterId' => 0,
                         'idGroupDefault' => $infoGroupDefault['id'],
                         'createdAt'=> date('Y-m-d H:i:s'),
                         'updatedAt'=> date('Y-m-d H:i:s')
                        ];
                $threadId  = ChatThreads::createGroup($arrData);
                if( $threadId) {
                    ChatThreadUser::addUserToGroup($threadId, [$userId]);
                }
            }
        }

    }

    public static function createMessageForGroup($userOwnId, $listUser, $message) {
        $arrReturn = [];
        foreach( $listUser as $k => $v ) {
            $userId = $v['use_id'];
            $checkThread = ChatThreads::where(function ($query) use ($userOwnId, $userId)  {
                     $query->where(['chatthreads.ownerId' => $userOwnId, 'chatthreads.requesterId' => $userId])
                                ->orWhere(['chatthreads.ownerId' => $userId, 'chatthreads.requesterId' => $userOwnId]);
                })
                ->where("chatthreads.type","=", 'private')->first();
            $detailGroup = $checkThread;
            if($checkThread) {
                $threadId = $checkThread->id;
                $arrData = ['type' => 'private',
                            'ownerId' => $userOwnId,
                            'threadId' => $threadId,
                            'text' => $message['text'],
                            'typedata' => $message['typedata'],
                            'messageId' => $message['messageId'],
                            'width' => intval($message['width']),
                            'height' => intval($message['height']),
                            'size' => $message['size'],
                            'createdAt' => date('Y-m-d H:i:s'),
                            'updatedAt' => date('Y-m-d H:i:s'),
                        ];

                $messageId  = ChatMessages::sendMessage($arrData);
                ChatUserRead::updateCountMessageUnreadUser($threadId, $userId);
                    ChatMessageRead::createRowMessageUser(['messageId' => $messageId, 'threadId' => $threadId, 'userId' => $userId ]);

            }
            else {
                $arrData = ['type' => 'private',
                             'ownerId' =>  $userOwnId,
                             'namegroup' => "",
                             'avatar' => "",
                             'typegroup' => '' ,
                             'typechat' => 2,
                             'requesterId' => $userId,
                             'idGroupDefault' => 1,
                             'createdAt'=> date('Y-m-d H:i:s'),
                             'updatedAt'=> date('Y-m-d H:i:s')
                            ];
                if( $userOwnId != $userId) {
                    $threadId  = ChatThreads::createGroup($arrData);
                    if( $threadId) {
                        $arr = [$userOwnId, $userId];
                        ChatThreadUser::addUserToGroup($threadId, $arr , 1);
                    }
                    $detailGroup = ChatThreads::where('id',"=", $threadId)->first();

                    $arrDataMessage = ['type' => 'private',
                                'ownerId' => $userOwnId,
                                'threadId' => $threadId,
                                'text' => $message['text'],
                                'typedata' => $message['typedata'],
                                'messageId' => $message['messageId'],
                                'width' => intval($message['width']),
                                'height' => intval($message['height']),
                                'size' => $message['size'],
                                'createdAt' => date('Y-m-d H:i:s'),
                                'updatedAt' => date('Y-m-d H:i:s'),
                            ];

                    $messageId  = ChatMessages::sendMessage($arrDataMessage);
                    ChatUserRead::updateCountMessageUnreadUser($threadId, $userId);
                        ChatMessageRead::createRowMessageUser(['messageId' => $messageId, 'threadId' => $threadId, 'userId' => $userId ]);

                }

            }
            //$detailGroup = $detailGroup->toArray();
            //$detailMessage = ChatMessages::where("id", "=", $messageId)->first()->toArray();
            if($threadId) {
                $detailMessage =  ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                ->where("chatmessages.id","=", $messageId)
                ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "chatmessages.*" )->first()->toArray();
                $detailMessage['groupChatId'] = $detailMessage['threadId'];
                $userGroup = User::where(['use_id' => $userId])->select("use_fullname")->first();
                $detailMessage['namegroup'] = $userGroup['use_fullname'];

                $infoA = ChatThreadUser::where(['userId' => $userOwnId, 'threadId' => $detailMessage['threadId']])->first();
                if($infoA) {
                    $detailMessage['blocked'] = $infoA['blocked'];
                    $detailMessage['blockedNotify'] = $infoA['blockedNotify'];
                }
                $infoB = ChatThreadUser::where(['userId' => $userId , 'threadId' => $detailMessage['threadId'] ])->first();
                if($infoB) {
                    $detailMessage['blocked_B'] = $infoB['blocked'];
                    $detailMessage['blockedNotify_B'] = $infoB['blockedNotify'];
                }
                //$detailMessage['ownerId'] = $userId;
                //$detailMessage['info'] = $detailGroup;
                //$detailMessage['info']['ownerId'] = $userId;
                if($detailMessage['typedata'] =='multiImage') {
                    $detailMessage['listImage'] = json_decode($detailMessage['listImage'], true);
                }
                else {
                    $detailMessage['listImage'] = [];
                }
                if($detailMessage['typedata'] =='product') {
                    $infoProduct = self::getDetailProduct($detailMessage['productId']);
                    $detailMessage['infoProduct'] = $infoProduct;
                }
                else {
                    $detailMessage['infoProduct'] = null;
                }
                $detailMessage['reload'] = 1;
                $detailMessage['created_ts'] = Commons::convertDateTotime($detailMessage['createdAt']);
                $detailMessage['updated_ts'] = Commons::convertDateTotime($detailMessage['updatedAt']);
                $detailMessage['emoij'] = ChatMessageEmoij::getEmoijMessage($detailMessage['id']);
                if($detailMessage['messageId'] != 0) {
                    $detailMessage['parentMessageArr'] = ChatMessages::getArrayMessageParent($detailMessage['messageId']);
                }
                else {
                    $detailMessage['parentMessageArr'] = null;
                }


                $arrReturn[$userId] = $detailMessage ;

            }

        }
        return $arrReturn;
    }

    public static function createMessageForGroup1($userOwnId, $listUser, $message) {
        $arrReturn = [];
        foreach( $listUser as $k => $v ) {
            if( $userOwnId != $v) {
                $userId = $v;
                $checkThread = ChatThreads::where(function ($query) use ($userOwnId, $userId)  {
                         $query->where(['chatthreads.ownerId' => $userOwnId, 'chatthreads.requesterId' => $userId])
                                    ->orWhere(['chatthreads.ownerId' => $userId, 'chatthreads.requesterId' => $userOwnId]);
                    })
                    ->where("chatthreads.type","=", 'private')->first();
                $detailGroup = $checkThread;
                if($checkThread) {
                    $threadId = $checkThread->id;
                    $arrData = ['type' => 'private',
                                'ownerId' => $userOwnId,
                                'threadId' => $threadId,
                                'text' => $message['text'],
                                'typedata' => $message['typedata'],
                                'messageId' => $message['messageId'],
                                'width' => intval($message['width']),
                                'height' => intval($message['height']),
                                'size' => $message['size'],
                                'createdAt' => date('Y-m-d H:i:s'),
                                'updatedAt' => date('Y-m-d H:i:s'),
                            ];

                    $messageId  = ChatMessages::sendMessage($arrData);
                    ChatUserRead::updateCountMessageUnreadUser($threadId, $userId);
                    ChatMessageRead::createRowMessageUser(['messageId' => $messageId, 'threadId' => $threadId, 'userId' => $userId ]);

                }
                else {
                    $arrData = ['type' => 'private',
                                 'ownerId' =>  $userOwnId,
                                 'namegroup' => "",
                                 'avatar' => "",
                                 'typegroup' => '' ,
                                 'typechat' => 2,
                                 'requesterId' => $userId,
                                 'idGroupDefault' => 1,
                                 'createdAt'=> date('Y-m-d H:i:s'),
                                 'updatedAt'=> date('Y-m-d H:i:s')
                                ];
                    $threadId  = ChatThreads::createGroup($arrData);
                    if( $threadId) {
                        $arr = [$userOwnId, $userId];
                        ChatThreadUser::addUserToGroup($threadId, $arr , 1);
                    }
                    $detailGroup = ChatThreads::where('id',"=", $threadId)->first();

                    $arrDataMessage = ['type' => 'private',
                                'ownerId' => $userOwnId,
                                'threadId' => $threadId,
                                'text' => $message['text'],
                                'typedata' => $message['typedata'],
                                'messageId' => $message['messageId'],
                                'width' => intval($message['width']),
                                'height' => intval($message['height']),
                                'size' => $message['size'],
                                'createdAt' => date('Y-m-d H:i:s'),
                                'updatedAt' => date('Y-m-d H:i:s'),
                            ];

                    $messageId  = ChatMessages::sendMessage($arrDataMessage);
                    ChatUserRead::updateCountMessageUnreadUser($threadId, $userId);
                    ChatMessageRead::createRowMessageUser(['messageId' => $messageId, 'threadId' => $threadId, 'userId' => $userId ]);
                }
                //$detailGroup = $detailGroup->toArray();
                //$detailMessage = ChatMessages::where("id", "=", $messageId)->first()->toArray();
                $detailMessage =  ChatMessages::join("tbtt_user","tbtt_user.use_id","=","chatmessages.ownerId")
                    ->where("chatmessages.id","=", $messageId)
                    ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "chatmessages.*" )->first()->toArray();
                $detailMessage['groupChatId'] = $detailMessage['threadId'];
                $userGroup = User::where(['use_id' => $userId])->select("use_fullname")->first();
                $detailMessage['namegroup'] = $userGroup['use_fullname'];

                if($detailMessage['typedata'] =='multiImage') {
                    $detailMessage['listImage'] = json_decode($detailMessage['listImage'], true);
                }
                else {
                    $detailMessage['listImage'] = [];
                }
                if($detailMessage['typedata'] =='product') {
                    $infoProduct = self::getDetailProduct($detailMessage['productId']);
                    $detailMessage['infoProduct'] = $infoProduct;
                }
                else {
                    $detailMessage['infoProduct'] = null;
                }

                $infoA = ChatThreadUser::where(['userId' => $userOwnId, 'threadId' => $detailMessage['threadId']])->first();
                if($infoA) {
                    $detailMessage['blocked'] = $infoA['blocked'];
                    $detailMessage['blockedNotify'] = $infoA['blockedNotify'];
                }
                $infoB = ChatThreadUser::where(['userId' => $userId , 'threadId' => $detailMessage['threadId'] ])->first();
                if($infoB) {
                    $detailMessage['blocked_B'] = $infoB['blocked'];
                    $detailMessage['blockedNotify_B'] = $infoB['blockedNotify'];
                }
                //$detailMessage['ownerId'] = $userId;
                //$detailMessage['info'] = $detailGroup;
                //$detailMessage['info']['ownerId'] = $userId;
                $detailMessage['reload'] = 1;
                $detailMessage['created_ts'] = Commons::convertDateTotime($detailMessage['createdAt']);
                $detailMessage['updated_ts'] = Commons::convertDateTotime($detailMessage['updatedAt']);
                $detailMessage['emoij'] = ChatMessageEmoij::getEmoijMessage($detailMessage['id']);
                if($detailMessage['messageId'] != 0) {
                    $detailMessage['parentMessageArr'] = ChatMessages::getArrayMessageParent($detailMessage['messageId']);
                }
                else {
                    $detailMessage['parentMessageArr'] = null;
                }
                $arrReturn[$userId] = $detailMessage ;
            }

        }
        return $arrReturn;
    }


    public static function getListGroupUser($params) {
        $userId = $params['userId'];
        $arrThreads = [];
        $listUserThread = ChatThreadUser::join("chatthreads","chatthreads.id","=","chatthreaduser.threadId")
            ->where("chatthreaduser.userId", "=", $userId)
            ->where("chatthreads.userDeleteGroup", "<>", $userId)
            ->where("chatthreaduser.accept_request", "=", 1)->select("chatthreaduser.threadId")->get();
            if( count($listUserThread) > 0) {
                foreach( $listUserThread as $k => $v) {
                    $arrThreads[] = $v['threadId'];
                }
        }
        return $arrThreads;
    }

    public static function getListGroupUserPrivate($params) {
        $userId = $params['userId'];
        $arrThreads = [];
        $listUserThread = ChatThreadUser::join("chatthreads","chatthreads.id","=","chatthreaduser.threadId")
            ->where("chatthreaduser.userId", "=", $userId)
            ->where("chatthreads.userDeleteGroup", "<>", $userId)
            ->where("chatthreads.type", "=", 'private')
            ->where("chatthreaduser.accept_request", "=", 1)->select("chatthreaduser.threadId")->get();
            if( count($listUserThread) > 0) {
                foreach( $listUserThread as $k => $v) {
                    $arrThreads[] = $v['threadId'];
                }
        }
        return $arrThreads;
    }

    public static function getListGroupUserPrivateSecret($params) {
        $userId = $params['userId'];
        $arrThreads = [];
        $listUserThread = ChatThreadUser::join("chatthreads","chatthreads.id","=","chatthreaduser.threadId")
            ->where("chatthreaduser.userId", "=", $userId)
            ->where("chatthreads.userDeleteGroup", "<>", $userId)
            //->where("chatthreads.type", "=", 'private')
            ->whereIn("chatthreads.type", ['private', 'secret'])
            ->where("chatthreaduser.accept_request", "=", 1)->select("chatthreaduser.threadId")->get();
            if( count($listUserThread) > 0) {
                foreach( $listUserThread as $k => $v) {
                    $arrThreads[] = $v['threadId'];
                }
        }
        return $arrThreads;
    }

    public static function getListGroupUserGroup($params) {
        $userId = $params['userId'];
        $arrThreads = [];
        $listUserThread = ChatThreadUser::join("chatthreads","chatthreads.id","=","chatthreaduser.threadId")
            ->where("chatthreaduser.userId", "=", $userId)
            ->where("chatthreads.userDeleteGroup", "<>", $userId)
            ->where("chatthreads.type", "=", 'group')
            ->where("chatthreaduser.accept_request", "=", 1)->select("chatthreaduser.threadId")->get();
            if( count($listUserThread) > 0) {
                foreach( $listUserThread as $k => $v) {
                    $arrThreads[] = $v['threadId'];
                }
        }
        return $arrThreads;
    }


    public static function getInfoIsAdmin($userId, $threadId) {
        $info = ChatThreadUser::where(['userId' => $userId, 'threadId' => $threadId])->select("admin")->first();
        return $info;
    }

    public static function deleteTypeGroup($threadId) {
        $delete = ChatThreads::where(['id' => $threadId])->delete();
        // delete user in group
        ChatThreadUser::where(['threadId' => $threadId])->delete();
        // delete message in gorup
        ChatMessages::where(['threadId' => $threadId])->delete();
        // delete message unread
        ChatMessageRead::where(['threadId' => $threadId])->delete();
         // delete user unread of  thread
        ChatUserRead::where(['threadId' => $threadId])->delete();
        return $delete;

    }


    public static function getUserGroupFolow($params) {
        $userId = $params['userId'];
        $list = User::join("tbtt_user_follow", "tbtt_user_follow.user_id","=", "tbtt_user.use_id")
                ->leftJoin("chatfacephone", function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatfacephone.userId');
                })
                ->where("use_status","=", 1)
                ->whereNotIn("tbtt_user.use_id", User::ID_GROUPADMIN)
                ->where("tbtt_user_follow.hasFollow","=", 1)
                ->where("tbtt_user.use_id","<>", $userId)
                //->where("tbtt_user_follow.follower","=", $userId)
                ->where(function ($query) use ($userId) {
                        $query->where('tbtt_user_follow.follower', '=', $userId)
                                ->orWhere('tbtt_user_follow.user_id','=', $userId);
                    })

                ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "tbtt_user.use_id","chatfacephone.face_id","chatfacephone.face_name","chatfacephone.face_picture","chatfacephone.phone_name" )->orderby('tbtt_user.use_fullname', 'asc')->get();
        return $list;

    }


    public static function getUserGroupFolowPagination($params) {
        $userId = $params['userId'];
        $limit = $params['limit'];
        $page = $params['page'];
        $offset = ($page - 1) * $limit;
        $list = User::join("tbtt_user_follow", "tbtt_user_follow.user_id","=", "tbtt_user.use_id")
                ->leftJoin("chatfacephone", function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatfacephone.userId');
                })
                ->where("use_status","=", 1)
                ->whereNotIn("tbtt_user.use_id", User::ID_GROUPADMIN)
                ->where("tbtt_user_follow.hasFollow","=", 1)
                ->where("tbtt_user.use_id","<>", $userId)
                //->where("tbtt_user_follow.follower","=", $userId)
                ->where(function ($query) use ($userId) {
                        $query->where('tbtt_user_follow.follower', '=', $userId)
                                ->orWhere('tbtt_user_follow.user_id','=', $userId);
                    })

                ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "tbtt_user.use_id","chatfacephone.face_id","chatfacephone.face_name","chatfacephone.face_picture","chatfacephone.phone_name" )->orderby('tbtt_user.use_fullname', 'asc')
                ->offset($offset)
                ->limit($limit);
        return $list;

    }


    public static function getListCall($page, $pageSize, $params) {
        $userId = $params['userId'];
        $offset = ($page - 1) * $pageSize;
        $filterSearch = $params['search'];
        $type= $params['type'];

    }

    public static function infoDetailUser($arrUser, $userId, $userCall = null) {
        if( $userCall != null) {
            $list = User::leftJoin(DB::raw("(select * from chatuseralias where userId = $userId) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->whereIn("tbtt_user.use_id", $arrUser)
                ->where("tbtt_user.use_id", "<>", $userCall)
                ->select("tbtt_user.avatar", "tbtt_user.use_id","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))->get();
        }
        else {
            $list = User::leftJoin(DB::raw("(select * from chatuseralias where userId = $userId) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->whereIn("tbtt_user.use_id", $arrUser)
                ->select("tbtt_user.avatar", "tbtt_user.use_id","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))->get();
        }

        return $list;

    }






}
