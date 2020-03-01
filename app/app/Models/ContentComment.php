<?php

namespace App\Models;

use App\BaseModel;
use App\Observers\CommentObserver;
use App\Models\Content;
/**
 * ContentComment model
 *
 * @property integer $serviceId Relation of service
 */
class ContentComment extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_content_comment';

    protected $primaryKey = 'noc_id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_content_comment';
    }

    public static function boot() {
        parent::boot();

        static::observe(new CommentObserver());
    }

    protected $fillable = [
        'noc_comment',
        'noc_name',
        'noc_email',
        'noc_phone',
        'noc_user',
        'noc_date',
        'noc_content',
        'noc_avatar',
        'noc_reply'
    ];

    /**
     * User relationship
     * @return App\Models\User
     */
    public function user() {
        return $this->hasOne('App\Models\User', 'use_id', 'noc_user')->select(['use_id', 'use_username', 'avatar', 'use_fullname', 'use_phone']);
    }

    /**
     * Comments relationship
     * @return App\Models\ContentComment
     */
    public function replies() {
        return $this->hasMany('App\Models\ContentComment', 'noc_reply', 'noc_id')->orderBy('noc_date', 'DESC');
    }

    public function getRelatedUserIds() {
        return Content::where('not_id', $this->noc_content)->where('not_user', '<>', 0)->pluck('not_user')->toArray();
    }
    
    public function news() {
        return $this->hasOne('App\Models\Content', 'not_id', 'noc_content');
    }

}
