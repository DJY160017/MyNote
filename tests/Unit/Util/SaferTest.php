<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/9
 * Time: 0:20
 */

namespace App\Http\Util;



use Tests\TestCase;

class SaferTest extends TestCase{

    public function test(){
        $safer = new Safer();
        $this->assertEquals('e10adc3949ba59abbe56e057f20f883e',$safer->encode('123456'));
    }

}
