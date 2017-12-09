<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/4
 * Time: 19:46
 */

namespace App\Http\Util;


class IDReserver{

    /**
     * @var string 当前用户的ID
     */
    private $path;

    /**
     * IDReserver constructor.
     */
    public function __construct(){
        $this->path = resource_path('util/id_resever.txt');
    }


    /**
     * @return string 返回用户的ID
     */
    public function getUserID(){
        $file = fopen($this->path, 'r');
        $userID = '';
        if(!feof($file)){
            $userID = fgets($file);
        }
        fclose($file);
        return $userID;
    }

    /**
     * @param $userID string 设置当前用户的ID
     */
    public function setUserID($userID){
        $file = fopen($this->path,'w');
        fwrite($file, $userID);
        fclose($file);
    }
}