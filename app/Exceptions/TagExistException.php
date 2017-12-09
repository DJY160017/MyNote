<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/14
 * Time: 21:09
 */

namespace App\Exceptions;


use Exception;

class TagExistException extends Exception{

    protected $message = '该标签已存在';

    public function __toString(){
        return $this->message;
    }
}