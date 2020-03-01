<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Notification;
use App\Models\Device;
use Illuminate\Support\Facades\Log;
use Edujugon\PushNotification\PushNotification;
use App\Models\User;
use App\Models\Product;
use App\Components\Notification as HelperNotification;

class SendNewsNotification implements ShouldQueue {

    use InteractsWithQueue,
        Queueable,
        SerializesModels;


    protected $data;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $data) {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Log::info("Jobs Send Notification ");
        switch ($this->type) {
            
            case Notification::TYPE_CTY_CREATE_NEWS:
                
                $this->pushCreateNews();
                break;
             
            default:
                # code...
                break;
        }
    }
    


    // notif
    private function pushCreateNews() {
       $news = $this->data;  // comment model
       if(empty($news) || (!empty($news) && empty($news->user))){
           return;
       }
       
       $user = $this->getAllEmployee($news->user);
       if(empty($user)){
           return;
       }
 
        $this->saveNotification($user, [
            'actionId' => $news->not_id,
            'title' => 'Công ty của bạn vừa đăng tin',
            'body' =>'Công ty của bạn vừa đăng tin',
            'actionType' => $this->type
        ]);
        return;
    }
    
    protected function getAllEmployee($user){
        $tree = [];
        $tree[] = $user->use_id;
        $query = User::where(['use_status' => User::STATUS_ACTIVE])->whereIn('use_group',[User::TYPE_AffiliateUser,User::TYPE_BranchUser]);
        $query->whereIn('parent_id', function($q) use ($user) {
            $q->select('use_id');
            $q->from((new User)->getTable());
            $q->where('use_status', User::STATUS_ACTIVE);
            $q->where(function($q2) use ($user) {
                $q2->whereIn('use_group', [User::TYPE_StaffStoreUser, User::TYPE_StaffUser, User::TYPE_BranchUser,
                    User::TYPE_AffiliateStoreUser,User::TYPE_Partner2User,User::TYPE_Partner1User,User::TYPE_Developer1User,User::TYPE_Developer2User]);
                $q2->where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $user->use_id]);
            });
            $q->orWhere(function($q) use($user) {
                $q->where('use_group', User::TYPE_StaffUser);
                $q->whereIn('parent_id', function($q) use($user) {
                    $q->select('use_id');
                    $q->from(User::tableName());
                    $q->where(function($q) use ($user) {
                        $q->where('use_group', User::TYPE_BranchUser);
                        $q->where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $user->use_id]);
                    });
                });
            });
            $q->orWhere(function($q) use($user) {
                $q->where('use_group', User::TYPE_StaffUser);
                $q->whereIn('parent_id', function($q) use($user){
                    $q->select('use_id');
                    $q->from(User::tableName());
                    $q->where('use_status', User::STATUS_ACTIVE);
                    $q->where('use_group', User::TYPE_BranchUser);
                    $q->whereIn('parent_id', function($q) use($user) {
                        $q->select('use_id');
                        $q->from(User::tableName());
                        $q->where('use_group', User::TYPE_StaffStoreUser);
                        $q->where('parent_id',$user->use_id);
                    });
                });
            });
            $q->orWhere(function($q) use($user) {
                $q->where('use_group', User::TYPE_BranchUser);
                $q->where('use_status', User::STATUS_ACTIVE);
                $q->whereIn('parent_id', function($q) use($user) {
                    $q->select('use_id');
                    $q->from(User::tableName());
                    $q->where('use_group', User::TYPE_StaffStoreUser);
                     $q->where('parent_id',$user->use_id);
                });
            });
            $q->orWhere('use_id', $user->use_id);
        });
        
        
        return $query->pluck('use_id')->toArray();
    }

    private function saveNotification($userIds, $data) {
        if (!$userIds) {
            return;
        }
        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }
        $list = [];
        foreach ($userIds as $value) {
            $list[] = array(
                'actionType' => $this->type,
                'actionId' => isset($data['actionId']) ? $data['actionId'] : null,
                'title' => isset($data['title']) ? $data['title'] : null,
                'body' => isset($data['body']) ? $data['body'] : null,
                'meta' => isset($data['meta']) ? json_encode($data['meta']) : null,
                'userId' => $value,
                'createdAt' => time(),
                'updatedAt' => time()
            );
        }
        Notification::insert($list);

        HelperNotification::sendFCM($userIds, $data);
    }

}
