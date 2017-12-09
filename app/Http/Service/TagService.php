<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/15
 * Time: 10:18
 */

namespace App\Http\Service;


use App\Exceptions\TagExistException;
use App\Http\Dao\NoteDao;
use App\Http\Dao\TagDao;

class TagService{

    /**
     * @var TagDao 标签数据层对象
     */
    private $tagDao;

    /**
     * @var NoteDao 笔记数据层对象
     */
    private $noteDao;

    /**
     * TagService constructor.
     */
    public function __construct(){
        $this->tagDao = new TagDao();
        $this->noteDao = new NoteDao();
    }

    /**
     * 根据tag搜索指定用户的note
     *
     * @param $tags array
     * @param $userID string
     * @return array
     */
    public function search($userID, $tags){
        return $this->noteDao->getNoteByTag($userID, $tags);
    }

    /**
     * 获取指定用户的标签组
     *
     * @param $userID string
     * @return array
     */
    public function getTags($userID){
        return $this->tagDao->getTags($userID);
    }

    /**
     * 用于添加用户的标签
     *
     * @param $userID string 用户ID
     * @param $tagID string 标签ID
     * @return boolean 是否成功添加
     * @throws TagExistException
     */
    public function add($userID, $tagID){
        $tags = $this->getTags($userID);
        if(!is_null($tags)&&in_array($tagID, $tags)){
            throw new TagExistException();
        }
        return $this->tagDao->add($userID, $tagID);
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
        return $this->tagDao->remove($userID, $tagID);
    }
}