<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\BaseModel;
use App\Observers\AffiliateProductObserver;

/**
 * Description of ProductAffiiate
 *
 * @author hoanvu
 */
class ProductAffiiate extends BaseModel {

    //put your code here
    const NUMBER_ALLOW_ADD_PRO = 32;

    protected $table = 'tbtt_product_affiliate_user';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;
    public static function tableName() {
        return 'tbtt_product_affiliate_user';
    }

    public function user() {
        return $this->hasOne('App\Models\User', 'use_id', 'use_id');
    }

    public function product() {
        return $this->hasOne('App\Models\Product', 'pro_id', 'pro_id');
    }

    protected $fillable = [
        'use_id',
        'pro_id',
        'homepage',
        'date_added'
    ];

    function getTotalCategoriesByAff($user_detail) {
        //$this->db->cache_off();
        if ($user_detail->parent_id > 0) {
            $user_parent = $this->user_model->get('*', 'use_id = ' . $user_detail->parent_id . ' AND use_status = 1');
            if ($user_parent->use_group == 3) {
                $query = "SELECT au.use_id,pro.pro_id,pro.pro_category FROM tbtt_product_affiliate_user AS au JOIN tbtt_product as pro ON pro.pro_id = au.pro_id where au.use_id = " . $userId . " and pro.pro_user <> " . $user_parent->use_id . " GROUP BY pro.pro_category";
            } elseif ($user_parent->use_group != 3 && $user_detail->parent_shop > 0) {
                $query = "SELECT au.use_id,pro.pro_id,pro.pro_category FROM tbtt_product_affiliate_user AS au JOIN tbtt_product as pro ON pro.pro_id = au.pro_id where au.use_id = " . $userId . " and pro.pro_user <> " . $user_detail->parent_shop . " GROUP by pro.pro_category";
            } elseif ($user_parent->use_group != 3 && $user_detail->parent_shop == 0) {
                $query = "SELECT au.use_id,pro.pro_id,pro.pro_category FROM tbtt_product_affiliate_user AS au JOIN tbtt_product as pro ON pro.pro_id = au.pro_id where au.use_id = " . $userId . " GROUP BY pro.pro_category";
            }
        }
        $user->parent_id != 0;
        if ($userId > 0) {
            $this->load->model('user_model');
            $user_detail = $this->user_model->get('*', 'use_id = ' . $userId . ' AND use_status = 1');
            if ($user_detail->parent_id > 0) {
                $user_parent = $this->user_model->get('*', 'use_id = ' . $user_detail->parent_id . ' AND use_status = 1');
                if ($user_parent->use_group == 3) {
                    $query = "SELECT au.use_id,pro.pro_id,pro.pro_category FROM tbtt_product_affiliate_user AS au JOIN tbtt_product as pro ON pro.pro_id = au.pro_id where au.use_id = " . $userId . " and pro.pro_user <> " . $user_parent->use_id . " GROUP BY pro.pro_category";
                } elseif ($user_parent->use_group != 3 && $user_detail->parent_shop > 0) {
                    $query = "SELECT au.use_id,pro.pro_id,pro.pro_category FROM tbtt_product_affiliate_user AS au JOIN tbtt_product as pro ON pro.pro_id = au.pro_id where au.use_id = " . $userId . " and pro.pro_user <> " . $user_detail->parent_shop . " GROUP by pro.pro_category";
                } elseif ($user_parent->use_group != 3 && $user_detail->parent_shop == 0) {
                    $query = "SELECT au.use_id,pro.pro_id,pro.pro_category FROM tbtt_product_affiliate_user AS au JOIN tbtt_product as pro ON pro.pro_id = au.pro_id where au.use_id = " . $userId . " GROUP BY pro.pro_category";
                }
            }

            $return = $this->db->query($query);
            return $return->result();
        }
    }

    public static function boot() {
        parent::boot();

        static::observe(new AffiliateProductObserver());
    }

}
