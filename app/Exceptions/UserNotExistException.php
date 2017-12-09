<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/14
 * Time: 21:09
 */

namespace App\Exceptions;


use Exception;

class UserNotExistException extends Exception{

    protected $message = '该用户不存在';

    public function __toString(){
        return $this->message;
    }
}