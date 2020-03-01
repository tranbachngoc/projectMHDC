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
class Task extends BaseModel {
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DONE = 2;
    const STATUS_PEDING = 0;
    const STATUS_PEDING_PARENT_ACCEPT = 1;
    //put your code here
    protected $table = 'tbtt_task';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'detail',
        'note',
        'created_date',
        'updated_date',
        'added_date',
        'asigned_user',
        'store_id',
        'status',
        'date_img',
        'images1', 'images2', 'images3',
        'file1', 'file2', 'file3'
    ];
    protected $defaults = [
        'name' => '',
        'detail' => '',
        'note' => '',
        'date_img' => '',
        'images1' => '',
        'images2' => '',
        'images3' => '',
        'file1' => '',
        'file2' => '',
        'file3' => ''
    ];
    
    public function user(){
       return $this->hasOne('App\Models\User','use_id','asigned_user');
    }
    
    public function puclicInfo() {
        $this->imageURL1 = $this->images1 ? env("MEDIA_URL") . '/images/staff/'.$this->date_img.'/' . $this->images1 : '';
        $this->imageURL2 = $this->images2 ? env("MEDIA_URL") . '/images/staff/'.$this->date_img.'/' . $this->images2 : '';
        $this->imageURL3 = $this->images3 ? env("MEDIA_URL") . '/images/staff/'.$this->date_img.'/' . $this->images3 : '';
        $this->file1 = $this->file1 ? env("MEDIA_URL") . '/word/staff/'.$this->date_img.'/' . $this->file1 : '';
        $this->file2 = $this->file2 ? env("MEDIA_URL") . '/pdf/staff/'.$this->date_img.'/' . $this->file2 : '';
        $this->file3 = $this->file3 ? env("MEDIA_URL") . '/excel/staff/'.$this->date_img.'/' . $this->file3 : '';
        return $this;
    }

}
