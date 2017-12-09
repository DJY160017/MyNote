<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/13
 * Time: 19:56
 */

namespace App\Http\Dao;


use Illuminate\Support\Facades\DB;

class TagDao{

    /**
     * @var string tag数据库表名
     */
    private $tablename = 'tag';

    /**
     * 获取指定用户的标签组
     *
     * @param $userID string
     * @return array
     */
    public function getTags($userID){
        $tag_info = DB::table($this->tablename)->where('userID', $userID)->get(['tagID']);
        $array_tag = $tag_info->toArray();
        $result = array();
        foreach ($array_tag as $item){
            $tag = get_object_vars($item);
            if(sizeof($tag) != 0){
                array_push($result, $tag['tagID']);
            }
        }

        if(sizeof($result) == 0){
            return null;
        }
        return $result;
    }

    /**
     * 用于添加用户的标签
     *
     * @param $userID string 用户ID
     * @param $tagID string 标签ID
     * @return boolean 是否成功添加
     *
     */
    public function add($userID, $tagID){
        DB::table($this->tablename)->insert([
            'userID' => $userID,
            'tagID' => $tagID
        ]);
        return true;
    }

    /**
     * 删除指定用户的ID
     *
     * @param $userID string 用户ID
     * @param $tagID string 标签ID
     * @return boolean 是否成功删除
     *
     */
    public function remove($userID, $tagID){
        DB::table($this->tablename)->where([
            ['userID','=',$userID],
            ['tagID','=', $tagID]
        ])->delete();
        return true;
    }
}