<?php

namespace App\Models;

use App\BaseModel;

/**
 * Category model
 *
 */
class Category extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    const STATUS_ACTIVE = 1;
    protected $table = 'tbtt_category';

    protected $primaryKey = 'cat_id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_category';
    }

    /**
     * get All level by id
     * @param array
     */
    public static function getAllLevelCategorieById($id) {
        return self::getAllLevelCategories([$id]);
    }

    public static function getAllLevelCategories($array) {
        $ids = self::whereIn('parent_id', $array)->pluck('cat_id');
        if (!$ids || sizeof($ids) == 0) {
            return $array;
        }

        $results = self::getAllLevelCategories($ids);
        $list = [];
        foreach ($array as $key => $value) {
            $list[] = $value;
        }
        foreach ($results as $key => $value) {
            $list[] = $value;
        }
        return $list;
    }
    function findParentCate($cat, $level = 0) {
        if ($cat->cat_level == 1) {
            return $cat->toArray();
        }
       
        $level = $level - 1;
        
        $catParent = $cat->parentCate;
        if (empty($catParent)) {
            return $cat->toArray();
        }
        return $this->findParentCate($catParent, $level);
    }

    public function findParent() {
      
        
        if ($this->cat_level == 1) {
            $this->parent_cate = null;
            return null;
        }
        if ($this->parent_id == null) {
            $this->parent_cate = null;
            return null; 
        }
        $this->parent_cate = $this->findParentCate($this, $this->cat_level);
        
    }
    public function parentCate() {
        return $this->hasOne('App\Models\Category', 'cat_id', 'parent_id')->select([
                'cat_name', 'cat_id','cat_level','parent_id','b2c_fee','cate_type'
        ]);
    }
    public function parentCateActive(){
        return $this->hasOne('App\Models\Category', 'cat_id', 'parent_id')->select([
                'cat_name', 'cat_id','cat_level','parent_id','b2c_fee','cate_type','cat_status'
        ])->where('cat_status', self::STATUS_ACTIVE)->where('cate_type',0);
    }
    
    public function child() {
        return $this->hasMany('App\Models\Category', 'parent_id', 'cat_id');
    }

}
