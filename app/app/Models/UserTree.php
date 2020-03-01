<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use App\BaseModel;
/**
 * Description of UserTree
 *
 * @author hoanvu
 */
class UserTree extends BaseModel{
    //put your code here
    protected $table = 'tbtt_user_tree';
    
    public function getListChildTree($user, &$list_child = array()) {
        if (empty($user->getChild)) {
            return 0;
        }
        $child = $user->getChild->child;
        $list_child[] = $child;
        $this->getNextList($child, $list_child);
    }

    public function getNextList($child, &$list_next = array()) {
        $userObject = self::where(['user_id' => $child])->first();
        if ($userObject->next > 0) {
            $list_next[] = $userObject->next;
        }
        if ($userObject->next > 0) {
            $this->getNextList($userObject->next, $list_next);
        } else {
            return $list_next;
        }
    }

    public function getChild($userid) {
        if ($userid > 0) {
            $userObject = UserTree::where(['user_id' => $userid])->first();
            if (empty($userObject)) {
                return 0;
            }
            return $userObject->child;
        } else {
            return 0;
        }
    }

    public function getTreeInList($user, &$allChild) {

        $listChild = array();
        $this->getListChildTree($user, $listChild);
        foreach ($listChild as $child) {
            if ($child > 0) {
                $allChild[] = $child;
                $this->getTreeInList($child, $allChild);
            }
        }
    }
    
    

}
