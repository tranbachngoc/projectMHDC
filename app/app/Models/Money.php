<?php

namespace App\Models;

use App\BaseModel;

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
class Money extends BaseModel {
    const STATUS_WITHDRAW = 9;
    const STATUS_IN_BANKING = 1;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_money';
    protected $primaryKey = 'id';
    public $timestamps = false;
    

    public static function tableName() {
        return 'tbtt_money';
    }
}
