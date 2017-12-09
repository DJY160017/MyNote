<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/14
 * Time: 20:57
 */

namespace App\Http\Service;


use App\Exceptions\PasswordInvalidException;
use App\Exceptions\UserExistedException;
use App\Exceptions\UserNotExistException;
use App\Http\Dao\UserDao;
use App\Model\User;

class UserService{

    /**
     * @var UserDao 用户的Dao层对象
     */
    private $userDao;

    /**
     * UserService constructor.
     */
    public function __construct(){
        $this->userDao = new UserDao();
    }

    /**
     *  用户登录
     *
     * @param $userID string 用户ID
     * @param $password string 用户密码
     * @return boolean 能否登录
     * @throws UserNotExistException
     * @throws PasswordInvalidException
     */
    public function login($userID, $password){
        $user = $this->userDao->get($userID);
        if(is_null($user)){
            throw new UserNotExistException();
        }

        if(strcmp($password, $user->getPassword()) != 0){
            throw new PasswordInvalidException();
        }
        return true;
    }

    /**
     * 用户注册
     *
     * @param $user User 用户信息实体
     * @return boolean 是否成功注册
     * @throws UserExistedException
     */
    public function signUp($user){
        $user_temp = $this->userDao->get($user->getUserID());
        if(!is_null($user_temp)){
            throw new UserExistedException();
        }
        $this->userDao->add($user);
        return true;
    }

    /**
     *  用户登录
     *
     * @param $userID string 用户ID
     * @return User 用户实体
     */
    public function get($userID){
        $user = $this->userDao->get($userID);
        return $user;
    }

    /**
     * 用户修改个人资料
     *
     * @param $user User
     */
    public function modifyInfo($user){
        $this->userDao->modify($user);
    }

    /**
     * @param $userID string 当前用户ID
     * @return array
     */
    public function getAllUser($userID){
        return $this->userDao->getAllUser($userID);
    }

    /**
     * @param $info string
     * @param $userID string
     * @return array
     */
    public function searchUser($info,$userID){
       return $this->userDao->searchUser($info, $userID);
    }
}