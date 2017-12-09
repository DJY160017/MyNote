<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/13
 * Time: 19:45
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Notebook{

    /**
     * 笔记本ID
     *
     * @var string
     */
    private $notebookID;

    /**
     * 用户ID
     *
     * @var string
     */
    private $userID;

    /**
     * 评论
     *
     * @var string
     */
    private $comment;

    /**
     * 笔记本创建时间
     *
     * @var string
     */
    private $createtime;

    /**
     * 用于从collection中获取信息
     *
     * @param $collection Collection
     *
     */
    public function setArray($collection){
        $array = $collection->toArray();
        $info = get_object_vars($array[0]);
        $this->notebookID = $info['notebookID'];
        $this->userID = $info['userID'];
        $this->comment = $info['comment'];
        $this->createtime = $info['createtime'];
    }

    /**
     * @return string
     */
    public function getNotebookID(): string
    {
        return $this->notebookID;
    }

    /**
     * @param string $notebookID
     */
    public function setNotebookID(string $notebookID)
    {
        $this->notebookID = $notebookID;
    }

    /**
     * @return string
     */
    public function getUserID(): string
    {
        return $this->userID;
    }

    /**
     * @param string $userID
     */
    public function setUserID(string $userID)
    {
        $this->userID = $userID;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getCreatetime(): string
    {
        return $this->createtime;
    }

    /**
     * @param string $createtime
     */
    public function setCreatetime(string $createtime)
    {
        $this->createtime = $createtime;
    }
}