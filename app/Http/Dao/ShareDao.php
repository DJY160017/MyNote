<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/9
 * Time: 13:37
 */

namespace App\Http\Dao;


use Illuminate\Support\Facades\DB;

class ShareDao{

    /**
     * @var string friend数据库表名
     */
    private $tablename = 'friend';

    /**
     * @param $userID string
     * @return array|null
     */
    public function getFriends($userID){
        $friend_info = DB::table($this->tablename)->where('userID', '=', $userID)->get();
        $array_friend = $friend_info->toArray();
        $result = array();
        foreach ($array_friend as $item) {
            $array = get_object_vars($item);
            if(sizeof($array) != 0) {
                array_push($result, $array);
            }
        }
        return $result;
    }

    /**
     * @param $userID string
     * @param $info string
     * @return array|null
     */
    public function searchFriends($userID, $info){
        $friend_info = DB::table($this->tablename)->where([
         ['userID', '=', $userID],
         ['friend', 'like', '%'.$info.'%']
        ])->get();
        $array_friend = $friend_info->toArray();
        $result = array();
        foreach ($array_friend as $item) {
            $array = get_object_vars($item);
            if(sizeof($array) != 0) {
                array_push($result, $array);
            }
        }
        return $result;
    }

    /**
     * @param $userID string
     * @param $friendID string
     * @return bool
     */
    public function addFriend($userID, $friendID){
        DB::table($this->tablename)->insert([
            'userID'=>$userID,
            'friendID'=>$friendID
        ]);
        return true;
    }

    /**
     * @param $userID string
     * @param $friendID string
     * @return bool
     */
    public function removeFriend($userID, $friendID){
        DB::table($this->tablename)->where([
            'userID'=>$userID,
            'friendID'=>$friendID
        ])->delete();
        return true;
    }
}