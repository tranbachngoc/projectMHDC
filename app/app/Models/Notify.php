<?php

namespace App\Models;

use App\BaseModel;
use App\Observers\NotifyObserver;

/**
 * Notify model
 *
 */
class Notify extends BaseModel {
    const STATUS_ACTIVE = 1;
    const TYPE_SHARE = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_notify';

    protected $primaryKey = 'not_id';
    
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_notify';
    }

    public static function boot() {
        parent::boot();

        static::observe(new NotifyObserver());
    }

    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    protected $defaults = array(
        'not_view' => '',
        'link_share' => '',
        'not_group' => '',
        'not_degree' => 0,
        'not_status' => 1,
        'not_user' => 0
    );

    protected $fillable = [
        'not_view',
        'not_title',
        'link_share',
        'not_group',
        'not_degree',
        'not_detail',
        'not_begindate',
        'not_enddate',
        'not_view',
        'not_status',
        'not_user',
        'category'
    ];

    public function addViewer($userId = null) {
        if (!$userId) {
            return;
        }

        if (!$this->not_view) {
            $this->not_view = [];    
        }

        $array = $this->not_view;
        if (!in_array($userId, $this->not_view)) {
            $array[] = $userId;
        }

        $this->not_view = $array;
    }

    /**
     * casting params
     */
    protected $casts = [
        'not_view' => 'array'
    ];
}
