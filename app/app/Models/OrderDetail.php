<?php

namespace App\Models;

use App\BaseModel;

/**
 * Order model
 *
 */
class OrderDetail extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_showcart';
    protected $primaryKey = 'shc_id';
    public $timestamps = false;
    
    public static function tableName() {
        return 'tbtt_showcart';
    }
    protected $fillable = [
        'shc_product',
        'shc_quantity',
        'pro_category',
        'shc_saler',
        'shc_buyer',
        'shc_saler_parent',
        'shc_buyer_parent',
        'shc_buyer_group',
        'shc_buydate',
        'shc_process',
        'shc_orderid',
        'shc_status',
        'shc_change_status_date',
        'shc_saler_store_type',
        'em_discount',
        'shc_total',
        'af_amt',
        'af_rate',
        'dc_amt',
        'dc_rate',
        'affiliate_discount_amt',
        'affiliate_discount_rate',
        'pro_price',
        'pro_price_original',
        'pro_price_rate',
        'pro_price_amt',
        'af_id',
        'af_id_parent',
        'shc_saler_store_type',
        'shc_group_id',
        'shc_user_sale'
    ];
    protected $defaults = array(
        'af_amt' => 0,
        'af_rate'=>0,
        'af_id'=>0,
        'shc_dp_pro_id' => 0,
        'shc_group_id' => 0,
        'shc_user_sale' => 0
//        'order_coupon_code' => ''
    );

    public function __construct(array $attributes = array()) {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    public function product() {
        return $this->hasOne('App\Models\Product', 'pro_id', 'shc_product')->select([
                'pro_id', 'pro_name', 'pro_descr', 'pro_cost', 'pro_currency', 'pro_buy', 'pro_view',
                'pro_weight', 'pro_height', 'pro_width', 'pro_length','pro_category','af_rate','af_amt',
                'pro_detail', 'pro_image', 'pro_dir', 'pro_instock', 'pro_quality', 'pro_status',
        ]);
    }
    
        
    
    public function products() {
        return $this->hasOne('App\Models\Product', 'pro_id', 'shc_product')->select([
                'pro_id', 'pro_name', 'pro_descr', 'pro_cost', 'pro_currency', 'pro_buy', 'pro_view',
                'pro_weight', 'pro_height', 'pro_width', 'pro_length','pro_category',
                'pro_detail', 'pro_image', 'pro_dir', 'pro_instock', 'pro_quality', 'pro_status',
        ]);
    }

    public function category() {
        return $this->hasOne('App\Models\Category', 'cat_id', 'pro_category')->select([
                'cat_name', 'cat_id','cat_level','parent_id','b2c_fee'
        ]);
    }
    
    
    public function status(){
        return $this->hasOne('App\Models\Status', 'status_id', 'shc_status')->select([
                'text','status_id'
        ]);
    }
    
    public function buyer() {
        return $this->hasOne('App\Models\User', 'use_id', 'shc_buyer')->select([
            'use_username','use_id','use_group'
        ]);
    }

    public function saler() {
        return $this->hasOne('App\Models\User', 'use_id', 'shc_saler')->select([
                'use_username', 'use_id'
        ]);
    }

    public function shop() {
        return $this->hasOne('App\Models\Shop', 'sho_user', 'shc_saler');
    }
    
    public function affUser() {
        return $this->hasOne('App\Models\User', 'use_id', 'af_id')->select([
                'use_username', 'use_id'
        ]);
    }

    public function affUserShop() {
        return $this->hasOne('App\Models\Shop', 'sho_user', 'af_id');
    }

}
