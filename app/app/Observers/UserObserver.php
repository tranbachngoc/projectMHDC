<?php

namespace App\Observers;

use App\Observers\AbstractObserver;
use App\Models\User;
use App\Models\Shop;

use App\Mail\RegisterAffiliate;
use App\Mail\RegisterShop;
use App\Mail\RegisterMember;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification;
use App\Jobs\SendNotification;

class UserObserver extends AbstractObserver {

    public function saved($model) {
        if (!$model->isDirty()) {
        	return;
        }

        if ($model->wasNew) {
            $this->createShop($model);
        	$this->sendMailAndNotiy($model);
        }
        
    }

    public function saving($model) {
        
    }

    public function deleting($model) {
        
    }

    public function deleted($model) {
        
    }


    private function sendMailAndNotiy($model) {

    	switch ($model->getType()) {
    		case User::TYPE_AffiliateUser:
                Mail::to($model->use_email)->send(new RegisterAffiliate($model));
    			dispatch(new SendNotification(Notification::TYPE_NEW_AFFILIATE_USER, $model));
    			break;
    		case User::TYPE_AffiliateStoreUser:
    			Mail::to($model->use_email)->queue(new RegisterShop($model));
    			break;
    		case User::TYPE_BranchUser:
                Mail::to($model->use_email)->queue(new RegisterShop($model)); //TODO change this 1
                dispatch(new SendNotification(Notification::TYPE_NEW_BRANCH_USER, $model));
                break;
            case User::TYPE_NormalUser:
                
                Mail::to($model->use_email)->send(new RegisterMember($model));
    		default:
    			
    			break;
    	}
    }

    private function createShop($model) {
        if (!in_array($model->getType(), [User::TYPE_AffiliateUser, User::TYPE_BranchUser])) {
            return;
        }

        if($model->getType() === User::TYPE_AffiliateUser){
            $shopName = 'Đại lý bán lẻ online';
            $shopDesc = "Gian hàng Đại lý bán lẻ online azibai";
            $shopType = Shop::TYPE_AFFILIATE;
        } else {
            $shopName = 'Chi nhánh Gian hàng';
            $shopDesc = "Gian hàng Chi nhánh azibai";
            $shopType = Shop::TYPE_BRANCH;
        }
        $array  = $model->getAttributes();
      
        $shop = new Shop([
            'sho_name' => $shopName,
            'sho_descr' => $shopDesc,
            'sho_link' => 'store'.$model->use_id,
            'sho_logo' => 'default-logo.png',
            'sho_dir_logo' => 'defaults',
            'sho_banner' => 'default-banner.jpg',
            'sho_dir_banner' => 'defaults',
            'sho_province' => $model->use_province,
            'sho_district' => $array['user_district'],
            'sho_category' => 1,
            'sho_phone' => $model->use_phone,
            'sho_mobile' => $model->use_mobile,
            'sho_user' => $model->use_id,
            'sho_begindate' => $model->use_regisdate,
            'sho_enddate' => 0,
            'sho_view' => 1,
            'sho_status' => 1,
            'sho_style' => 'default',
            'sho_email' => $model->use_email,
            'shop_type' => $shopType
        ]);

        $shop->save();
    }

}
