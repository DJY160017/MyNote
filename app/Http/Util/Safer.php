<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/9
 * Time: 0:16
 */

namespace App\Http\Util;


class Safer{

    /**
     * 用于对密码进行加密
     *
     * @param $password string
     * @return string 加密后的密码
     */
    public function encode($password){
        return md5($password);
    }
}