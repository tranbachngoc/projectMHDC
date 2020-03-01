<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
/**
 * Description of Wallet
 *
 * @author hoanvu
 */
class Wallet extends BaseModel {
    //put your code here
    protected $table = 'tbtt_wallet';

    const TYPE_DESPOSIT = 1;
    const TYPE_WITHRAW = 0;
    const TYPE_MONEY = 1;
    const TYPE_POINT = 2;

    public $timestamps = false;
    protected $primaryKey = 'id';
    public static function tableName() {
        return 'tbtt_wallet';
    }

    protected $fillable = [
        'group_id',
        'parent_id',
        'type',
        'description',
        'created_date',
        'month_year',
        'status',
        'amount',
        'user_id'
    ];
    protected $defaults = array(
        'id_walletlog' => 0,
        'update_by_admin' => 0,
        'status_apply' => 0,
    );

    public function __construct(array $attributes = array()) {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

}
