<?php

namespace App\Models;

use App\BaseModel;
use App\Observers\OrderObserver;

/**
 * Order model
 *
 */
/**
 * @SWG\Tag(
 *   name="Order",
 *   description="Danh sách API của đơn hàng",
 * )
 */
class Order extends BaseModel {
    const PAYMENT_METHOD_NGANLUONG = 'info_nganluong';
    const ORDER_TYPE_PROMOTION = 2;
    const STATUS_PENDING = '01';
    const STATUS_ON_TRANS = '02';
    const STATUS_RECIVICE = '03';
    const STATUS_SUCCESS = '98';
    const STATUS_CANCEL = '99';
    
    const SHIPPING_SHOPGIAO = 'SHO';
    const SHIPPING_VIETTEL = 'VTP';
    const SHIPPING_GIAOHANGNHANH = 'GHN';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_order';

    protected $primaryKey = 'id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_order';
    }

    public function userReceive() {
        return $this->hasOne('App\Models\UserReceive', 'order_id', 'id');
    }

    public function orderDetails() {
        return $this->hasMany('App\Models\OrderDetail', 'shc_orderid', 'id');
    }
    
    public function orderDetail() {
        return $this->hasOne('App\Models\OrderDetail', 'shc_orderid', 'id');
    }

    public function products() {
          // return $this->belongsToMany('App\Models\User', (new \App\Models\SelectNews)->getTable(), 'not_id', 'sho_user')->select(['use_id', 'use_username', 'avatar', 'use_fullname', 'use_phone']);
        return $this->belongsToMany('App\Models\Product', (new \App\Models\OrderDetail)->getTable(), 'shc_orderId','shc_product');
    }
    
     public function product() {
          // return $this->belongsToMany('App\Models\User', (new \App\Models\SelectNews)->getTable(), 'not_id', 'sho_user')->select(['use_id', 'use_username', 'avatar', 'use_fullname', 'use_phone']);
        return $this->hasOne('App\Models\Product', 'pro_id','shc_product');
    }

    public function user() {
        return $this->hasOne('App\Models\User', 'use_id', 'order_user')->select('use_id', 'use_username', 'use_fullname');
    }
    
     public function status() {
        return $this->hasOne('App\Models\Status', 'status_id', 'order_status');
    }
    

    public function shop() {
        return $this->hasOne('App\Models\Shop', 'sho_user', 'order_saler');
    }
     public function shopFullInfor() {
        return $this->hasOne('App\Models\Shop', 'sho_user', 'order_saler');
    }
    
    public function orderSaler(){
         return $this->hasOne('App\Models\User', 'use_id', 'order_saler');
    }

    protected $fillable = [
        'date',
        'payment_method',
        'shipping_method',
        'order_code',
        'order_token',
        'change_status_date',
        'token',
        'other_info',
        'payment_other_info',
        'payment_method',
         'order_group_id',
        'order_user_sale',
    ];
    
    
    protected $defaults = array(
        'payment_other_info' => '',
        'order_coupon_code' => '',
        'order_group_id' => 0,
        'order_user_sale' => 0
    );

    public function __construct(array $attributes = array()) {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    public static function boot() {
        parent::boot();

        static::observe(new OrderObserver());
    }

    public function getMessageByStatus() {
        if ($this->order_status == self::STATUS_CANCEL) {
            return 'Đơn hàng #'.$this->id.' của bạn đã bị từ chối.';
        }

        if ($this->order_status == self::STATUS_ON_TRANS) {
            return 'Đơn hàng #'.$this->id.' của bạn đang trên đường vận chuyển.';
        }

        if ($this->order_status == self::STATUS_SUCCESS) {
            return 'Đơn hàng #'.$this->id.' của bạn đã được giao thành công.';
        }
    }
}
