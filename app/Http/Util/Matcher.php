<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/9
 * Time: 0:11
 */

namespace App\Http\Util;


class Matcher{

    /**
     * @var string pattern
     */
    private $reg;

    /**
     * Matcher constructor.
     */
    public function __construct(){
        $this->reg = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
    }

    /**
     * 用于检测邮箱是否匹配
     *
     * @param $mail string
     * @return boolean
     */
    public function mailMatcher($mail){
        $result = preg_match($this->reg, $mail);
        return $result;
    }
}