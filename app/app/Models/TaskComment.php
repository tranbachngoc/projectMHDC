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
class TaskComment extends BaseModel {

    //put your code here
    protected $table = 'tbtt_task_comment';
    public $timestamps = false;
    protected $fillable = [
        'comment',
        'created_date'
    ];
    
    public function user(){
       return $this->hasOne('App\Models\User','use_id','id_user');
    }
}
