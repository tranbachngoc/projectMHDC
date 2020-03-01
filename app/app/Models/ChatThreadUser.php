<?php

namespace App\Models;

use App\BaseModel;
use App\Models\User;
use App\Models\ChatThreads;
use App\Models\ChatMessages;
use App\Models\ChatUserRead;
use App\Models\ChatMessageRead;
use App\Models\UserFollow;
use DB;

/**
 * Category model
 *
 */
class ChatThreadUser extends BaseModel {

    protected $table = 'chatthreaduser';
    protected static $table_name = 'chatthreaduser';
    protected $fillable = [
        'userId',
        'threadId',
        'createdAt',
        'updatedAt',
        'accept_request',
        'admin',
        'alias_secret',
        'avatar_secret'
      ];

    public static function getListUserOfGroup($page, $pageSize, $params) {
        $offset = ($page - 1) * $pageSize;
        $threadId = $params['threadId'];
        //$infoThread = ChatThreads::where('id', "=", $threadId)->first();
        //$ownerId = $infoThread['ownerId'];
        $ownerId = $params['userId'];
        $offset = ($page - 1) * $pageSize;
        $list = ChatThreadUser::join("tbtt_user","tbtt_user.use_id","=","chatthreaduser.userId")
                ->where("chatthreaduser.threadId","=", $threadId)
                ->where("chatthreaduser.userId","<>", $ownerId)
                ->where("chatthreaduser.accept_request","=", 1)
                //->whereNotIn("use_group",User::ID_GROUPADMIN)
                ->orderBy('chatthreaduser.id','desc')
                ->select("tbtt_user.use_id as use_id","tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname");
        return $list;
    }

    public static function getListUserOfGroupAlias($page, $pageSize, $params) {
        $offset = ($page - 1) * $pageSize;
        $threadId = $params['threadId'];
        $ownerId = $params['userId'];
        $offset = ($page - 1) * $pageSize;
        $list = ChatThreadUser::join("tbtt_user","tbtt_user.use_id","=","chatthreaduser.userId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $ownerId) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatthreaduser.threadId","=", $threadId)
                ->where("chatthreaduser.userId","<>", $ownerId)
                ->where("chatthreaduser.accept_request","=", 1)
                ->orderBy('chatthreaduser.id','desc')
                ->select("tbtt_user.use_id as use_id","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'));
        return $list;
    }

    public static function addUserToGroup($threadId, $listUser, $accept_request = 0, $admin=0) {
        if(count($listUser) > 0) {
            foreach( $listUser as $k => $userId) {
                DB::table(ChatThreadUser::$table_name)->insert(['userId' => $userId, 'threadId' => $threadId, 'createdAt' => date('Y-m-d H:i:s'), 'updatedAt' => date('Y-m-d H:i:s'),'statusRead' => 1, 'blocked' => 0, 'blockedNotify' => 0, 'accept_request' => $accept_request, 'admin'=> $admin ]);
            }
        }
    }

    public static function getListUserNotJoin($threadId, $page, $pageSize, $params) {
        $userId = $params['userId'];
        $search = $params['search'];
        $start = ($page - 1) * $pageSize;
        $listUserJoinGroup = ChatThreadUser::where("threadId","=", $threadId)->select("userId")->get()->toArray();
        $arrId = [];
        if($listUserJoinGroup) {
            foreach($listUserJoinGroup as $k => $v) {
                $arrId[] = $v['userId'];
            }
        }
        $list = User::whereNotIn('use_id', $arrId)
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('use_mobile', 'like', '%'.$search.'%')
                                ->orWhere('use_phone', 'like', '%'.$search.'%');
                    }
                })
                ->whereNotIn("use_group",User::ID_GROUPADMIN)
                ->select("use_id","use_username","use_fullname","avatar")
                ->limit($start, $pageSize);
        return $list;

    }

    public static function getListUserNotJoinAlias($threadId, $page, $pageSize, $params) {
        $userId = $params['userId'];
        $search = $params['search'];
        $start = ($page - 1) * $pageSize;
        $listUserJoinGroup = ChatThreadUser::where("threadId","=", $threadId)->select("userId")->get()->toArray();
        $arrId = [];
        if($listUserJoinGroup) {
            foreach($listUserJoinGroup as $k => $v) {
                $arrId[] = $v['userId'];
            }
        }
        $list = User::whereNotIn('use_id', $arrId)
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userId) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('use_mobile', 'like', '%'.$search.'%')
                                ->orWhere('use_phone', 'like', '%'.$search.'%');
                    }
                })
                ->whereNotIn("use_group",User::ID_GROUPADMIN)
                ->select("use_id","use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'),"avatar")
                ->limit($start, $pageSize);
        return $list;

    }

    public static function getListUserNotJoinFolow($threadId, $page, $pageSize, $params) {
        $userId = $params['userId'];
        $search = $params['search'];
        $start = ($page - 1) * $pageSize;
        $listUserJoinGroup = ChatThreadUser::where("threadId","=", $threadId)->select("userId")->get()->toArray();
        $arrId = [];
        if($listUserJoinGroup) {
            foreach($listUserJoinGroup as $k => $v) {
                $arrId[] = $v['userId'];
            }
        }
        $list = User::join("tbtt_user_follow", "tbtt_user_follow.follower","=", "tbtt_user.use_id")
                ->where("use_status","=", 1)
                ->where("tbtt_user_follow.user_id","=", $userId)
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_email', 'like', '%'.$search.'%')
                                ->orWhere('use_mobile', 'like', '%'.$search.'%')
                                ->orWhere('use_phone', 'like', '%'.$search.'%');
                    }
                })
                ->whereNotIn("tbtt_user.use_group",User::ID_GROUPADMIN)
                ->whereNotIn('use_id', $arrId)->select("use_id","use_username","use_fullname","avatar")
                ->limit($start, $pageSize);
        return $list;

    }

    public static function getListUserNotJoinFolowAlias($threadId, $page, $pageSize, $params) {
        $userId = $params['userId'];
        $search = $params['search'];
        $start = ($page - 1) * $pageSize;
        $listUserJoinGroup = ChatThreadUser::where("threadId","=", $threadId)->select("userId")->get()->toArray();
        $arrId = [];
        if($listUserJoinGroup) {
            foreach($listUserJoinGroup as $k => $v) {
                $arrId[] = $v['userId'];
            }
        }
        $list = User::join("tbtt_user_follow", "tbtt_user_follow.follower","=", "tbtt_user.use_id")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userId) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->where("use_status","=", 1)
                ->where("tbtt_user_follow.user_id","=", $userId)
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_email', 'like', '%'.$search.'%')
                                ->orWhere('use_mobile', 'like', '%'.$search.'%')
                                ->orWhere('use_phone', 'like', '%'.$search.'%');
                    }
                })
                ->whereNotIn("tbtt_user.use_group",User::ID_GROUPADMIN)
                ->whereNotIn('use_id', $arrId)
                ->select("use_id","use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'),"avatar")
                ->limit($start, $pageSize);
        return $list;
    }


    public static function updateStatusReadMessage($userId, $threadId) {

        $update = DB::table('chatthreaduser')->where("threadId","=", $threadId)->where("userId","<>", $userId)->update(['statusRead' => 0]);
        return $update;
    }

    public static function getStatusReadThreadUser($userId, $threadId) {
        $info = ChatThreadUser::where(['userId' => $userId, 'threadId' => $threadId])->first();
        if($info) {
            return $info['statusRead'];
        }
        return 0;

    }

    public static function detailUserChat($userId, $threadId) {
        $list = ChatThreadUser::join("tbtt_user","tbtt_user.use_id","=","chatthreaduser.userId")
                ->where("chatthreaduser.userId","=", $userId)
                ->where("chatthreaduser.threadId","=", $threadId)
                ->select("tbtt_user.use_id as use_id","tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "chatthreaduser.blocked","chatthreaduser.blockedNotify")->first();
        return $list;
    }



    public static function detailUserChatAlias($userId, $threadId, $userIdLogin) {
        $list = ChatThreadUser::join("tbtt_user","tbtt_user.use_id","=","chatthreaduser.userId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userIdLogin and userId_alias = $userId) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatthreaduser.userId","=", $userId)
                ->where("chatthreaduser.threadId","=", $threadId)
                ->select("tbtt_user.use_id as use_id","tbtt_user.avatar","tbtt_user.use_username",
                    DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname')
                    , "chatthreaduser.blocked","chatthreaduser.blockedNotify", "chatthreaduser.alias_secret","chatthreaduser.avatar_secret")->first();
        return $list;
    }


    public static function getInfoUser($userId) {
         $infoUser = User::where(['use_id' => $userId ])->select("use_id","use_username","use_fullname","avatar","use_email","use_phone","use_mobile","use_group","company_name")->first()->toArray();
         return $infoUser;
    }

    public static function getInfoUserAlias($userId, $userLogin) {
        $infoUser = User::leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin and userId_alias = $userId  ) as chatuseralias"), function($join) {
                                     $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                            })
                        ->where(['use_id' => $userId ])
                        ->select("use_id","use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'),"avatar","use_email","use_phone","use_mobile","use_group","company_name")->first()->toArray();
         return $infoUser;
    }

    public static function getListUserOfGroupNotAdmin($page, $pageSize, $params) {
        $offset = ($page - 1) * $pageSize;
        $threadId = $params['threadId'];
        $ownerId = $params['userId'];
        $search = $params['search'];
        $list = ChatThreadUser::join("tbtt_user","tbtt_user.use_id","=","chatthreaduser.userId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $ownerId) as chatuseralias"), function($join) {
                         $join->on('chatthreaduser.userId', '=', 'chatuseralias.userId_alias');
                })
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('tbtt_user.use_username', 'like', '%'.$search.'%')
                                ->orWhere('tbtt_user.use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('tbtt_user.use_mobile', 'like', '%'.$search.'%')
                                 ->orWhere('chatuseralias.name_alias', 'like', '%'.$search.'%')
                                ->orWhere('tbtt_user.use_phone', 'like', '%'.$search.'%');
                    }
                })
                ->where("chatthreaduser.threadId","=", $threadId)
                ->where("chatthreaduser.userId","<>", $ownerId)
                ->where("chatthreaduser.accept_request","=", 1)
                ->where("chatthreaduser.admin","=", 0)
                ->orderBy('chatthreaduser.id','desc')
                ->select("tbtt_user.use_id as use_id","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->offset($offset)
                ->limit($pageSize);
        return $list;
    }

    public static function getListUserOfGroupIsAdmin($page, $pageSize, $params) {
        $offset = ($page - 1) * $pageSize;
        $threadId = $params['threadId'];
        $ownerId = $params['userId'];
        $search = $params['search'];
        $list = ChatThreadUser::join("tbtt_user","tbtt_user.use_id","=","chatthreaduser.userId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $ownerId) as chatuseralias"), function($join) {
                         $join->on('chatthreaduser.userId', '=', 'chatuseralias.userId_alias');
                })
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('tbtt_user.use_username', 'like', '%'.$search.'%')
                                ->orWhere('tbtt_user.use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('tbtt_user.use_mobile', 'like', '%'.$search.'%')
                                 ->orWhere('chatuseralias.name_alias', 'like', '%'.$search.'%')
                                ->orWhere('tbtt_user.use_phone', 'like', '%'.$search.'%');
                    }
                })
                ->where("chatthreaduser.threadId","=", $threadId)
                ->where("chatthreaduser.userId","<>", $ownerId)
                ->where("chatthreaduser.accept_request","=", 1)
                ->where("chatthreaduser.admin","=", 1)
                ->orderBy('chatthreaduser.id','desc')
                ->select("tbtt_user.use_id as use_id","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))
                ->offset($offset)
                ->limit($pageSize);
        return $list;
    }

    public static function updateUserAdmin($userId, $threadId, $value) {
        $update = DB::table('chatthreaduser')->where("threadId","=", $threadId)->where("userId","=", $userId)->update(['admin' => $value] );
        return $update;
    }

    public static function getDetailUserAdmin($userId, $groupChatId, $userLogin) {
        $info = ChatThreadUser::join("tbtt_user","tbtt_user.use_id","=","chatthreaduser.userId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId_alias = $userId and userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatthreaduser.userId', '=', 'chatuseralias.userId_alias');
                })
                ->where("chatthreaduser.threadId","=", $groupChatId)
                ->where("chatthreaduser.userId","=", $userId)
                ->select("tbtt_user.use_id as use_id","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'))->first();
        return $info;

    }

    //chatmessageread

    public static function getListUserViewMessage($page, $pageSize, $messageId, $groupChatId, $userLogin) {
        $offset = ($page - 1) * $pageSize;
        $list = ChatThreadUser::join("tbtt_user","tbtt_user.use_id","=","chatthreaduser.userId")
                ->join("chatmessageread","chatmessageread.userId","=","chatthreaduser.userId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatthreaduser.userId', '=', 'chatuseralias.userId_alias');
                })
                ->where(['chatthreaduser.threadId' => $groupChatId, 'chatthreaduser.accept_request' => 1])
                ->where('chatmessageread.messageId', $messageId)
                ->where('chatmessageread.statusRead', 1)
                ->offset($offset)
                ->limit($pageSize)
                ->select("tbtt_user.use_id as use_id","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'));

        return $list;
    }

    public static function getListUserUnreadMessage($page, $pageSize, $messageId, $groupChatId, $userLogin) {
        $offset = ($page - 1) * $pageSize;
        $list = ChatThreadUser::join("tbtt_user","tbtt_user.use_id","=","chatthreaduser.userId")
                ->join("chatmessageread","chatmessageread.userId","=","chatthreaduser.userId")
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('chatthreaduser.userId', '=', 'chatuseralias.userId_alias');
                })
                ->where(['chatthreaduser.threadId' => $groupChatId, 'chatthreaduser.accept_request' => 1])
                ->where('chatmessageread.messageId', $messageId)
                ->where('chatmessageread.statusRead', 0)
                ->offset($offset)
                ->limit($pageSize)
                ->select("tbtt_user.use_id as use_id","tbtt_user.avatar","tbtt_user.use_username",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'));

        return $list;
    }

    public static function deleteUserIngroup($userId, $threadId) {
        $delete = ChatThreadUser::where(['userId' => $userId, 'threadId' => $threadId])->delete();
        ChatUserRead::where(['userId' => $userId, 'threadId' => $threadId])->delete();
        return $delete;

    }

    public static function updateOwnerGroup($userId, $threadId) {
        $update = DB::table('chatthreads')->where("id","=", $threadId)->update(['ownerId' => $userId] );
        return $update;
    }

    public static function getInfoSearchAll($userId, $userLogin){
        $arrReturn = [];
        $checkThreadUser = ChatThreads::where(function ($query) use ($userId, $userLogin) {
                        $query->where(['ownerId' => $userId, 'requesterId' => $userLogin])
                            ->orWhere(['ownerId' => $userLogin, 'requesterId' => $userId]);

                })->where("type","=","private")->first();
        if( $checkThreadUser) {
            $arrReturn['groupChatId'] = $checkThreadUser->id;
            $arrReturn['typechat'] =  $checkThreadUser->type;
        }
        else {
             $arrReturn['groupChatId'] = null;
             $arrReturn['typechat'] = null;
        }
        $info = User::where('use_id', $userId)->select("avatar")->first();
        if($info) {
            $arrReturn['avatar'] = $info->avatar;
        }
        else {
            $arrReturn['avatar'] = "";
        }
        return  $arrReturn;
    }

    public static function searchAll($page, $pageSize, $params) {
        $offset = ($page - 1) * $pageSize;
        $userLogin = $params['userLogin'];
        $search = $params['search'];
        $list = DB::table('tbtt_user')->leftJoin(DB::raw("(select * from chatuseralias where userId = $userLogin) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->where("tbtt_user.use_id","<>", $userLogin)
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('tbtt_user.use_username', 'like', '%'.$search.'%')
                                ->orWhere('tbtt_user.use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('tbtt_user.use_mobile', 'like', '%'.$search.'%')
                                 ->orWhere('chatuseralias.name_alias', 'like', '%'.$search.'%')
                                ->orWhere('tbtt_user.use_phone', 'like', '%'.$search.'%');
                    }
                })
                ->whereNotIn("tbtt_user.use_group",User::ID_GROUPADMIN)
                ->selectRaw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS name,(CASE WHEN tbtt_user.use_id is null THEN NULL ELSE NULL END) AS groupChatId, (CASE WHEN tbtt_user.avatar is null THEN NULL ELSE NULL END) AS avatar, tbtt_user.use_id, (CASE WHEN tbtt_user.avatar is null THEN NULL ELSE NULL END) AS type')
                ->union(DB::table(DB::raw("(SELECT chatthreads.namegroup as name, chatthreads.id as groupChatId, chatthreads.avatar as avatar, chatthreads.ownerId as use_id,chatthreads.type as type FROM `chatthreads` where chatthreads.id in (select threadId from chatthreaduser where userId = $userLogin and accept_request = 1 ) and namegroup like '%$search%') as a")) );

        $querySql = $list->toSql();
        $query = DB::table(DB::raw("($querySql) as a"))->mergeBindings($list);
        return $query;
    }

    public static function updateAliasSecet($userId, $threadId, $alias_secret) {
        $update = DB::table('chatthreaduser')->where("threadId","=", $threadId)->where("userId","=", $userId)->update(['alias_secret' => $alias_secret ]);
        return $update;
    }

    public static function updateAvatarSecet($userId, $threadId, $avatar_secret) {
        $update = DB::table('chatthreaduser')->where("threadId","=", $threadId)->where("userId","=", $userId)->update(['avatar_secret' => $avatar_secret ]);
        return $update;
    }

    public static function checkFollow($userId, $userFollow) {
        $check = UserFollow::where(function ($query) use ($userId, $userFollow) {
                     $query->where(['tbtt_user_follow.follower' => $userId, 'tbtt_user_follow.user_id' => $userFollow] )
                         ->orWhere(['tbtt_user_follow.follower' => $userFollow, 'tbtt_user_follow.user_id' => $userId] );
                })->first();
        if($check) {
            return true;
        }
        return false;
    }

    public static function createFollow($userId, $arrUserFollow) {
        foreach($arrUserFollow as $k => $v ) {
            if($userId != $v && $v != 0) {
                $check = self::checkFollow($userId, $v);
                if(!$check) {
                    $arrData = [
                        'user_id' => $userId,
                        'follower' =>  $v,
                        'hasFollow' => 1
                    ];
                    UserFollow::create($arrData);
                }
            }

        }

    }



}
