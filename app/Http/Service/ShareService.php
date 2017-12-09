<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/9
 * Time: 13:36
 */

namespace App\Http\Service;


use App\Http\Dao\NoteDao;
use App\Http\Dao\ShareDao;
use App\Http\Dao\UserDao;

class ShareService{

    private $shareDao;

    private $noteDao;

    private $userDao;

    /**
     * ShareService constructor.
     */
    public function __construct(){
        $this->shareDao = new ShareDao();
        $this->userDao = new UserDao();
        $this->noteDao = new NoteDao();
    }

    /**
     * @param $userID string
     * @return array|null
     */
    public function getFriends($userID){
        $friends = $this->shareDao->getFriends($userID);
        $result_users = array();
        for ($i = 0; $i < count($friends); $i++) {
            $array = array();
            $user = $this->userDao->get($friends[$i]['friendID']);
            array_push($array, $user->getUserID());
            array_push($array, $user->getIntroduction());
            array_push($array, $user->getMail());
            array_push($array, $this->noteDao->countNote($user->getUserID()));
            array_push($result_users, $array);
        }
        return $result_users;
    }

    /**
     * @param $userID string
     * @param $info string
     * @return array|null
     */
    public function searchFriends($userID, $info){
        $friends = $this->shareDao->searchFriends($userID,$info);
        $result_users = array();
        for ($i = 0; $i < count($friends); $i++) {
            $array = array();
            $user = $this->userDao->get($friends[$i]['friendID']);
            array_push($array, $user->getUserID());
            array_push($array, $user->getIntroduction());
            array_push($array, $user->getMail());
            array_push($array, $this->noteDao->countNote($user->getUserID()));
            array_push($result_users, $array);
        }
        return $result_users;
    }

    /**
     * @param $userID string
     * @param $friendID string
     * @return bool
     */
    public function addFriend($userID, $friendID){
        return $this->shareDao->addFriend($userID, $friendID);
    }

    /**
     * @param $userID string
     * @param $friendID string
     * @return bool
     */
    public function removeFriend($userID, $friendID){
        return $this->shareDao->removeFriend($userID, $friendID);
    }

    /**
     * @param $userID string
     * @return array
     */
    public function getAllFriendNote($userID){
        $friends = $this->shareDao->getFriends($userID);
        $result_users = array();
        for ($i = 0; $i < count($friends); $i++) {
            $notes = $this->noteDao->getUserAllNote($friends[$i]['friendID']);
            for ($i = 0; $i < count($notes); $i++) {
                $array = array();
                array_push($array, $notes[$i]['userID']);
                array_push($array, $notes[$i]['notebookID']);
                array_push($array, $notes[$i]['noteID']);
                array_push($array, $notes[$i]['createtime']);
                array_push($result_users, $array);
            }
        }
        return $result_users;
    }
}