<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
/**
 * Description of Contact
 *
 * @author hoanvu
 */
/**
 * Order model
 *
 */
/**
 * @SWG\Tag(
 *   name="Contact",
 *   description="Danh sách API của tin nhắn",
 * )
 */
class Contact extends BaseModel {

    //put your code here
    protected $table = 'tbtt_contact';
    protected $primaryKey = 'con_id';
    public $timestamps = false;
    protected $fillable = [
        'con_title',
        'con_detail',
        'con_position',
        'con_in_urecei',
        'con_date_contact',
        'con_date_reply'
    ];
     protected $defaults = [
         'con_position' => 0,
        'con_view' => 0,
        'con_reply' => 0,
        'con_status' => 1,
        'con_in_usend' => 0,
        'con_out_usend' => 0,
        'con_in_urecei' => 0,
        'con_out_urecei' => 0,
    ];

    public function __construct(array $attributes = array()) {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    public function userRecieve() {
        return $this->hasOne('App\Models\User', 'use_id', 'con_user_recieve')
                ->select('use_fullname', 'use_id', 'use_username', 'avatar');
    }

    public function userSended() {
        return $this->hasOne('App\Models\User', 'use_id', 'con_user')
                ->select('use_fullname', 'use_id', 'use_username', 'avatar');
    }

}
