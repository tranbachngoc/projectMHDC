<?php

namespace App\Models;

use App\BaseModel;

/**
 * Notify model
 *
 */
class Notification extends BaseModel {

    const TYPE_NEW_COMMENTS = 'key_new_comment';
    const TYPE_SHARE_NEWS = 'key_share_news';
    const TYPE_RATE_NEWS = 'key_rate_news';
    const TYPE_LIMIT_PRODUCTS = 'key_limit_product';
    const TYPE_NEW_BRANCH_USER = 'key_new_branch_user';
    const TYPE_NEW_AFFILIATE_USER = 'key_new_affiliate_user';
    const TYPE_CTY_DEACTIVE_PRODUCT = 'key_cty_key_deactive_product';
    const TYPE_CTY_CREATE_NEW_PRODUCT = 'key_cty_create_new_product';
    
    const TYPE_NEW_ORDER = 'key_new_order';
    const TYPE_STATUS_ORDER = 'key_status_order';
    const TYPE_DEACTIVE_PRODUCT = 'key_deactive_product';
    const TYPE_BRANCH_CREATE_PRODUCT = 'key_branch_create_product';
    const TYPE_AFFILIATE_SELECT_BUY_PRODUCT ='key_affiliate_select_buy_product';
    const TYPE_AFFILIATE_REMOVE_SELECT_BUY_PRODUCT ='key_affiliate_remove_select_buy_product';
    
    //News
    
    const TYPE_CTY_CREATE_NEWS = 'key_cty_create_news';
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_notifications';

    public static function tableName() {
        return 'tbtt_notifications';
    }

    protected $fillable = [
        'read',
        'title',
        'description',
        'actionId',
        'actionType',
        'userId',
        'createdAt',
        'updatedAt',
        'meta'
    ];

    public function save(array $options = array()) {
        //default tag is personal
        if (!$this->exists) {
            $this->createdAt = time();
        }

        $this->updatedAt = time();

        parent::save($options);
    }

    protected $casts = [
        'meta' => 'json',
        'read' => 'boolean',
    ];
}
