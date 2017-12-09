<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/5
 * Time: 16:09
 */

namespace App\Http\Dao;


use App\Model\User;
use Illuminate\Support\Facades\DB;

class UserDao {

    /**
     * @var string user数据库表名
     */
    private $tablename = 'user';

    /**
     * 根据用户ID获取用户实体
     *
     * @param $userID string 用户ID
     * @return User 用户实体
     *
     */
    public function get($userID){
        $user_info = DB::table($this->tablename)->where('userID', $userID)->get();
        if(sizeof($user_info->toArray()) == 0){
            return null;
        }

        $user = new User();
        $user->setArray($user_info);
        return $user;
    }

    /**
     * 添加一个用户实体
     *
     * @param $user_info User 用户实体
     * @return boolean 添加是否成功
     *
     */
    public function add($user_info){
       DB::table($this->tablename)->insert([
            'userID'=>$user_info->getUserID(),
            'password'=>$user_info->getPassword(),
            'headportrait'=>$user_info->getHeadportrait(),
            'introduction'=>$user_info->getIntroduction(),
            'mail'=>$user_info->getMail()
        ]);
       return true;
    }

    /**
     * 修改用户信息
     *
     * @param $user_info User 需要修改的用户信息
     * @return boolean 修改是否成功
     *
     */
    public function modify($user_info){
        DB::table($this->tablename)->where('userID', $user_info->getUserID())->update([
            'password'=>$user_info->getPassword(),
            'headportrait'=>$user_info->getHeadportrait(),
            'introduction'=>$user_info->getIntroduction(),
            'mail'=>$user_info->getMail()
        ]);
        return true;
    }

    /**
     * @param $userID string 当前用户ID
     * @return array
     */
    public function getAllUser($userID){
        $users = DB::table($this->tablename)->where('userID', '<>',$userID)->get();
        $array_user = $users->toArray();
        $result = array();
        foreach ($array_user as $item) {
            $array = get_object_vars($item);
            if(sizeof($array) != 0) {
                array_push($result, $array);
            }
        }
        return $result;
    }

    /**
     * @param $info string
     * @param $userID string
     * @return array
     */
    public function searchUser($info,$userID){
        $user_info = DB::table($this->tablename)->where([
            ['userID', '<>', $userID],
            ['userID', 'like', '%'.$info.'%']
        ])->orWhere([
            ['userID', '<>', $userID],
            ['introduction', 'like', '%'.$info.'%']
        ])->orWhere([
            ['userID', '<>', $userID],
            ['mail', 'like', '%'.$info.'%']
        ])->get();

        $array_user = $user_info->toArray();
        $result = array();
        foreach ($array_user as $item) {
            $array = get_object_vars($item);
            if(sizeof($array) != 0) {
                array_push($result, $array);
            }
        }
        return $result;
    }
}