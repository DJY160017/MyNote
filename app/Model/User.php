<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/4
 * Time: 16:05
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class User
{

    /**
     * @var string
     *
     * 用户的账户ID
     */
    private $userID;

    /**
     * @var string
     *
     * 用户的登录密码
     */
    private $password;

    /**
     * @var string
     *
     * 用户的头像
     */
    private $headportrait;

    /**
     * @var string
     *
     * 个人的介绍
     */
    private $introduction;

    /**
     * @var string
     *
     * 用户的邮箱
     */
    private $mail;

    /**
     * 用于从collection中获取信息
     *
     * @param $collection Collection
     *
     */
    public function setArray($collection){
        $array = $collection->toArray();
        $info = get_object_vars($array[0]);
        $this->userID = $info['userID'];
        $this->password = $info['password'];
        $this->headportrait = $info['headportrait'];
        $this->introduction = $info['introduction'];
        $this->mail = $info['mail'];
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getHeadportrait()
    {
        return $this->headportrait;
    }

    /**
     * @param string $headportrait
     */
    public function setHeadportrait($headportrait)
    {
        $this->headportrait = $headportrait;
    }

    /**
     * @return string
     */
    public function getIntroduction(): string
    {
        return $this->introduction;
    }

    /**
     * @param string $introduction
     */
    public function setIntroduction(string $introduction)
    {
        $this->introduction = $introduction;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail)
    {
        $this->mail = $mail;
    }
}